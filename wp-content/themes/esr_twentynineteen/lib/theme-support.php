<?php

    add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_support' );
    
    function theme_support(){

        global $color_palette;

        ////////////////////////////////////////
        // Image Preferences
        ////////////////////////////////////////

        add_theme_support( 'post-thumbnails' );

        update_option( 'thumbnail_size_w', 320 );
        update_option( 'thumbnail_size_h', 320 );
        update_option( 'thumbnail_crop', false );

        update_option( 'medium_size_w', 0 );
        update_option( 'medium_size_h', 0 );

        update_option( 'medium_large_size_w', 0 );
        update_option( 'medium_large_size_h', 0 );

        update_option( 'large_size_w', 0 );
        update_option( 'large_size_h', 0 );
        
        // Custom JPG Compression

        function my_prefix_regenerate_thumbnail_quality() {
            return 85;
        }
         
        add_filter( 'jpeg_quality', 'my_prefix_regenerate_thumbnail_quality');

    } // theme_support

    ////////////////////////////////////////
    // Remove Dashboard Menu Items
    ////////////////////////////////////////
    
    add_action( 'admin_menu', __NAMESPACE__ . '\remove_menus' );

    function remove_menus(){
        remove_menu_page( 'edit-comments.php' );
    }



    ////////////////////////////////////////
    // Custom Post Types
    ////////////////////////////////////////


    add_action( 'init', __NAMESPACE__ . 'create_post_type' );

    function create_post_type() {

        register_post_type( 'Projects',
            array(
                'labels' => array(
                'name' => __( 'Projects' ),
                'singular_name' => __( 'Project' )
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'projects'),
            'has_archive' => false,
            'menu_icon' => 'dashicons-admin-site'
            )
        );

        register_post_type( 'Characters',
            array(
                'labels' => array(
                'name' => __( 'Characters' ),
                'singular_name' => __( 'Character' )
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'characters'),
            'menu_icon' => 'dashicons-groups'
            )
        );
        
        register_post_type( 'Videos',
            array(
                'labels' => array(
                'name' => __( 'Videos' ),
                'singular_name' => __( 'Video' )
            ),
            'public' => true,
            'rewrite' => array( 'slug' => 'videos'),
            'menu_icon' => 'dashicons-video-alt3'
            )
        );
    }
















    ////////////////////////////////////////
    // Custom Logo
    ////////////////////////////////////////

    add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_prefix_setup' );

    function theme_prefix_setup() {
        add_theme_support( 'custom-logo' );
    }

    add_action( 'login_head', __NAMESPACE__ . '\wpdev_filter_login_head', 100 );
    
    function wpdev_filter_login_head() {
 
        if ( has_custom_logo() ) :
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            $height = '100px';
            $width = '185px';
        ?>

        <style type="text/css">
            .login h1 a {
                background-image: url( <?php echo esc_url( $image[0] ); ?> );
                -webkit-background-size: <?php echo $image[0] ?>px;
                background-size: contain;
                height: <?php echo $height ?>;
                width: <?php echo $width ?>;
            }
        </style>
        
        <?php endif;
    }