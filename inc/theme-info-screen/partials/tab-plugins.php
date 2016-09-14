<?php
/**
 * Plugins Tab on a welcome screen.
 *
 * @package Counter
 */

?>

<div id="plugins" class="tp-tab-content card">

	<h2 class="tab-heading"><?php esc_html_e( 'Recommended Plugins', 'counter' ); ?></h2>

	<p><?php esc_html_e( 'These are completely optional but it is recommended to install them to in order to create a website that looks like the demo.', 'counter' ); ?></p>

	<h3>Jetpack</h3>

	<p><?php esc_html_e( 'Adds WordPress.com functionality to your self-hosted WordPress site. Note that in order to use Jetpack you\'ll need WordPress.com account. NYou don\'t need to enable all the features of Jetpack.', 'counter' ); ?></p>

	<?php $this->counter_theme_info_screen_plugin_install_button( 'jetpack', 'jetpack/jetpack.php', 'Jetpack' ); ?>

	<hr>

	<h3>Contact Form 7</h3>

	<p><?php esc_html_e( 'Creates contact forms that can be easily added to posts, pages, widgets and front page panels.', 'counter' ); ?></p>

	<?php $this->counter_theme_info_screen_plugin_install_button( 'contact-form-7', 'contact-form-7/wp-contact-form-7.php', 'WPCF7' ); ?>

	<hr>

	<h3>Regenerate Thumbnails</h3>

	<p><?php esc_html_e( 'If you are switching from another theme, this plugin is a must. It will resize all the images so they look nice with your new theme.', 'counter' ); ?></p>

	<?php $this->counter_theme_info_screen_plugin_install_button( 'regenerate-thumbnails', 'regenerate-thumbnails/regenerate-thumbnails.php', 'RegenerateThumbnails' ); ?>

</div>
