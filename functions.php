<?php
defined('ABSPATH') || exit;

define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());

require_once THEME_DIR . '/inc/setup.php';
require_once THEME_DIR . '/inc/helpers.php';
require_once THEME_DIR . '/inc/scf-fields.php';
require_once THEME_DIR . '/inc/cookie.php';
require_once THEME_DIR . '/inc/submissions.php';
require_once THEME_DIR . '/inc/objects.php';
require_once THEME_DIR . '/inc/services.php';
require_once THEME_DIR . '/inc/projects.php';
require_once THEME_DIR . '/inc/admin-tools.php';
require_once THEME_DIR . '/inc/telegram-sync.php';

function custom_scripts() {
    wp_enqueue_style('theme-fonts', THEME_URI . '/assets/fonts/fonts.css', [], custom_asset_ver('/assets/fonts/fonts.css'));

    // Собранный и минифицированный бандл (bin/build-css.php), с fallback на исходники, если он не сгенерирован
    if (file_exists(THEME_DIR . '/assets/css/dist/theme.min.css')) {
        wp_enqueue_style('theme', THEME_URI . '/assets/css/dist/theme.min.css', ['theme-fonts'], custom_asset_ver('/assets/css/dist/theme.min.css'));
        $main_dep = 'theme';
    } else {
        wp_enqueue_style('base', THEME_URI . '/assets/css/base.css', ['theme-fonts'], custom_asset_ver('/assets/css/base.css'));
        wp_enqueue_style('main', THEME_URI . '/assets/css/main.css', ['base'], custom_asset_ver('/assets/css/main.css'));
        wp_enqueue_style('components', THEME_URI . '/assets/css/components.css', ['main'], custom_asset_ver('/assets/css/components.css'));
        wp_enqueue_style('header', THEME_URI . '/assets/css/header.css', ['main'], custom_asset_ver('/assets/css/header.css'));
        wp_enqueue_style('footer', THEME_URI . '/assets/css/footer.css', ['main'], custom_asset_ver('/assets/css/footer.css'));
        wp_enqueue_style('modals', THEME_URI . '/assets/css/modals.css', ['components'], custom_asset_ver('/assets/css/modals.css'));
        wp_enqueue_style('pages', THEME_URI . '/assets/css/pages.css', ['main'], custom_asset_ver('/assets/css/pages.css'));
        $main_dep = 'main';
    }
    
    // Swiper (карусель портфолио) нужен и на главной, и на странице отдельной услуги
    if (is_front_page() || is_singular('service')) {
        wp_enqueue_style('swiper', THEME_URI . '/assets/vendor/swiper/swiper-bundle.min.css', [], '11');
        wp_enqueue_script('swiper', THEME_URI . '/assets/vendor/swiper/swiper-bundle.min.js', [], '11', true);
        wp_enqueue_script('front-page', THEME_URI . '/assets/js/front-page.js', ['swiper'], custom_asset_ver('/assets/js/front-page.js'), true);
    }

    if (is_front_page()) {
        if (file_exists(THEME_DIR . '/assets/css/dist/home.min.css')) {
            wp_enqueue_style('home', THEME_URI . '/assets/css/dist/home.min.css', [$main_dep], custom_asset_ver('/assets/css/dist/home.min.css'));
        } else {
            $home_sections = ['hero', 'services', 'coating-places', 'coating-layers', 'portfolio', 'process', 'approach'];
            foreach ($home_sections as $section) {
                wp_enqueue_style("home-{$section}", THEME_URI . "/assets/css/home/{$section}.css", [$main_dep], custom_asset_ver("/assets/css/home/{$section}.css"));
            }
        }
    }

    if (is_singular('service')) {
        wp_enqueue_style('single-service', THEME_URI . '/assets/css/single-service.css', [$main_dep], custom_asset_ver('/assets/css/single-service.css'));
        // Блок "Выполненные проекты" здесь — тот же компонент, что и на главной
        wp_enqueue_style('home-portfolio', THEME_URI . '/assets/css/home/portfolio.css', [$main_dep], custom_asset_ver('/assets/css/home/portfolio.css'));
    }

    if (is_page_template('template-about.php')) {
        // Хэндл 'about' занят ядром WP (wp-admin/css/about.min.css) — используем свой, иначе wp_enqueue_style() молча подставит чужой файл
        wp_enqueue_style('theme-about', THEME_URI . '/assets/css/about.css', [$main_dep], custom_asset_ver('/assets/css/about.css'));
        // Блок "Процесс" здесь — тот же компонент, что и на главной
        wp_enqueue_style('home-process', THEME_URI . '/assets/css/home/process.css', [$main_dep], custom_asset_ver('/assets/css/home/process.css'));
    }

    if (is_page_template('template-projects.php')) {
        wp_enqueue_style('projects', THEME_URI . '/assets/css/projects.css', [$main_dep], custom_asset_ver('/assets/css/projects.css'));
        // Карточки проектов — тот же компонент, что и на главной
        wp_enqueue_style('home-portfolio', THEME_URI . '/assets/css/home/portfolio.css', [$main_dep], custom_asset_ver('/assets/css/home/portfolio.css'));
    }

    if (is_page_template('template-contacts.php')) {
        wp_enqueue_style('contacts', THEME_URI . '/assets/css/contacts.css', [$main_dep], custom_asset_ver('/assets/css/contacts.css'));
    }

    wp_enqueue_script('main', THEME_URI . '/assets/js/main.js', [], custom_asset_ver('/assets/js/main.js'), true);
    wp_enqueue_script('phone-mask', THEME_URI . '/assets/js/phone-mask.js', [], custom_asset_ver('/assets/js/phone-mask.js'), true);

    wp_localize_script('main', 'custom', array(
        'ajax_url'  => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('custom_form_nonce'),
        'thanks_url'=> custom_get_thanks_page_url(),
    ));
}
add_action('wp_enqueue_scripts', 'custom_scripts');
