<?php
/**
 * Theme info screen intro.
 *
 * @package Owner
 */

?>

<div class="tp-theme-intro">
<div class="tp-two-col">
	<div class="tp-col tp-theme-screenshot">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/screenshot.png'; ?>" alt="<?php echo esc_html( $this->theme->get( 'Name' ) ); ?>" />
	</div>

	<div class="tp-col tp-theme-description">
		<?php
			// Title and version.
			printf(
				'<h1 class="theme-name">%s <span class="theme-version">%s</span></h1>',
				esc_html( $this->theme->get( 'Name' ) ),
				esc_html__( 'Version: ', 'owner' ) . esc_html( $this->theme->get( 'Version' ) )
			);

			// Theme description.
			printf(
				'<p class="theme-description-text">%s</p>',
				esc_html( $this->theme->get( 'Description' ) )
			);
		?>
	</div>
</div>
</div><!-- .theme-intro -->
