<?php
/**
 * Template Name: Главная
 */
get_header();
?>

<main class="main">
    <?php
    get_template_part('template-parts/home/hero');
    get_template_part('template-parts/home/services');
    get_template_part('template-parts/home/coating-places');
    get_template_part('template-parts/home/coating-layers');
    get_template_part('template-parts/home/portfolio');
    get_template_part('template-parts/home/process');
    get_template_part('template-parts/home/approach');
    get_template_part('template-parts/home/calc-section');
    ?>
</main>

<?php get_footer(); ?>
