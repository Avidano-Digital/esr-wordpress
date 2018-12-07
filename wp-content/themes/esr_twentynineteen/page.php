<?php get_header(); ?>

<main id="content">

  <section class="py-7">

    <header class="container bg-warning">
      <div class="narrow text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
      </div>
    </header>

  <!-- Article content -->

  <?php get_template_part( 'template-parts/article' ) ?>
  <?php get_template_part( 'template-parts/share' ) ?>

  </section>
  <!-- .container-fluid -->

</main>
<!-- #content -->
    
<?php get_footer(); ?>