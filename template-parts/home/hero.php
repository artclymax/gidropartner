<?php
defined('ABSPATH') || exit;

$bg          = function_exists('get_field') ? get_field('hero_bg_image') : null;
$bg_mobile   = function_exists('get_field') ? get_field('hero_bg_image_mobile') : null;
$title       = function_exists('get_field') ? get_field('hero_title') : null;
$description = function_exists('get_field') ? get_field('hero_description') : null;
$btn_text    = function_exists('get_field') ? get_field('hero_btn_text') : null;
$btn_text    = $btn_text ?: 'Рассчитать стоимость';
$stats       = function_exists('get_field') ? get_field('hero_stats') : null;
?>

<section class="home-hero">

    <?php if (!empty($bg['url'])) : ?>
    <div class="home-hero__bg">
        <?= custom_bg_picture($bg, $bg_mobile, '100vw', 'eager') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-hero__inner">

            <div class="home-hero__content">
               <div class="home-hero__wrapper">
                 <?php if ($title) : ?><h1 class="home-hero__title title-1"><?= custom_unwrap_p($title) ?></h1><?php endif; ?>
                <?php if ($description) : ?><p class="home-hero__text text"><?= nl2br(esc_html($description)) ?></p><?php endif; ?>

                <button type="button" class="btn home-hero__btn" data-open="calc-modal"><?= esc_html($btn_text) ?></button>
               </div>

                <?php if ($stats) : ?>
                <div class="home-hero__stats">
                    <?php foreach ($stats as $i => $stat) : ?>
                        <?php if ($i !== 0): ?>
                            <span></span>
                        <?php endif; ?>
                        <div class="home-hero__stat">
                            <?php if (!empty($stat['icon']['url'])) : ?>
                                <?= custom_responsive_img($stat['icon'], '48px', 'home-hero__stat-icon') ?>
                            <?php endif; ?>
                            <?php if (!empty($stat['value'])) : ?><div class="home-hero__stat-value title-3"><?= esc_html($stat['value']) ?></div><?php endif; ?>
                            <?php if (!empty($stat['label'])) : ?>
                                <div class="home-hero__stat-label text-s<?= !empty($stat['label_mobile']) ? ' home-hero__stat-label--desktop' : '' ?>"><?= nl2br(esc_html($stat['label'])) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($stat['label_mobile'])) : ?>
                                <div class="home-hero__stat-label home-hero__stat-label--mobile text-s"><?= nl2br(esc_html($stat['label_mobile'])) ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('template-parts/home/objects'); ?>

        </div>
    </div>

</section>
