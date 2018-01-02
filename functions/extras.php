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


// ******************* Add Custom Excerpt Lengths ****************** //

function wpe_excerptlength_index($length) {
	return 160;
}
function wpe_excerptmore($more) {
	return '...<a href="'. get_permalink().'">Read More ></a>';
}

function wpe_excerpt($length_callback='', $more_callback='') {
	global $post;
	if(function_exists($length_callback)){
		add_filter('excerpt_length', $length_callback);
	}
	if(function_exists($more_callback)){
		add_filter('excerpt_more', $more_callback);
	}
	$output = get_the_excerpt();
	$output = apply_filters('wptexturize', $output);
	$output = apply_filters('convert_chars', $output);
	$output = '<p>'.$output.'</p>';
	echo $output;
}

// ******************* ACF Options Page ****************** //

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}

// ******************* Add SVG Upload Support ****************** //

function wpcontent_svg_mime_type( $mimes = array() ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'wpcontent_svg_mime_type' );

add_filter( 'wp_get_attachment_image_src', 'fix_wp_get_attachment_image_svg', 10, 4 );  /* the hook */

function fix_wp_get_attachment_image_svg($image, $attachment_id, $size, $icon) {
	if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
		if(is_array($size)) {
			$image[1] = $size[0];
			$image[2] = $size[1];
		} elseif(($xml = simplexml_load_file($image[0])) !== false) {
			$attr = $xml->attributes();
			$viewbox = explode(' ', $attr->viewBox);
			$image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
			$image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
		} else {
			$image[1] = $image[2] = null;
		}
	}
	return $image;
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin

add_action( 'init', 'html5wp_pagination' ); // Add our HTML5 Pagination

function html5wp_pagination() {
	global $wp_query;
	$big = 999999999;
	echo paginate_links( array(
		'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format'  => '?paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total'   => $wp_query->max_num_pages,
	) );
}
?>
