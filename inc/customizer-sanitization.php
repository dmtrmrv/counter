<?php
/**
 * Set of sanitization functions used in the theme
 *
 * @package Counter
 */

/**
 * Sanitizes Panel Size Type.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_size_type( $input ) {
	$choices = array(
		'cover',
		'percent',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'auto';
}

/**
 * Sanitizes Opacity Range.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_opacity_range( $input ) {
	if ( $input && is_numeric( $input ) ) {
		if ( 1 <= $input ) {
			return 1;
		} else {
			return abs( number_format( $input, 2 ) );
		}
	}
	return 1;
}

/**
 * Sanitizes Panel Background Repeat.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_repeat( $input ) {
	$choices = array(
		'repeat',
		'repeat-x',
		'repeat-y',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'no-repeat';
}

/**
 * Sanitizes Panel Background Position.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_position( $input ) {
	$choices = array(
		'left center',
		'left bottom',
		'center top',
		'center center',
		'center bottom',
		'right top',
		'right center',
		'right bottom',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'left top';
}

/**
 * Sanitizes background attachment.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_attachment( $input ) {
	if ( 'fixed' == $input ) {
		return $input;
	}
	return 'scroll';
}
