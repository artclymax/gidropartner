<?php
defined('ABSPATH') || exit;

$eyebrow   = $args['eyebrow'] ?? null;
$title     = $args['title'] ?? null;
$text      = $args['text'] ?? null;
$btn_text  = $args['btn_text'] ?? 'Получить расчёт';
$id_prefix = $args['id_prefix'] ?? 'calc';
$note_icon = $args['note_icon'] ?? null;
$note_text = $args['note_text'] ?? null;
$bg        = $args['bg'] ?? null;
$bg_mobile = $args['bg_mobile'] ?? null;
$short     = $args['short'] ?? false;
$text_theme = $args['text_theme'] ?? 'light';
?>

<section class="home-calc-section">

    <?php if (!empty($bg['url'])) : ?>
    <div class="home-calc-section__bg">
        <?= custom_bg_picture($bg, $bg_mobile, '100vw') ?>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="home-calc-section__inner">

            <div class="home-calc-section__content home-calc-section__content--theme-<?= esc_attr($text_theme) ?>">
                <?php if ($eyebrow) : ?><p class="home-calc-section__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
                <?php if ($title) : ?><h2 class="home-calc-section__title title-2"><?= $title ?></h2><?php endif; ?>
                <?php if ($text) : ?><p class="home-calc-section__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>

                <?php if ($note_text) : ?>
                    <div class="home-calc-section__note">
                        <?php if (!empty($note_icon['url'])) : ?>
                            <?= custom_responsive_img($note_icon, '32px', 'home-calc-section__note-icon') ?>
                        <?php endif; ?>
                        <span class="text"><?= esc_html($note_text) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="home-calc-section__form-wrap">
                <?php get_template_part('template-parts/calc-form', null, array('id_prefix' => $id_prefix, 'submit_text' => $btn_text, 'short' => $short)); ?>
            </div>

        </div>
    </div>
</section>
