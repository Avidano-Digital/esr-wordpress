<?php
$homeurl = get_bloginfo('home');
$themeurl = get_bloginfo('template_url');
$sitename = get_bloginfo('name');
$urlparts = parse_url($homeurl);




wp_enqueue_style('theme-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700|Noticia+Text:400,400italic,700', array(), THEME_VERSION);


wp_enqueue_style('theme-reset', $themeurl.'/reset.css');
wp_enqueue_style('theme', $themeurl.'/style.css', array('theme-reset', 'theme-fonts'), THEME_VERSION);
wp_enqueue_style('theme-print', $themeurl.'/print.css', array('theme'), THEME_VERSION, 'print');
wp_enqueue_style('theme-ie9', $themeurl.'/ie9.css', array('theme'), THEME_VERSION);
$GLOBALS['wp_styles']->add_data('theme-ie9', 'conditional', 'lte IE 9');
wp_enqueue_style('theme-ie8', $themeurl.'/ie8.css', array('theme'), THEME_VERSION);
$GLOBALS['wp_styles']->add_data('theme-ie8', 'conditional', 'lte IE 8');

wp_enqueue_script('theme', $themeurl.'/js/page.js', array('jquery', 'hoverIntent'), THEME_VERSION);



$section = get_current_nav_item();
if ($section) {
	$section_slug = sanitize_title($section->title);
	add_body_class('section-'.$section_slug);
	switch($section_slug) {
		case 'wide page slug':
			add_body_class('wide');
		break;
	}
	if (($post->post_type == 'page') && !$post->post_parent) {
		add_body_class('section-frontpage');
	}
} else {
	if (is_page()) {
		if (!$post->post_parent) {
			add_body_class('section-frontpage');
			add_body_class('section-'.$post->post_name);
		} else {
		
		}
	}
	if (preg_match('@/research/@', $_SERVER['REQUEST_URI'])) {
		add_body_class('section-research');
	}

}

remove_action('wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', 'feed_links', 2 );

?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ) ?> xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 

<meta name="p:domain_verify" content="a75630c6f56ad0980ccbf422614e004f"/>
 
<title><?php wp_title(' '); ?><?php echo (wp_title(' ', false) ? ' : ' : '') ?><?php bloginfo('name'); ?></title>

<script>
var BASE = <?php echo json_encode($themeurl);?>;
var BASEWP = <?php echo json_encode(get_bloginfo('wpurl'));?>;
var HOSTNAME = <?php echo json_encode($urlparts['host']);?>;
var DOMAINS = ['cheetah.org', 'www.cheetah.org', HOSTNAME];
</script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 

<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="<?php echo get_bloginfo('rss2_url');?>" />

<?php 
get_template_part('header', 'meta');
get_template_part('header', 'meta-tracking');
wp_head();
?>
</head>


<body <?php body_class('no-js');?>>
<div id="bg">
<?php echo apply_filters('theme_bg_img', '<div class="img"></div>');?>
<div class="fade"></div>
</div>
<div id="nav-bg">
<div class="ind"></div>
</div>


<div id="wrap">

<div id="header">
	<div class="logo" itemscope itemtype="http://schema.org/Organization"><a itemprop="url" href="<?php echo $homeurl;?>"><img itemprop="logo" src="<?php echo $themeurl;?>/images/logo.png" alt="<?php bloginfo('name');?>" /></a></div>
<?php
wp_nav_menu(array(
	'theme_location' => 'main', 
	'menu_id' => 'menu', 
	'depth' => 2,
	'container_id' => 'nav',
));

?> 



<div id="page-top">
<div  id="header-library">
<a href="/research/">Research Library</a>
</div>

<?php if ($html =  get_ad('donate-header')):?>
<div id="header-donate"><?php echo $html?></div>
<?php endif;?>

<form method="get" id="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="query" class="field" name="s" id="s" placeholder="Search" />
	<button type="submit">GO</button>
</form>

<div id="search-toggle"></div>
</div>





</div>

<?php 
include('header-breadcrumb.php');
do_action('theme_main_pre');
?>

<div id="main">
<div id="main-left">
<?php echo apply_filters('theme_main_top', '<div class="top"></div>');?>

<div id="content">

