<?php
defined('ABSPATH') || exit;

$eyebrow  = function_exists('get_field') ? get_field('approach_eyebrow') : null;
$title    = function_exists('get_field') ? get_field('approach_title') : null;
$text     = function_exists('get_field') ? get_field('approach_text') : null;
$btn_text = function_exists('get_field') ? get_field('approach_btn_text') : null;
$btn_text = $btn_text ?: 'Обсудить проект';
$features = function_exists('get_field') ? get_field('approach_features') : null;

$clients_title = function_exists('get_field') ? get_field('clients_title') : null;
$clients_title = $clients_title ?: 'Нам доверяют';
$clients_text  = function_exists('get_field') ? get_field('clients_text') : null;
$clients_logos = function_exists('get_field') ? get_field('clients_logos') : null;
?>

<section class="home-approach">
    <div class="container">
        <div class="home-approach__inner">

            <div class="home-approach__content">
                <?php if ($eyebrow) : ?><p class="home-approach__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
                <?php if ($title) : ?><h2 class="home-approach__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
                <?php if ($text) : ?><p class="home-approach__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>
                <button type="button" class="btn home-approach__btn" data-open="discuss-modal"><?= esc_html($btn_text) ?></button>
            </div>

            <?php if ($features) : ?>
            <div class="home-approach__grid">
                <?php foreach ($features as $feature) : ?>
                    <div class="home-approach__card">
                        <?php if (!empty($feature['icon']['url'])) : ?>
                            <?= custom_responsive_img($feature['icon'], '72px', 'home-approach__icon') ?>
                        <?php endif; ?>
                        <?php if (!empty($feature['title'])) : ?><p class="home-approach__card-title title-5"><?= esc_html($feature['title']) ?></p><?php endif; ?>
                        <?php if (!empty($feature['text'])) : ?><p class="home-approach__card-text text-s"><?= esc_html($feature['text']) ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>

        <div class="home-approach__divider"></div>

        <div class="home-approach__clients">
            <div class="home-approach__clients-content">
                <p class="home-approach__clients-title title-4"><?= esc_html($clients_title) ?></p>
                <?php if ($clients_text) : ?><p class="home-approach__clients-text text"><?= nl2br(esc_html($clients_text)) ?></p><?php endif; ?>
            </div>

            <div class="home-approach__clients-marquee">
                <?php get_template_part('template-parts/clients-marquee', null, array('logos' => $clients_logos)); ?>
            </div>
        </div>
    </div>
</section>
