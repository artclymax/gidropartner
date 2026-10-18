<?php
defined('ABSPATH') || exit;

$objects_title    = function_exists('get_field') ? get_field('objects_title') : null;
$objects_title    = $objects_title ?: 'Актуальные объекты';
$objects_subtitle = function_exists('get_field') ? get_field('objects_subtitle') : null;
$telegram_url     = function_exists('get_field') ? get_field('telegram_channel_url') : null;
$telegram_btn     = function_exists('get_field') ? get_field('telegram_btn_text') : null;
$telegram_btn     = $telegram_btn ?: 'Смотреть все обновления в телеграм';

$objects = get_posts(array(
    'post_type'      => 'recent_object',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
));
?>

<div class="home-objects">
    <div class="home-objects__header">
        <p class="home-objects__title title-4"><?= esc_html($objects_title) ?></p>
        <?php if ($objects_subtitle) : ?>
            <p class="home-objects__subtitle text">
                <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19 0.602225L15.9946 16.2923C15.9946 16.2923 15.5741 17.3801 14.4189 16.8584L7.48458 11.3526L7.45242 11.3364C8.38909 10.4654 15.6524 3.70266 15.9698 3.39612C16.4613 2.92136 16.1562 2.63873 15.5856 2.99736L4.85679 10.053L0.717638 8.61077C0.717638 8.61077 0.0662573 8.37083 0.00359284 7.84911C-0.0598962 7.32653 0.739076 7.0439 0.739076 7.0439L17.6131 0.188948C17.6131 0.188948 19 -0.44207 19 0.602225Z" fill="white"/>
</svg>

                <span><?= esc_html($objects_subtitle) ?></span>
            </p>
        <?php endif; ?>
    </div>

    <?php if ($objects) : ?>
    <div class="home-objects__grid">
        <?php foreach ($objects as $object_post) :
            $image = function_exists('get_field') ? get_field('object_image', $object_post->ID) : null;
            $desc  = function_exists('get_field') ? get_field('object_description', $object_post->ID) : '';
            $link  = function_exists('get_field') ? get_field('object_link', $object_post->ID) : null;
            if (empty($image['url'])) continue;
        ?>
            <?php if ($link) : ?>
                <a href="<?= esc_url($link) ?>" target="_blank" rel="noopener" class="home-objects__item">
                    <?= custom_responsive_img($image, '200px', '', 'lazy', $desc) ?>
                </a>
            <?php else : ?>
                <div class="home-objects__item">
                    <?= custom_responsive_img($image, '200px', '', 'lazy', $desc) ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($telegram_url) : ?>
        <a href="<?= esc_url($telegram_url) ?>" target="_blank" rel="noopener" class="btn btn--outline home-objects__btn">
            <?= custom_icon_telegram() ?>
            <span class="text-button"><?= esc_html($telegram_btn) ?></span>
            <?= custom_icon_arrow_right() ?>
        </a>
    <?php endif; ?>
</div>
