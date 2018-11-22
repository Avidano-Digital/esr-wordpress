<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>
        <?php the_title(); ?> • Endangered Species Revenge
    </title>

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header id="global-header" role="banner">

        <div class="wrap-header bg-primary">

            <div class="container-fluid">

                <!-- row 01 -->
                <div class="row align-items-center">

                    <div class="col-sm py-2">

                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                        
                            <a class="d-inline-block" href="/" title="Home">
                                <?php the_custom_logo(); ?>
                            </a>

                            <p class="text-white font-weight-bold fs-sm ml-2">
                                <em>
                                    <span class="d-block">Bringing Fun to</span>
                                    <span class="d-block">Wildlife Conservation<sup>TM</sup></span>
                                </em>
                            </p>
                        
                        </div>
                        <!-- .d-flex -->

                    </div>
                    <!-- .col -->

                    <div class="col-sm-auto text-right">


                        <div class="d-xl-none py-1" id="wrap-toggle">

                            <button class="align-self-center ml-auto"
                                id="toggle-device-menu"
                                data-toggle="collapse" 
                                data-target="#device-menu" 
                                aria-expanded="false" 
                                aria-controls="device-menu"
                                type="button">
                                <span class="sr-only">Toggle Menu</span>
                            </button>

                        </div>
                        <!-- #wrap-toggle -->

                        <div class="d-none d-xl-block">

                            <nav id="secondary-navigation">
                                <?php include( 'include/secondary-navigation.php' );?>
                            </nav>

                            <nav id="primary-navigation-desktop">
                                <?php include( 'include/primary-navigation.php' );?>
                            </nav>

                        </div>
                        <!-- .d-none  -->

                    </div>
                    <!-- .col -->

                </div>
                <!-- .row -->

            </div>
            <!-- .container-fluid -->

        </div>
        <!-- .wrap-header -->

        <div id="device-menu" class="primary-navigation-device collapse d-xl-none">

            <?php include('include/all-links.php');?>

        </div>

    </header>
    <!-- #global-header -->