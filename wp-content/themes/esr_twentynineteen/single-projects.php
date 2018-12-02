<?php get_header(); ?>

<main id="content" role="main">

  <?php if( have_rows('hero') ): while( have_rows('hero') ): the_row(); 
  
  // vars
  $subtitle = get_sub_field('subtitle');
  $image = get_sub_field('image');
  $character_image = get_sub_field('character_image');
  $class_name = get_sub_field('class_name');
  
  ?>

  <section class="featured-panel torn-bottom-white responsive-md">

    <div class="card <?php if( !empty($class_name) ) echo $class_name ?>">

      <div class="overlay-gradient-y-blacks">
        <?php if ($image) : ?>
        <img class="card-img opacity-30 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
        <?php else : ?>
        <img class="card-img" src="http://via.placeholder.com/1200x675/000000/333333/.jpg" alt="Placeholder">
        <?php endif; ?>
      </div>

      <!-- .overlay-gradient-y-black -->
      <div class="card-img-overlay d-flex">

        <div class="container align-self-center pt-4 pb-6">

          <div class="text-white text-center">
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

      $image = $figure_inline_single['image'];
      $caption = $figure_inline_single['caption'];

      ?>

      <div class="figure-block my-6">
          <figure class="figure my-0">
              <img class="figure-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
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

        <div class="video-block my-6">

        <div class="wide bg-black">

          <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>"></iframe>
          </div>

        </div>
        <!-- .wide -->

        </div>
        <!-- .video_block -->

        <?php endif; wp_reset_postdata(); /* post_objects */ ?>

      <?php elseif( get_row_layout() == 'donate_block' ): ?>

      <div id="donate-block" class="mobile-edge bg-light p-3 p-lg-5 mb-7">

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