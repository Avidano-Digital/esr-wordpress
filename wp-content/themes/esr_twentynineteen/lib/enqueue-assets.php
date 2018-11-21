<?php
    
    add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_assets' );

    function enqueue_theme_assets(){

        ////////////////////////////////////////
        // CSS
        ////////////////////////////////////////

        wp_enqueue_style( 
            'theme', 
            get_template_directory_uri() . '/css/theme.css'
        );

        wp_enqueue_style( 
            'fontAwesome', 
            'https://use.fontawesome.com/releases/v5.5.0/css/all.css'
        );
        
        wp_enqueue_style( 
            'googleFonts', 
            'https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,900,900i|Oswald' 
        );

        ////////////////////////////////////////
        // JS
        ////////////////////////////////////////

        wp_enqueue_script( 
            'popper', 
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', 
            ['jquery'],
            '1.14.3', 
            true 
        );

        wp_enqueue_script( 
            'bootstrap-js', 
            'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js',
            ['jquery'],
            '4.1.3', 
            true 
        );

        wp_enqueue_script( 
            'hoverIntent', 
            get_template_directory_uri() . '/js/vendor/jquery.hoverIntent.min.js', 
            ['jquery'],
            '1.0', 
            true 
        );

        wp_enqueue_script( 
            'main', 
            get_template_directory_uri() . '/js/main.js',
            ['jquery'],
            '1.0.0', 
            true 
        );

    } // enqueue_theme_assets