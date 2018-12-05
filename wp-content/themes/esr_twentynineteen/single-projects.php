<?php get_header(); ?>

<main id="content" role="main">

  <?php if( have_rows('hero') ): while( have_rows('hero') ): the_row(); 
  
  // vars
  $subtitle = get_sub_field('subtitle');
  $image = get_sub_field('image');
  $character_image = get_sub_field('character_image');
  $class_name = get_sub_field('class_name');
  
  ?>

  <section class="featured-panel responsive-md torn-bottom">

    <div class="card <?php if( !empty($class_name) ) echo $class_name ?>">

      <div class="torn-bottom">
        <?php if ($image) : ?>
        <img class="card-img opacity-20 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
        <?php else : ?>
        <img class="card-img" src="http://via.placeholder.com/1200x675/000000/333333/.jpg" alt="Placeholder">
        <?php endif; ?>
      </div>

      <div class="card-img-overlay d-flex">

        <div class="container align-self-center">

          <div class="text-white text-center mb-6 mb-md-0">
            <img class="mb-2" src="<?php echo $character_image['url']; ?>" alt="<?php echo $character_image['alt'] ?>">
            <h1 class="card-title display-3">
              <?php the_title(); ?>
            </h1>
            <p class="fs-lg"><strong><?php echo $subtitle; ?></strong></p>
          </div>

        </div>
      </div>

    </div>
    <!-- .card -->

  </section>
  <!-- .featured-panel -->

  <?php endwhile;  endif; /* hero */ ?>

  <!-- Put article content here -->

  <article>

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
      $narrow = get_sub_field('narrow');

      $image = $figure_inline_single['image'];
      $caption = $figure_inline_single['caption'];

      ?>

      <div class="figure-block <?php if( $narrow ) echo 'narrow' ?> my-6">
          <figure class="figure my-0">
              <img class="figure-img w-100" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
              <figcaption class="figure-caption"><?php echo $caption; ?></figcaption>
          </figure>
      </div>
      <!-- .narrow -->

      <?php elseif( get_row_layout() == 'video_block' ):

      $single_video = get_sub_field( 'single_video');
      $post_object = $single_video;

      ?>

      <?php if( $post_object ): 

        // override $post
        $post = $post_object;
        setup_postdata( $post ); 

        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );
  
        ?>

        <div class="video-block mobile-margin-offset-x my-6">

        <div class="wide bg-black">

          <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>"></iframe>
          </div>

        </div>
        <!-- .wide -->

        </div>
        <!-- .video_block -->

        <?php endif; wp_reset_postdata(); /* post_objects */ ?>

      <?php elseif( get_row_layout() == 'two_figure_block' ): 

      $figure_inline_single_a = get_sub_field('figure_inline_single_a');

      $image_a = $figure_inline_single_a['image'];
      $caption_a = $figure_inline_single_a['caption'];

      $figure_inline_single_b = get_sub_field('figure_inline_single_b');

      $image_b = $figure_inline_single_b['image'];
      $caption_b = $figure_inline_single_b['caption'];

      ?>

      <div class="wide my-6">

          <div class="row matrix-gutter">

              <div class="col-sm-6 mb-4 mb-sm-0">
                  <figure class="figure my-0">
                    <img class="figure-img" src="<?php echo $image_a['url']; ?>" alt="<?php echo $image_a['alt'] ?>">
                    <figcaption class="figure-caption"><?php echo $caption_a; ?></figcaption>
                  </figure>
              </div>
              <!-- .col -->

              <div class="col-sm-6">
                  <figure class="figure my-0">
                    <img class="figure-img" src="<?php echo $image_b['url']; ?>" alt="<?php echo $image_b['alt'] ?>">
                    <figcaption class="figure-caption"><?php echo $caption_b; ?></figcaption>
                  </figure>
              </div>
              <!-- .col -->

          </div>
          <!-- .row -->

      </div>
      <!-- .narrow -->


      <?php elseif( get_row_layout() == 'gallery_matrix_block' ):
      
      $images = get_sub_field('gallery_matrix');
      
      ?>

      <?php if( $images ):  ?> 
      
      <div class="gallery-matrix-block my-6">

        <div class="row no-gutters">

          <div class="col-8">
              <img class="flex-grow-1" src="<?php echo $images[0]['url']; ?>" alt="<?php echo $image[0]['alt']; ?>">
          </div>
          <!-- .col -->

          <div class="col-4">

            <div class="row">

              <div class="col-12">
                  <img class="" src="<?php echo $images[1]['url']; ?>" alt="<?php echo $image[1]['alt']; ?>">
              </div>
              <!-- .col -->

              <div class="col-12">
                  <img src="<?php echo $images[2]['url']; ?>" alt="<?php echo $image[2]['alt']; ?>">
              </div>
              <!-- .col -->

            </div>
            <!-- .row -->
          
          </div>
          <!-- .col -->


        </div>
        <!-- .matrix-border -->

      </div>
      <!-- .gallery-matrix-block -->

      <?php endif; ?>

      <?php elseif( get_row_layout() == 'donate_block' ): ?>

      <div id="donate-block" class="mobile-margin-offset-x bg-light p-3 p-lg-5 my-6">

        <h2 class="text-center text-green mb-4">Donate to the <?php the_title(); ?> Project</h2>

        <?php echo do_shortcode( get_sub_field('donation_form_shortcode') ); ?>

      </div>

      <?php endif; /* text_block | figure_block | donate_block */ ?>

    </section>

    <?php endwhile; endif; /* article_section */ ?>

  </article>

  <?php get_template_part( 'template-parts/share' ) ?>
    
</main>
<!-- #content -->

<?php get_footer(); ?>