<?php
/**
 * @package WordPress
 * @subpackage Yoko
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline'">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="clearfix">
	<header id="branding">
		<?php global $yoko_options;
		$yoko_settings = get_option( 'yoko_options', $yoko_options ); ?>

		<?php if( $yoko_settings['custom_logo'] ) : ?>
			<img src="<?php echo $yoko_settings['custom_logo']; ?>" class="header-logo" alt="KuB Berlin" /></a>
		<?php endif ?>

		<hgroup id="site-title">
			<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup><!-- end site-title -->

		<?php
			// The header image
			// Check if this is a post or page, if it has a thumbnail, and if it's a big one
			if ( is_singular() &&
				current_theme_supports( 'post-thumbnails' ) &&
				has_post_thumbnail( $post->ID ) &&
				( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
				$image[1] >= HEADER_IMAGE_WIDTH ) :
				// Houston, we have a new header image!
						echo get_the_post_thumbnail( $post->ID , array(1102,350), array('class' => 'headerimage'));
						elseif ( get_header_image() ) : ?>
						<img src="<?php header_image(); ?>" class="headerimage" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /><!-- end headerimage -->
		<?php endif; ?>

		<nav id="mainnav" class="clearfix">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- end mainnav -->
		<div class="clear"></div>

		<?php if (is_nav_menu( 'Sub Menu' ) ) : ?>
			<nav id="subnav">
				<?php wp_nav_menu( array('menu' => 'Sub Menu' )) ?>
			</nav>
		<?php endif ?>
</header><!-- end header -->