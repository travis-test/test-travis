<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package crystal
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-header_left">
				<?php crystal_posted_on(); ?>
			</div><!-- .entry-header_left -->
		<?php endif; ?>

		<div class="entry-header_right">
			<div class="entry-header_right_wrap">
				<?php
					if ( is_single() ) {
						the_title( '<h3 class="entry-title">', '</h3>' );
					} else {
						the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					}
				?>
				<?php if ( 'post' === get_post_type() ) : ?>
					<?php crystal_post_author(); ?>
				<?php endif; ?>
			</div>

			<?php crystal_post_comments(); ?>

		</div><!-- .entry-header_right -->

	</header><!-- .entry-header -->

	<?php if (has_post_thumbnail()){ ?>
		<figure class="entry-thumbnail">
			<?php
				if ( is_single() ) {
				 	the_post_thumbnail();
				} else{ ?>
					<a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr(the_title_attribute()); ?>"> <?php the_post_thumbnail(); ?> </a>
				<?php }
			?>
		</figure>
	<?php } ?>

	<div class="entry-content">
		<?php
			if ( is_single() ) {
				the_content( sprintf(
				/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'crystal' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'crystal' ),
					'after'  => '</div>',
				) );
			} else{
				the_excerpt();
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php crystal_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
