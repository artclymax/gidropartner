<?php
defined('ABSPATH') || exit;

$policy_url  = function_exists('get_privacy_policy_url') ? get_privacy_policy_url() : '';
$id_prefix   = $args['id_prefix'] ?? 'discuss';
$submit_text = $args['submit_text'] ?? 'Обсудить объект';

$service_options = array();
$service_posts = get_posts(array(
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
));
foreach ($service_posts as $service_post) {
    $service_options[] = $service_post->post_title;
}
?>
<form class="js-callback-form modal__form">
    <div class="modal__row">
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_object_type">Тип работ*</label>
            <div class="input-select custom-select" data-required="1">
                <button type="button" class="custom-select__trigger input-text" id="<?= esc_attr($id_prefix) ?>_object_type" aria-haspopup="listbox" aria-expanded="false">
                    <span class="custom-select__value">Выберите тип работ</span>
                </button>
                <?= custom_icon_chevron() ?>
                <ul class="custom-select__list" role="listbox" tabindex="-1">
                    <?php foreach ($service_options as $option) : ?>
                        <li class="custom-select__option" role="option" data-value="<?= esc_attr($option) ?>"><?= esc_html($option) ?></li>
                    <?php endforeach; ?>
                </ul>
                <input type="hidden" name="cb_object_type" value="">
            </div>
        </div>
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_area">Площадь объекта, м²</label>
            <input class="input-text" type="number" id="<?= esc_attr($id_prefix) ?>_area" name="cb_area" placeholder="Например: 1500">
        </div>
    </div>
    <div class="modal__row">
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_city">Город / регион</label>
            <input class="input-text" type="text" id="<?= esc_attr($id_prefix) ?>_city" name="cb_city" placeholder="Введите город">
        </div>
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_object_kind">Тип объекта</label>
            <input class="input-text" type="text" id="<?= esc_attr($id_prefix) ?>_object_kind" name="cb_object_kind" placeholder="Например: Склад">
        </div>
    </div>
    <div class="modal__row">
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_name">Имя</label>
            <input class="input-text" type="text" id="<?= esc_attr($id_prefix) ?>_name" name="cb_name" placeholder="Ваше имя">
        </div>
        <div class="input-wrapper">
            <label class="input-label" for="<?= esc_attr($id_prefix) ?>_phone">Телефон*</label>
            <input class="input-text" type="tel" id="<?= esc_attr($id_prefix) ?>_phone" name="cb_phone" required>
        </div>
    </div>
    <div class="input-wrapper">
        <label class="input-label" for="<?= esc_attr($id_prefix) ?>_message">Комментарий</label>
        <textarea class="input-text" id="<?= esc_attr($id_prefix) ?>_message" name="cb_message" rows="3" placeholder="Комментарий"></textarea>
    </div>

    <label class="checkbox">
        <input type="checkbox" checked class="checkbox__input" name="cb_consent" required>
        <span class="checkbox__box"></span>
        <span class="checkbox__label">
            Соглашаюсь с
            <?php if ($policy_url) : ?>
                <a href="<?= esc_url($policy_url) ?>" target="_blank" rel="noopener">политикой обработки персональных данных</a>
            <?php else : ?>
                политикой обработки персональных данных
            <?php endif; ?>
        </span>
    </label>

    <input type="hidden" name="form_type" value="discuss">

    <button type="submit" class="btn modal__submit"><?= esc_html($submit_text) ?></button>
</form>
