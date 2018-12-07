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

  <?php endwhile; endif; /* hero */ ?>

  <!-- Article content -->

  <?php get_template_part( 'template-parts/article' ) ?>
    
</main>
<!-- #content -->

<?php get_footer(); ?>