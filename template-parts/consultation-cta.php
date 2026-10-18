<?php
defined('ABSPATH') || exit;

$prefix   = $args['prefix'] ?? 'services_cta';
$wrap     = $args['wrap'] ?? true;
$modifier = $args['modifier'] ?? '';

$cta_icon     = function_exists('get_field') ? get_field("{$prefix}_icon") : null;
$cta_title    = function_exists('get_field') ? get_field("{$prefix}_title") : null;
$cta_text     = function_exists('get_field') ? get_field("{$prefix}_text") : null;
$cta_features = function_exists('get_field') ? get_field("{$prefix}_features") : null;
$cta_btn_text = function_exists('get_field') ? get_field("{$prefix}_btn_text") : null;
$cta_btn_text = $cta_btn_text ?: 'Получить консультацию';
$cta_image    = function_exists('get_field') ? get_field("{$prefix}_image") : null;
$cta_bg       = function_exists('get_field') ? get_field("{$prefix}_bg_image") : null;
$cta_bg_mobile = function_exists('get_field') ? get_field("{$prefix}_bg_image_mobile") : null;
$cta_card_bg        = function_exists('get_field') ? get_field("{$prefix}_card_bg_image") : null;
$cta_card_bg_mobile = function_exists('get_field') ? get_field("{$prefix}_card_bg_image_mobile") : null;

// Фон карточки: либо отдельное поле карточки (services_cta), либо поле фона (about_cta) — оба применяются к самой карточке, не к секции
if (empty($cta_card_bg['url']) && !empty($cta_bg['url'])) {
    $cta_card_bg        = $cta_bg;
    $cta_card_bg_mobile = $cta_bg_mobile;
}

ob_start();
?>
        <div class="services-cta__card">
            <?php if (!empty($cta_card_bg['url'])) : ?>
                <div class="services-cta__card-bg">
                    <?= custom_bg_picture($cta_card_bg, $cta_card_bg_mobile, '100vw') ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($cta_image['url'])) : ?>
                <div class="services-cta__image">
                    <?= custom_responsive_img($cta_image, '400px') ?>
                </div>
            <?php endif; ?>
            <div class="services-cta__left">
                <?php if (!empty($cta_icon['url'])) : ?>
                    <div class="services-cta__icon">
                        <?= custom_responsive_img($cta_icon, '64px') ?>
                    </div>
                <?php endif; ?>

                <div class="services-cta__body">
                    <?php if ($cta_title) : ?><h2 class="services-cta__title title-3"><?= custom_unwrap_p($cta_title) ?></h2><?php endif; ?>
                    <?php if ($cta_text) : ?><p class="services-cta__text text"><?= nl2br(esc_html($cta_text)) ?></p><?php endif; ?>
                </div>
            </div>

            <div class="services-cta__right">
                <?php if ($cta_features) : ?>
                    <div class="services-cta__features">
                        <?php foreach ($cta_features as $feature) :
                            if (empty($feature['text'])) continue;
                        ?>
                            <div class="services-cta__feature">
                                <?php if (!empty($feature['icon']['url'])) : ?>
                                    <?= custom_responsive_img($feature['icon'], '24px', 'services-cta__feature-icon') ?>
                                <?php endif; ?>
                                <span class="text-s"><?= esc_html($feature['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <button type="button" class="btn services-cta__btn" data-open="calc-modal"><?= esc_html($cta_btn_text) ?></button>
            </div>
        </div>
<?php
$card_html = ob_get_clean();

if ($wrap) :
?>
<section class="services-cta<?= $modifier ? ' services-cta--' . esc_attr($modifier) : '' ?>">
    <div class="container">
        <?= $card_html ?>
    </div>
</section>
<?php else : ?>
    <?= $card_html ?>
<?php endif; ?>
