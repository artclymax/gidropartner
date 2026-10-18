<?php
defined('ABSPATH') || exit;

// ——— Автосинхронизация «Актуальные объекты» из Telegram-канала (WP-Cron) ———

add_filter('cron_schedules', function ($schedules) {
    $schedules['custom_fifteen_minutes'] = array(
        'interval' => 15 * MINUTE_IN_SECONDS,
        'display'  => 'Каждые 15 минут',
    );
    return $schedules;
});

add_action('init', function () {
    if (!wp_next_scheduled('custom_telegram_sync_cron')) {
        wp_schedule_event(time(), 'custom_fifteen_minutes', 'custom_telegram_sync_cron');
    }
});

add_action('switch_theme', function () {
    wp_clear_scheduled_hook('custom_telegram_sync_cron');
});

add_action('custom_telegram_sync_cron', 'custom_run_telegram_sync');

/**
 * Забирает новые посты с фото из настроенного Telegram-канала
 * и создаёт из них записи CPT recent_object. Вызывается как по крону,
 * так и вручную из «Инструменты темы».
 */
function custom_run_telegram_sync(): array {
    $report = array('processed' => 0, 'skipped' => 0, 'errors' => array());

    $token   = get_field('telegram_bot_token', 'option');
    $enabled = get_field('telegram_sync_enabled', 'option');
    $channel = get_field('telegram_source_channel', 'option');

    if (!$enabled || !$token || !$channel) {
        return $report;
    }

    $offset = (int) get_option('custom_telegram_last_update_id', 0);

    $response = wp_remote_get('https://api.telegram.org/bot' . $token . '/getUpdates', array(
        'timeout' => 20,
        'body'    => array(
            'offset'          => $offset ? $offset + 1 : 0,
            'allowed_updates' => wp_json_encode(array('channel_post')),
            'limit'           => 50,
        ),
    ));

    if (is_wp_error($response)) {
        $report['errors'][] = $response->get_error_message();
        return $report;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($data['ok']) || empty($data['result'])) {
        return $report;
    }

    $channel_norm   = ltrim($channel, '@');
    $max_update_id  = $offset;

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    foreach ($data['result'] as $update) {
        $update_id = (int) ($update['update_id'] ?? 0);
        if ($update_id > $max_update_id) {
            $max_update_id = $update_id;
        }

        $post = $update['channel_post'] ?? null;
        if (!$post) {
            continue;
        }

        $chat          = $post['chat'] ?? array();
        $chat_id       = (string) ($chat['id'] ?? '');
        $chat_username = ltrim((string) ($chat['username'] ?? ''), '@');

        if ($chat_id !== $channel_norm && $chat_username !== $channel_norm) {
            continue;
        }

        if (empty($post['photo'])) {
            $report['skipped']++;
            continue;
        }

        $message_id = (int) ($post['message_id'] ?? 0);

        $existing = get_posts(array(
            'post_type'      => 'recent_object',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
            'meta_query'     => array(
                array('key' => '_telegram_message_id', 'value' => $message_id),
            ),
        ));
        if (!empty($existing)) {
            $report['skipped']++;
            continue;
        }

        // Фото наибольшего размера — последний элемент массива photo
        $largest_photo = end($post['photo']);
        $file_id = $largest_photo['file_id'] ?? null;
        if (!$file_id) {
            $report['skipped']++;
            continue;
        }

        $file_response = wp_remote_get('https://api.telegram.org/bot' . $token . '/getFile?file_id=' . rawurlencode($file_id), array('timeout' => 20));
        if (is_wp_error($file_response)) {
            $report['errors'][] = $file_response->get_error_message();
            continue;
        }
        $file_data = json_decode(wp_remote_retrieve_body($file_response), true);
        $file_path = $file_data['result']['file_path'] ?? null;
        if (!$file_path) {
            $report['errors'][] = 'Не удалось получить файл поста ' . $message_id;
            continue;
        }

        $caption  = sanitize_text_field($post['caption'] ?? '');
        $file_url = 'https://api.telegram.org/file/bot' . $token . '/' . $file_path;

        $attachment_id = media_sideload_image($file_url, 0, $caption ?: null, 'id');
        if (is_wp_error($attachment_id)) {
            $report['errors'][] = $attachment_id->get_error_message();
            continue;
        }

        $title = $caption
            ? wp_trim_words($caption, 8, '…')
            : ('Объект от ' . date_i18n('d.m.Y', $post['date'] ?? time()));

        $post_id = wp_insert_post(array(
            'post_type'   => 'recent_object',
            'post_title'  => $title,
            'post_status' => 'publish',
        ));

        if (!$post_id || is_wp_error($post_id)) {
            $report['errors'][] = 'Не удалось создать запись для поста ' . $message_id;
            continue;
        }

        update_field('object_image', $attachment_id, $post_id);
        update_field('object_description', $caption, $post_id);
        if ($chat_username) {
            update_field('object_link', 'https://t.me/' . $chat_username . '/' . $message_id, $post_id);
        }
        update_post_meta($post_id, '_telegram_message_id', $message_id);

        $report['processed']++;
    }

    if ($max_update_id > $offset) {
        update_option('custom_telegram_last_update_id', $max_update_id, false);
    }

    return $report;
}
