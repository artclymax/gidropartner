<?php
defined('ABSPATH') || exit;

$service_id = $args['service_id'] ?? null;

$query_args = array(
    'post_type'      => 'project',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
);

if ($service_id) {
    $query_args['meta_query'] = array(
        array('key' => 'project_service', 'value' => $service_id, 'compare' => '='),
    );
}

$projects = get_posts($query_args);

// Если у этой услуги ещё нет своих проектов — показываем последние проекты вообще
if ($service_id && empty($projects)) {
    unset($query_args['meta_query']);
    $projects = get_posts($query_args);
}
?>

<?php if ($projects) : ?>
<div class="home-portfolio-grid swiper">
    <div class="swiper-wrapper">
        <?php foreach ($projects as $project_post) :
            $project_id = $project_post->ID;
            $image      = function_exists('get_field') ? get_field('project_image', $project_id) : null;
            $subtitle   = function_exists('get_field') ? get_field('project_subtitle', $project_id) : '';
            $area       = function_exists('get_field') ? get_field('project_area', $project_id) : '';
            $work_type  = function_exists('get_field') ? get_field('project_work_type', $project_id) : '';
        ?>
            <div class="swiper-slide home-portfolio-grid__card">
                <?php if (!empty($image['url'])) : ?>
                    <button type="button" class="home-portfolio-grid__photo-btn" data-open="project-photo-<?= (int) $project_id ?>">
                        <?= custom_responsive_img($image, '600px', 'home-portfolio-grid__photo') ?>
                    </button>
                <?php endif; ?>
                <div class="home-portfolio-grid__body">
                    <div class="home-portfolio-grid__heading">
                        <p class="home-portfolio-grid__title title-3"><?= esc_html($project_post->post_title) ?></p>
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
        <?php endforeach; ?>
    </div>
</div>

<div class="home-portfolio-grid__controls">
    <button type="button" class="home-portfolio-grid__nav-btn swiper-button-prev" aria-label="Предыдущий"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.5 12H21" stroke="#3F3FCD" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18 7L23 12L18 17" stroke="#3F3FCD" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>
    <button type="button" class="home-portfolio-grid__nav-btn swiper-button-next" aria-label="Следующий"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.5 12H21" stroke="#3F3FCD" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M18 7L23 12L18 17" stroke="#3F3FCD" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>
</div>

<?php foreach ($projects as $project_post) :
    $project_id = $project_post->ID;
    $image      = function_exists('get_field') ? get_field('project_image', $project_id) : null;
    if (empty($image['url'])) continue;
?>
    <div id="project-photo-<?= (int) $project_id ?>" class="modal photo-modal" data-closable="project-photo-<?= (int) $project_id ?>">
        <div class="modal__overlay"></div>
        <div class="photo-modal__dialog">
            <button type="button" class="modal__close" data-open="project-photo-<?= (int) $project_id ?>" aria-label="Закрыть"><?= custom_icon_close() ?></button>
            <?= custom_responsive_img($image, '90vw') ?>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
