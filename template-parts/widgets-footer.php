<?php
/**
 * Template for displaying widgets in the footer
 *
 * @package Counter
 */

if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) || is_active_sidebar( 'sidebar-5' ) ) : ?>

	<div class="site-footer-widgets">

		<div class="wrap">

			<?php for ( $i = 2; $i <= 5; $i++ ) : ?>

				<?php if ( is_active_sidebar( 'sidebar-' . $i ) ) : ?>

					<div class="site-footer-widget-column">

						<?php dynamic_sidebar( 'sidebar-' . $i ); ?>

					</div>

				<?php endif; ?>

			<?php endfor; ?>

		</div>

	</div>

<?php endif;
