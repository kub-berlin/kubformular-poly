<?php
/**
 * @package Yoko
 */

get_header(); ?>

<div id="wrap">

	<div id="content" class="site-content full-width">

		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="single-entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<p>
					<?php yoko_posted_on(); ?>
					<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'yoko' ), __( '1 Comment', 'yoko' ), __( '% Comments', 'yoko' ) ); ?></span>
					<?php endif; ?>
				</p>
			</header><!-- end entry-header -->

			<nav id="image-nav">
				<span class="previous-image"><?php previous_image_link( false, __( '&larr; Previous Image' , 'yoko' ) ); ?></span>
				<span class="next-image"><?php next_image_link( false, __( 'Next Image &rarr;' , 'yoko' ) ); ?></span>
			</nav><!-- end image-nav -->

			<div class="single-entry-content">

				<div class="entry-attachment">
					<div class="attachment">
						<?php
						/**
						* Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
						* or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
						*/
						$attachments = array_values(
							get_children( array(
								'post_parent'    => $post->post_parent,
								'post_status'    => 'inherit',
								'post_type'      => 'attachment',
								'post_mime_type' => 'image',
								'order'          => 'ASC',
								'orderby'        => 'menu_order ID',
							) )
						);
						foreach ( $attachments as $k => $attachment ) {
							if ( $attachment->ID == $post->ID )
								break;
						}
						$k++;
						// If there is more than 1 attachment in a gallery
						if ( count( $attachments ) > 1 ) {
							if ( isset( $attachments[ $k ] ) ) {
								$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID ); // get the URL of the next image attachment
							} else {
								$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID ); // or get the URL of the first image attachment
							}
						} else {
							$next_attachment_url = wp_get_attachment_url(); // or, if there's only 1 image, get the URL of the image
						}
						?>
						<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment">
							<?php
							$attachment_size = apply_filters( 'yoko_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
							echo wp_get_attachment_image( $post->ID, $attachment_size );
							?>
						</a>
					</div><!-- end attachment -->

					<?php if ( ! empty( $post->post_excerpt ) ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div>
					<?php endif; ?>
				</div><!-- end entry-attachment -->

				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'yoko' ), 'after' => '</div>' ) ); ?>

			</div><!-- end entry-content -->
			<div class="clear"></div>

			<footer class="entry-meta">
				<p>
					<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
						<?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'yoko' ), get_trackback_url() ); ?>
					<?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
						<?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'yoko' ), get_trackback_url() ); ?>
					<?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
						<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'yoko' ); ?>
					<?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
						<?php _e( 'Both comments and trackbacks are currently closed.', 'yoko' ); ?>
					<?php endif; ?>
					<?php edit_post_link( __( 'Edit', 'yoko' ), ' <span class="edit-link">', '</span>' ); ?>
				</p>
			</footer><!-- end entry-utility -->

		</article>

		<?php comments_template(); ?>

	</div><!-- end content -->

<?php get_footer(); ?>