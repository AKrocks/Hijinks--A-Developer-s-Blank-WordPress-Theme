<?php


// Register scripts
if ( ! function_exists( 'theme_scripts' ) ) {
	// ********  Include css and Js files
	function load_theme_scripts() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_enqueue_style( 'main-css', get_template_directory_uri() . '/css/style.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/js/script-min.js', 1.0, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		// Google fonts
		wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700', false );

	}

	//	function be_load_more_js() {
	//
	//		if ( ! is_post_type_archive( 'videos' ) ) {
	//			return;
	//		}
	//
	//		global $wp_query;
	//		$args = array(
	//			'url'       => admin_url( 'admin-ajax.php' ),
	//			'query'     => $wp_query->query,
	//			'num_pages' => $wp_query->max_num_pages,
	//		);
	//
	//		wp_enqueue_script( 'be-load-more', get_template_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	//		wp_localize_script( 'be-load-more', 'beloadmore', $args );
	//
	//	}
	//
	//	add_action( 'wp_enqueue_scripts', 'be_load_more_js' );

	add_action( 'wp_enqueue_scripts', 'load_theme_scripts' );

}
