<?php
defined('ABSPATH') || exit;

// ——— CPT: Актуальные объекты (фото с телеграм-канала для главной страницы) ———
add_action('init', 'custom_register_object_cpt');
function custom_register_object_cpt() {
    register_post_type('recent_object', array(
        'labels'       => array(
            'name'          => 'Актуальные объекты',
            'singular_name' => 'Объект',
            'menu_name'     => 'Актуальные объекты',
            'add_new_item'  => 'Добавить объект',
            'edit_item'     => 'Редактировать объект',
            'all_items'     => 'Все объекты',
            'search_items'  => 'Поиск',
            'not_found'     => 'Ничего не найдено',
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-camera',
        'menu_position'       => 4,
        'supports'            => array('title'),
    ));
}
