<?php
/**
 * Counter Custom CSS
 *
 * @package Counter
 */

/**
 * Returns spacing for panels in a form of an array.
 */
function counter_get_panel_spacings() {
	for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
		$spacings[ $i ] = get_theme_mod( 'panel_spacing_' . $i, 0 );
	}
	return $spacings;
}

/**
 * Returns CSS for panel spacings.
 *
 * @param array $spacings Spacings for panels.
 *
 * @return string CSS with custom spacings.
 */
function counter_get_panel_spacings_css( $spacings = array() ) {

if ( ! array_filter( $spacings ) ) {
	return;
}

$css = '
@media screen and (min-width: 768px) {
';

foreach ( $spacings as $i => $v ) :

if ( 0 != $v ) :
/*
 * Left Layout Panel.
 */
if ( 'left' == get_theme_mod( 'panel_layout_' . $i ) ) :

$css .= <<<CSS
#panel-{$i} .panel-thumbnail {
	padding: {$v}% 0 {$v}% {$v}%;
}

CSS;

/*
 * Right Layout Panel.
 */
elseif ( 'right' == get_theme_mod( 'panel_layout_' . $i ) ) :

$css .= <<<CSS
#panel-{$i} .panel-thumbnail {
	padding: {$v}% {$v}% {$v}% 0;
}

CSS;

/*
 * Other Panels.
 */
else :

$css .= <<<CSS
#panel-{$i} .wrap {
	padding-top: {$v}%;
	padding-bottom: {$v}%;
}

CSS;

endif;

endif;

endforeach;

$css .= '}';

return $css;
}

/**
 * Return an Underscore template for generating CSS for the panels.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function counter_get_panel_spacings_css_template() {

// Create CSS template strings.
$spacings = array();
for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
	$spacings[ $i ] = '{{ data.panel_spacing_' . $i . ' }}';
}

// Build panel spacing CSS template.
$css = '

@media screen and (min-width: 768px) {
';

foreach ( $spacings as $i => $v ) :
$css .= <<<CSS

#panel-{$i} .wrap {
	padding-top: {$v}%;
	padding-bottom: {$v}%;
}

#panel-{$i}.panel-left .panel-thumbnail {
	padding: {$v}% 0 {$v}% {$v}%;
}

#panel-{$i}.panel-right .panel-thumbnail {
	padding: {$v}% {$v}% {$v}% 0;
}

CSS;
endforeach;
$css .= '}'; ?>

<script type="text/html" id="tmpl-counter-panel-spacings">
	<?php echo $css; // WPCS: XSS OK. ?>
</script><?php
}
add_action( 'customize_controls_print_footer_scripts', 'counter_get_panel_spacings_css_template' );

/**
 * Adds inline CSS.
 */
function counter_custom_css() {
	wp_add_inline_style( 'counter-style', counter_get_panel_spacings_css( counter_get_panel_spacings() ) );
}
add_action( 'wp_enqueue_scripts', 'counter_custom_css', 11 );
