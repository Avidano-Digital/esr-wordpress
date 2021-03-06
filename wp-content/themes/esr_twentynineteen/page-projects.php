<?php

/*
Template Name: Conservation Projects
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

    <!-- Conservation Projects -->

    <?php if( have_rows('conservation_project_summary') ): ?>

    <div class="container-fluid wide mb-child-border my-7">

      <?php while( have_rows('conservation_project_summary') ): the_row(); 

      // vars
      $class_name = get_sub_field('class_name');

      $image = get_sub_field('image');
      $image_character = get_sub_field('image_character');
      
      $headline = get_sub_field('headline');
      $paragraph = get_sub_field('paragraph');
      $link = get_sub_field('link');

      ?>
    
      <section class="featured-panel responsive-xl mobile-margin-offset-x">

        <div class="card <?php if( !empty($class_name) ) echo $class_name ?>">

          <?php if( !empty($image) ) : ?>

          <div class="torn-bottom">
            <img class="card-img opacity-20 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
          </div>

          <?php endif; ?>

          <div class="card-img-overlay d-flex">
            <div class="container align-self-center">
              <div class="narrow text-white text-center">
              
              <div class="character mx-auto mb-3"><img src="<?php echo $image_character['url']; ?>" alt="<?php echo $image_character['alt']; ?>"></div> 
                
                <h2 class="card-title">
                  <?php echo $headline; ?>
                </h2>

                <div class="fs-lg mb-2">
                  <?php echo $paragraph; ?>
                </div>

                <a class="btn btn-lg btn-secondary text-primary rounded" href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>">
                  <?php echo $link['title']; ?>
                </a>

              </div>
              <!-- .narrow -->
            </div>
            <!-- .container -->
          </div>
        </div>

      </section>
      <!-- .featured-panel -->

      <?php endwhile; /* conservation_project_summary */ ?>

    </div>
    <!-- .container-fluid -->

    <?php endif; /* conservation_project_summary */ ?>

</main>
<!-- #content -->
    
<?php get_footer(); ?>