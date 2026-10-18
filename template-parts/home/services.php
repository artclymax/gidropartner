<?php
defined('ABSPATH') || exit;

$eyebrow      = function_exists('get_field') ? get_field('services_eyebrow') : null;
$title        = function_exists('get_field') ? get_field('services_title') : null;
$text         = function_exists('get_field') ? get_field('services_text') : null;
$bg           = function_exists('get_field') ? get_field('services_bg_image') : null;
$bg_mobile    = function_exists('get_field') ? get_field('services_bg_image_mobile') : null;
?>

<section class="home-services">

    <?php if (!empty($bg['url'])) : ?>
    <div class="home-services__bg">
        <?= custom_bg_picture($bg, $bg_mobile, '100vw') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-services__header">
            <?php if ($eyebrow) : ?><p class="home-services__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
            <?php if ($title) : ?><h2 class="home-services__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
            <?php if ($text) : ?><p class="home-services__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>
        </div>

        <?php get_template_part('template-parts/services-grid'); ?>
    </div>
</section>
