<?php

add_action( 'after_setup_theme', 'ak_theme_setup' );
function ak_theme_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'almita', get_template_directory() . '/lang' );

	// Enable plugins to manage the document title
	add_theme_support( 'title-tag' );

	// Register wp_nav_menu() menus
	register_nav_menus( [
		'primary_navigation' => __( 'Primary Navigation', 'almita' ),
	] );

	// Enable post thumbnails
	add_theme_support( 'post-thumbnails' );

	// To enable only for posts and custom post types:
	add_theme_support( 'post-thumbnails', array( 'post' ) );

	// Enable HTML5 markup support
	add_theme_support( 'html5', [
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	] );

	/**
	 * Register sidebars
	 */
	function illum_widgets_init() {
		register_sidebar( [
			'name'          => __( 'Primary', 'almita' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<section class="widget %1$s %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		] );
		register_sidebar( [
			'name'          => __( 'Footer widgets', 'almita' ),
			'id'            => 'footer',
			'before_widget' => '<div class="widget %1$s %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		] );
	}

	add_action( 'widgets_init', 'illum_widgets_init' );

	/**
	 * Duplicate 'the_content' filters
	 */
	global $wp_embed;
	add_filter( 'ak_the_content', array( $wp_embed, 'run_shortcode' ), 8 );
	add_filter( 'ak_the_content', array( $wp_embed, 'autoembed' ), 8 );
	add_filter( 'ak_the_content', 'wptexturize' );
	add_filter( 'ak_the_content', 'convert_chars' );
	add_filter( 'ak_the_content', 'wpautop' );
	add_filter( 'ak_the_content', 'shortcode_unautop' );
	add_filter( 'ak_the_content', 'do_shortcode' );
}