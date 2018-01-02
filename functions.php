<?php

/**
 * illuminea framework functions
 *
 * Please note that missing files will produce a fatal error.
 *
 */


$illum_includes = [
	'functions/clean.php', // Cleans up the theme
	'functions/scripts.php',    // Scripts and stylesheets
	'functions/extras.php',    // Custom functions
	'functions/setup.php',     // Theme setup
	'functions/hooks.php', // Theme customizer
	'functions/editor-styles.php', // Adds site styles to the WordPress editor
	'functions/login.php', //  Customize the WordPress login menu
	'functions/load-more.php', //  The load more function
];

foreach ( $illum_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'pollo' ), $file ), E_USER_ERROR );
	}

	require_once $filepath;
}
unset( $file, $filepath );

add_editor_style( 'css/editor-style.css' );