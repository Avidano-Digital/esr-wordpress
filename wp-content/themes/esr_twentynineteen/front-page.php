<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

 get_header(); ?>

  <main id="content">

    <section class="py-7 bg-danger" id="introduction">

      <div class="container-fluid wide">

        <div class="mb-5" id="featured-projects">
        
          <div class="narrow mb-5">
            <h1 class="display-4 text-center">We help the world’s greatest scientists save endangered animals</h1>
          </div>

          <div class="row matrix-border">

            <?php $i=1; while( $i <= 6) : ?>

            <div class="col-6">

              <a href="#" class="project-link">
                <img src="https://via.placeholder.com/800x400" alt="Placeholder">
              </a>

            </div>
            <!-- .col -->

            <?php $i++; endwhile; ?>

            <div class="col-6">

            </div>
            <!-- .col -->

          </div>
          <!-- .row -->

        </div>
        <!-- #featured-projects -->

        <div id="featured-shorts">
            
          <h2 class="text-center mb-4">Painted Dog Shorts</h2>

          <div class="row matrix-border">

            <?php $i=1; while( $i <= 3) : ?>

            <div class="col-4">

              <a href="#" class="project-link">
                <img src="https://via.placeholder.com/800x400" alt="Placeholder">
              </a>

            </div>
            <!-- .col -->

            <?php $i++; endwhile; ?>

            <div class="col-6">

            </div>
            <!-- .col -->

          </div>
          <!-- .row -->

        </div>
        <!-- #featured-shorts -->

      </div>
      <!-- .container-fluid -->

    </section>
    <!-- #introduction -->

  </main>
  <!-- #content -->

  <?php get_footer(); ?>