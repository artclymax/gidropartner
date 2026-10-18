<?php
/**
 * Template Name: Услуги
 */
defined('ABSPATH') || exit;
get_header();

$hero_bg        = function_exists('get_field') ? get_field('services_hero_bg_image') : null;
$hero_bg_mobile = function_exists('get_field') ? get_field('services_hero_bg_image_mobile') : null;
$hero_eyebrow   = function_exists('get_field') ? get_field('services_hero_eyebrow') : null;
$hero_title     = function_exists('get_field') ? get_field('services_hero_title') : null;
$hero_text      = function_exists('get_field') ? get_field('services_hero_text') : null;
$hero_btn_text  = function_exists('get_field') ? get_field('services_hero_btn_text') : null;
$hero_btn_link  = function_exists('get_field') ? get_field('services_hero_btn_link') : null;

$directions_eyebrow  = function_exists('get_field') ? get_field('services_directions_eyebrow') : null;
$directions_title    = function_exists('get_field') ? get_field('services_directions_title') : null;
$directions_text     = function_exists('get_field') ? get_field('services_directions_text') : null;
$directions_bg       = function_exists('get_field') ? get_field('services_directions_bg_image') : null;
$directions_bg_mobile = function_exists('get_field') ? get_field('services_directions_bg_image_mobile') : null;
?>

<main class="main">

    <section class="service-hero">
        <?php if (!empty($hero_bg['url'])) : ?>
            <div class="service-hero__bg">
                <?= custom_bg_picture($hero_bg, $hero_bg_mobile, '100vw', 'eager') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <nav class="breadcrumb text-caption" aria-label="Breadcrumb">
                <a href="<?= esc_url(home_url('/')) ?>">Главная</a>
                <span class="breadcrumb__sep">/</span>
                <span><?php the_title(); ?></span>
            </nav>

            <div class="service-hero__inner">
                <div class="service-hero__content">
                    <?php if ($hero_eyebrow) : ?><p class="service-hero__eyebrow text-badge"><?= esc_html($hero_eyebrow) ?></p><?php endif; ?>
                    <?php if ($hero_title) : ?><h1 class="service-hero__title title-1"><?= custom_unwrap_p($hero_title) ?></h1><?php endif; ?>
                    <?php if ($hero_text) : ?><p class="service-hero__text text"><?= nl2br(esc_html($hero_text)) ?></p><?php endif; ?>
                    <?php if ($hero_btn_text && $hero_btn_link) : ?>
                        <a href="<?= esc_url($hero_btn_link) ?>" class="btn service-hero__btn"><?= esc_html($hero_btn_text) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="services-directions">
        <?php if (!empty($directions_bg['url'])) : ?>
            <div class="services-directions__bg">
                <?= custom_bg_picture($directions_bg, $directions_bg_mobile, '100vw') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="services-directions__header">
                <?php if ($directions_eyebrow) : ?><p class="services-directions__eyebrow text-badge"><?= esc_html($directions_eyebrow) ?></p><?php endif; ?>
                <?php if ($directions_title) : ?><h2 class="services-directions__title title-2"><?= custom_unwrap_p($directions_title) ?></h2><?php endif; ?>
                <?php if ($directions_text) : ?><p class="services-directions__text text"><?= nl2br(esc_html($directions_text)) ?></p><?php endif; ?>
            </div>

            <?php get_template_part('template-parts/services-grid'); ?>

            <?php get_template_part('template-parts/consultation-cta', null, array('prefix' => 'services_cta', 'wrap' => false)); ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
