<?php
/**
 * @package Yoko
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-link">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'yoko' ) ); ?>

		<footer class="entry-meta">
			<p>
				<?php yoko_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'yoko' ), '| <span class="edit-link">', '</span>' ); ?>
			</p>
		</footer><!-- end entry-meta -->
	</div><!-- end entry-link -->

</article>