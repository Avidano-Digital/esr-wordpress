<?php

/*
Template Name: About
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

    <div class="container-fluid wide">

      <div class="mb-7">
      
      <?php get_template_part('template-parts/featured-video-group'); ?>
      
      </div>
      <!-- .mb_7 -->
      
      <?php get_template_part('template-parts/project-video-group'); ?>

    </div>
    <!-- .container-fluid -->

    <!-- Conservation Projects -->

    <?php if( have_rows('conservation_project_summary') ): ?>

    <div class="container-fluid wide mb-child-border">

      <?php while( have_rows('conservation_project_summary') ): the_row(); 

      // vars
      $class_name = get_sub_field('class_name');

      $image = get_sub_field('image');
      
      $headline = get_sub_field('headline');
      $link = get_sub_field('link');

      ?>
    
      <section class="featured-panel responsive-xl">

        <div class="card <?php if( !empty($class_name) ) echo $class_name ?>">

          <?php if( !empty($image) ) : ?>

          <div class="overlay-gradient-y-blacky">
            <img class="card-img opacity-30 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
          </div>
          <?php endif; ?>

          <div class="card-img-overlay d-flex">
            <div class="container align-self-center">
              <div class="narrow text-white text-center py-4">
                <h2 class="h1 card-title">
                  <?php echo $headline; ?>
                </h2>
                <p class="fs-lg">
                  African poachers hide thousands of deadly snares every day to catch antelope – but beautiful, endangered
                  painted dogs suffer horrible deaths when they are caught by these snares instead.
                </p>
                <a class="btn btn-lg btn-secondary text-primary rounded" href="#" title="<?php echo $link['title']; ?>">
                  <?php echo $link['title']; ?></a>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- .featured-panel -->

      <?php endwhile; /* conservation_project_summary */ ?>

    </div>
    <!-- .container-fluid -->

    <?php endif; /* conservation_project_summary */ ?>

  </section>
  <!-- .container-fluid -->

</main>
<!-- #content -->

<?php get_footer(); ?>