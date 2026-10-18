<?php
/**
 * Template Name: Контакты
 */
defined('ABSPATH') || exit;
get_header();

$hero_eyebrow  = get_field('contacts_hero_eyebrow');
$hero_title    = get_field('contacts_hero_title');
$hero_text     = get_field('contacts_hero_text');
$hero_bg       = get_field('contacts_hero_bg_image');
$hero_bg_mobile = get_field('contacts_hero_bg_image_mobile');

$phone       = get_field('contact_phone', 'option');
$hours       = get_field('contact_hours', 'option');
$phone_icon  = get_field('contacts_phone_icon');
$phone_href  = $phone ? 'tel:' . preg_replace('/[^\d+]/', '', $phone) : '';

$email_icon  = get_field('contacts_email_icon');
$email_value = get_field('contacts_email_value');
$email_text  = get_field('contacts_email_text');

$address_icon  = get_field('contacts_address_icon');
$address_value = get_field('contacts_address_value');
$address_text  = get_field('contacts_address_text');

$front_page_id  = (int) get_option('page_on_front');
$telegram_icon  = get_field('contacts_telegram_icon');
$telegram_text  = get_field('contacts_telegram_text');
$telegram_url   = get_field('telegram_channel_url', $front_page_id);
$telegram_btn   = get_field('telegram_btn_text', $front_page_id);
$telegram_btn   = $telegram_btn ?: 'Смотреть обновления';

$form_title   = get_field('contacts_form_title');
$form_text    = get_field('contacts_form_text');
$form_btn_text = get_field('contacts_form_btn_text');
$form_btn_text = $form_btn_text ?: 'Получить расчёт';
$section_bg        = get_field('contacts_form_map_bg_image');
$section_bg_mobile  = get_field('contacts_form_map_bg_image_mobile');

$map_title      = get_field('contacts_map_title');
$map_text       = get_field('contacts_map_text');
$map_items      = get_field('contacts_map_items');
$map_bg         = get_field('contacts_map_bg_image');
$map_bg_mobile  = get_field('contacts_map_bg_image_mobile');

$requisites_icon    = get_field('requisites_icon', 'option');
$requisites_name    = get_field('requisites_name', 'option');
$requisites_unp     = get_field('requisites_unp', 'option');
$requisites_address  = get_field('requisites_legal_address', 'option');
$requisites_account = get_field('requisites_bank_account', 'option');
$requisites_bank    = get_field('requisites_bank', 'option');
$requisites_bg        = get_field('requisites_bg_image', 'option');
$requisites_bg_mobile  = get_field('requisites_bg_image_mobile', 'option');
?>

