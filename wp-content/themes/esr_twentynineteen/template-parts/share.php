<div id="share" class="container text-center mb-7">

    <p class="fs-md"><em>Share this:</em></p>

    <ul class="link-list horizontal justify-content-center">

        <li>
        <a class="no-btn-style" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>&title=<?php echo the_title(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/btn-share-facebook.svg" alt="Facebook"></a>

        </li>
        <li>
        <a class="no-btn-style" href="http://twitter.com/share?text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/btn-share-twitter.svg" alt="Twitter"></a>

        </li>
        <li>
        <a class="no-btn-style" href="mailto:?subject=Endangered Species Revenge&body=Check out <?php echo $url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/btn-share-email.svg" alt="Email"></a>

        </li>

    </ul>

</div>