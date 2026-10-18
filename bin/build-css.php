<?php
/**
 * Сборка и минификация CSS темы. Запускать вручную перед деплоем: php bin/build-css.php
 * Пишет assets/css/dist/theme.min.css и assets/css/dist/home.min.css.
 * Чистый PHP, без загрузки ядра WordPress.
 */

$root = dirname(__DIR__);
require $root . '/inc/css-builder.php';

foreach (custom_rebuild_min_css($root) as $report) {
    foreach ($report['missing'] as $rel) {
        fwrite(STDERR, "Пропущен (не найден): {$rel}\n");
    }
    echo "Собрано: assets/css/dist/{$report['file']} ({$report['before']} -> {$report['after']} байт)\n";
}
