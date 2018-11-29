<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Endangered Species Revenge
 */

get_header(); ?>

<div id="content" role="main">

  <section class="container-narrow stack">

    <div class="one-across v-space">

      <div class="h-space">

      <?php
      while ( have_posts() ) : the_post();

        the_title();

      	the_content();

      endwhile; // End of the loop.
      ?>

      </div><!-- end h-space -->
        
    </div><!-- end one-across -->
        
  </section>

</div>

<?php
get_footer();
