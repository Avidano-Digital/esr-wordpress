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

        <section class="featured-panel responsive-xl border-bottom border-white">

          <div class="card" style="background-color: #7c3e42;">
          
            <img class="card-img opacity-40 show-on-mobile" src="<?php echo get_template_directory_uri(); ?>/images/thumb-video-african-painted-dog.jpg" alt="Card image">
            
            <div class="card-img-overlay d-flex">
              <div class="container align-self-center">
                <div class="narrow text-white text-center">            
                  <h2 class="card-title text-shadow">Saving Painted Dogs From Deadly Snares!</h2>
                  <p class="fs-lg text-shadow">
                    African poachers hide thousands of deadly snares every day to catch antelope – but beautiful, endangered painted dogs suffer horrible deaths when they are caught by these snares instead.
                  </p>
                  <a class="btn btn-lg btn-secondary text-primary rounded" href="#" title="African Painted Dogs">African Painted Dogs</a>
                </div>
              </div>
            </div>
          </div>

        </section>
        <!-- .featured-panel -->

    </div>
    <!-- .container-fluid -->

  </main>
  <!-- #content -->

  <?php get_footer(); ?>