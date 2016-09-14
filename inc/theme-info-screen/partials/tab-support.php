<?php
/**
 * Support Tab on a welcome screen.
 *
 * @package Owner
 */

?>

<div id="support" class="tp-tab-content card">

<h2 class="tab-heading"><?php esc_html_e( 'Support', 'owner' ); ?></h2>

<h3><?php esc_html_e( 'Basic Support', 'owner' ); ?></h3>

<p><?php esc_html_e( 'Basic support is provided with the purchase of any ThemePatio theme. It includes answering the setup questions, questions about theme features and bug fixes. Basic support lasts for one year from the date of purchase. After that, you can renew the license with a 30% discount off the theme price and get another year of support and updates.', 'owner' ); ?></p>

<p class="tp-theme-feature-buttons">
	<?php
		// Submit a Ticket Button.
		printf(
			'<a href="%s" class="button button-primary">%s</a> ',
			esc_url( $this->theme_author_url . '/support' ),
			esc_html__( 'Submit a Ticket', 'owner' )
		);
	?>
</p>

<hr>

<h3><?php esc_html_e( 'Priority Support $59', 'owner' ); ?></h3>

<p><?php esc_html_e( 'On top of the basic plan, priority support includes answers to the more technical questions, faster responses, and theme installation. Priority Support can be provided for our free themes as well. It lasts for 45 days from the day of purchase and is a huge time-saver.', 'owner' ); ?></p>

<p class="tp-theme-feature-buttons">
	<?php
		// More info on Premium support.
		printf(
			'<a href="%s" class="button button-primary">%s</a> ',
			esc_url( $this->theme_author_url . '/support' ),
			esc_html__( 'Get Priority Support', 'owner' )
		);
	?>
</p>

</div>
