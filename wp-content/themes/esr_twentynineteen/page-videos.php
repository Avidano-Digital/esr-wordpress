<?php
/*
Template Name: Videos
*/

get_header(); ?>

<main id="content">

  <section class="py-7">

    <header class="mb-5">
      <div class="narrow text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
      </div>
    </header>

    <!-- Videos -->

    <section class="container-fluid wide bg-danger mb-7" id="esr-shorts">
      
      <?php get_template_part('template-parts/featured-video-group'); ?>
      
    </section>
    <!-- .container-fluid -->
      
    <section class="container-fluid wide bg-danger" id="project-videos">

      <?php get_template_part('template-parts/project-video-group'); ?>

    </section>

  </section>
  <!-- .container-fluid -->

  <?php get_template_part( 'template-parts/share' ) ?>
    
</main>
<!-- #content -->
    
<?php get_footer(); ?>