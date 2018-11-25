<?php $project_video_group = get_field('project_video_group');	

$headline = $project_video_group['headline'];
$videos = $project_video_group['videos'];

$post_objects = $videos;

if( $project_video_group ): ?>

<div class="featured-videos">
    
    <h2 class="text-center mb-4"><?php echo $headline; ?></h2>

    <div class="row matrix-border">

    <?php

        if( $post_objects ) :
        foreach($post_objects as $post) :
        setup_postdata( $post ); 

        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );

        $project_link = get_field('project_link');
    ?>
    
    <div class="col-md-6">

        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id;?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
        </div>

        <?php if ( !empty($project_link) ) : ?>

        <div class="bg-black p-2">
            <a class="h4 text-white no-link-style" href="<?php echo $project_link['url']; ?>" title="<?php echo $project_link['title']; ?>"><?php echo $project_link['title']; ?></a>
        </div>

        <?php endif; ?>

    </div>
    <!-- .col -->

    <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

    </div>
    <!-- .row -->

</div>
<!-- .featured-videos -->

<?php endif; /* featured_video_group */ ?>