<?php get_header(); ?>

<main id="content" role="main">

<?php if( have_rows('project_content') ):

  while ( have_rows('project_content') ) : the_row();

    if( get_row_layout() == 'hero_block' ):

    $type = get_sub_field('type');
    $video = get_sub_field('video');
    $image = get_sub_field('image');

    $post_object = $video;
    
    ?>

    <?php if( $type == 'Video' ) : ?>

    <section class="container-fluid bg-black text-white py-6">

      <h1 class="display-4 text-center mb-5"><?php the_title(); ?></h1>

      <?php

      if( $post_object ) :
      foreach($post_object as $post) :
      setup_postdata( $post ); 

      $video_url = get_field('video_url');
      $video_id = substr( strrchr( $video_url, '/' ), 1 );

      ?>

      <div class="offset-gutter-x">

        <div class="wide">
        
          <div class="embed-responsive embed-responsive-16by9 shadow-lg">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>"></iframe>
          </div>

        </div>
        <!-- .wide -->

      </div>
      <!-- .offset-gutter-x -->

      <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

    </section>
    <!-- .container-fluid  -->

    <?php elseif( $type == 'Image' ) : ?>

    <section class="container-fluid bg-black text-white py-6">

    <h1 class="display-4 text-center mb-5"><?php the_title(); ?></h1>

      <div class="offset-gutter-x">

        <div class="wide overlay-gradient-y-black">

          <?php if ($image) : ?>
            <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
          <?php else : ?>
            <img class="card-img" src="http://via.placeholder.com/1200x675/000000/333333/.jpg" alt="Placeholder">
          <?php endif; ?>

        </div>
        <!-- .wide -->

      </div>
      <!-- .offset-gutter-x -->

    </section>
    <!-- .container-fluid  -->


    <?php endif; /* Image */ ?>

    <?php endif; /* hero_block */ ?>

    <?php endwhile; endif; /* project_content */ ?>

    <section class="py-7 torn-top">

      <div class="narrow">
      
        <h2 class="text-center mb-4">Saving Painted Dogs From Deadly Snares!</h2>
        <p>
            African poachers hide thousands of deadly snares every day to catch antelope – but beautiful, endangered painted dogs suffer horrible deaths when they are caught by these snares instead.
        </p>

        <p>
          Dr. Greg Rasmussen has designed a cutting-edge collar to save the last 4,500 dogs – who have one of Earth’s most incredible social systems.
        </p>

      </div>
      <!-- .narrow -->
    
    </section>

    <section id="donate-block" class="container mobile-edge bg-light p-3 p-lg-5 mb-5">

      <h3 class="text-center text-green mb-4">Donate to the <?php the_title(); ?> Project</h3>

      <?php echo do_shortcode(get_field('donation_form_shortcode')); ?>

    </section>
    
</main><!-- #content -->

<?php get_footer(); ?>