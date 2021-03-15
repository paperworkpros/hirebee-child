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
