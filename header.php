<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="<?= esc_url(THEME_URI . '/assets/fonts/inter/inter-regular.woff2') ?>">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="<?= esc_url(THEME_URI . '/assets/fonts/bebas-neue-cyrillic/bebas-neue-cyrillic-regular.woff2') ?>">
    <?php wp_head(); ?>
</head>
<body id="top" <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$logo              = function_exists('get_field') ? get_field('site_logo', 'option') : null;
$logo_text         = function_exists('get_field') ? get_field('site_logo_text', 'option') : null;
$logo_text_alt     = trim(preg_replace('/\r\n|\r|\n/', ' ', (string) $logo_text));
$phone             = function_exists('get_field') ? get_field('contact_phone', 'option') : null;
$hours             = function_exists('get_field') ? get_field('contact_hours', 'option') : null;
$phone_href        = $phone ? 'tel:' . preg_replace('/[^\d+]/', '', $phone) : '';
$callback_btn_text = function_exists('get_field') ? get_field('callback_modal_btn_text', 'option') : null;
$callback_btn_text = $callback_btn_text ?: 'Заказать звонок';
?>

<header class="header">
    <div class="container">
        <div class="header__inner">
            <a href="<?= esc_url(home_url('/')) ?>" class="header__logo">
                <?php if (!empty($logo['url'])) : ?>
                    <img src="<?= esc_url($logo['url']) ?>" alt="<?= esc_attr($logo_text_alt) ?>" class="header__logo-icon" width="<?= (int) $logo['width'] ?>" height="<?= (int) $logo['height'] ?>">
                <?php endif; ?>
                <?php if ($logo_text) : ?><span class="header__logo-text text"><?= nl2br(esc_html($logo_text)) ?></span><?php endif; ?>
            </a>

            <?php if (has_nav_menu('primary')) : ?>
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'header__menu',
                    'depth'          => 1,
                ]); ?>
            <?php endif; ?>

            <div class="header__wrapper">
                <div class="header__contacts">
                    <?= custom_icon_phone() ?>
                    <?php if ($phone) : ?>
                        <a href="<?= esc_url($phone_href) ?>" class="header__phone">
                            
                           <?= esc_html($phone) ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($hours) : ?>
                        <span class="header__hours"><?= esc_html($hours) ?></span>
                    <?php endif; ?>
                </div>

                <button type="button" class="btn header__cta" data-open="callback-modal"><?= esc_html($callback_btn_text) ?></button>
            </div>

            <div class="header__mobile-actions">
                <?php if ($phone) : ?>
                    <a href="<?= esc_url($phone_href) ?>" class="header__icon-btn" aria-label="Позвонить"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_105_751)">
<path d="M18.3332 14.1V16.6C18.3341 16.8321 18.2866 17.0618 18.1936 17.2745C18.1006 17.4871 17.9643 17.678 17.7933 17.8349C17.6222 17.9918 17.4203 18.1112 17.2005 18.1856C16.9806 18.2599 16.7477 18.2876 16.5165 18.2667C13.9522 17.988 11.489 17.1118 9.32486 15.7083C7.31139 14.4289 5.60431 12.7218 4.32486 10.7083C2.91651 8.53434 2.04007 6.05916 1.76653 3.48334C1.7457 3.25289 1.77309 3.02064 1.84695 2.80136C1.9208 2.58208 2.03951 2.38058 2.1955 2.20969C2.3515 2.0388 2.54137 1.90226 2.75302 1.80877C2.96468 1.71528 3.19348 1.66689 3.42486 1.66667H5.92486C6.32928 1.66269 6.72136 1.8059 7.028 2.06961C7.33464 2.33332 7.53493 2.69954 7.59153 3.1C7.69705 3.90006 7.89274 4.68561 8.17486 5.44167C8.28698 5.73994 8.31125 6.0641 8.24478 6.37574C8.17832 6.68737 8.02392 6.97343 7.79986 7.2L6.74153 8.25833C7.92783 10.3446 9.65524 12.072 11.7415 13.2583L12.7999 12.2C13.0264 11.9759 13.3125 11.8215 13.6241 11.7551C13.9358 11.6886 14.2599 11.7129 14.5582 11.825C15.3143 12.1071 16.0998 12.3028 16.8999 12.4083C17.3047 12.4654 17.6744 12.6693 17.9386 12.9812C18.2029 13.2932 18.3433 13.6913 18.3332 14.1Z" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_105_751">
<rect width="20" height="20" fill="white"/>
</clipPath>
</defs>
</svg>
</a>
                <?php endif; ?>
                <button type="button" class="header__icon-btn header__burger-btn" data-open="mobile-menu" aria-label="Меню">
                    <span class="header__burger-icon"><?= custom_icon_burger() ?></span>
                    <span class="header__close-icon"><?= custom_icon_close() ?></span>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobile-menu" class="mobile-menu" data-closable="mobile-menu">
    <div class="container">
        <?php if (has_nav_menu('primary')) : ?>
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mobile-menu__list',
                'depth'          => 1,
            ]); ?>
        <?php endif; ?>

        <div class="mobile-menu__divider"></div>

        <div class="header__contacts mobile-menu__contacts">
            <?= custom_icon_phone() ?>
            <?php if ($phone) : ?>
                <a href="<?= esc_url($phone_href) ?>" class="header__phone">
                    
                    <?= esc_html($phone) ?>
                </a>
            <?php endif; ?>
            <?php if ($hours) : ?>
                <span class="header__hours"><?= esc_html($hours) ?></span>
            <?php endif; ?>
        </div>

        <button type="button" class="btn mobile-menu__btn" data-open="callback-modal"><?= esc_html($callback_btn_text) ?></button>
    </div>
</div>

