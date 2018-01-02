<?php

// Fire all our initial functions at the start
add_action('after_setup_theme','pollo_frito_set_up', 16);

function pollo_frito_set_up() {

    // launching operation cleanup
    add_action('init', 'pollo_frito_head_cleanup');
    
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'pollo_frito_remove_wp_widget_recent_comments_style', 1 );
    
    // clean up comment styles in the head
    add_action('wp_head', 'pollo_frito_remove_recent_comments_style', 1);
    
    // clean up gallery output in wp
    add_filter('gallery_style', 'pollo_frito_gallery_style');

    add_filter('embed_oembed_html', 'illum_embed_oembed_html', 9999, 4);

} /* end illum start */

//The default wordpress head is a mess. Let's clean it up by removing all the junk we don't need.
function pollo_frito_head_cleanup() {
  // Remove category feeds
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  // Remove post and comment feeds
   remove_action( 'wp_head', 'feed_links', 2 );
  // Remove EditURI link
  remove_action( 'wp_head', 'rsd_link' );
  // Remove Windows live writer
  remove_action( 'wp_head', 'wlwmanifest_link' );
  // Remove index link
  remove_action( 'wp_head', 'index_rel_link' );
  // Remove previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // Remove start link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // Remove links for adjacent posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // Remove WP version
  remove_action( 'wp_head', 'wp_generator' );
} /* end illum head cleanup */

// Remove injected CSS for recent comments widget
function pollo_frito_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// Remove injected CSS from recent comments widget
function pollo_frito_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// Remove injected CSS from gallery
function pollo_frito_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

//This is a modified the_author_posts_link() which just returns the link. This is necessary to allow usage of the usual l10n process with printf()
function pollo_frito_get_the_author_posts_link() {
  global $authordata;
  if ( !is_object( $authordata ) )
    return false;
  $link = sprintf(
    '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
    get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
    esc_attr( sprintf( __( 'Posts by %s', 'asa' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
    get_the_author()
  );
  return $link;
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}
// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter( $var ) {
	return is_array( $var ) ? array() : '';
}
// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list( $thelist ) {
	return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}