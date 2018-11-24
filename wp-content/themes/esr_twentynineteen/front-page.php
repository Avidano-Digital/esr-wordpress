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

      <header class="mb-6">
        <h1 class="display-4 text-center">
          <span class="d-lg-block">We help the world’s greatest scientists</span>
          <span class="d-lg-block">save endangered animals</span>
        </h1>
      </header>

      <div class="container-fluid wide bg-danger">

        <div class="mb-7" id="featured-projects">

          <?php if( have_rows('featured_panels') ): ?>

            <div class="row matrix-border">

            <?php while( have_rows('featured_panels') ): the_row(); 

              // vars
              $type = get_sub_field('type');
              $class_name = get_sub_field('class_name');

              $image_thumbnail = get_sub_field('image_thumbnail');
              $image_character = get_sub_field('image_character');
              
              $title = get_sub_field('title');
              $link = get_sub_field('link');

              ?>

              <div class="col-md-6">

                <a href="#" class="featured-tile <?php if( $type == 'Project' ) : ?>project<?php endif; ?> <?php if( !empty($class_name) ) echo $class_name ?>">
                  
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
                    <h2 class="h4 text-white"><?php echo $title; ?></h2>
                  </div>
                  
                </a>

              </div>
              <!-- .col -->

            <?php endwhile; /* featured_panels */ ?>

            </div>
            <!-- .row -->

          <?php endif; ?>

          <div class="row matrix-border d-none">

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

        <?php

        // vars
        $featured_video_group = get_field('featured_video_group');	

        $headline = $featured_video_group['headline'];
        $videos = $featured_video_group['videos'];

        $post_objects = $videos;

        if( $featured_video_group ): ?>

        <div class="featured-videos bg-warning">
            
            <h2 class="text-center mb-4"><?php echo $headline; ?></h2>

            <div class="row matrix-border">

            <?php

                if( $post_objects ) :
                foreach($post_objects as $post) :
                setup_postdata( $post ); 

                $video_url = get_field('video_url');
                $video_id = substr( strrchr( $video_url, '/' ), 1 );
            ?>
            
            <div class="col-md-4">

                <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowTransparency="true"
                    allowfullscreen="true"></iframe>
                </div>

            </div>
            <!-- .col -->

            <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

            </div>
            <!-- .row -->

        </div>
        <!-- .featured-videos -->

        <?php endif; /* featured_video_group */ ?>

      </div>
      <!-- .container-fluid -->

    </section>
    <!-- #introduction -->

    <?php include('include/artifacts.php'); ?>

  </main>
  <!-- #content -->

  <?php get_footer(); ?>