<?php
defined('ABSPATH') || exit;

// ——— CPT: Услуги (карточки на главной, список в футере, опции в форме расчёта) ———
add_action('init', 'custom_register_service_cpt');
function custom_register_service_cpt() {
    register_post_type('service', array(
        'labels'       => array(
            'name'          => 'Услуги',
            'singular_name' => 'Услуга',
            'menu_name'     => 'Услуги',
            'add_new_item'  => 'Добавить услугу',
            'edit_item'     => 'Редактировать услугу',
            'all_items'     => 'Все услуги',
            'search_items'  => 'Поиск',
            'not_found'     => 'Ничего не найдено',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'uslugi'),
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-hammer',
        'menu_position'       => 5,
        'supports'            => array('title', 'page-attributes'),
    ));
}
