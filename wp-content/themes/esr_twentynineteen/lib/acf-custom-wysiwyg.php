<?php

    add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );

    function my_toolbars( $toolbars ){

        // Add a new toolbar called "Very Simple"
        $toolbars['Very Simple' ] = array();
        $toolbars['Very Simple' ][1] = array( 'bold' , 'italic' , 'underline', 'link' );

        // Edit the "Full" toolbar and remove 'code'
        // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
        if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false ){
            unset( $toolbars['Full' ][2][$key] );
        }

        // Remove the 'Basic' toolbar completely
        unset( $toolbars['Basic' ] );

        // Return $toolbars
        return $toolbars;
    }

    ////////////////////////////////////////
    // Remove default format select
    ////////////////////////////////////////

    add_filter( 'mce_buttons', 'remove_default_tiny_mce_buttons' );

    function remove_default_tiny_mce_buttons( $buttons ) {
        $remove = array( 
            'formatselect',
            'blockquote',
            'hr', // horizontal line
            'alignleft',
            'aligncenter',
            'alignright',
            'wp_more', // read more link
            'spellchecker',
            'dfw', // distraction free writing mode
            'wp_adv', // kitchen sink toggle (if removed, kitchen sink will always display)
         );
        return array_diff( $buttons, $remove );
    }

    ////////////////////////////////////////
    // Add 'styleselect' to buttons array
    ////////////////////////////////////////

    add_filter( 'mce_buttons', 'my_new_mce_buttons' );

    function my_new_mce_buttons( $buttons ) {
        array_unshift( $buttons, 'styleselect' );
        return $buttons;
    }

    ////////////////////////////////////////
    // Add Formats to 'styleselect'
    ////////////////////////////////////////

    add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

    function my_mce_before_init_insert_formats( $init_array ) {
        
        // Define the style_formats array and insert into 'style_formats'
        $style_formats = array(

            array(
                'title' => 'Headline (h2)',
                'block' => 'h2',
                'classes' => 'h1',
                'exact' => false,
            ),
            array(
                'title' => 'Headline (h3)',
                'block' => 'h3',
            ),
            array(
                'title' => 'Headline (h4)',
                'block' => 'h4',
            ),
            array(
                'title' => 'Headline (h5)',
                'block' => 'h5',
            ),
            array(
                'title' => 'Paragraph',
                'block' => 'p',
            ),
            array(
                'title' => 'Blockquote',
                'block' => 'blockquote',
                'classes' => 'pullout my-4',
            )
        );

        $init_array['style_formats'] = json_encode( $style_formats );  
        return $init_array;  
    }