<?php
/**
 * Template Name: Проекты
 */
defined('ABSPATH') || exit;
get_header();

$hero_eyebrow  = get_field('projects_hero_eyebrow');
$hero_title    = get_field('projects_hero_title');
$hero_text     = get_field('projects_hero_text');
$hero_btn_text = get_field('projects_hero_btn_text');
$hero_btn_text = $hero_btn_text ?: 'Рассчитать стоимость';
$hero_bg        = get_field('projects_hero_bg_image');
$hero_bg_mobile = get_field('projects_hero_bg_image_mobile');

$objects_title = get_field('projects_objects_title');
$objects_title = $objects_title ?: 'Свежие работы в Telegram';
$objects_text  = get_field('projects_objects_text');
$objects_bg        = get_field('projects_objects_bg_image');
$objects_bg_mobile = get_field('projects_objects_bg_image_mobile');
$telegram_url  = get_field('telegram_channel_url', (int) get_option('page_on_front'));
$telegram_btn  = get_field('telegram_btn_text', (int) get_option('page_on_front'));
$telegram_btn  = $telegram_btn ?: 'Смотреть все обновления в телеграм';

$calc_eyebrow   = get_field('projects_calc_eyebrow') ?: get_field('calc_default_eyebrow', 'option');
$calc_title_raw = get_field('projects_calc_title') ?: get_field('calc_default_title', 'option');
$calc_text      = get_field('projects_calc_text') ?: get_field('calc_default_text', 'option');
$calc_note_icon = get_field('projects_calc_note_icon') ?: get_field('calc_default_note_icon', 'option');
$calc_note_text = get_field('projects_calc_note_text') ?: get_field('calc_default_note_text', 'option');
$calc_btn_text  = get_field('projects_calc_btn_text') ?: get_field('calc_default_btn_text', 'option');
$calc_text_theme = get_field('projects_calc_text_theme') ?: get_field('calc_default_text_theme', 'option');
$calc_bg        = get_field('calc_default_bg_image', 'option');
$calc_bg_mobile = get_field('calc_default_bg_image_mobile', 'option');

$paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
$projects_query = new WP_Query(array(
    'post_type'      => 'project',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$recent_objects = get_posts(array(
    'post_type'      => 'recent_object',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
));
?>

<main class="main">

    <section class="projects-hero">
        <?php if (!empty($hero_bg['url'])) : ?>
        <div class="projects-hero__bg">
            <?= custom_bg_picture($hero_bg, $hero_bg_mobile, '100vw') ?>
        </div>
        <?php endif; ?>

        <div class="container">
            <nav class="breadcrumb text-caption" aria-label="Breadcrumb">
                <a href="<?= esc_url(home_url('/')) ?>">Главная</a>
                <span class="breadcrumb__sep">/</span>
                <span><?php the_title(); ?></span>
            </nav>

            <div class="projects-hero__inner">
                <div class="projects-hero__content">
                    <?php if ($hero_eyebrow) : ?><p class="projects-hero__eyebrow text-badge"><?= esc_html($hero_eyebrow) ?></p><?php endif; ?>
                    <?php if ($hero_title) : ?><h1 class="projects-hero__title title-1"><?= custom_unwrap_p($hero_title) ?></h1><?php endif; ?>
                    <?php if ($hero_text) : ?><p class="projects-hero__text text"><?= nl2br(esc_html($hero_text)) ?></p><?php endif; ?>
                    <button type="button" class="btn projects-hero__btn" data-open="calc-modal"><?= esc_html($hero_btn_text) ?></button>
                </div>
            </div>
        </div>
    </section>

    <section class="projects-grid-section">
        <div class="container">
            <?php if ($projects_query->have_posts()) : ?>
                <div class="projects-grid">
                    <?php while ($projects_query->have_posts()) : $projects_query->the_post();
                        $project_id = get_the_ID();
                        $image      = get_field('project_image');
                        $subtitle   = get_field('project_subtitle');
                        $area       = get_field('project_area');
                        $work_type  = get_field('project_work_type');
                    ?>
                        <div class="home-portfolio-grid__card">
                            <?php if (!empty($image['url'])) : ?>
                                <button type="button" class="home-portfolio-grid__photo-btn" data-open="project-photo-<?= (int) $project_id ?>">
                                    <?= custom_responsive_img($image, '600px', 'home-portfolio-grid__photo') ?>
                                </button>
                            <?php endif; ?>
                            <div class="home-portfolio-grid__body">
                                <div class="home-portfolio-grid__heading">
                                    <p class="home-portfolio-grid__title title-3"><?php the_title(); ?></p>
                                    <?php if ($subtitle) : ?><p class="home-portfolio-grid__subtitle text"><?= esc_html($subtitle) ?></p><?php endif; ?>
                                </div>
                                <?php if ($area || $work_type) : ?>
                                <div class="home-portfolio-grid__stats">
                                    <?php if ($area) : ?><div class="home-portfolio-grid__stat"><span class="text-xs">Площадь:</span><span class="title-4"><?= esc_html($area) ?></span></div><?php endif; ?>
                                    <?php if ($work_type) : ?><div class="home-portfolio-grid__stat"><span class="text-xs">Тип работ:</span><span class="text-s"><?= esc_html($work_type) ?></span></div><?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($image['url'])) : ?>
                            <div id="project-photo-<?= (int) $project_id ?>" class="modal photo-modal" data-closable="project-photo-<?= (int) $project_id ?>">
                                <div class="modal__overlay"></div>
                                <div class="photo-modal__dialog">
                                    <button type="button" class="modal__close" data-open="project-photo-<?= (int) $project_id ?>" aria-label="Закрыть"><?= custom_icon_close() ?></button>
                                    <?= custom_responsive_img($image, '90vw') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

                <?php
                $big = 999999999;
                $pagination = paginate_links(array(
                    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, $paged),
                    'total'     => $projects_query->max_num_pages,
                    'prev_text' => '←',
                    'next_text' => '→',
                ));
                if ($pagination) : ?>
                    <div class="projects-grid__pagination"><?= $pagination ?></div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="projects-objects">
        <?php if (!empty($objects_bg['url'])) : ?>
        <div class="projects-objects__bg">
            <?= custom_bg_picture($objects_bg, $objects_bg_mobile, '100vw') ?>
        </div>
        <?php endif; ?>

        <div class="container">
            <div class="projects-objects__header">
                <div>
                    <p class="projects-objects__title title-2"><?= esc_html($objects_title) ?></p>
                    <?php if ($objects_text) : ?><p class="projects-objects__text text"><?= esc_html($objects_text) ?></p><?php endif; ?>
                </div>
                <?php if ($telegram_url) : ?>
                    <a href="<?= esc_url($telegram_url) ?>" target="_blank" rel="noopener" class="btn projects-objects__btn">
                        <?= custom_icon_telegram() ?>
                       <?= esc_html($telegram_btn) ?>
                        <?= custom_icon_arrow_right() ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($recent_objects) : ?>
            <div class="projects-objects__grid">
                <?php foreach ($recent_objects as $object_post) :
                    $obj_image = get_field('object_image', $object_post->ID);
                    $obj_desc  = get_field('object_description', $object_post->ID);
                    $obj_link  = get_field('object_link', $object_post->ID);
                    if (empty($obj_image['url'])) continue;
                ?>
                    <?php if ($obj_link) : ?>
                        <a href="<?= esc_url($obj_link) ?>" target="_blank" rel="noopener" class="projects-objects__item">
                            <?= custom_responsive_img($obj_image, '250px', '', 'lazy', $obj_desc) ?>
                        </a>
                    <?php else : ?>
                        <div class="projects-objects__item">
                            <?= custom_responsive_img($obj_image, '250px', '', 'lazy', $obj_desc) ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    get_template_part('template-parts/calc-section', null, array(
        'eyebrow'   => $calc_eyebrow,
        'title'     => $calc_title_raw ? custom_unwrap_p($calc_title_raw) : null,
        'text'      => $calc_text,
        'btn_text'  => $calc_btn_text,
        'id_prefix' => 'pr',
        'note_icon' => $calc_note_icon,
        'note_text' => $calc_note_text,
        'text_theme' => $calc_text_theme,
        'bg'        => $calc_bg,
        'bg_mobile' => $calc_bg_mobile,
        'short'     => true,
    ));
    ?>

</main>

<?php get_footer(); ?>