<main class="main">

    <section class="contacts-hero">
        <?php if (!empty($hero_bg['url'])) : ?>
            <div class="contacts-hero__bg">
                <?= custom_bg_picture($hero_bg, $hero_bg_mobile, '100vw', 'eager') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <nav class="breadcrumb text-caption" aria-label="Breadcrumb">
                <a href="<?= esc_url(home_url('/')) ?>">Главная</a>
                <span class="breadcrumb__sep">/</span>
                <span><?php the_title(); ?></span>
            </nav>

            <div class="contacts-hero__inner">
                <?php if ($hero_eyebrow) : ?><p class="contacts-hero__eyebrow text-badge"><?= esc_html($hero_eyebrow) ?></p><?php endif; ?>
                <?php if ($hero_title) : ?><h1 class="contacts-hero__title title-1"><?= custom_unwrap_p($hero_title) ?></h1><?php endif; ?>
                <?php if ($hero_text) : ?><p class="contacts-hero__text text"><?= nl2br(esc_html($hero_text)) ?></p><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="contacts-methods">
        <div class="container">
            <div class="contacts-methods__grid">

                <div class="contacts-methods__card">
                    <?php if (!empty($phone_icon['url'])) : ?>
                        <div class="contacts-methods__icon"><?= custom_responsive_img($phone_icon, '24px') ?></div>
                    <?php endif; ?>
                    <p class="contacts-methods__label title-5">Телефон</p>
                    <?php if ($phone) : ?><p class="contacts-methods__value title-4"><a href="<?= esc_url($phone_href) ?>"><?= esc_html($phone) ?></a></p><?php endif; ?>
                    <?php if ($hours) : ?><p class="contacts-methods__text text-s"><?= esc_html($hours) ?></p><?php endif; ?>
                </div>

                <div class="contacts-methods__card">
                    <?php if (!empty($email_icon['url'])) : ?>
                        <div class="contacts-methods__icon"><?= custom_responsive_img($email_icon, '24px') ?></div>
                    <?php endif; ?>
                    <p class="contacts-methods__label title-5">Email</p>
                    <?php if ($email_value) : ?><p class="contacts-methods__value title-4"><a href="mailto:<?= esc_attr($email_value) ?>"><?= esc_html($email_value) ?></a></p><?php endif; ?>
                    <?php if ($email_text) : ?><p class="contacts-methods__text text-s"><?= esc_html($email_text) ?></p><?php endif; ?>
                </div>

                <div class="contacts-methods__card">
                    <?php if (!empty($address_icon['url'])) : ?>
                        <div class="contacts-methods__icon"><?= custom_responsive_img($address_icon, '24px') ?></div>
                    <?php endif; ?>
                    <p class="contacts-methods__label title-5">Адрес</p>
                    <?php if ($address_value) : ?><p class="contacts-methods__value title-4"><?= esc_html($address_value) ?></p><?php endif; ?>
                    <?php if ($address_text) : ?><p class="contacts-methods__text text-s"><?= esc_html($address_text) ?></p><?php endif; ?>
                </div>

                <div class="contacts-methods__card">
                    <?php if (!empty($telegram_icon['url'])) : ?>
                        <div class="contacts-methods__icon"><?= custom_responsive_img($telegram_icon, '24px') ?></div>
                    <?php endif; ?>
                    <p class="contacts-methods__label title-5">Telegram</p>
                    <?php if ($telegram_text) : ?><p class="contacts-methods__text text-s"><?= esc_html($telegram_text) ?></p><?php endif; ?>
                    <?php if ($telegram_url) : ?>
                        <a href="<?= esc_url($telegram_url) ?>" target="_blank" rel="noopener" class="btn btn--outline contacts-methods__btn"><?= esc_html($telegram_btn) ?></a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <section class="contacts-form-map">
        <?php if (!empty($section_bg['url'])) : ?>
            <div class="contacts-form-map__bg">
                <?= custom_bg_picture($section_bg, $section_bg_mobile, '100vw') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="contacts-form-map__grid">

                <div class="contacts-card contacts-form-card">
                    <?php if ($form_title) : ?><h2 class="contacts-card__title title-3"><?= esc_html($form_title) ?></h2><?php endif; ?>
                    <?php if ($form_text) : ?><p class="contacts-card__text text"><?= nl2br(esc_html($form_text)) ?></p><?php endif; ?>
                    <?php get_template_part('template-parts/calc-form', null, array('id_prefix' => 'ct', 'submit_text' => $form_btn_text)); ?>
                </div>

                <div class="contacts-card contacts-map-card">
                    <?php if (!empty($map_bg['url'])) : ?>
                        <div class="contacts-map-card__bg">
                            <?= custom_bg_picture($map_bg, $map_bg_mobile, '100vw') ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($map_title) : ?><h2 class="contacts-card__title title-3"><?= esc_html($map_title) ?></h2><?php endif; ?>
                    <?php if ($map_text) : ?><p class="contacts-card__text text"><?= nl2br(esc_html($map_text)) ?></p><?php endif; ?>

                    <?php if ($map_items) : ?>
                    <ul class="contacts-map-card__list">
                        <?php foreach ($map_items as $item) :
                            if (empty($item['label'])) continue;
                        ?>
                            <li class="contacts-map-card__item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="0.5" y="0.5" width="23" height="23" rx="11.5" stroke="#3F3FCD"/>
<path d="M18 7.5L9.6 16.5L6 13.125" stroke="#3F3FCD" stroke-width="2" stroke-linejoin="round"/>
</svg>
    
                            <?= esc_html($item['label']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

            </div>

            <?php if ($requisites_name) : ?>
            <div class="contacts-requisites__inner">
                <?php if (!empty($requisites_bg['url'])) : ?>
                    <div class="contacts-requisites__bg">
                        <?= custom_bg_picture($requisites_bg, $requisites_bg_mobile, '100vw') ?>
                    </div>
                <?php endif; ?>

                <div class="contacts-requisites__wrapper">
                    <?php if (!empty($requisites_icon['url'])) : ?>
                        <div class="contacts-requisites__icon">
                            <?= custom_responsive_img($requisites_icon, '32px') ?>
                        </div>
                    <?php endif; ?>
                    
                        <div class="contacts-requisites__name">
                            <p class="title-3">Реквизиты</p>
                            <p class="title-5"><?= esc_html($requisites_name) ?></p>
                        </div>
                </div> 

                
                
<div class="contacts-requisites__items">
                <?php if ($requisites_unp) : ?>
                    <div class="contacts-requisites__field">
                        <p class="text-s">УНП:</p>
                        <p class="text"><?= esc_html($requisites_unp) ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($requisites_address) : ?>
                    <div class="contacts-requisites__field">
                        <p class="text-s">Юридический адрес:</p>
                        <p class="text"><?= esc_html($requisites_address) ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($requisites_account) : ?>
                    <div class="contacts-requisites__field">
                        <p class="text-s">Расчётный счёт:</p>
                        <p class="text"><?= esc_html($requisites_account) ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($requisites_bank) : ?>
                    <div class="contacts-requisites__field">
                        <p class="text-s">Банк:</p>
                        <p class="text"><?= esc_html($requisites_bank) ?></p>
                    </div>
                <?php endif; ?>
               
            </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
