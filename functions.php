<?php

// Load includes.
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/blocks.php';
require_once __DIR__ . '/includes/agreement.php';

// Disable limit login attempts by Flywheel.
add_filter( 'login_errors', function ( $errors ) {
	if ( is_page_template( 'form-login.php' ) && ! is_a( $errors, 'WP_Error' ) ) {
		$errors = new WP_Error();
	}

	return $errors;
} );

// Setup theme.
add_action( 'init', function () {

	// Head optimizations.
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link' );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_head', 'wp_resource_hints', 2 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	add_action( 'wp_footer', function () {
		wp_dequeue_script( 'wp-embed' );
	} );

	add_action( 'widgets_init', function () {
		global $wp_widget_factory;
		remove_action( 'wp_head', [
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style',
		] );
	} );

	// Custom logo size.
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 356,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Home page customization.
	add_filter( 'hrb_background_cover', function () {
		return 'class="hero-section"';
	} );

	// Replace strings.
	$replacements = [
		'FREELANCER' => 'DEVELOPER',
		'Freelancer' => 'Developer',
		'freelancer' => 'developer',
	];

	foreach ( $replacements as $original => $replacement ) {
		\add_filter( 'gettext', function ( $string, $text, $domain ) use ( $original, $replacement ) {
			if ( APP_TD === $domain && \strpos( $text, $original ) !== false ) {
				$string = \str_replace( $original, $replacement, $text );
			}

			return $string;
		}, 10, 3 );
	}

}, 0 );

// Platform showcase customizations.
add_action( 'wp', function () {
	if ( is_page( 'platform-showcase' ) ) {
		remove_action( 'hrb_content_container_top', '_hrb_content_container_top' );

		add_action( 'hrb_content_container_top', function () {
			?>
			<div class="content-header">
				<div class="row">
					<div class="columns">
						<h3>Platform Showcase</h3>
						<p>Learn more about industry-leading no-code development platforms</p>
					</div>
					<div class="columns">
						<a href="/platform-showcase-application" class="button">Platform Showcase Application</a>
					</div>
				</div>
			</div>
			<?php
		} );
	}

	if ( is_singular( 'platform' ) ) {
		remove_action( 'hrb_content_container_top', '_hrb_content_container_top' );

		add_action( 'hrb_content_container_top', function () {
			?>
			<div class="row single-platform-header">
				<div class="columns">
					<a href="/platform-showcase">← Back to all platforms</a>
				</div>
			</div>
			<?php
		} );
	}

	add_filter( 'body_class', function ( $classes ) {
		if ( is_hrb_users_archive() ) {
			$classes[] = 'user-archive';
		}

		return $classes;
	} );
}, 99 );

// Load assets.
add_action( 'wp_enqueue_scripts', function () {
	global $post;

	if ( ! is_page( 'edit-profile' ) ) {
		wp_deregister_style( 'dashicons' );
	}

	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'hrb-styles' );
	wp_deregister_style( 'app-form-progress' );
	wp_deregister_style( 'googleFonts' );

	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	wp_enqueue_script(
		get_stylesheet() . '-menus',
		get_stylesheet_directory_uri() . '/js/menus.js',
		[ 'jquery' ],
		filemtime( get_stylesheet_directory() . '/js/menus.js' )
	);

	wp_enqueue_style(
		get_stylesheet(),
		get_stylesheet_uri(),
		[],
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	wp_enqueue_style(
		get_stylesheet() . '-checkout',
		get_stylesheet_directory_uri() . '/css/checkout.css',
		[],
		filemtime( get_stylesheet_directory() . '/css/checkout.css' )
	);

	wp_register_style(
		get_stylesheet() . '-gravity-forms',
		get_stylesheet_directory_uri() . '/css/gravity-forms.css',
		[],
		filemtime( get_stylesheet_directory() . '/css/gravity-forms.css' )
	);

	if ( isset( $post->post_content ) && ( strpos( $post->post_content, '[gravityform' ) !== false || strpos( $post->post_content, 'wp:gravityforms' ) !== false ) ) {
		wp_enqueue_style( get_stylesheet() . '-gravity-forms' );
	}
}, 999 );

// Register "Platform Showcase" custom post type.
add_action( 'init', function () {
	register_post_type( 'platform', [
		'labels'              => [
			'name'                  => 'Platforms',
			'singular_name'         => 'Platform',
			'menu_name'             => _x( 'Platforms', 'Admin Menu text' ),
			'add_new'               => _x( 'Add New', 'Platform' ),
			'add_new_item'          => 'Add New Platform',
			'new_item'              => 'New Platform',
			'edit_item'             => 'Edit Platform',
			'view_item'             => 'View Platform',
			'all_items'             => 'Platforms',
			'search_items'          => 'Search Platforms',
			'parent_item_colon'     => 'Parent Platform:',
			'not_found'             => 'No platforms found.',
			'not_found_in_trash'    => 'No platforms found in Trash.',
			'archives'              => 'Platform archives',
			'insert_into_item'      => 'Insert in to platform',
			'uploaded_to_this_item' => 'Uploaded to this platform',
			'filter_items_list'     => 'Filter platforms list',
			'items_list_navigation' => 'Platforms list navigation',
			'items_list'            => 'Platforms list',
		],
		'label'               => 'Platform',
		'description'         => 'Platform Description',
		'supports'            => [ 'title', 'excerpt', 'editor', 'thumbnail' ],
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-slides',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
	] );
} );

// Override stripe templates.
add_filter( 'appthemes_stripe_escrow_user_form', function () {
	return __DIR__ . '/templates/stripe-escrow-user-form.php';
} );

// Set minimum hourly rate.
add_filter( 'hrb_profile_base_fields', function ( $fields ) {
	foreach ( $fields as $field => $args ) {
		if ( isset( $args['name'] ) && 'hrb_rate' === $args['name'] ) {
			$fields[ $field ]['extra'] = [
				'size'  => 3,
				'class' => 'short-field',
				'type'  => 'number',
				'min'   => 30,
			];
		}
	}

	return $fields;
}, 11, 1 );
