<?php
/**
 * Template Name: Спасибо за заявку
 */
defined('ABSPATH') || exit;
get_header();

$bg        = function_exists('get_field') ? get_field('thanks_bg_image'        ) : null;
$bg_mobile = function_exists('get_field') ? get_field('thanks_bg_image_mobile' ) : null;
$title     = function_exists('get_field') ? get_field('thanks_title'      ) : null;
$message   = function_exists('get_field') ? get_field('thanks_description') : null;
$btn       = function_exists('get_field') ? get_field('thanks_btn_text'   ) : null;
?>

<section class="page-hero">

    <?php if (!empty($bg['url'])): ?>
    <div class="page-hero__bg page-hero__bg--grad">
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
            <?php if ($title) : ?><h1 class="page-hero__title title-1 page-hero__dark"><?= custom_unwrap_p($title) ?></h1><?php endif; ?>
            <?php if ($message) : ?><p class="page-hero__text page-hero__dark text"><?= nl2br(esc_html($message)) ?></p><?php endif; ?>
            <?php if ($btn) : ?>
                <div class="page-hero__actions">
                    <a href="<?= esc_url(home_url('/')) ?>" class="btn page-hero__btn"><?= esc_html($btn) ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php get_footer(); ?>
