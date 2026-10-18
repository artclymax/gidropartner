<?php
defined('ABSPATH') || exit;

// ——— CPT: Заявки ———
add_action('init', 'custom_register_lead_cpt');
function custom_register_lead_cpt() {
    register_post_type('callback_lead', array(
        'labels'       => array(
            'name'          => 'Заявки',
            'singular_name' => 'Заявка',
            'menu_name'     => 'Заявки',
            'all_items'     => 'Все заявки',
            'view_item'     => 'Просмотр заявки',
            'search_items'  => 'Поиск',
            'not_found'     => 'Заявок нет',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'exclude_from_search'=> true,
        'show_ui'          => true,
        'show_in_menu'     => true,
        'menu_icon'        => 'dashicons-email-alt',
        'menu_position'    => 3,
        'supports'         => array('title'),
        'capabilities'     => array('create_posts' => 'do_not_allow'),
        'map_meta_cap'     => true,
    ));
}

// ——— Явная защита: не пускать служебный CPT заявок в sitemap Yoast ———
add_filter('wpseo_sitemap_exclude_post_type', function ($excluded, $post_type) {
    return $post_type === 'callback_lead' ? true : $excluded;
}, 10, 2);

// ——— Колонки в списке заявок ———
add_filter('manage_callback_lead_posts_columns', function ($cols) {
    return array(
        'cb'           => $cols['cb'],
        'title'        => 'Имя',
        'lead_phone'   => 'Телефон',
        'lead_object'   => 'Тип Работ',
        'lead_message' => 'Сообщение',
        'lead_source'  => 'Страница',
        'date'         => 'Дата',
    );
});

add_action('manage_callback_lead_posts_custom_column', function ($col, $post_id) {
    $map = array(
        'lead_phone'   => '_lead_phone',
        'lead_message' => '_lead_message',
        'lead_object'  => '_lead_object',
        'lead_systems'  => '_lead_systems',
        'lead_source'  => '_lead_source',
    );
    if (isset($map[$col])) {
        echo esc_html(get_post_meta($post_id, $map[$col], true) ?: '—');
    }
}, 10, 2);

add_filter('manage_edit-callback_lead_sortable_columns', function ($cols) {
    $cols['date'] = 'date';
    return $cols;
});

// ——— Метабокс: данные заявки на странице просмотра ———
add_action('add_meta_boxes', function () {
    add_meta_box('lead_details', 'Данные заявки', 'custom_lead_meta_box', 'callback_lead', 'normal', 'high');
});

function custom_lead_meta_box($post) {
    $rows = array(
        '_lead_name'       => 'Имя',
        '_lead_phone'      => 'Телефон',
        '_lead_email'      => 'Email',
        '_lead_company'    => 'Компания',
        '_lead_object'      => 'Тип работ',
        '_lead_area'        => 'Площадь, м²',
        '_lead_city'        => 'Город / регион',
        '_lead_foundation'  => 'Состояние основания',
        '_lead_object_kind' => 'Тип объекта',
        '_lead_message'     => 'Сообщение',
        '_lead_source'     => 'Страница',
    );
    echo '<table class="widefat striped" style="margin-top:8px"><tbody>';
    foreach ($rows as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        if ($val === '' || $val === null) continue;
        if ($key === '_lead_source') {
            $val = '<a href="' . esc_url($val) . '" target="_blank" rel="noopener">' . esc_html($val) . '</a>';
        } else {
            $val = nl2br(esc_html($val));
        }
        echo '<tr><th style="width:180px;text-align:left">' . esc_html($label) . '</th><td>' . $val . '</td></tr>';
    }
    echo '</tbody></table>';
}

// ——— AJAX-обработчик формы ———
add_action('wp_ajax_custom_submit',        'custom_handle_form_submit');
add_action('wp_ajax_nopriv_custom_submit', 'custom_handle_form_submit');
function custom_handle_form_submit() {
    if (!check_ajax_referer('custom_form_nonce', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Security check failed'), 403);
    }

    $name    = sanitize_text_field(wp_unslash($_POST['cb_name']    ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['cb_phone']   ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['cb_email']        ?? ''));
    $company = sanitize_text_field(wp_unslash($_POST['cb_company']  ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['cb_message'] ?? ''));
    $object      = sanitize_text_field(wp_unslash($_POST['cb_object_type'] ?? ''));
    $area        = sanitize_text_field(wp_unslash($_POST['cb_area']       ?? ''));
    $city        = sanitize_text_field(wp_unslash($_POST['cb_city']       ?? ''));
    $foundation  = sanitize_text_field(wp_unslash($_POST['cb_foundation'] ?? ''));
    $object_kind = sanitize_text_field(wp_unslash($_POST['cb_object_kind'] ?? ''));
    $form_type   = sanitize_text_field(wp_unslash($_POST['form_type']     ?? ''));
    $source  = esc_url_raw(wp_unslash($_POST['source']             ?? ''));

    $phone_digits = preg_replace('/\D/', '', $phone);
    if (preg_match('/^80(17|25|29|33|44)\d{7}$/', $phone_digits)) {
        $phone_digits = '375' . substr($phone_digits, 2);
    }
    if (!preg_match('/^375(17|25|29|33|44)\d{7}$/', $phone_digits)) {
        wp_send_json_error(array('message' => 'Введите корректный белорусский номер'), 400);
    }
    $phone = '+' . substr($phone_digits, 0, 3) . ' (' . substr($phone_digits, 3, 2) . ') '
           . substr($phone_digits, 5, 3) . '-' . substr($phone_digits, 8, 2) . '-' . substr($phone_digits, 10, 2);

    if (empty($_POST['cb_consent'])) {
        wp_send_json_error(array('message' => 'Необходимо согласие с политикой обработки данных'), 400);
    }

    // Сохраняем заявку в БД
    $title_prefix = $form_type === 'calc' ? 'Расчёт: ' : ($form_type === 'discuss' ? 'Обсуждение: ' : '');
    $title   = trim($title_prefix . ($name ? $name . ' — ' : '') . $phone);
    $post_id = wp_insert_post(array(
        'post_type'   => 'callback_lead',
        'post_title'  => $title,
        'post_status' => 'publish',
    ));

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_lead_name',        $name);
        update_post_meta($post_id, '_lead_phone',       $phone);
        update_post_meta($post_id, '_lead_message',     $message);
        update_post_meta($post_id, '_lead_object',      $object);
        update_post_meta($post_id, '_lead_area',        $area);
        update_post_meta($post_id, '_lead_city',        $city);
        update_post_meta($post_id, '_lead_foundation',  $foundation);
        update_post_meta($post_id, '_lead_object_kind', $object_kind);
        update_post_meta($post_id, '_lead_source',      $source);
    }

    // Формируем список получателей
    $raw = get_field('notification_emails', 'option') ?: '';
    $to  = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $raw)));
    if (empty($to)) {
        $to = array(get_option('admin_email'));
    }

    // Отправляем email
    $blog = get_bloginfo('name');
    if ($form_type === 'calc') {
        $lead_label = 'Новый расчёт стоимости';
    } elseif ($form_type === 'discuss') {
        $lead_label = 'Новая заявка на обсуждение объекта';
    } else {
        $lead_label = 'Новая заявка с сайта';
    }
    $subject    = "[{$blog}] {$lead_label}";
    $body  = "{$lead_label} — " . get_bloginfo('url') . "\n\n";
    $body .= "Имя:       " . ($name    ?: '—') . "\n";
    $body .= "Телефон:   " . $phone               . "\n";
    $body .= "Тип работ: " . ($object  ?: '—') . "\n";
    if ($area)        $body .= "Площадь:     {$area} м²\n";
    if ($city)         $body .= "Город:       {$city}\n";
    if ($foundation)   $body .= "Основание:   {$foundation}\n";
    if ($object_kind)  $body .= "Тип объекта: {$object_kind}\n";
    $body .= "Сообщение: " . ($message ?: '—') . "\n";
    $body .= "Страница:  " . ($source  ?: '—') . "\n";
    $body .= "\n" . date_i18n('d.m.Y H:i');

    wp_mail($to, $subject, $body, array('Content-Type: text/plain; charset=UTF-8'));

    custom_send_telegram_notification(array(
        'form_type'   => $form_type,
        'name'        => $name,
        'phone'       => $phone,
        'company'     => $company,
        'object'      => $object,
        'area'        => $area,
        'city'        => $city,
        'foundation'  => $foundation,
        'object_kind' => $object_kind,
        'message'     => $message,
        'source'      => $source,
    ));

    wp_send_json_success();
}

