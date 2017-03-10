<?php
/**
 * @package Yoko
 */

// Change content_width
$content_width = 820;

get_header(); ?>

<div id="wrap">
<div id="main" <?php yoko_sidebar_class(); ?>>

	<div id="content" class="site-content">
		<?php the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>
		<?php comments_template( '', true ); ?>
	</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>