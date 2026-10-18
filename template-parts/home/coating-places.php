<?php
defined('ABSPATH') || exit;

$eyebrow = function_exists('get_field') ? get_field('coating_places_eyebrow') : null;
$title   = function_exists('get_field') ? get_field('coating_places_title') : null;
$text    = function_exists('get_field') ? get_field('coating_places_text') : null;
$image        = function_exists('get_field') ? get_field('coating_places_image') : null;
$image_mobile = function_exists('get_field') ? get_field('coating_places_image_mobile') : null;
$items   = function_exists('get_field') ? get_field('coating_places_items') : null;
?>

<section class="home-coating-places">

    <?php if (!empty($image['url'])) : ?>
    <div class="home-coating-places__bg">
        <?= custom_bg_picture($image, $image_mobile, '100vw') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-coating-places__inner">

            <div class="home-coating-places__content">
                <?php if ($eyebrow) : ?><p class="home-coating-places__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
                <?php if ($title) : ?><h2 class="home-coating-places__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
                <?php if ($text) : ?><p class="home-coating-places__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>

                <?php if ($items) : ?>
                <ul class="home-coating-places__list">
                    <?php foreach ($items as $i => $item) : if (empty($item['label'])) continue; ?>
                        <?php if ($i !== 0): ?>
                            <span></span>
                        <?php endif; ?>
                        <li class="home-coating-places__item title-3"><?= custom_icon_plus() ?><?= esc_html($item['label']) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
