<?php
/**
 * @package Yoko
 */

get_header(); ?>

<div id="wrap">
<div id="main" <?php yoko_sidebar_class(); ?>>

	<div id="content" class="site-content">
		<?php the_post(); ?>

		<header class="page-header">
			<h1 class="page-title author"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'yoko' ), "<a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h1>
		</header><!-- end page header -->

		<?php rewind_posts(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php yoko_content_nav( 'nav-below' ); ?>
	</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>