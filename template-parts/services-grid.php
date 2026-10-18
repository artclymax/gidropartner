<?php
defined('ABSPATH') || exit;

$services = get_posts(array(
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
));
?>

<?php if ($services) : ?>
<div class="home-services__grid">
    <?php foreach ($services as $index => $service_post) :
        $icon        = function_exists('get_field') ? get_field('service_icon', $service_post->ID) : null;
        $description = function_exists('get_field') ? get_field('service_description', $service_post->ID) : '';
        $price       = function_exists('get_field') ? get_field('service_price', $service_post->ID) : '';
        $link        = function_exists('get_field') ? get_field('service_link', $service_post->ID) : null;
        $link        = $link ?: get_permalink($service_post->ID);
    ?>
        <div class="home-services__card">
            <div class="home-services__card-wrapper">
                <span class="home-services__num title-2"><?= esc_html(sprintf('%02d', $index + 1)) ?></span>
                <span class="home-services__card-sep"></span>
                <?php if (!empty($icon['url'])) : ?>
                    <?= custom_responsive_img($icon, '72px', 'home-services__icon') ?>
                <?php endif; ?>
            </div>
            <p class="home-services__card-title title-4"><?= esc_html($service_post->post_title) ?></p>
            <?php if ($description) : ?><p class="home-services__card-text text-s"><?= esc_html($description) ?></p><?php endif; ?>
            <div class="home-services__card-bottom">
                <?php if ($price) : ?><p class="home-services__price title-4"><?= esc_html($price) ?></p><?php endif; ?>
            <?php if ($link) : ?>
                <a href="<?= esc_url($link) ?>" class="home-services__link text-button">
                    Подробнее
                    <span>
                        <svg width="6" height="11" viewBox="0 0 6 11" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.5 0.5L5.16667 5.16667L0.5 9.83333" stroke="#3F3FCD" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

                    </span>
                </a>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
