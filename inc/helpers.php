<?php
defined('ABSPATH') || exit;

/**
 * Версия ассета по дате изменения файла — исключает отдачу устаревшей версии из кэша браузера.
 */
function custom_asset_ver(string $rel_path): string {
    $file = THEME_DIR . $rel_path;
    return file_exists($file) ? (string) filemtime($file) : '1.6.0';
}

/**
 * Выводит <img> с srcset/sizes/width/height по ACF image-массиву (return_format => array).
 */
function custom_responsive_img(array $image, string $sizes_attr = '100vw', string $class = '', string $loading = 'lazy', ?string $alt = ''): string {
    if (empty($image['url'])) {
        return '';
    }
    $alt = !empty($alt) ? $alt : ($image['alt'] ?? '');

    $candidates = [];
    foreach (['medium', 'medium_large', 'large', 'theme_lg', 'theme_xl'] as $size) {
        if (!empty($image['sizes'][$size]) && !empty($image['sizes']["{$size}-width"])) {
            $candidates[] = esc_url($image['sizes'][$size]) . ' ' . (int) $image['sizes']["{$size}-width"] . 'w';
        }
    }
    $candidates[] = esc_url($image['url']) . ' ' . (int) $image['width'] . 'w';

    return sprintf(
        '<img src="%s" srcset="%s" sizes="%s" width="%d" height="%d" alt="%s" loading="%s" decoding="async"%s>',
        esc_url($image['url']),
        implode(', ', array_unique($candidates)),
        esc_attr($sizes_attr),
        (int) $image['width'],
        (int) $image['height'],
        esc_attr($alt),
        esc_attr($loading),
        $class ? ' class="' . esc_attr($class) . '"' : ''
    );
}

/**
 * Выводит <picture> с отдельным изображением для мобайла (≤768px) поверх custom_responsive_img().
 */
function custom_bg_picture(array $image, $image_mobile = null, string $sizes_attr = '100vw', string $loading = 'lazy'): string {
    if (empty($image['url'])) {
        return '';
    }
    $source = '';
    if (!empty($image_mobile['url'])) {
        $source = sprintf('<source media="(max-width: 768px)" srcset="%s">', esc_url($image_mobile['url']));
    }
    return '<picture>' . $source . custom_responsive_img($image, $sizes_attr, '', $loading) . '</picture>';
}

/**
 * Убирает обёртку <p>...</p> или <pre>...</pre>, которую ACF wysiwyg добавляет
 * вокруг значения при чтении (wpautop), — нужно, чтобы вставить значение
 * внутрь <h1>/<h2> без невалидной вложенности и без white-space: pre,
 * ломающего перенос строк в заголовке.
 */
function custom_unwrap_p(string $html): string {
    return preg_replace('#^\s*<(p|pre)>(.*)</\1>\s*$#s', '$2', trim($html));
}

/**
 * Иконки шапки/меню — инлайн SVG, цвет наследуется через currentColor.
 */
function custom_icon_phone(): string {
    return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_63_670)">
<path d="M8.28289 11.7183C6.37393 9.80934 5.94289 7.90037 5.84565 7.13554C5.81848 6.92407 5.89126 6.71198 6.04255 6.56175L7.58738 5.01761C7.81462 4.7905 7.85495 4.43657 7.68462 4.16416L5.22496 0.344852C5.03652 0.0432134 4.6496 -0.0656509 4.33152 0.0934725L0.382895 1.95313C0.125674 2.07979 -0.0256201 2.35308 0.00358448 2.6383C0.210481 4.60382 1.06738 9.43554 5.81565 14.1842C10.5639 18.9328 15.395 19.7893 17.3615 19.9962C17.6467 20.0254 17.92 19.8741 18.0467 19.6169L19.9063 15.6683C20.0649 15.3509 19.9567 14.965 19.6563 14.7762L15.837 12.3173C15.5648 12.1468 15.2109 12.1868 14.9836 12.4138L13.4394 13.9586C13.2892 14.1099 13.0771 14.1827 12.8657 14.1555C12.1008 14.0583 10.1919 13.6273 8.28289 11.7183Z" fill="#3F3FCD"/>
<path d="M15.8623 10.6896C15.4814 10.6896 15.1726 10.3809 15.1726 9.99998C15.1694 7.14468 12.8555 4.8308 10.0002 4.82757C9.61932 4.82757 9.31055 4.5188 9.31055 4.13791C9.31055 3.75703 9.61932 3.44826 10.0002 3.44826C13.617 3.45225 16.5479 6.38322 16.5519 9.99998C16.5519 10.3809 16.2432 10.6896 15.8623 10.6896Z" fill="#3F3FCD"/>
<path d="M19.3105 10.6897C18.9297 10.6897 18.6209 10.3809 18.6209 10C18.6156 5.24113 14.7591 1.38463 10.0002 1.37931C9.61932 1.37931 9.31055 1.07054 9.31055 0.689655C9.31055 0.308769 9.61932 0 10.0002 0C15.5205 0.00608133 19.9941 4.47967 20.0002 10C20.0002 10.1829 19.9275 10.3583 19.7982 10.4877C19.6689 10.617 19.4935 10.6897 19.3105 10.6897Z" fill="#3F3FCD"/>
</g>
<defs>
<clipPath id="clip0_63_670">
<rect width="20" height="20" fill="white"/>
</clipPath>
</defs>
</svg>
';
}

