<?php
/**
 * Template for displaying widgets in the footer
 *
 * @package Counter
 */

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) {
	echo '<div class="site-footer-widgets"><div class="wrap">';
		for ( $i = 1; $i <= 4; $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				echo '<div class="site-footer-widget-column">';
					dynamic_sidebar( 'footer-' . $i );
				echo '</div>';
			}
		}
	echo '</div></div>';
}
