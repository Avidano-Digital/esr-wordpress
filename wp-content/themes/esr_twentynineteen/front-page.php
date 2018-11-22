<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

 get_header(); ?>

  <main id="content">

    <section class="py-7" id="introduction">

      <div class="container-fluid wide">

        <div class="mb-7" id="featured-projects">
        
          <div class="mb-5">
            <h1 class="display-4 text-center">
              <span class="d-lg-block">We help the world’s greatest scientists</span>
              <span class="d-lg-block">save endangered animals</span>
            </h1>
          </div>




              <?php if( have_rows('featured_panels') ): ?>

                <div class="row matrix-border">

                <?php while( have_rows('featured_panels') ): the_row(); 

                  // vars
                  $image_thumbnail = get_sub_field('image_thumbnail');
                  $title = get_sub_field('title');
                  $link = get_sub_field('link');

                  ?>

                <div class="col-6">

                    <img src="<?php echo $image_thumbnail['url']; ?>" alt="<?php echo $image_thumbnail['alt'] ?>" />
                    <?php echo $title; ?>
                </div>
                <!-- .col -->
                <?php endwhile; ?>


                </div>
                <!-- .row -->

              <?php endif; ?>









          <div class="row matrix-border">

            <?php $i=1; while( $i <= 6) : ?>

            <div class="col-6">

              <a href="#" class="project-link">
                <img src="https://via.placeholder.com/800x400" alt="Placeholder">
              </a>

            </div>
            <!-- .col -->

            <?php $i++; endwhile; ?>

          </div>
          <!-- .row -->

        </div>
        <!-- #featured-projects -->

        <div id="featured-shorts">
            
          <h2 class="text-center mb-4">Painted Dog Shorts</h2>

          <div class="row matrix-border">

            <?php $i=1; while( $i <= 3) : ?>

            <div class="col-4">

              <a href="#" class="project-link">
                <img src="https://via.placeholder.com/800x400" alt="Placeholder">
              </a>

            </div>
            <!-- .col -->

            <?php $i++; endwhile; ?>

            <div class="col-6">

            </div>
            <!-- .col -->

          </div>
          <!-- .row -->

        </div>
        <!-- #featured-shorts -->

      </div>
      <!-- .container-fluid -->

    </section>
    <!-- #introduction -->

    <?php include('include/artifacts.php'); ?>

  </main>
  <!-- #content -->

  <?php get_footer(); ?>