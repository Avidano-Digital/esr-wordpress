<?php
/*
Template Name: Videos
*/

get_header(); ?>

<main id="content">

<section class="container-fluid bg-light torn-bottom pt-7 pb-8">

  <header class="narrow text-center">
      <h1 class="display-4">
        <?php the_title(); ?>
      </h1>
  </header>

</section>

  <?php get_template_part( 'template-parts/article' ) ?>
  <?php get_template_part( 'template-parts/share' ) ?>
    
</main>
<!-- #content -->
    
<?php get_footer(); ?>