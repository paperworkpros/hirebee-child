<?php

if ( ! function_exists( 'string_contains' ) ) {
	function string_contains( $needle, $haystack ) {
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
}

if ( ! function_exists( 'get_dom_document' ) ) {
	function get_dom_document( $html ) {
		$dom = new DOMDocument;
		$libxml_previous_state = libxml_use_internal_errors( true );
		$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" ) );
		$dom->removeChild( $dom->doctype );
		$dom->replaceChild( $dom->firstChild->firstChild->firstChild, $dom->firstChild );
		libxml_clear_errors();
		libxml_use_internal_errors( $libxml_previous_state );

		return $dom;
	}
}
