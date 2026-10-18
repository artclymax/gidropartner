<?php
/**
 * Template Name: О компании
 */
defined('ABSPATH') || exit;
get_header();

$hero_eyebrow    = get_field('about_hero_eyebrow');
$hero_title      = get_field('about_hero_title');
$hero_text       = get_field('about_hero_text');
$hero_btn_text   = get_field('about_hero_btn_text');
$hero_btn_text   = $hero_btn_text ?: 'Рассчитать стоимость';
$hero_bg         = get_field('about_hero_bg_image');
$hero_bg_mobile  = get_field('about_hero_bg_image_mobile');

$approach_eyebrow    = get_field('about_approach_eyebrow');
$approach_title      = get_field('about_approach_title');
$approach_text       = get_field('about_approach_text');
$approach_features   = get_field('about_approach_features');
$approach_bg         = get_field('about_approach_bg_image');
$approach_bg_mobile  = get_field('about_approach_bg_image_mobile');

$focus_eyebrow   = get_field('about_focus_eyebrow');
$focus_title     = get_field('about_focus_title');
$focus_text      = get_field('about_focus_text');
$focus_bg        = get_field('about_focus_bg_image');
$focus_bg_mobile = get_field('about_focus_bg_image_mobile');
$focus_items     = get_field('about_focus_items');

$clients_title        = get_field('about_clients_title');
$clients_title_lines  = preg_split('/\r\n|\r|\n/', trim((string) $clients_title));
$clients_title_first  = $clients_title_lines[0] ?? '';
$clients_title_rest   = implode(' ', array_slice($clients_title_lines, 1));
$clients_bg         = get_field('about_clients_bg_image');
$clients_bg_mobile  = get_field('about_clients_bg_image_mobile');
$clients_logos      = get_field('about_clients_logos');
?>

<main class="main">

    <section class="about-hero">
        <?php if (!empty($hero_bg['url'])) : ?>
        <div class="about-hero__bg">
            <?= custom_bg_picture($hero_bg, $hero_bg_mobile, '100vw') ?>
        </div>
        <?php endif; ?>

        <div class="container">
            <nav class="breadcrumb text-caption" aria-label="Breadcrumb">
                <a href="<?= esc_url(home_url('/')) ?>">Главная</a>
                <span class="breadcrumb__sep">/</span>
                <span><?php the_title(); ?></span>
            </nav>

            <div class="about-hero__inner">
                <div class="about-hero__content">
                    <?php if ($hero_eyebrow) : ?><p class="about-hero__eyebrow text-badge"><?= esc_html($hero_eyebrow) ?></p><?php endif; ?>
                    <?php if ($hero_title) : ?><h1 class="about-hero__title title-1"><?= custom_unwrap_p($hero_title) ?></h1><?php endif; ?>
                    <?php if ($hero_text) : ?><p class="about-hero__text text"><?= nl2br(esc_html($hero_text)) ?></p><?php endif; ?>
                    <button type="button" class="btn about-hero__btn" data-open="calc-modal"><?= esc_html($hero_btn_text) ?></button>
                </div>
            </div>
        </div>
    </section>

    <section class="about-approach">
        <?php if (!empty($approach_bg['url'])) : ?>
        <div class="about-approach__bg">
            <?= custom_bg_picture($approach_bg, $approach_bg_mobile, '100vw') ?>
        </div>
        <?php endif; ?>

        <div class="container">
            <div class="about-approach__header">
                <?php if ($approach_eyebrow) : ?><p class="about-approach__eyebrow text-badge"><?= esc_html($approach_eyebrow) ?></p><?php endif; ?>
                <?php if ($approach_title) : ?><h2 class="about-approach__title title-2"><?= custom_unwrap_p($approach_title) ?></h2><?php endif; ?>
                <?php if ($approach_text) : ?><p class="about-approach__text text"><?= nl2br(esc_html($approach_text)) ?></p><?php endif; ?>
            </div>

            <?php if ($approach_features) : ?>
            <div class="about-approach__grid">
                <?php foreach ($approach_features as $feature) : ?>
                    <div class="about-approach__card">
                        <?php if (!empty($feature['icon']['url'])) : ?>
                            <?= custom_responsive_img($feature['icon'], '40px', 'about-approach__icon') ?>
                        <?php endif; ?>
                        <?php if (!empty($feature['title'])) : ?><p class="about-approach__card-title title-5"><?= esc_html($feature['title']) ?></p><?php endif; ?>
                        <?php if (!empty($feature['text'])) : ?><p class="about-approach__card-text text-s"><?= esc_html($feature['text']) ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="about-focus">
        <?php if (!empty($focus_bg['url'])) : ?>
            <div class="about-focus__bg">
                <?= custom_bg_picture($focus_bg, $focus_bg_mobile, '100vw') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="about-focus__header">
                <?php if ($focus_eyebrow) : ?><p class="about-focus__eyebrow text-badge"><?= esc_html($focus_eyebrow) ?></p><?php endif; ?>
                <?php if ($focus_title) : ?><h2 class="about-focus__title title-2"><?= custom_unwrap_p($focus_title) ?></h2><?php endif; ?>
                <?php if ($focus_text) : ?><p class="about-focus__text text"><?= nl2br(esc_html($focus_text)) ?></p><?php endif; ?>
            </div>

            <?php if ($focus_items) : ?>
            <div class="about-focus__grid">
                <?php foreach ($focus_items as $item) : ?>
                    <div class="about-focus__card">
                        <?php if (!empty($item['icon']['url'])) : ?>
                            <?= custom_responsive_img($item['icon'], '40px', 'about-focus__icon') ?>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])) : ?><p class="about-focus__card-title title-5"><?= esc_html($item['title']) ?></p><?php endif; ?>
                        <?php if (!empty($item['text'])) : ?><p class="about-focus__card-text text-caption"><?= esc_html($item['text']) ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php get_template_part('template-parts/home/process', null, array('prefix' => 'about_process')); ?>

    <section class="about-clients">
        <?php if (!empty($clients_bg['url'])) : ?>
        <div class="about-clients__bg">
            <?= custom_bg_picture($clients_bg, $clients_bg_mobile, '100vw') ?>
        </div>
        <?php endif; ?>

        <div class="container">
            <div class="about-clients__inner">
                <div class="about-clients__content">
                    <?php if ($clients_title_first) : ?>
                    <p class="about-clients__title title-4">
                        <span class="about-clients__title-accent"><?= esc_html($clients_title_first) ?></span>
                        <?php if ($clients_title_rest) : ?><br><?= esc_html($clients_title_rest) ?><?php endif; ?>
                    </p>
                    <?php endif; ?>
                </div>

                <div class="about-clients__marquee">
                    <?php get_template_part('template-parts/clients-marquee', null, array('logos' => $clients_logos, 'modifier' => 'about')); ?>
                </div>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/consultation-cta', null, array('prefix' => 'about_cta', 'modifier' => 'about')); ?>

</main>

<?php get_footer(); ?>
