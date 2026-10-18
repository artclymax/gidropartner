<?php
defined('ABSPATH') || exit;

$eyebrow    = function_exists('get_field') ? get_field('calc_section_eyebrow') : null;
$eyebrow    = $eyebrow ?: get_field('calc_default_eyebrow', 'option');
$title_raw  = function_exists('get_field') ? get_field('calc_section_title') : null;
$title_raw  = $title_raw ?: get_field('calc_default_title', 'option');
$title      = $title_raw ? custom_unwrap_p($title_raw) : null;
$text       = function_exists('get_field') ? get_field('calc_section_text') : null;
$text       = $text ?: get_field('calc_default_text', 'option');
$btn_text   = function_exists('get_field') ? get_field('calc_section_btn_text') : null;
$btn_text   = $btn_text ?: get_field('calc_default_btn_text', 'option');
$note_icon  = get_field('calc_default_note_icon', 'option');
$note_text  = get_field('calc_default_note_text', 'option');
$bg         = function_exists('get_field') ? get_field('calc_section_bg_image') : null;
$bg         = $bg ?: get_field('calc_default_bg_image', 'option');
$bg_mobile  = function_exists('get_field') ? get_field('calc_section_bg_image_mobile') : null;
$bg_mobile  = $bg_mobile ?: get_field('calc_default_bg_image_mobile', 'option');
$text_theme = function_exists('get_field') ? get_field('calc_section_text_theme') : null;
$text_theme = $text_theme ?: get_field('calc_default_text_theme', 'option');

get_template_part('template-parts/calc-section', null, array(
    'eyebrow'    => $eyebrow,
    'title'      => $title,
    'text'       => $text,
    'btn_text'   => $btn_text,
    'note_icon'  => $note_icon,
    'note_text'  => $note_text,
    'bg'         => $bg,
    'bg_mobile'  => $bg_mobile,
    'id_prefix'  => 'hcs',
    'short'      => true,
    'text_theme' => $text_theme,
));
