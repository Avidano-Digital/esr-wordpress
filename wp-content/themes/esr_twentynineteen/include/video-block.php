<section id="video-block" class="container-fluid px-0 py-6 bg-black">

    <header>
        <h1 class="display-4 text-white text-center mb-5">
            <?php the_title(); ?>
        </h1>
    </header>

    <div class="wide">

        <?php

        $post_objects = get_field('videos');
        if( $post_objects ) : 

        foreach($post_objects as $post) :
        setup_postdata( $post ); 

        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );

        if (strpos($video_url,'youtu') !== false) : ?>

        <div class="mb-5">
        <div id="video-embed" class="youtube-embed"  data-featured="<?php echo $video_id; ?>"><iframe src="https://www.youtube.com/embed/<?php echo $video_id;?>?rel=0" frameborder="0" allowfullscreen=""></iframe></div>
        </div>

        <?php 
        endif;
        break;
        endforeach;
        ?>

        <h2 class="h3 text-white text-center mb-4">Related Videos</h2>

        <div class="row no-gutters px-3 px-xl-0 d-flex justify-content-center offset-border-x">

        <?php
        $number = 0;

        foreach($post_objects as $post) :
        if($number > 0 && $number < 5) :
        
        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );
        
        ?>

        <div class="col-6 col-lg-3 border border-transparent">
            <a href="#" data-video="<?php echo $video_id; ?>">
                <img class="img-fluid" src="<?php echo 'http://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg'; ?>" alt="placeholder">
            </a>            
        </div>

        <?php 
        endif;
        $number++;
        endforeach;
        ?>

        </div>
        
    </div>

    <?php
    wp_reset_postdata();
    endif; 
    ?>

</section>