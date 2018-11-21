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
                                data-toggle="collapse" 
                                data-target="#mobile-menu" 
                                aria-expanded="false" 
                                aria-controls="mobile-menu"
                                type="button">
                                <span class="sr-only">Toggle Menu</span>
                            </button>
                        </div>

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

        <div id="device-menu" class="primary-navigation-device collapse d-lg-none">

            <hr>

            <nav class="nav d-flex flex-column py-3" role="navigation">

                <div class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="nav-item-01-b" data-toggle="dropdown"
                        aria-expanded="false" title="Nav Item">
                        Nav Item
                    </a>

                    <div class="dropdown-menu" aria-labelledby="nav-item-01-b">

                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>

                    </div>

                </div>

                <div class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="nav-item-02-b" data-toggle="dropdown"
                        aria-expanded="false" title="Nav Item">
                        Nav Item
                    </a>

                    <div class="dropdown-menu" aria-labelledby="nav-item-02-b">

                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>

                    </div>

                </div>

                <div class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="nav-item-03-b" data-toggle="dropdown"
                        aria-expanded="false" title="Nav Item">
                        Nav Item
                    </a>

                    <div class="dropdown-menu" aria-labelledby="nav-item-04-b">

                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>

                    </div>

                </div>

                <div class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="nav-item-04-b" data-toggle="dropdown"
                        aria-expanded="false" title="Nav Item">
                        Nav Item
                    </a>

                    <div class="dropdown-menu" aria-labelledby="nav-item-04-b">

                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>

                    </div>

                </div>

                <div class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="nav-item-05-b" data-toggle="dropdown"
                        aria-expanded="false" title="Nav Item">
                        Nav Item
                    </a>

                    <div class="dropdown-menu" aria-labelledby="nav-item-05-b">

                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>
                        <a class="dropdown-item" href="#" title="Link">Link</a>

                    </div>

                </div>

            </nav>

        </div>

    </header>
    <!-- #global-header -->