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

    <section class="container-fluid bg-black torn-bottom-white text-white ">

      <h1 class="sr-only"><?php the_title(); ?></h1>

      <?php

      if( $post_object ) :
      foreach($post_object as $post) :
      setup_postdata( $post ); 

      $video_url = get_field('video_url');
      $video_id = substr( strrchr( $video_url, '/' ), 1 );

      ?>

      <div class="offset-gutter-x">

        <div class="wide">
        
          <div class="embed-responsive embed-responsive-16by9">
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




    <section class="featured-panel torn-bottom-white responsive-md">

      <div class="card bg-black" style="background-color: #1B6486">

        <div class="overlay-gradient-y-blacks">
        <?php if ($image) : ?>
          <img class="card-img opacity-60 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
        <?php else : ?>
          <img class="card-img" src="http://via.placeholder.com/1200x675/000000/333333/.jpg" alt="Placeholder">
        <?php endif; ?>
        </div>

        <!-- .overlay-gradient-y-black -->
        <div class="card-img-overlay d-flex">

          <!-- QGUHJGVCFHJGEFGVHBJNGFBDVGSCFGVHBJNKJHGFDGHJKHGFDCGHJKHGFCGHBJNKJHGFCGHJ  VBNJNHVGCFXDFCGHVJBNKBHVGCFXCGVHBJHVGCFXVBN -->
          <!-- QGUHJGVCFHJGEFGVHBJNGFBDVGSCFGVHBJNKJHGFDGHJKHGFDCGHJKHGFCGHBJNKJHGFCGHJ  VBNJNHVGCFXDFCGHVJBNKBHVGCFXCGVHBJHVGCFXVBN -->
          <!-- QGUHJGVCFHJGEFGVHBJNGFBDVGSCFGVHBJNKJHGFDGHJKHGFDCGHJKHGFCGHBJNKJHGFCGHJ  VBNJNHVGCFXDFCGHVJBNKBHVGCFXCGVHBJHVGCFXVBN -->
          
          <div class="container align-self-center py-5">
 
            <div class="text-white text-center">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/character-superbear-small.svg" alt="">
              <h1 class="card-title display-3 text-shadow"><?php the_title(); ?></h1>
            </div>

          </div>
        </div>
      </div>

    </section>
    <!-- .featured-panel -->






    <section class="container-fluid bg-black d-none text-white">

    <h1 class="sr-only"><?php the_title(); ?></h1>

      <div class="offset-gutter-x">

        <div class="overlay-gradient-y-black">

          <?php if ($image) : ?>
            <img class="card-img opacity-80" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
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

    <div class="py-7">

      <!-- Put article content here -->

      <article>

        <header class="container mb-4">

          <h2 class="h1 text-center">Saving Painted Dogs From Deadly Snares!</h2>

        </header>

        <?php if( have_rows('article_section') ) :
      
        while( have_rows('article_section') ) : the_row(); ?>

        <section class="container">

          <?php if( get_row_layout() == 'text_block' ):

          $wysiwyg = get_sub_field('wysiwyg'); ?>

          <div class="text-block my-6">
              <?php echo $wysiwyg; ?>
          </div>

          <?php elseif( get_row_layout() == 'figure_block' ): 

          $figure_inline_single = get_sub_field('figure_inline_single');

          $image = $figure_inline_single['image'];
          $caption = $figure_inline_single['caption'];

          ?>

          <div class="figure-block my-6">
              <figure class="figure my-0">
                  <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
                  <figcaption class="figure-caption"><?php echo $caption; ?></figcaption>
              </figure>
          </div>
          <!-- .narrow -->


          <?php elseif( get_row_layout() == 'donate_block' ): ?>

          <div id="donate-block" class="mobile-edge bg-light p-3 p-lg-5 mb-7">

            <h2 class="text-center text-green mb-4">Donate to the <?php the_title(); ?> Project</h2>

            <?php echo do_shortcode( get_sub_field('donation_form_shortcode') ); ?>

          </div>

          <?php endif; /* text_block | figure_block | donate_block */ ?>

        </section>

        <?php endwhile; endif; /* article_section */ ?>
    
      </article>
      
    </div>
    <!-- .torn-top -->
    
</main><!-- #content -->

<?php get_footer(); ?>