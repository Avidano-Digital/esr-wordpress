<?php

/*
Template Name: About
*/

get_header(); ?>

<main id="content">

  <section class="py-7">

    <header class="mb-7">
      <div class="narrow text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
      </div>
    </header>

    <?php

    // check if the flexible content field has rows of data
    if( have_rows('esr_videos') ):

      // loop through the rows of data
      while ( have_rows('esr_videos') ) : the_row(); ?>

      <div class="container-fluid wide">


          <?php if( get_row_layout() == 'video_block' ):
                  
          // vars
          $featured_video_group = get_sub_field('featured_video_group');	

          $headline = $featured_video_group['headline'];
          $videos = $featured_video_group['videos'];

          $post_objects = $videos;

          if( $featured_video_group ): ?>

          <div class="featured-videos">
              
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

          <p>HELLO!!!!!</p>

      </div>
      <!-- .container-fluid -->


          <?php elseif( get_row_layout() == 'download' ): 

            $file = get_sub_field('file'); ?>

          <?php endif; endwhile; ?>

  <?php endif; ?>

























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