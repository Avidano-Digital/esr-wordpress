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