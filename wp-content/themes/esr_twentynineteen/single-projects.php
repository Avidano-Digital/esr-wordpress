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

    <div class="py-7 torn-top">

      <!-- Put article content here -->

      <?php if( have_rows('article_section') ) :
    
      while( have_rows('article_section') ) : the_row(); ?>

      <article>

      <section class="container">

        <?php if( get_row_layout() == 'text_block' ):

        $wysiwyg = get_sub_field('wysiwyg'); ?>

        <div class="narrow mb-6">
            <?php echo $wysiwyg; ?>
        </div>

        <?php endif; /* text_block */ ?>

      </section>
      
      </article>
      
      <?php endwhile; endif; /* article_content */ ?>
    
      </div>
      <!-- .torn-top -->

    <section id="donate-block" class="container narrow mobile-edge bg-light p-3 p-lg-5 mb-5">

      <h3 class="text-center text-green mb-4">Donate to the <?php the_title(); ?> Project</h3>

      <?php echo do_shortcode(get_field('donation_form_shortcode')); ?>

    </section>
    
</main><!-- #content -->

<?php get_footer(); ?>