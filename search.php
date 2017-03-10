<?php
/**
 * @package Yoko
 */

get_header(); ?>

<div id="wrap">
<div id="main" <?php yoko_sidebar_class(); ?>>

	<div id="content" class="site-content">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'yoko' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!--end page-header-->

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'search' ); ?>
			<?php endwhile; ?>

			<?php yoko_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Nothing Found', 'yoko' ); ?></h1>
				</header>

				<div class="single-entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'yoko' ); ?></p>
					<?php get_search_form(); ?>
				</div>

			</article>

		<?php endif; ?>

	</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>