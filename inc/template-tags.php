<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package crystal
 */

if ( ! function_exists( 'crystal_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function crystal_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('d M Y') ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date('d M Y') )
	);

	$posted_on = sprintf(
		'<span class="posted-on">' . $time_string . '</span>'
	);

	echo $posted_on; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'crystal_post_author' ) ) :
	/**
	 * Prints HTML with meta information for the author.
	 */
	function crystal_post_author($avatar_show = false) {

		$avatar = '<figure class="entry-author_avatar">' . get_avatar( get_the_author_meta('ID'), 72 ). '</figure>';

		$byline = sprintf(
			esc_html_x( 'Writen by %s', 'post author', 'crystal' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);
		if ( true == $avatar_show){
			echo '<span class="entry-author byline"> ' . $avatar . '<span class="author vcard">' . $byline . '</span></span>'; // WPCS: XSS OK.
		} else{
			echo '<span class="entry-author byline"><span class="author vcard">' . $byline . '</span></span>'; // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'crystal_post_comments' ) ) :
	/**
	 * Prints HTML with meta information for the comments.
	 */
	function crystal_post_comments() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="entry-comments comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'crystal' ), esc_html__( '1', 'crystal' ), esc_html__( '%', 'crystal' ) );
			echo '</span>';
		}
	}
endif;


if ( ! function_exists( 'crystal_entry_footer' ) ) :
/**
 * Prints HTML with meta information for tags and permalink.
 */
function crystal_entry_footer() {

	//entry-permalink
	if ( !is_single()) {
		if (!post_password_required()) {
			printf('<div class="entry-permalink"><a href="%1$s" class="btn">%2$s</a></div>', esc_url(get_permalink()), esc_html__('More', 'crystal'));
		}
	}

	// Hide tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' ', 'crystal' ) );
		if ( !is_single() ) {
			if ($tags_list) {
				printf('<span class="tags-links">' . esc_html__('%1$s', 'crystal') . '</span>', $tags_list); // WPCS: XSS OK.
			}
		} else{
			if ($tags_list) {
				printf('<span class="tags-links">' .__('<span>Tags:</span> %1$s', 'crystal') . '</span>', $tags_list); // WPCS: XSS OK.
			}
		}
	}
}
endif;

/**
 * Print the post excerpt.
 *
 * @param array $args
 */
function crystal_excerpt($args = array()){
	$args = wp_parse_args( $args, array(
		'before'    => '',
		'after'     => '',
	) );

	$excerpt = '<p> %1$s' . get_the_excerpt() . '%2$s </p>';

	printf($excerpt, $args['before'], $args['after']);
}

/**
 * Aside link format.
 *
 * @return string
 */
function crystal_aside_link(){
	if (!post_password_required()) {
		$link_format = '<a href="' . esc_url(get_permalink()) .'" class="aside-link fa fa-chain"></a>';
		return $link_format;
	}
}

/**
 * Gets the first URL from the content, even if it's not wrapped in an <a> tag.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @param  string $content Post content.
 * @return string          URL.
 */
function crystal_get_content_url() {
	$content = get_the_content();
	// Catch links that are not wrapped in an '<a>' tag.
	preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', make_clickable( $content ), $matches );

	return ! empty( $matches[1] ) ? esc_url_raw( $matches[1] ) : '';
}
/**
 * Display the first URL from the post content
 */
function crystal_the_content_url() {
	echo crystal_get_content_url();
}

/**
 * Checks if the quote post has a <blockquote> tag within the content.
 * If not, wraps the entire post content with one.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @global object $post
 * @param  string $content The post content.
 * @return string $content
 */
function crystal_get_quote_content() {

	$content = get_the_content();

	if ( ! preg_match( '/<blockquote.*?>/', $content, $matches ) ) {
		$content = "<blockquote>{$content}</blockquote>";
	}

	return $content;
}
/**
 * Display the quote post
 */
function crystal_the_quote_content(){
	echo crystal_get_quote_content();
}

/**
 * Get first audio from post content
 */
function crystal_get_audio_content() {

	$content = get_the_content();
	$embeds  = get_media_embedded_in_content( apply_filters( 'the_content', $content ), array( 'audio' ) );

	if ( empty( $embeds ) ) {
		return;
	}

	if ( false == preg_match( '/<audio[^>]*>(.*?)<\/audio>/', $embeds[0], $matches ) ) {
		return ;
	}

	return $result = $matches[0];
}
/**
 * Display a featured audio.
 */
function crystal_the_audio_content(){
	echo crystal_get_audio_content();
}

/**
 * Get first video from post content
 *
 * @return string|void
 */
function crystal_get_video_content() {

	$content = apply_filters( 'the_content', get_the_content() );
	$types   = array( 'video', 'object', 'embed', 'iframe' );
	$embeds  = get_media_embedded_in_content( $content, $types );

	if ( empty( $embeds ) ) {
		return;
	}

	foreach ( $types as $tag ) {
		if ( preg_match( "/<{$tag}[^>]*>(.*?)<\/{$tag}>/", $embeds[0], $matches ) ) {
			$result = $matches[0];
			break;
		}
	}

	if ( false === $result ) {
		return;
	}

	return $result = sprintf( '<div class="entry-video embed-responsive embed-responsive-16by9">%s</div>', $result );
}
/**
 * Display a featured video.
 */
function crystal_the_video_content(){
	echo crystal_get_video_content();
}

/**
 * The post thumbnail url
 */
function crystal_the_post_thumbnail_url(){
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
	echo $thumb_url[0];
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function crystal_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'crystal_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'crystal_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so crystal_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so crystal_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in crystal_categorized_blog.
 */
function crystal_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'crystal_categories' );
}
add_action( 'edit_category', 'crystal_category_transient_flusher' );
add_action( 'save_post',     'crystal_category_transient_flusher' );


/**
 * crystal layout classes
 *
 * @param $section , section: header, content, footer
 */
function crystal_the_layout_classes($section){

	$layout = get_theme_mod('crystal_'.$section.'_grid_type', 'boxed');

	if('boxed' === $layout){
		echo 'container';
	}
	if('wide' === $layout){
		echo 'container-fluid';
	}
}

/**
 * crystal sidebar classes
 *
 */
function crystal_the_sidebar_classes(){
	$sidebar_position = get_theme_mod('crystal_sidebar_position', 'right');

	if ('right' === $sidebar_position) {
		echo 'content-sidebar';
	}
	if ('left' === $sidebar_position) {
		echo 'sidebar-content';
	}
}