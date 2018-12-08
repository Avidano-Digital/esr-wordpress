<?php
/*
Template Name: Videos
*/

get_header(); ?>

<main id="content">

  <section class="py-7">

    <header class="container">
      <div class="narrow text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
      </div>
    </header>

    <!-- Videos -->

    <section class="container-fluid wide py-7" id="esr-shorts">
      
      <?php get_template_part('template-parts/featured-video-group'); ?>
      
    </section>
    <!-- .container-fluid -->

    <hr>
      
    <section class="container-fluid wide py-7" id="project-videos">

      <?php get_template_part('template-parts/project-video-group'); ?>

    </section>

  <?php get_template_part( 'template-parts/share' ) ?>

  </section>
  <!-- .container-fluid -->
    
</main>
<!-- #content -->
    
<?php get_footer(); ?>