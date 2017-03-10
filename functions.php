<?php
/**
 * @package Yoko
 */

/**
 * Set theme colors
 */
if ( ! isset( $themecolors ) ) {
	$themecolors = array(
		'bg'     => 'ffffff',
		'text'   => '777777',
		'link'   => '009bc2',
		'border' => 'dddddd',
		'url'    => '009bc2'
	);
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 611;

/**
 * Set content width for full-width template
 */
function yoko_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width-page.php' ) ) {
		$content_width = 1102;
	}

}
add_action( 'template_redirect', 'yoko_content_width' );

/**
 * Tell WordPress to run yoko() when the 'after_setup_theme' hook is run.
 */
if ( ! function_exists( 'yoko' ) ):
/**
 * Sets up theme defaults and registers support for WordPress features.
 */
function yoko() {

	//Create Yoko Theme Options Page
	require_once ( get_template_directory() . '/inc/theme-options/theme-options.php' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	//Make theme available for translation
	load_theme_textdomain( 'yoko', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'  => __( 'Primary Navigation', 'yoko' ),
		'sub_menu' => __( 'Sub Menu', 'yoko' )
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'video', 'image', 'quote' ) );

	// This theme allows users to set a custom background
	add_theme_support( 'custom-background' );
}
endif;
add_action( 'after_setup_theme', 'yoko' );


/**
 * Adds custom classes to the array of body classes.
 */
function yoko_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() )
		$classes[] = 'group-blog';

	return $classes;
}
add_filter( 'body_class', 'yoko_body_classes' );


if ( ! function_exists( 'yoko_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function yoko_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'yoko' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'yoko' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;


if ( ! function_exists( 'yoko_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function yoko_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'yoko' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr; Previous Post', 'Previous post link', 'yoko' ) . '</span>' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next Post &rarr;', 'Next post link', 'yoko' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'yoko' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'yoko' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


if ( ! function_exists( 'yoko_entry_meta' ) ) :
/**
 * Display category/tag/permalink when applicable
 */
function yoko_entry_meta() {
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'yoko' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', ', ' );

	if ( ! yoko_categorized_blog() ) {
		// This blog only has 1 category so we just need to worry about tags in the meta text
		if ( '' != $tag_list ) {
			$meta_text = __( 'Tags: %2$s | <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>.', 'yoko' );
		} else {
			$meta_text = __( '<a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>.', 'yoko' );
		}

	} else {
		// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list ) {
			$meta_text = __( 'Categories: %1$s | Tags: %2$s | <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>.', 'yoko' );
		} else {
			$meta_text = __( 'Categories: %1$s | <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>.', 'yoko' );
		}

	} // end check for categories on this blog

	printf(
		$meta_text,
		$category_list,
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;


/**
 * Returns true if a blog has more than 1 category
 */
function yoko_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so yoko_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so yoko_categorized_blog should return false
		return false;
	}
}


/**
 * Flush out the transients used in yoko_categorized_blog
 */
function yoko_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'yoko_category_transient_flusher' );
add_action( 'save_post', 'yoko_category_transient_flusher' );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function yoko_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'yoko_page_menu_args' );


/**
 * Sets the post excerpt length to 40 characters.
 */
function yoko_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'yoko_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 */
function yoko_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'yoko' ) . '</a>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and yoko_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function yoko_auto_excerpt_more( $more ) {
	return ' &hellip;' . yoko_continue_reading_link();
}
add_filter( 'excerpt_more', 'yoko_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function yoko_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() )
		$output .= yoko_continue_reading_link();

	return $output;
}
add_filter( 'get_the_excerpt', 'yoko_custom_excerpt_more' );


if ( ! function_exists( 'yoko_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function yoko_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-gravatar"><?php echo get_avatar( $comment, 65 ); ?></div>

			<div class="comment-body">
				<div class="comment-meta commentmetadata">
					<?php printf( __( '%s', 'yoko' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?><br/>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php printf( __( '%1$s at %2$s', 'yoko' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( 'Edit', 'yoko' ), ' ' ); ?>
				</div>

				<?php comment_text(); ?>

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'yoko' ); ?></p>
				<?php endif; ?>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		</div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'yoko' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'yoko' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/**
 * Register widgetized area and update sidebar with default widgets
 */
function yoko_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar 1', 'yoko' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Primary sidebar area', 'yoko' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'yoko' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'An optional second sidebar area', 'yoko' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'yoko_widgets_init' );


/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function yoko_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'yoko_remove_recent_comments_style' );


/**
 * Enqueue scripts and styles
 */
function yoko_scripts() {
	global $post;
	$protocol = is_ssl() ? 'https' : 'http';

	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'yoko-fonts', "$protocol://fonts.googleapis.com/css?family=Droid+Sans:regular,bold|Droid+Serif:regular,italic,bold,bolditalic&subset=latin" );

	wp_enqueue_script( 'yoko-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20140702', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'yoko_scripts' );

/**
 * Enqueue font style for the custom header admin page.
 */
function yoko_admin_fonts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'everafter-pacifico', "$protocol://fonts.googleapis.com/css?family=Droid+Sans:regular,bold|Droid+Serif:regular,italic,bold,bolditalic&subset=latin" );
}
add_action( 'admin_enqueue_scripts', 'yoko_admin_fonts' );


/**
 * Calls SmoothScroll in Footer
 */
function yoko_smoothscroll_init() {
	wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'yoko_smoothscroll_init' );


/**
 * Check for secondary sidebar
 */
function yoko_sidebar_class() {
	if ( is_active_sidebar( 'sidebar-2' ) ) :
		$class = 'two-sidebar';
	else :
		$class = 'one-sidebar';
	endif;

	echo 'class="' . $class . '"';
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Yoko 1.0.5
 */
function yoko_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'yoko' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'yoko_wp_title', 10, 2 );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Infinite Scroll Theme Assets
 *
 * Register support for @Yoko and enqueue relevant styles.
 */

/**
 * Add theme support for infinity scroll
 */
function yoko_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content'
	) );
}
add_action( 'init', 'yoko_infinite_scroll_init' );

/**
 * Enqueue CSS stylesheet with theme styles for infinity.
 */
function yoko_infinite_scroll_enqueue_styles() {
	// Add theme specific styles.
	wp_enqueue_style( 'infinity-yoko', plugins_url( 'yoko.css', __FILE__ ), array(), '20120227' );
}
add_action( 'wp_enqueue_scripts', 'yoko_infinite_scroll_enqueue_styles', 25 );

/**
 * Yoko doesn't have footer widgets but when it's viewed from mobile the sidebars drop down below the content
 *
 * @uses jetpack_is_mobile
 * @filter infinite_scroll_has_footer_widgets
 * @return bool
 */
function yoko_has_footer_widgets( $has_widgets ) {
	if ( jetpack_is_mobile( '', true ) )
		$has_widgets = true;

	return $has_widgets;
}
add_filter( 'infinite_scroll_has_footer_widgets', 'yoko_has_footer_widgets' );

// updater for WordPress.com themes
if ( is_admin() )
	include dirname( __FILE__ ) . '/inc/updater.php';
