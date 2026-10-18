<?php
defined('ABSPATH') || exit;
get_header();

$front_page_id = (int) get_option('page_on_front');

while (have_posts()) : the_post();

    $hero_text      = get_field('service_hero_text');
    $hero_bg        = get_field('service_hero_bg_image');
    $hero_bg_mobile = get_field('service_hero_bg_image_mobile');
    $hero_features  = get_field('service_hero_features');
    $price          = get_field('service_price');
    $cta_btn_text   = get_field('service_cta_btn_text');
    $cta_btn_text   = $cta_btn_text ?: 'Рассчитать стоимость';

    $tech_eyebrow   = get_field('service_tech_eyebrow');
    $tech_title     = get_field('service_tech_title');
    $tech_text      = get_field('service_tech_text');
    $tech_bg        = get_field('service_tech_bg_image');
    $tech_bg_mobile = get_field('service_tech_bg_image_mobile');
    $tech_steps     = get_field('service_tech_steps');

    $price_eyebrow   = get_field('service_price_eyebrow');
    $price_title     = get_field('service_price_title');
    $price_text      = get_field('service_price_text');
    $price_note      = get_field('service_price_note');
    $price_factors   = get_field('service_price_factors');
    $price_bg        = get_field('service_price_bg_image');
    $price_bg_mobile = get_field('service_price_bg_image_mobile');

    $calc_title = get_field('service_calc_title') ?: get_field('calc_default_title', 'option');

    $portfolio_eyebrow  = $front_page_id ? get_field('portfolio_eyebrow', $front_page_id) : null;
    $portfolio_title    = $front_page_id ? get_field('portfolio_title', $front_page_id) : null;
    $portfolio_text     = $front_page_id ? get_field('portfolio_text', $front_page_id) : null;
    $portfolio_all_text = $front_page_id ? get_field('portfolio_all_text', $front_page_id) : null;

    $calc_section_text     = get_field('calc_default_text', 'option');
    $calc_section_btn_text = get_field('calc_default_btn_text', 'option');
    $calc_section_text_theme = get_field('calc_default_text_theme', 'option');
    $calc_section_note_icon = get_field('calc_default_note_icon', 'option');
    $calc_section_note_text = get_field('calc_default_note_text', 'option');
    $calc_section_bg        = get_field('calc_default_bg_image', 'option');
    $calc_section_bg_mobile = get_field('calc_default_bg_image_mobile', 'option');
    ?>

    <main class="main">

        <section class="service-hero-page">
            <?php if (!empty($hero_bg['url'])) : ?>
                <div class="service-hero-page__bg">
                    <?= custom_bg_picture($hero_bg, $hero_bg_mobile, '100vw', 'eager') ?>
                </div>
            <?php endif; ?>

            <div class="container">
            

                <div class="service-hero-page__inner">
                    <div class="service-hero-page__content">
                        <p class="service-hero-page__eyebrow text-badge">Услуги</p>
                        <h1 class="service-hero-page__title title-1"><?php the_title(); ?></h1>
                        <?php if ($hero_text) : ?><p class="service-hero-page__text text"><?= nl2br(esc_html($hero_text)) ?></p><?php endif; ?>
                        <?php if ($price) : ?><p class="service-hero-page__price title-4"><?= esc_html($price) ?></p><?php endif; ?>

                        <button type="button" class="btn service-hero-page__btn" data-open="calc-modal"><?= esc_html($cta_btn_text) ?></button>

                        <?php if ($hero_features) : ?>
                        <div class="service-hero-page__features">
                            <?php foreach ($hero_features as $feature) :
                                if (empty($feature['text'])) continue;
                            ?>
                                <div class="service-hero-page__feature">
                                    <?php if (!empty($feature['icon']['url'])) : ?>
                                        <?= custom_responsive_img($feature['icon'], '32px', 'service-hero-page__feature-icon') ?>
                                    <?php endif; ?>
                                    <span class="text-caption"><?= esc_html($feature['text']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="service-tech">
            <?php if (!empty($tech_bg['url'])) : ?>
                <div class="service-tech__bg">
                    <?= custom_bg_picture($tech_bg, $tech_bg_mobile, '100vw') ?>
                </div>
            <?php endif; ?>

            <div class="container">
                <div class="service-tech__header">
                    <div>
                        <?php if ($tech_eyebrow) : ?><p class="service-tech__eyebrow text-badge"><?= esc_html($tech_eyebrow) ?></p><?php endif; ?>
                        <?php if ($tech_title) : ?><h2 class="service-tech__title title-2"><?= custom_unwrap_p($tech_title) ?></h2><?php endif; ?>
                        <?php if ($tech_text) : ?><p class="service-tech__text text"><?= nl2br(esc_html($tech_text)) ?></p><?php endif; ?>
                    </div>
                </div>

                <?php if ($tech_steps) : ?>
                <div class="service-tech__grid">
                    <?php foreach ($tech_steps as $index => $step) : ?>
                        <div class="service-tech__step">
                            <span class="service-tech__num text-badge"><?= esc_html(sprintf('%02d', $index + 1)) ?></span>
                            <?php if (!empty($step['icon']['url'])) : ?>
                                <?= custom_responsive_img($step['icon'], '32px', 'service-tech__icon') ?>
                            <?php endif; ?>
                            <?php if (!empty($step['title'])) : ?><p class="service-tech__step-title title-5"><?= esc_html($step['title']) ?></p><?php endif; ?>
                            <?php if (!empty($step['text'])) : ?><p class="service-tech__step-text text-caption"><?= esc_html($step['text']) ?></p><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="service-price">
            <?php if (!empty($price_bg['url'])) : ?>
                <div class="service-price__bg">
                    <?= custom_bg_picture($price_bg, $price_bg_mobile, '100vw') ?>
                </div>
            <?php endif; ?>

            <div class="container">
                <div class="service-price__inner">
                    <div class="service-price__content">
                        <div class="service-price__header">
                            <?php if ($price_eyebrow) : ?><p class="service-price__eyebrow text-badge"><?= esc_html($price_eyebrow) ?></p><?php endif; ?>
                            <?php if ($price_title) : ?><h2 class="service-price__title title-2"><?= custom_unwrap_p($price_title) ?></h2><?php endif; ?>
                            <?php if ($price_text) : ?><p class="service-price__text text"><?= nl2br(esc_html($price_text)) ?></p><?php endif; ?>
                        </div>

                        <div class="service-price__card">
                            <p class="service-price__card-label text-caption">Стоимость работ</p>
                            <?php if ($price) : ?><p class="service-price__card-value title-3"><?= esc_html($price) ?></p><?php endif; ?>
                            <?php if ($price_note) : ?><p class="service-price__card-note text-caption"><?= esc_html($price_note) ?></p><?php endif; ?>
                        </div>
                        <button type="button" class="btn service-price__card-btn" data-open="calc-modal"><?= esc_html($cta_btn_text) ?></button>
                    </div>

                    <?php if ($price_factors) : ?>
                    <div class="service-price__grid">
                        <?php foreach ($price_factors as $index => $factor) : ?>
                            <div class="service-price__factor">
                                <span class="service-price__num text-badge"><?= esc_html(sprintf('%02d', $index + 1)) ?></span>
                                <?php if (!empty($factor['icon']['url'])) : ?>
                                    <?= custom_responsive_img($factor['icon'], '32px', 'service-price__icon') ?>
                                <?php endif; ?>
                                <?php if (!empty($factor['title'])) : ?><p class="service-price__factor-title title-5"><?= esc_html($factor['title']) ?></p><?php endif; ?>
                                <?php if (!empty($factor['text'])) : ?><p class="service-price__factor-text text-caption"><?= esc_html($factor['text']) ?></p><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="service-portfolio">
            <div class="container">
                <div class="service-portfolio__header">
                    <div>
                        <?php if ($portfolio_eyebrow) : ?><p class="service-portfolio__eyebrow text-badge"><?= esc_html($portfolio_eyebrow) ?></p><?php endif; ?>
                        <?php if ($portfolio_title) : ?><h2 class="service-portfolio__title title-2"><?= custom_unwrap_p($portfolio_title) ?></h2><?php endif; ?>
                        <?php if ($portfolio_text) : ?><p class="service-portfolio__text text"><?= nl2br(esc_html($portfolio_text)) ?></p><?php endif; ?>
                    </div>
                    <a href="<?= esc_url(custom_get_projects_page_url()) ?>" class="btn btn--outline service-portfolio__all"><?= esc_html($portfolio_all_text ?: 'Смотреть все проекты') ?></a>
                </div>

                <?php get_template_part('template-parts/home/portfolio-grid', null, array('service_id' => get_the_ID())); ?>
            </div>
        </section>

        <?php
        get_template_part('template-parts/calc-section', null, array(
            'eyebrow'     => 'Рассчитать стоимость',
            'title'     => $calc_title ? custom_unwrap_p($calc_title) : null,
            'text'      => $calc_section_text,
            'btn_text'  => $calc_section_btn_text,
            'id_prefix' => 'ss',
            'text_theme' => $calc_section_text_theme,
            'bg'        => $calc_section_bg,
            'bg_mobile' => $calc_section_bg_mobile,
            'short'     => true,
            'note_icon' => $calc_section_note_icon,
            'note_text' => $calc_section_note_text,
        ));
        ?>

    </main>

<?php endwhile; ?>

<?php get_footer(); ?>
