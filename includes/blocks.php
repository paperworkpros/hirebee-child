<?php

// Adds correct button classes to button blocks.
add_filter( 'render_block', function ( $block_content, $block ) {
	if ( $block_content && isset( $block['attrs']['className'] ) && 'core/button' === $block['blockName'] ) {
		$block_content = str_replace(
			[
				'wp-block-button__link',
				' is-style-outline',
			],
			[
				'wp-block-button__link button' . ( string_contains( 'outline', $block_content ) ? ' button-outline' : '' ),
				'',
			],
			$block_content
		);
	}

	return $block_content;
}, 10, 2 );
