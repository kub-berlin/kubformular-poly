<?php
/**
 * Yoko Theme Options
 *
 * @package Yoko
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 */
function yoko_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'yoko-theme-options', get_template_directory_uri() . '/inc/theme-options/theme-options.css' );
	wp_enqueue_script( 'yoko-theme-options', get_template_directory_uri() . '/inc/theme-options/theme-options.js', array( 'farbtastic' ) );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'yoko_admin_enqueue_scripts' );

/**
 * Register the form setting for our yoko_options array.
 */
function yoko_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === yoko_get_theme_options() )
		add_option( 'yoko_theme_options', yoko_get_default_theme_options() );

	register_setting(
		'yoko_options',       // Options group, see settings_fields() call in yoko_theme_options_render_page()
		'yoko_theme_options', // Database option, see yoko_get_theme_options()
		'yoko_theme_options_validate' // The sanitization callback, see yoko_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see yoko_theme_options_add_page()
	);


	add_settings_field( 'link_color', __( 'Link Color', 'yoko' ), 'yoko_settings_field_link_color', 'theme_options', 'general' );
}
add_action( 'admin_init', 'yoko_theme_options_init' );

/**
 * Change the capability required to save the 'yoko_options' options group.
 */
function yoko_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_yoko_options', 'yoko_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 */
function yoko_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'yoko' ),   // Name of page
		__( 'Theme Options', 'yoko' ),   // Label in menu
		'edit_theme_options',            // Capability required
		'theme_options',                 // Menu slug, used to uniquely identify the page
		'yoko_theme_options_render_page' // Function that renders the options page
	);
}
add_action( 'admin_menu', 'yoko_theme_options_add_page' );

/**
 * Returns the default options for Yoko.
 */
function yoko_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '009BC2',
	);

	return apply_filters( 'yoko_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Yoko.
 *
 * @since Yoko 1.0
 */
function yoko_get_theme_options() {
	return get_option( 'yoko_theme_options', yoko_get_default_theme_options() );
}

/**
 * Renders the Link Color setting field.
 *
 * @since Yoko 1.3
 */
function yoko_settings_field_link_color() {
	$options = yoko_get_theme_options();
	?>
	<input type="text" name="yoko_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
	<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
	<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'yoko' ); ?>" />
	<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
	<br />
	<span><?php _e( 'Default color: #009bc2', 'yoko' ); ?></span>
	<?php
}

/**
 * Returns the options array for Yoko.
 *
 * @since Yoko 1.2
 */
function yoko_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'yoko' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'yoko_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see yoko_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since Yoko 1.0
 */
function yoko_theme_options_validate( $input ) {
	$output = $defaults = yoko_get_default_theme_options();

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	return apply_filters( 'yoko_theme_options_validate', $output, $input, $defaults );
}

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Yoko 1.0
 */
function yoko_print_link_color_style() {
	$options = yoko_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = yoko_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style type="text/css">
	a { color: <?php echo esc_attr( $link_color ); ?>; }
	#content .single-entry-header h1.entry-title { color: <?php echo esc_attr( $link_color ); ?> !important; }
	input#submit:hover { background-color: <?php echo esc_attr( $link_color ); ?> !important; }
	#content .page-entry-header h1.entry-title { color: <?php echo esc_attr( $link_color ); ?> !important; }
	.searchsubmit:hover { background-color: <?php echo esc_attr( $link_color ); ?> !important; }
	</style>
<?php
}
add_action( 'wp_head', 'yoko_print_link_color_style' );