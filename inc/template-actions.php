<?php
/**
 * Functions hooked to custom theme actions and related functions
 *
 * @package crystal
 */

/**
 * Attach defined actions
 */

//search form
add_filter('get_search_form', 'crystal_search_form');

//widget_tag_cloud_args
add_filter('widget_tag_cloud_args', 'crystal_tag_cloud_args');

//crystal excerpt more
add_filter('excerpt_more', 'crystal_excerpt_more');

// Modify a comment form.
add_filter('comment_form_defaults', 'crystal_modify_comment_form');

/**
 * Modify search form
 */
function crystal_search_form($form)
{
    $form = '
		<form class="search-form" action="' . esc_url(home_url('/')) . '" method="get" role="search">
			<input class="search-field" type="search" name="s" value="" placeholder="' . __('Search...', 'crystal') . ' ">
			<button class="search-submit fa fa-search" value="" type="submit"></button>
		</form>
	';
    return $form;
}

/**
 * Modify widget tag cloud args
 */
function crystal_tag_cloud_args($args)
{
    $args['number'] = 5;
    return $args;
}

/**
 * crystal excerpt more
 */
function crystal_excerpt_more() {
    return '..';
}

/**
 * Modify a comment form
 */
function crystal_modify_comment_form($args){
    $args = wp_parse_args($args);

    if (!isset($args['format'])) {
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    }

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html_req = ($req ? " required='required'" : '');
    $html5 = 'html5' === $args['format'];
    $commenter = wp_get_current_commenter();

    $args['label_submit'] = __('Submit comment', 'crystal');
    $args['class_submit'] = 'submit-comment';
    $args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>';


    return $args;
}