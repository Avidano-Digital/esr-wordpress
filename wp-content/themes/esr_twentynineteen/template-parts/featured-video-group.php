<?php $featured_video_group = get_field('featured_video_group');	

$headline = $featured_video_group['headline'];
$videos = $featured_video_group['videos'];

$post_objects = $videos;

if( $featured_video_group ): ?>

<div class="featured-videos">
    
    <h2 class="text-center mb-4"><?php echo $headline; ?></h2>

    <div class="row matrix-border mobile-margin-offset-x">

    <?php

        if( $post_objects ) :
        foreach($post_objects as $post) :
        setup_postdata( $post ); 

        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );
    ?>
    
    <div class="col-md-4">

        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
        </div>

    </div>
    <!-- .col -->

    <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

    </div>
    <!-- .row -->

</div>
<!-- .featured-videos -->

<?php endif; /* featured_video_group */ ?>