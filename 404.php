<?php
/**
 * 404 Not Found — поля редактируются в «Настройки сайта → Страница 404».
 */
defined('ABSPATH') || exit;
get_header();

$bg        = function_exists('get_field') ? get_field('error_bg_image',        'option') : null;
$bg_mobile = function_exists('get_field') ? get_field('error_bg_image_mobile', 'option') : null;
$title     = function_exists('get_field') ? get_field('error_title',     'option') : null;
$message   = function_exists('get_field') ? get_field('error_message',   'option') : null;
$btn       = function_exists('get_field') ? get_field('error_btn_text',  'option') : null;
$btn2_text = function_exists('get_field') ? get_field('error_btn2_text', 'option') : null;
$btn2_link = function_exists('get_field') ? get_field('error_btn2_link', 'option') : null;
?>

<section class="page-hero">

    <?php if (!empty($bg['url'])): ?>
    <div class="page-hero__bg">
        <picture>
            <?php if (!empty($bg_mobile['url'])): ?>
                <source media="(max-width: 768px)" srcset="<?= esc_url($bg_mobile['url']) ?>">
            <?php endif; ?>
            <?= custom_responsive_img($bg, '100vw', '', 'eager') ?>
        </picture>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="page-hero__inner">
            <?php if ($title) : ?><h1 class="page-hero__title title-1"><?= custom_unwrap_p($title) ?></h1><?php endif; ?>
            <?php if ($message) : ?><p class="page-hero__text text"><?= nl2br(esc_html($message)) ?></p><?php endif; ?>
            <?php if ($btn || (!empty($btn2_text) && !empty($btn2_link['url']))) : ?>
                <div class="page-hero__actions">
                    <?php if ($btn) : ?>
                        <a href="<?= esc_url(home_url('/')) ?>" class="btn page-hero__btn"><?= esc_html($btn) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($btn2_text) && !empty($btn2_link['url'])) : ?>
                        <a href="<?= esc_url($btn2_link['url']) ?>" class="btn btn--outline page-hero__btn"<?= !empty($btn2_link['target']) ? ' target="' . esc_attr($btn2_link['target']) . '"' : '' ?>><?= esc_html($btn2_text) ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php get_footer(); ?>
