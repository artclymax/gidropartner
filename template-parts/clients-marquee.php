<?php
defined('ABSPATH') || exit;

$logos    = $args['logos'] ?? null;
$modifier = $args['modifier'] ?? '';
$class    = 'clients-marquee' . ($modifier ? ' clients-marquee--' . $modifier : '');
if (empty($logos)) return;

$items = array();
foreach ($logos as $client) {
    if (empty($client['logo']['url'])) continue;
    $items[] = $client;
}
if (empty($items)) return;

// Дублируем дорожку с запасом, чтобы на любой ширине экрана и при любом
// количестве логотипов лента прокручивалась бесшовно, без разрывов.
$repeat = 6;
?>
<div class="<?= esc_attr($class) ?>">
    <div class="clients-marquee__track">
        <?php for ($i = 0; $i < $repeat; $i++) : ?>
            <?php foreach ($items as $client) : ?>
                <?php if (!empty($client['url'])) : ?>
                    <a href="<?= esc_url($client['url']) ?>" target="_blank" rel="noopener" class="clients-marquee__item">
                        <?= custom_responsive_img($client['logo'], '160px') ?>
                    </a>
                <?php else : ?>
                    <div class="clients-marquee__item">
                        <?= custom_responsive_img($client['logo'], '160px') ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
