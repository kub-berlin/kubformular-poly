<?php
/**
 * @package Yoko
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/css3-mediaqueries.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="clearfix">
	<header id="branding">
		<nav id="mainnav" class="clearfix" role="navigation">
			<button class="menu-toggle"><?php _e( 'Menu', 'yoko' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- end mainnav -->

		<hgroup id="site-title">
			<?php yoko_the_site_logo(); ?>
			<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup><!-- end site-title -->

	<?php
			// The header image. If single post w/thumbnail that's big enough, show it
			if ( is_singular() && current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( $post->ID ) && ( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) && $image[1] >= HEADER_IMAGE_WIDTH ) :
				echo get_the_post_thumbnail( $post->ID , array( 1102, 350 ), array( 'class' => 'headerimage' ) );
			elseif ( get_header_image() ) : ?>
				<img src="<?php header_image(); ?>" class="headerimage" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo get_custom_header()->height; ?>>" alt="" />
		<?php
			endif;
		?>
		<div class="clear"></div>

		<?php if ( has_nav_menu( 'sub_menu' ) ) { ?>
			<nav id="subnav" class="clearfix">
				<?php wp_nav_menu( array( 'theme_location' => 'sub_menu' ) ); ?>
			</nav><!-- end subnav -->
		<?php }	?>
	</header><!-- end header -->