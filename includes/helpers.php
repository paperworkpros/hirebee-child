<?php

/**
 * Description of expected behavior.
 *
 * @since 1.0.0
 *
 * @param $needle
 * @param $haystack
 *
 * @return bool
 */
function ncd_string_contains( $needle, $haystack ) {
	if ( is_array( $needle ) ) {
		foreach ( $needle as $string ) {
			if ( false !== strpos( $haystack, $string ) ) {
				return true;
			}
		}

		return false;
	}

	return false !== strpos( $haystack, $needle );
}

/**
 * Description of expected behavior.
 *
 * @since 1.0.0
 *
 * @param $html
 *
 * @return DOMDocument
 */
function ncd_get_dom_document( $html ) {
	$dom                   = new DOMDocument;
	$libxml_previous_state = libxml_use_internal_errors( true );
	$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" ) );
	$dom->removeChild( $dom->doctype );
	$dom->replaceChild( $dom->firstChild->firstChild->firstChild, $dom->firstChild );
	libxml_clear_errors();
	libxml_use_internal_errors( $libxml_previous_state );

	return $dom;
}


/**
 * Description of expected behavior.
 *
 * @since 1.0.0
 *
 * @param WP_User $user
 *
 * @return string
 */
function ncd_get_user_display_name( $user ) {
	$user_name = $user->nickname;

	if ( $user->first_name ) {
		$user_name = $user->first_name;

		if ( isset( $user->last_name[0] ) ) {
			$user_name .= ' ' . $user->last_name[0];
		}
	}

	return ucwords( $user_name );
}

/**
 * Description of expected behavior.
 *
 * @since 1.0.0
 *
 * @param string $name Form name.
 *
 * @return int
 */
function ncd_get_form_id_by_name( $name ) {
	$forms = \GFAPI::get_forms();

	foreach ( $forms as $key => $form ) {
		if ( $form['title'] === $name ) {
			return $form['id'];
		}
	}

	return false;
}

/**
 * Check if page contains a Gravity Form.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function ncd_has_gravity_form() {
	global $post;

	if ( ! isset( $post->post_content ) ) {
		return false;
	}

	if ( ncd_string_contains( '[gravityform', $post->post_content ) ) {
		return true;
	}

	if ( ncd_string_contains( 'wp:gravityforms', $post->post_content ) ) {
		return true;
	}

	if ( in_array( $post->ID, [ 1330 ], true ) ) {
		return true;
	}

	return false;
}
