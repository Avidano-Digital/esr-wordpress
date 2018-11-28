<?php get_header(); ?>

<main id="content" role="main">

  <?php include('include/video-block.php'); ?>

  <section class="container px-0 py-5">

    <h4 class="h2 text-center px-3 mb-5"><?php the_field('heading'); ?></h4>

    <?php
    $image = get_field('photo');
    if( !empty($image) ): 
    ?>      

    <figure class="mb-5">
      <img class="img-fluid w-100" src="<?php echo $image['url']; ?>"  alt="<?php echo $image['alt']; ?>">
    </figure>
    
    <?php endif; ?>

    <section class="narrow px-4">

      <?php the_field('description_text'); ?>

    </section>

  </section>

  <section id="donate-block" class="container mobile-edge bg-light p-3 p-lg-5 mb-5">

    <h3 class="text-center text-green mb-4">Donate to the <?php the_title(); ?> Project</h3>

    <?php echo do_shortcode(get_field('donation_form_shortcode')); ?>

  </section>

</section>

<?php include('include/share.php'); ?>

</main><!-- #content -->

<?php get_footer(); ?>