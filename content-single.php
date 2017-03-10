<?php
/**
 * @package Yoko
 */

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && ( $image[1] < HEADER_IMAGE_WIDTH ) ) : ?>
		<div class="single-entry-details">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
		</div><!-- end single-entry-details -->
	<?php endif; ?>

	<header class="single-entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<p>
			<?php yoko_posted_on(); ?>
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link"><?php comments_popup_link( __('Leave a comment', 'yoko' ), __( '1 Comment', 'yoko' ), __( '% Comments', 'yoko' ) ); ?></span>
			<?php endif; ?>
		</p>
	</header><!-- end single-entry-header -->

	<div class="single-entry-content">

		<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<?php the_excerpt(); ?>
		<?php else : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'yoko' ) ); ?>
			<div class="clear"></div>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'yoko' ), 'after' => '</div>' ) ); ?>
		<?php endif; ?>

		<footer class="entry-meta">
			<p>
				<?php yoko_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'yoko' ), '| <span class="edit-link">', '</span>' ); ?>
			</p>
		</footer><!-- end entry-meta -->

		<?php if ( get_the_author_meta( 'description' ) ) :  ?>
			<div class="author-info">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'yoko_author_bio_avatar_size', 70 ) ); ?>
				<div class="author-description">
					<h3><?php printf( __( 'Author: %s', 'yoko' ), "<a href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h3>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- end author-description -->
			</div><!-- end author-info -->
		<?php endif; ?>

	</div><!-- end single-entry-content -->

</article>
<div class="clear"></div>