<?php

/*
Template Name: About
*/

get_header(); ?>

  <main id="content">


    <section class="container-fluid py-7">

      <header class="narrow text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
      </header>
      
    </section>
    <!-- .container-fluid -->

      <div class="container-fluid wide mb-7">

        <?php if( have_rows('conservation_project_summary') ): ?>

        <?php while( have_rows('conservation_project_summary') ): the_row(); 

          // vars
          $class_name = get_sub_field('class_name');

          $image = get_sub_field('image');
          
          $headline = get_sub_field('headline');
          $link = get_sub_field('link');

          ?>

          <section class="featured-panel responsive-xl border-bottom border-white">

            <div class="card <?php if( !empty($class_name) ) echo $class_name ?> bg-black">

              <?php if( !empty($image) ) : ?>
                <img class="card-img opacity-40 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
              <?php endif; ?>
            
              <div class="card-img-overlay d-flex">
                <div class="container align-self-center">
                  <div class="narrow text-white text-center">            
                    <h2 class="card-title text-shadow"><?php echo $headline; ?></h2>
                    <p class="fs-lg text-shadow">
                      African poachers hide thousands of deadly snares every day to catch antelope – but beautiful, endangered painted dogs suffer horrible deaths when they are caught by these snares instead.
                    </p>
                    <a class="btn btn-lg btn-secondary text-primary rounded" href="#" title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                  </div>
                </div>
              </div>
            </div>

          </section>
          <!-- .featured-panel -->

        <?php endwhile; endif; /* conservation_project_summary */ ?>

    </div>
    <!-- .container-fluid -->

  </main>
  <!-- #content -->

  <?php get_footer(); ?>