function custom_send_telegram_notification(array $data): void {
    $token   = get_field('telegram_bot_token', 'option');
    $chat_id = get_field('telegram_chat_id', 'option');
    if (!$token || !$chat_id) return;

    if (($data['form_type'] ?? '') === 'calc') {
        $lead_label = 'Новый расчёт стоимости';
    } elseif (($data['form_type'] ?? '') === 'discuss') {
        $lead_label = 'Новая заявка на обсуждение объекта';
    } else {
        $lead_label = 'Новая заявка с сайта';
    }
    $lines = array('<b>🔔 ' . $lead_label . '</b>');
    if (!empty($data['name']))        $lines[] = 'Имя: '          . htmlspecialchars($data['name'],        ENT_QUOTES);
    if (!empty($data['phone']))       $lines[] = 'Телефон: '      . htmlspecialchars($data['phone'],       ENT_QUOTES);
    if (!empty($data['company']))     $lines[] = 'Компания: '     . htmlspecialchars($data['company'],     ENT_QUOTES);
    if (!empty($data['object']))      $lines[] = 'Тип работ: '    . htmlspecialchars($data['object'],      ENT_QUOTES);
    if (!empty($data['area']))        $lines[] = 'Площадь: '      . htmlspecialchars($data['area'], ENT_QUOTES) . ' м²';
    if (!empty($data['city']))        $lines[] = 'Город: '        . htmlspecialchars($data['city'],        ENT_QUOTES);
    if (!empty($data['foundation']))  $lines[] = 'Основание: '    . htmlspecialchars($data['foundation'],  ENT_QUOTES);
    if (!empty($data['object_kind'])) $lines[] = 'Тип объекта: '  . htmlspecialchars($data['object_kind'], ENT_QUOTES);
    if (!empty($data['message']))     $lines[] = 'Сообщение: '    . htmlspecialchars($data['message'],     ENT_QUOTES);
    if (!empty($data['source']))      $lines[] = 'Источник: '     . htmlspecialchars($data['source'],      ENT_QUOTES);

    wp_remote_post(
        'https://api.telegram.org/bot' . $token . '/sendMessage',
        array(
            'timeout'  => 5,
            'blocking' => false,
            'body'     => array(
                'chat_id'    => $chat_id,
                'text'       => implode("\n", $lines),
                'parse_mode' => 'HTML',
            ),
        )
    );
}
