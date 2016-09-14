<?php
/**
 * Intro Tab on a welcome screen.
 *
 * @package Owner
 */

?>

<div id="getting-started" class="tp-tab-content card">

<h2 class="tab-heading"><?php esc_html_e( 'Getting Started', 'owner' ); ?></h2>

<p><?php esc_html_e( 'These manuals will help you get started with the Owner theme quickly. Make sure to read these guides carefully to get the idea of how the theme works and what it is capable of.', 'owner' ); ?></p>

<?php
	$tp_manuals = array(
		__( 'Getting Started', 'owner' )            => '/docs/owner-getting-started/',
		__( 'Recommended Plugins', 'owner' )        => '/docs/owner-recommended-plugins/',
		__( 'Importing the Demo Content', 'owner' ) => '/docs/owner-importing-the-demo-content/',
		__( 'Page Templates', 'owner' )             => '/docs/owner-page-templates/',
		__( 'Setting Up The Front Page', 'owner' )  => '/docs/owner-setting-up-the-front-page/'
	);

echo '<ul>';

foreach ( $tp_manuals as $k => $v ) {
	printf( '<li><a href="%s" target="_blank">%s</a></li>', esc_url( $this->theme_author_url . $v ), esc_html( $k ) );
}

echo '</ul>';
?>

</div>
