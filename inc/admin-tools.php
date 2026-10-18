<?php
defined('ABSPATH') || exit;

require_once THEME_DIR . '/inc/css-builder.php';

/**
 * Страница «Инструменты темы» — пересборка .min.css без доступа к консоли сервера.
 */
add_action('admin_menu', function () {
    add_management_page(
        'Инструменты темы',
        'Инструменты темы',
        'manage_options',
        'custom-theme-tools',
        'custom_render_theme_tools_page'
    );
});

function custom_render_theme_tools_page(): void {
    if (!current_user_can('manage_options')) {
        return;
    }

    $reports = null;

    if (
        isset($_POST['custom_rebuild_min_css']) &&
        check_admin_referer('custom_rebuild_min_css_action', 'custom_rebuild_min_css_nonce')
    ) {
        $reports = custom_rebuild_min_css(THEME_DIR);
    }

    $telegram_report = null;

    if (
        isset($_POST['custom_sync_telegram']) &&
        check_admin_referer('custom_sync_telegram_action', 'custom_sync_telegram_nonce')
    ) {
        $telegram_report = custom_run_telegram_sync();
    }

    ?>
    <div class="wrap">
        <h1>Инструменты темы</h1>

        <h2>Пересборка .min.css</h2>
        <p>Собирает и минифицирует CSS-бандлы темы заново в <code>assets/css/dist/</code> на основе текущих исходных файлов.</p>

        <?php if ($reports !== null): ?>
            <div class="notice notice-success">
                <p><strong>Готово.</strong></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <?php foreach ($reports as $report): ?>
                        <li>
                            assets/css/dist/<?php echo esc_html($report['file']); ?>:
                            <?php echo esc_html((string) $report['before']); ?> &rarr; <?php echo esc_html((string) $report['after']); ?> байт
                            <?php if (!empty($report['missing'])): ?>
                                <br><span style="color:#b32d2e;">Не найдены: <?php echo esc_html(implode(', ', $report['missing'])); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field('custom_rebuild_min_css_action', 'custom_rebuild_min_css_nonce'); ?>
            <p>
                <button type="submit" name="custom_rebuild_min_css" value="1" class="button button-primary">
                    Пересобрать .min.css
                </button>
            </p>
        </form>

        <h2>Синхронизация «Актуальные объекты» с Telegram</h2>
        <p>Забирает новые посты с фото из канала, указанного в «Настройки сайта» → «Уведомления», и добавляет их как объекты. По умолчанию запускается автоматически по крону раз в 15 минут — эта кнопка нужна для проверки без ожидания.</p>

        <?php if ($telegram_report !== null): ?>
            <div class="notice notice-success">
                <p>
                    <strong>Готово.</strong>
                    Добавлено: <?php echo esc_html((string) $telegram_report['processed']); ?>,
                    пропущено: <?php echo esc_html((string) $telegram_report['skipped']); ?>.
                </p>
                <?php if (!empty($telegram_report['errors'])): ?>
                    <ul style="list-style: disc; margin-left: 20px; color:#b32d2e;">
                        <?php foreach ($telegram_report['errors'] as $error): ?>
                            <li><?php echo esc_html($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field('custom_sync_telegram_action', 'custom_sync_telegram_nonce'); ?>
            <p>
                <button type="submit" name="custom_sync_telegram" value="1" class="button button-primary">
                    Синхронизировать сейчас
                </button>
            </p>
        </form>
    </div>
    <?php
}
