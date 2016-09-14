<?php
/**
 * Docs widget on a welcome screen.
 *
 * @package Owner
 */

?>
<div class="welcome-screen-widget card">

<h2><?php echo esc_html( $strings['theme-license'] ); ?></h2>

<form method="post" action="options.php">

	<?php

		settings_fields( $this->theme_slug . '-license' );

		printf(
			'<p><input id="%1$s" name="%1$s" type="text" value="%2$s" /></p>',
			esc_attr( $this->theme_slug . '_license_key' ),
			esc_attr( $license )
		);

		printf(
			'<p class="description">%s</p>',
			wp_kses_post( $message )
		);

		echo '<p>';

		if ( $license ) {
			// Licence actions button.
			wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' );
				printf(
					'<input type="submit" class="button-primary" name="%s" value="%s"/> ',
					esc_attr( $this->theme_slug . '_license_activate' ),
					esc_attr( __( 'Save', 'owner' ) )
				);
		} else {
			// Save Changes button.
			submit_button( __( 'Save', 'owner' ), 'primary', false, false );
		}

		echo '</p>';

	?>

</form>

</div>
