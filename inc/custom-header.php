<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package yoko
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses yoko_header_style()
 * @uses yoko_admin_header_style()
 * @uses yoko_admin_header_image()
 *
 * @package yoko
 */
function yoko_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'yoko_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/images/headers/ginko.jpg',
		'default-text-color'     => '009BC2',
		'width'                  => 1102,
		'height'                 => 350,
		'flex-height'            => true,
		'wp-head-callback'       => 'yoko_header_style',
		'admin-head-callback'    => 'yoko_admin_header_style',
		'admin-preview-callback' => 'yoko_admin_header_image',
	) ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 350 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( get_custom_header()->width, get_custom_header()->height, true );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'ginko' => array(
			'url'           => '%s/images/headers/ginko.jpg',
			'thumbnail_url' => '%s/images/headers/ginko-thumbnail.jpg',
			'description'   => __( 'Ginko', 'yoko' )
		),
		'flowers' => array(
			'url'           => '%s/images/headers/flowers.jpg',
			'thumbnail_url' => '%s/images/headers/flowers-thumbnail.jpg',
			'description'   => __( 'Flowers', 'yoko' )
		),
		'plant' => array(
			'url'           => '%s/images/headers/plant.jpg',
			'thumbnail_url' => '%s/images/headers/plant-thumbnail.jpg',
			'description'   => __( 'Plant', 'yoko' )
		),
		'sailing' => array(
			'url'           => '%s/images/headers/sailing.jpg',
			'thumbnail_url' => '%s/images/headers/sailing-thumbnail.jpg',
			'description'   => __( 'Sailing', 'yoko' )
		),
		'cape' => array(
			'url'           => '%s/images/headers/cape.jpg',
			'thumbnail_url' => '%s/images/headers/cape-thumbnail.jpg',
			'description'   => __( 'Cape', 'yoko' )
		),
		'seagull' => array(
			'url'           => '%s/images/headers/seagull.jpg',
			'thumbnail_url' => '%s/images/headers/seagull-thumbnail.jpg',
			'description'   => __( 'Seagull', 'yoko' )
		)
	) );
}
add_action( 'after_setup_theme', 'yoko_custom_header_setup' );

if ( ! function_exists( 'yoko_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see yoko_custom_header_setup().
 */
function yoko_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		#site-title a,
		#site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			color: #<?php echo $header_text_color; ?>
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // yoko_header_style

if ( ! function_exists( 'yoko_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see yoko_custom_header_setup().
 */
function yoko_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#headimg #desc {
		}
		#headimg h1 {
			display: block;
			float: left;
			margin: 0 1% 0 0;
		}
		#headimg h1 a {
			font-family: 'Droid Sans', arial, sans-serif;
			font-size: 34px;
			font-weight: bold;
			line-height: 40px;
			text-decoration: none;
			text-transform: uppercase;
		}
		#desc {
			color: #777 !important;
			font-family: 'Droid Serif', arial, sans-serif;
			font-size: 14px;
			font-style: italic;
			margin-top: 17px;
			padding-bottom: 15px;
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // yoko_admin_header_style

if ( ! function_exists( 'yoko_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see yoko_custom_header_setup().
 */
function yoko_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php
}
endif; // yoko_admin_header_image
