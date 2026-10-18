<?php
/**
 * Template Name: Текстовая страница
 */
get_header();
?>

<main class="main">
  <div class="container">

   

    <article class="text-page">
       <nav class="breadcrumb text-caption" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Главная</a>
      <span class="breadcrumb__sep">/</span>
      <span><?php the_title(); ?></span>
    </nav>
      <h1 class="text-page__title title-2"><?php the_title(); ?></h1>

      <div class="text-page__body">
        <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
      </div>
    </article>

  </div>
</main>

<?php get_footer(); ?>
