<?php
defined('ABSPATH') || exit;

$eyebrow  = function_exists('get_field') ? get_field('coating_layers_eyebrow') : null;
$title    = function_exists('get_field') ? get_field('coating_layers_title') : null;
$text     = function_exists('get_field') ? get_field('coating_layers_text') : null;
$image        = function_exists('get_field') ? get_field('coating_layers_image') : null;
$image_mobile = function_exists('get_field') ? get_field('coating_layers_image_mobile') : null;
$features = function_exists('get_field') ? get_field('coating_layers_features') : null;
$btn_text = function_exists('get_field') ? get_field('coating_layers_btn_text') : null;
$btn_text = $btn_text ?: 'Подобрать покрытие';
?>

<section class="home-coating-layers">

    <?php if (!empty($image['url'])) : ?>
    <div class="home-coating-layers__bg">
        <?= custom_bg_picture($image, $image_mobile, '100vw') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-coating-layers__inner">

            <div class="home-coating-layers__content">
                <?php if ($eyebrow) : ?><p class="home-coating-layers__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
                <?php if ($title) : ?><h2 class="home-coating-layers__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
                <?php if ($text) : ?><p class="home-coating-layers__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>

                <?php if ($features) : ?>
                <div class="home-coating-layers__features">
                    <?php foreach ($features as $i => $feature) : ?>
                        <?php if ($i % 2 !== 0 && $i !== 0): ?>
                            <span></span>
                        <?php endif; ?>
                        <div class="home-coating-layers__feature">
                            <?php if (!empty($feature['icon']['url'])) : ?>
                                <div class="home-coating-layers__feature-icon">
                                    <?= custom_responsive_img($feature['icon'], '32px', '') ?>
                                </div>
                            <?php endif; ?>
                            <div class="home-coating-layers__feature-body">
                                <?php if (!empty($feature['title'])) : ?><p class="home-coating-layers__feature-title text"><?= esc_html($feature['title']) ?></p><?php endif; ?>
                                <?php if (!empty($feature['text'])) : ?><p class="home-coating-layers__feature-text text-s"><?= esc_html($feature['text']) ?></p><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <button type="button" class="btn home-coating-layers__btn" data-open="calc-modal"><?= esc_html($btn_text) ?></button>
            </div>

        </div>
    </div>
</section>
