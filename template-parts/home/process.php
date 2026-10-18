<?php
defined('ABSPATH') || exit;

$prefix       = $args['prefix'] ?? 'process';
$eyebrow      = function_exists('get_field') ? get_field("{$prefix}_eyebrow") : null;
$title        = function_exists('get_field') ? get_field("{$prefix}_title") : null;
$text         = function_exists('get_field') ? get_field("{$prefix}_text") : null;
$bg           = function_exists('get_field') ? get_field("{$prefix}_bg_image") : null;
$bg_mobile    = function_exists('get_field') ? get_field("{$prefix}_bg_image_mobile") : null;
$steps        = function_exists('get_field') ? get_field("{$prefix}_steps") : null;
$btn_text     = function_exists('get_field') ? get_field("{$prefix}_btn_text") : null;
$btn_text     = $btn_text ?: 'Обсудить проект';
?>

<section class="home-process">

    <?php if (!empty($bg['url'])) : ?>
    <div class="home-process__bg">
        <?= custom_bg_picture($bg, $bg_mobile, '100vw') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-process__header">
            <?php if ($eyebrow) : ?><p class="home-process__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
            <?php if ($title) : ?><h2 class="home-process__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
            <?php if ($text) : ?><p class="home-process__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>
        </div>

        <?php if ($steps) : ?>
        <div class="home-process__grid">
             <?php foreach (array_chunk($steps, 3, true) as $row_steps) : ?>
                <div class="home-process__row">
                    <?php foreach ($row_steps as $index => $step) : ?>
                        <div class="home-process__step">
                            <div class="home-process__step-top">
                                <?php if (!empty($step['icon']['url'])) : ?>
                                    <?= custom_responsive_img($step['icon'], '40px', 'home-process__icon') ?>
                                <?php endif; ?>
                                <span class="home-process__num title-3"><?= esc_html(sprintf('%02d', $index + 1)) ?></span>
                            </div>
                           <div class="home-process__wrapper">
                             <?php if (!empty($step['title'])) : ?><p class="home-process__step-title title-5"><?= esc_html($step['title']) ?></p><?php endif; ?>
                            <?php if (!empty($step['text'])) : ?><p class="home-process__step-text text-s"><?= esc_html($step['text']) ?></p><?php endif; ?>
                           </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <button type="button" class="btn home-process__btn" data-open="discuss-modal"><?= esc_html($btn_text) ?></button>
    </div>
</section>
