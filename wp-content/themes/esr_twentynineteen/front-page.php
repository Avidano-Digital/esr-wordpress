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

      <header class="mb-5">
        <h1 class="display-4 text-center">
          <span class="d-lg-block">We help the world’s greatest scientists</span>
          <span class="d-lg-block">save endangered animals</span>
        </h1>
      </header>

      <div class="container-fluid wide">

        <div class="featured-tiles mb-7">

          <?php if( have_rows('featured_tiles') ): ?>

            <div class="row matrix-border">

            <?php while( have_rows('featured_tiles') ): the_row(); 

              // vars
              $type = get_sub_field('type');
              

              $image_thumbnail = get_sub_field('image_thumbnail');
              $image_character = get_sub_field('image_character');
              
              $link = get_sub_field('link');
              $class_name = get_sub_field('class_name');

              ?>

              <div class="col-md-6">

                <a class="featured-tile <?php if( $type == 'Project' ) : ?>project<?php endif; ?> <?php if( !empty($class_name) ) echo $class_name ?>" href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>">
                  
                  <?php if( !empty($image_character) ) :?>
                    <div class="character"><img src="<?php echo $image_character['url']; ?>" alt="<?php echo $image_character['alt']; ?>"></div>
                  <?php endif; ?>
                    
                  <?php if( !empty($image_thumbnail) ) : ?>
                    <?php if( $type == 'Project' ) :?>
                      <div class="overlay-gradient-y-black">
                        <img src="<?php echo $image_thumbnail['url']; ?>" alt="<?php echo $image_thumbnail['alt']; ?>">
                      </div>
                    <?php else : ?>
                    <img class="img-fluid" src="<?php echo $image_thumbnail['url']; ?>" alt="<?php echo $image_thumbnail['alt']; ?>">
                    <?php endif; ?>
                  <?php endif; ?>

                  <div class="title p-2">
                    <h2 class="h4 text-white"><?php echo $link['title']; ?></h2>
                  </div>
                  
                </a>

              </div>
              <!-- .col -->

            <?php endwhile; /* featured_tiles */ ?>

            </div>
            <!-- .row -->

          <?php endif; ?>

        </div>
        <!-- .featured-tiles -->

        <?php get_template_part('template-parts/featured-video-group'); ?>

      </div>
      <!-- .container-fluid -->

    </section>
    <!-- #introduction -->

    <?php include('include/artifacts.php'); ?>

  </main>
  <!-- #content -->

  <?php get_footer(); ?>