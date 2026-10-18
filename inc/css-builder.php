<?php
/**
 * Общая логика сборки/минификации CSS темы.
 * Используется и в CLI-скрипте (bin/build-css.php), и в админке (inc/admin-tools.php).
 * Чистый PHP, без обращений к функциям ядра WordPress — можно подключать вне контекста WP.
 */

if (!function_exists('custom_css_bundles')) {
    function custom_css_bundles(): array {
        return [
            'theme.min.css' => [
                '/assets/css/base.css',
                '/assets/css/main.css',
                '/assets/css/components.css',
                '/assets/css/header.css',
                '/assets/css/footer.css',
                '/assets/css/pages.css',
            ],
            'home.min.css' => [
                
            ],
        ];
    }
}

if (!function_exists('custom_minify_css')) {
    function custom_minify_css(string $css): string {
        $css = preg_replace('!/\*.*?\*/!s', '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css);
        $css = str_replace(';}', '}', $css);
        return trim($css);
    }
}

/**
 * Пересобирает все .min.css бандлы в assets/css/dist.
 * Возвращает массив отчётов: [ 'file' => имя, 'before' => байт, 'after' => байт, 'missing' => [...] ].
 */
if (!function_exists('custom_rebuild_min_css')) {
    function custom_rebuild_min_css(string $root): array {
        $dist_dir = $root . '/assets/css/dist';
        if (!is_dir($dist_dir)) {
            mkdir($dist_dir, 0755, true);
        }

        $reports = [];
        foreach (custom_css_bundles() as $output => $sources) {
            $combined = '';
            $missing = [];
            foreach ($sources as $rel) {
                $path = $root . $rel;
                if (!file_exists($path)) {
                    $missing[] = $rel;
                    continue;
                }
                $combined .= file_get_contents($path) . "\n";
            }

            $minified = custom_minify_css($combined);
            file_put_contents($dist_dir . '/' . $output, $minified);

            $reports[] = [
                'file'    => $output,
                'before'  => strlen($combined),
                'after'   => strlen($minified),
                'missing' => $missing,
            ];
        }

        return $reports;
    }
}
