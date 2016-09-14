<?php
/**
 * Intro Tab on a welcome screen.
 *
 * @package Counter
 */

?>

<div id="getting-started" class="tp-tab-content card">

<h2 class="tab-heading"><?php esc_html_e( 'Getting Started', 'counter' ); ?></h2>

<p><?php esc_html_e( 'These manuals will help you get started with the Counter theme quickly. Make sure to read these guides carefully to get the idea of how the theme works and what it is capable of.', 'counter' ); ?></p>

<?php
	$tp_manuals = array(
		__( 'Getting Started', 'counter' )            => '/docs/counter-getting-started/',
		__( 'Recommended Plugins', 'counter' )        => '/docs/counter-recommended-plugins/',
		__( 'Importing the Demo Content', 'counter' ) => '/docs/counter-importing-the-demo-content/',
		__( 'Page Templates', 'counter' )             => '/docs/counter-page-templates/',
		__( 'Setting Up The Front Page', 'counter' )  => '/docs/counter-setting-up-the-front-page/'
	);

echo '<ul>';

foreach ( $tp_manuals as $k => $v ) {
	printf( '<li><a href="%s" target="_blank">%s</a></li>', esc_url( $this->theme_author_url . $v ), esc_html( $k ) );
}

echo '</ul>';
?>

</div>
