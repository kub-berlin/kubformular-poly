<?php
/**
 * @package Yoko
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-post-format">
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<p>
				<?php yoko_posted_on(); ?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'yoko' ), __( '1 Comment', 'yoko' ), __( '% Comments', 'yoko' ) ); ?></span>
				<?php endif; ?>
			</p>
		</header><!-- end entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
			<div class="entry-summary">
				<?php the_excerpt( __( 'View the pictures &rarr;', 'yoko' ) ); ?>
			</div><!-- end entry-summary -->
		<?php else : ?>

			<?php if ( post_password_required() ) : ?>
				<?php the_content( __( 'View the pictures &rarr;', 'yoko' ) ); ?>
			<?php else : ?>
				<?php
					$pattern = get_shortcode_regex();
					preg_match( "/$pattern/s", get_the_content(), $match );
					$atts    = isset( $match[3] ) ? shortcode_parse_atts( $match[3] ): array();
					$images  = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : false;
					$total_images = 0;

					if ( ! $images ) :
						$images = get_posts( array(
							'post_parent'      => get_the_ID(),
							'fields'           => 'ids',
							'post_type'        => 'attachment',
							'post_mime_type'   => 'image',
							'orderby'          => 'menu_order',
							'order'            => 'ASC',
							'numberposts'      => 999,
							'suppress_filters' => false
						) );
					endif;

					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
				?>
					<figure class="gallery-thumb">
						<a href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image( $image, 'medium' ); ?></a>
					</figure><!-- end gallery-thumb -->
				<?php endif; ?>

				<div class="entry-post-format">
					<?php the_content( __( 'View the pictures &rarr;', 'yoko' ) ); ?>
			<?php endif; ?>

					<p class="pics-count">
						<?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>', $total_images, 'yoko' ), 'href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'yoko' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark"', number_format_i18n( $total_images ) ); ?>
					</p>
				</div><!-- end entry-content-gallery -->
		<?php endif; ?>

		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'yoko' ), 'after' => '</div>' ) ); ?>

		<footer class="entry-meta">
			<p>
				<?php yoko_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'yoko' ), '| <span class="edit-link">', '</span>' ); ?>
			</p>
		</footer><!-- end entry-meta -->
	</div><!-- end entry-post-format -->
</article>
