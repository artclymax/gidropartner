<?php
defined('ABSPATH') || exit;

$eyebrow  = function_exists('get_field') ? get_field('portfolio_eyebrow') : null;
$title    = function_exists('get_field') ? get_field('portfolio_title') : null;
$text     = function_exists('get_field') ? get_field('portfolio_text') : null;
$all_text = function_exists('get_field') ? get_field('portfolio_all_text') : null;
$all_text = $all_text ?: 'Смотреть все проекты';
?>

<section class="home-portfolio">
    <div class="container">
        <div class="home-portfolio__header">
            <div class="home-portfolio__header-text">
                <?php if ($eyebrow) : ?><p class="home-portfolio__eyebrow text-badge"><?= esc_html($eyebrow) ?></p><?php endif; ?>
                <?php if ($title) : ?><h2 class="home-portfolio__title title-2"><?= custom_unwrap_p($title) ?></h2><?php endif; ?>
                <?php if ($text) : ?><p class="home-portfolio__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>
            </div>
            <a href="<?= esc_url(custom_get_projects_page_url()) ?>" class="btn btn--outline home-portfolio__btn"><?= esc_html($all_text) ?></a>
        </div>

        <?php get_template_part('template-parts/home/portfolio-grid'); ?>
    </div>
</section>
