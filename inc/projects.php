<?php
defined('ABSPATH') || exit;

// ——— CPT: Проекты (портфолио «Выполненные объекты» на главной) ———
add_action('init', 'custom_register_project_cpt');
function custom_register_project_cpt() {
    register_post_type('project', array(
        'labels'       => array(
            'name'          => 'Проекты',
            'singular_name' => 'Проект',
            'menu_name'     => 'Проекты',
            'add_new_item'  => 'Добавить проект',
            'edit_item'     => 'Редактировать проект',
            'all_items'     => 'Все проекты',
            'search_items'  => 'Поиск',
            'not_found'     => 'Ничего не найдено',
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-building',
        'menu_position'       => 6,
        'supports'            => array('title'),
    ));
}
