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
			<h1 class="page-title"><?php printf( __( 'Tag Archives: %s', 'yoko' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
		</header><!--end page-header-->

		<?php rewind_posts(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php yoko_content_nav( 'nav-below' ); ?>

	</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>