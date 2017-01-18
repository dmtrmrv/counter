<?php
/**
 * Template for displaying widgets in the footer
 *
 * @package Counter
 */

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>

	<div class="site-footer-widgets">
		<div class="wrap">

			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>

				<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

					<div class="site-footer-widget-column">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>

				<?php endif; ?>

			<?php endfor; ?>

		</div>
	</div>

<?php endif;
