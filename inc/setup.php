<?php
defined('ABSPATH') || exit;

function custom_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

   

    register_nav_menus([
        'primary' => 'Основное меню',
        'footer'  => 'Меню в подвале',
    ]);
}
add_action('after_setup_theme', 'custom_setup');

// ——— Доп. размеры изображений для responsive images (srcset) ———
add_action('after_setup_theme', function () {
    add_image_size('theme_xl', 1920, 0, false);
    add_image_size('theme_lg', 960, 0, false);
});

// ——— URL страницы "Спасибо" (кэшируется, т.к. используется на каждой загрузке сайта) ———
function custom_get_thanks_page_url(): string {
    $cache_key = 'custom_thanks_page_url';
    $cached    = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $thanks_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'template-thanks.php',
        'number'     => 1,
    ));
    $url = !empty($thanks_pages) ? get_permalink($thanks_pages[0]->ID) : home_url('/');

    set_transient($cache_key, $url, DAY_IN_SECONDS);
    return $url;
}
add_action('save_post_page', function () {
    delete_transient('custom_thanks_page_url');
});

// ——— Убираем блочный редактор контента там, где он не используется (весь контент страниц — через SCF-поля) ———
add_action('admin_init', function () {
    global $pagenow;
    if (!in_array($pagenow, array('post.php', 'post-new.php'), true)) {
        return;
    }

    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if (!$post_id || get_post_type($post_id) !== 'page') {
        return;
    }

    // template-text.php — единственный шаблон, где реально выводится the_content()
    if (get_page_template_slug($post_id) === 'template-text.php') {
        return;
    }

    remove_post_type_support('page', 'editor');
});

// ——— URL страницы "Услуги" (кэшируется, нужен для хлебных крошек на странице отдельной услуги) ———
function custom_get_services_page_url(): string {
    $cache_key = 'custom_services_page_url';
    $cached    = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $services_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'template-services.php',
        'number'     => 1,
    ));
    $url = !empty($services_pages) ? get_permalink($services_pages[0]->ID) : home_url('/');

    set_transient($cache_key, $url, DAY_IN_SECONDS);
    return $url;
}
add_action('save_post_page', function () {
    delete_transient('custom_services_page_url');
});

// ——— URL страницы "Проекты" (кэшируется, нужен для кнопки "Смотреть все проекты" на главной) ———
function custom_get_projects_page_url(): string {
    $cache_key = 'custom_projects_page_url';
    $cached    = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $projects_pages = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'template-projects.php',
        'number'     => 1,
    ));
    $url = !empty($projects_pages) ? get_permalink($projects_pages[0]->ID) : home_url('/');

    set_transient($cache_key, $url, DAY_IN_SECONDS);
    return $url;
}
add_action('save_post_page', function () {
    delete_transient('custom_projects_page_url');
});
