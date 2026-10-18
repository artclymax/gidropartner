<?php
defined('ABSPATH') || exit;

$title      = function_exists('get_field') ? get_field('callback_modal_title', 'option') : null;
$text       = function_exists('get_field') ? get_field('callback_modal_text', 'option') : null;
$btn_text   = function_exists('get_field') ? get_field('callback_modal_btn_text', 'option') : null;
$btn_text   = $btn_text ?: 'Заказать звонок';
$policy_url = function_exists('get_privacy_policy_url') ? get_privacy_policy_url() : '';
?>
<div id="callback-modal" class="modal" >
    <div class="modal__overlay"></div>
    <div data-closable="callback-modal" class="modal__dialog" role="dialog" aria-modal="true" aria-label="<?= esc_attr($title ?: $btn_text) ?>">
        <button type="button" class="modal__close" data-open="callback-modal" aria-label="Закрыть"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13 13L22.75 22.75M13 13L3.25 3.25M13 13L3.25 22.75M13 13L22.75 3.25" stroke="#616161" stroke-width="2" stroke-linecap="round"/>
</svg>
</button>

        <?php if ($title) : ?><h2 class="modal__title title-2"><?= esc_html($title) ?></h2><?php endif; ?>
        <?php if ($text) : ?><p class="modal__text text"><?= nl2br(esc_html($text)) ?></p><?php endif; ?>

        <form class="js-callback-form modal__form">
            <div class="modal__row">
                <div class="input-wrapper">
                    <label class="input-label" for="cb_phone">Телефон*</label>
                    <input class="input-text" type="tel" id="cb_phone" name="cb_phone" required>
                </div>
                <div class="input-wrapper">
                    <label class="input-label" for="cb_name">Имя</label>
                    <input class="input-text" type="text" id="cb_name" name="cb_name">
                </div>
            </div>
            <div class="input-wrapper">
                <label class="input-label" for="cb_message">Комментарий</label>
                <textarea class="input-text" id="cb_message" name="cb_message" rows="3"></textarea>
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

            <button type="submit" class="btn modal__submit"><?= esc_html($btn_text) ?></button>
        </form>
    </div>
</div>

<?php
$calc_title    = function_exists('get_field') ? get_field('calc_modal_title', 'option') : null;
$calc_text     = function_exists('get_field') ? get_field('calc_modal_text', 'option') : null;
$calc_btn_text = function_exists('get_field') ? get_field('calc_modal_btn_text', 'option') : null;
$calc_btn_text = $calc_btn_text ?: 'Рассчитать стоимость работ';
?>
<div id="calc-modal" class="modal" >
    <div class="modal__overlay"></div>
    <div data-closable="calc-modal" class="modal__dialog" role="dialog" aria-modal="true" aria-label="<?= esc_attr($calc_title ?: $calc_btn_text) ?>">
        <button type="button" class="modal__close" data-open="calc-modal" aria-label="Закрыть"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13 13L22.75 22.75M13 13L3.25 3.25M13 13L3.25 22.75M13 13L22.75 3.25" stroke="#616161" stroke-width="2" stroke-linecap="round"/>
</svg>
</button>

        <?php if ($calc_title) : ?><h2 class="modal__title title-2"><?= esc_html($calc_title) ?></h2><?php endif; ?>
        <?php if ($calc_text) : ?><p class="modal__text text"><?= nl2br(esc_html($calc_text)) ?></p><?php endif; ?>

        <?php get_template_part('template-parts/calc-form', null, array('id_prefix' => 'calc', 'submit_text' => $calc_btn_text)); ?>
    </div>
</div>

<?php
$discuss_title    = function_exists('get_field') ? get_field('discuss_modal_title', 'option') : null;
$discuss_text     = function_exists('get_field') ? get_field('discuss_modal_text', 'option') : null;
$discuss_btn_text = function_exists('get_field') ? get_field('discuss_modal_btn_text', 'option') : null;
$discuss_btn_text = $discuss_btn_text ?: 'Обсудить объект';
?>
<div id="discuss-modal" class="modal" >
    <div class="modal__overlay"></div>
    <div data-closable="discuss-modal" class="modal__dialog" role="dialog" aria-modal="true" aria-label="<?= esc_attr($discuss_title ?: $discuss_btn_text) ?>">
        <button type="button" class="modal__close" data-open="discuss-modal" aria-label="Закрыть"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13 13L22.75 22.75M13 13L3.25 3.25M13 13L3.25 22.75M13 13L22.75 3.25" stroke="#616161" stroke-width="2" stroke-linecap="round"/>
</svg>
</button>

        <?php if ($discuss_title) : ?><h2 class="modal__title title-2"><?= esc_html($discuss_title) ?></h2><?php endif; ?>
        <?php if ($discuss_text) : ?><p class="modal__text text"><?= nl2br(esc_html($discuss_text)) ?></p><?php endif; ?>

        <?php get_template_part('template-parts/discuss-form', null, array('id_prefix' => 'discuss', 'submit_text' => $discuss_btn_text)); ?>
    </div>
</div>
