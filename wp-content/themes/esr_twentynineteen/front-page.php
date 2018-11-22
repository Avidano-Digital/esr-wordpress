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
              $type = get_sub_field('type');

              $image_thumbnail = get_sub_field('image_thumbnail');
              $image_character = get_sub_field('image_character');
              
              $title = get_sub_field('title');
              $link = get_sub_field('link');

              ?>

            <div class="col-md-6">

              <p class="text-danger d-none"><?php echo $type; ?></p>

              <a href="#" class="no-btn-style <?php if( $type == 'Project' ) : ?>project-link<?php endif; ?>">
                
                <?php if( !empty($image_character) ) :?>
                  <div class="character"><img src="<?php echo $img_character['url']; ?>" alt="<?php echo $img_character['alt']; ?>"></div>
                <?php endif; ?>
                  
                <?php if( !empty($image_thumbnail) ) : ?>
                  <?php if( $type == 'Project' ) :?>
                    <div class="overlay-gradient-y-black">
                      <img class="img-fluid" src="<?php echo $image_thumbnail['url']; ?>" alt="<?php echo $image_thumbnail['alt']; ?>">
                    </div>
                  <?php else : ?>
                  <img class="img-fluid" src="<?php echo $image_thumbnail['url']; ?>" alt="<?php echo $image_thumbnail['alt']; ?>">
                  <?php endif; ?>
                <?php endif; ?>

                <div class="title p-2 <?php echo $color; ?> bg-danger"><h2 class="h4 text-white"><?php echo $title; ?><span class="fas fa-angle-right ml-1"></span></h2></div>
                
              </a>

            </div>
            <!-- .col -->

            <?php endwhile; /* featured_panels */ ?>

            </div>
            <!-- .row -->

          <?php endif; ?>









          <div class="row matrix-border">

            <?php $i=1; while( $i <= 4) : ?>

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