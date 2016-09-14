<?php
/**
 * Docs widget on a welcome screen.
 *
 * @package Counter
 */

?>

<div class="welcome-screen-widget card">
	<h2><?php esc_html_e( 'Looking For Help?', 'counter' ); ?></h2>
	<p><?php esc_html_e( 'We have more docs and tutorials at our website. Check them out if you need more detailed information about the theme.', 'counter' ); ?></p>
	<?php
		printf(
			'<p><a href="%s" class="button button-primary">%s</a></p>',
			esc_url( $this->theme_author_url . '/docs/counter-getting-started/' ),
			esc_html__( 'View Documentation', 'counter' )
		);
	?>

</div>