function custom_icon_plus(): string {
    return '<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.5625 20.625V-1.19209e-06H12.0625V20.625H8.5625ZM2.68221e-07 12.0625V8.5625H20.625V12.0625H2.68221e-07Z" fill="#3F3FCD"/>
</svg>
';
}

function custom_icon_burger(): string {
    return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.5 5H18.5M1.5 10H18.5M1.5 15H18.5" stroke="white" stroke-width="1.6" stroke-miterlimit="10" stroke-linecap="round"/>
</svg>
';
}

function custom_icon_close(): string {
    return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10 10L18 18M10 10L2 2M10 10L2 18M10 10L18 2" stroke="white" stroke-width="1.6" stroke-linecap="round"/>
</svg>
';
}

function custom_icon_arrow_up(): string {
    return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_216_318)">
<rect width="16" height="16" rx="8" transform="matrix(0 -1 -1 0 16 16)" fill="white"/>
<path d="M8 16L8 3" stroke="#3F3FCD" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12.668 7L8.0013 2.33333L3.33464 7" stroke="#3F3FCD" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_216_318">
<rect width="16" height="16" rx="8" transform="matrix(0 -1 -1 0 16 16)" fill="white"/>
</clipPath>
</defs>
</svg>
';
}

function custom_icon_telegram(): string {
    return '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="28" height="28" rx="14" fill="#27A6E5"/>
<path d="M19.6008 8.82158L17.497 19.8046C17.497 19.8046 17.2026 20.5661 16.394 20.2009L11.54 16.3468L11.5175 16.3355C12.1731 15.7258 17.2575 10.9919 17.4797 10.7773C17.8237 10.445 17.6101 10.2471 17.2107 10.4982L9.70054 15.4371L6.80313 14.4276C6.80313 14.4276 6.34716 14.2596 6.3033 13.8944C6.25885 13.5286 6.81813 13.3308 6.81813 13.3308L18.63 8.53229C18.63 8.53229 19.6008 8.09058 19.6008 8.82158Z" fill="white"/>
</svg>

';
}

function custom_icon_clock(): string {
    return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C14.9705 1.0001 19 5.02946 19 10C18.9999 14.9705 14.9705 18.9999 10 19C5.02946 19 1.0001 14.9705 1 10C1 5.0294 5.0294 1 10 1ZM10.0035 3.925C9.63094 3.92521 9.32857 4.22738 9.32852 4.6V10.0044C9.32852 10.1833 9.39985 10.3551 9.52627 10.4816L13.3416 14.2979C13.6051 14.5613 14.0325 14.5611 14.2961 14.2979C14.5597 14.0343 14.5596 13.607 14.2961 13.3434L10.6785 9.7249V4.6C10.6785 4.22725 10.3763 3.925 10.0035 3.925Z" fill="#3F3FCD"/>
</svg>
';
}

function custom_icon_chevron(): string {
    return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13 6L8 11L3 6" stroke="#0B0F12" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';
}

function custom_icon_arrow_right(): string {
    return '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_63_627)">
<path d="M0 8L13 8" stroke="#F6F6F6" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M9 3.33331L13.6667 7.99998L9 12.6666" stroke="#F6F6F6" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_63_627">
<rect width="16" height="16" fill="white"/>
</clipPath>
</defs>
</svg>
';
}
