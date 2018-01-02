<?php
// Add <body> classes

function add_page_slug( $classes ) {
	// Add page slug if it doesn't exist
	if ( is_single() || is_page() && ! is_front_page() ) {
		if ( ! in_array( basename( get_permalink() ), $classes ) ) {
			$classes[] = basename( get_permalink() );
		}
	}

	return $classes;
}

add_filter( 'body_class', 'add_page_slug' );

// Deletes all CSS classes and id's, except for those listed in the array below
function custom_wp_nav_menu( $var ) {
	return is_array( $var ) ? array_intersect( $var, array(
			// List of allowed menu classes
			'current_page_item',
			'current_page_parent',
			'current_page_ancestor',
			'first',
			'last',
			'vertical',
			'horizontal',
		) ) : '';
}

add_filter( 'nav_menu_css_class', 'custom_wp_nav_menu' );
add_filter( 'nav_menu_item_id', 'custom_wp_nav_menu' );
add_filter( 'page_css_class', 'custom_wp_nav_menu' );

// Replaces "current-menu-item" with "active"
function current_to_active( $text ) {
	$replace = array(
		// List of menu item classes that should be changed to "active"
		'current_page_item'     => 'active',
		'current_page_parent'   => 'active',
		'current_page_ancestor' => 'active',
	);
	$text    = str_replace( array_keys( $replace ), $replace, $text );

	return $text;
}

add_filter( 'wp_nav_menu', 'current_to_active' );

// Deletes empty classes and removes the sub menu class
function strip_empty_classes( $menu ) {
	$menu = preg_replace( '/ class=""| class="sub-menu"/', '', $menu );

	return $menu;
}

add_filter( 'wp_nav_menu', 'strip_empty_classes' );

// Returns number of search results with value
function title_search_results() {
	global $wp_query;
	$resutls     = $wp_query->found_posts;
	$search_term = get_search_query();
	$heading     = "";
	if ( $resutls < 2 ) {
		$heading .= '<span>' . $resutls . '</span> search result for the term ';
	} else {
		$heading .= '<span>' . $resutls . '</span> search results for the term ';
	}
	$heading .= '<span>' . $search_term . '</span>';// Dispaly the search resuts term

	return $heading;
}

// Gravity form conformation scroll to
add_filter( 'gform_confirmation_anchor', '__return_true' );

// Add the ability to hide labels but still be used with screen reader. 
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Add SVG Upload Support
function wpcontent_svg_mime_type( $mimes = array() ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'wpcontent_svg_mime_type' );


/**
 * ACF Options Page
 *
 */
function ea_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'title'      => 'Site Options',
			'capability' => 'manage_options',
		) );
	}
}
add_action( 'init', 'ea_acf_options_page' );

function allowed_html() {

	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);

	return $allowed_tags;
}