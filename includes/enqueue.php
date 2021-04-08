<?php

// Load assets.
add_action( 'wp_enqueue_scripts', function () {
	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'hrb-foundation' );
	wp_deregister_style( 'hrb-styles' );
	wp_deregister_style( 'app-form-progress' );
	wp_deregister_style( 'googleFonts' );

	wp_dequeue_script( 'foundation' );
	wp_dequeue_script( 'hrb-scripts' );

	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	wp_enqueue_script(
		get_stylesheet() . '-lightbox',
		get_stylesheet_directory_uri() . '/js/lightbox.js',
		[],
		filemtime( get_stylesheet_directory() . '/js/lightbox.js' )
	);

	wp_enqueue_script(
		get_stylesheet() . '-main',
		get_stylesheet_directory_uri() . '/js/main.js',
		[],
		filemtime( get_stylesheet_directory() . '/js/main.js' )
	);

	wp_enqueue_style(
		get_stylesheet() . '-main',
		get_stylesheet_directory_uri() . '/css/main.css',
		[],
		filemtime( get_stylesheet_directory() . '/css/main.css' )
	);
}, 999 );
