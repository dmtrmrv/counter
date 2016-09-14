<?php
/**
 * Counter Custom CSS
 *
 * @package Counter
 */

/**
 * Register color schemes for Counter.
 *
 * Can be filtered with {@see 'counter_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 0. Body Background
 * 1. Accent
 * 2. Headings
 * 3. Text
 * 4. Light Text
 *
 * @since Twenty Fifteen 1.0
 *
 * @return array An associative array of color scheme options.
 */
function counter_get_color_schemes() {
	return apply_filters( 'counter_color_schemes', array(
		'default' => array(
			'label'  => _x( 'Default', 'Color scheme', 'counter' ),
			'colors' => array(
				'#ffffff',
				'#d17d38',
				'#1e1e1e',
				'#555555',
				'#e6e6e6',
			),
		),
		'dark' => array(
			'label'  => _x( 'Dark', 'Color scheme', 'counter' ),
			'colors' => array(
				'#555555',
				'#d17d38',
				'#ffffff',
				'#d1d1d1',
				'#f8f8f8',
			),
		),
		'blueberry' => array(
			'label'  => _x( 'Blueberry', 'Color scheme', 'counter' ),
			'colors' => array(
				'#e6eef7',
				'#7eaed9',
				'#244673',
				'#3571a5',
				'#e1eaf2',
			),
		),
		'honey' => array(
			'label'  => _x( 'Honey', 'Color scheme', 'counter' ),
			'colors' => array(
				'#ffffff',
				'#ebc14e',
				'#664d2c',
				'#916e3f',
				'#efe9e2',
			),
		),
		'chocolate' => array(
			'label'  => _x( 'Chocolate', 'Color scheme', 'counter' ),
			'colors' => array(
				'#ffefd4',
				'#c5793f',
				'#502b0e',
				'#502b0e',
				'#e5dfdb',
			),
		),
		'raspberry' => array(
			'label'  => _x( 'Raspberry', 'Color scheme', 'counter' ),
			'colors' => array(
				'#f4edef',
				'#d9526b',
				'#59322e',
				'#7f4842',
				'#ece4e3',
			),
		),
		'olive' => array(
			'label'  => _x( 'Olive', 'Color scheme', 'counter' ),
			'colors' => array(
				'#fff8d6',
				'#7a8c37',
				'#5c3527',
				'#704030',
				'#eae3e0',
			),
		),
	) );
}

/**
 * Returns site color scheme.
 *
 * If passed 'actual' as a parameter, will return the actual color scheme of
 * of the website. That is the scheme stored in a database. Can return one of
 * standard color schemes defined by counter_get_color_schemes().
 *
 * @param  string $scheme_name The name of the scheme to return.
 * @return array               Multidimensional array of color values in HEX.
 */
function counter_get_color_scheme( $scheme_name = '' ) {

	// Get all standard color scheme.
	$schemes = counter_get_color_schemes();

	// Get default color scheme.
	$default = $schemes['default']['colors'];

	// If scheme name is not defined, try to get it from database.
	$scheme_name = $scheme_name ? $scheme_name : get_theme_mod( 'color_scheme', 'default' );

	// If we need actual scheme, defined by user.
	if ( 'actual' === $scheme_name ) {

		// Try to get the values from the database.
		$scheme[0] = get_theme_mod( 'color_bg', false );
		$scheme[1] = get_theme_mod( 'color_accent', false );
		$scheme[2] = get_theme_mod( 'color_headings', false );
		$scheme[3] = get_theme_mod( 'color_text', false );

		// We don't need to output the CSS if the values we get equal to the
		// defult color scheme. So filter them out.
		$scheme[0] = $default[0] !== $scheme[0] ? $scheme[0] : false;
		$scheme[1] = $default[1] !== $scheme[1] ? $scheme[1] : false;
		$scheme[2] = $default[2] !== $scheme[2] ? $scheme[2] : false;
		$scheme[3] = $default[3] !== $scheme[3] ? $scheme[3] : false;

		// Generate light text color if custom text color is set.
		$scheme[4] = $scheme[3] ? vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.15 )', counter_hex2rgb( $scheme[3] ) ) : false;

		// Build color scheme for panels.
		for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
			// Try to get the values from the database.
			$panel_scheme[0] = get_theme_mod( 'panel_color_bg_' . $i, false );
			$panel_scheme[1] = get_theme_mod( 'panel_color_accent_' . $i, false );
			$panel_scheme[2] = get_theme_mod( 'panel_color_headings_' . $i, false );
			$panel_scheme[3] = get_theme_mod( 'panel_color_text_' . $i, false );

			// We don't need to output a style if it matches the global color.
			$panel_scheme[0] = $scheme[0] == $panel_scheme[0] || $default[0] == $panel_scheme[0] ? false : $panel_scheme[0];
			$panel_scheme[1] = $scheme[1] == $panel_scheme[1] || $default[1] == $panel_scheme[1] ? false : $panel_scheme[1];
			$panel_scheme[2] = $scheme[2] == $panel_scheme[2] || $default[2] == $panel_scheme[2] ? false : $panel_scheme[2];
			$panel_scheme[3] = $scheme[3] == $panel_scheme[3] || $default[3] == $panel_scheme[3] ? false : $panel_scheme[3];

			// Generate light text color if custom text color is set for the panel.
			$panel_scheme[4] = $panel_scheme[3] ? vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.15 )', counter_hex2rgb( $panel_scheme[3] ) ) : false;

			// Add panel colors to the color scheme.
			$scheme[5][ $i ] = $panel_scheme;
		}

		// Return the scheme.
		return $scheme;
	}

	// If this color scheme exists assign it to $scheme variable.
	if ( array_key_exists( $scheme_name, $schemes ) ) {
		$scheme = $schemes[ $scheme_name ]['colors'];
	} else {
		$scheme = $default;
	}

	// Build color scheme for panels.
	for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
		$scheme[5][ $i ] = array( $scheme[0], $scheme[1], $scheme[2], $scheme[3], $scheme[4] );
	}

	// Return the scheme.
	return $scheme;
}

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
 * Returns an array of color scheme choices registered for Counter.
 */
function counter_get_color_scheme_choices() {
	$color_schemes                = counter_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function counter_get_color_scheme_css( $colors = array() ) {

$css = '';

/*
 * Site Background.
 * ========================================================================= *
 */
if ( $colors[0] ) :

$css .= <<<CSS
/* Site background */
.site,
.main-navigation,
.menu-toggle,
.menu-toggle:hover,
.menu-toggle:focus,
.main-navigation,
.main-navigation ul ul,
.post-navigation .nav-link,
.lead-dots span:first-child,
.lead-dots span + span {
    background-color: {$colors[0]};
}

CSS;
endif;

/*
 * Accent Color.
 * ========================================================================= *
 */
if ( $colors[1] ) :

$css .= <<<CSS
/* Accent color */
a,
a:hover,
a:active,
a:focus,
.main-navigation a:hover,
.main-navigation a:focus,
.main-navigation a:active {
	color: {$colors[1]};
}

.btn.btn-accent,
#content .mejs-time-current,
.posts-navigation .nav-previous a:hover,
.posts-navigation .nav-previous a:focus,
.posts-navigation .nav-next a:hover,
.posts-navigation .nav-next a:focus,
#infinite-handle button:hover,
#infinite-handle button:focus {
	background-color: {$colors[1]};
}

.btn.btn-accent,
input[type="text"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="password"]:focus,
input[type="search"]:focus,
textarea:focus,
.posts-navigation .nav-previous a:hover,
.posts-navigation .nav-previous a:focus,
.posts-navigation .nav-next a:hover,
.posts-navigation .nav-next a:focus,
#infinite-handle button:hover,
#infinite-handle button:focus {
	border-color: {$colors[1]};
}

CSS;
endif;

/*
 * Headings.
 * ========================================================================= *
 */
if ( $colors[2] ) :

$css .= <<<CSS
/* Headings */
h1, h2, h3, h4, h5, h6,
.site-title a,
.site-title a:hover,
.site-title a:focus,
.site-description,
.entry-title a,
.dropcap {
	color: {$colors[2]};
}

CSS;
endif;

/*
 * Text.
 * ========================================================================= *
 */
if ( $colors[3] ) :

// Text color. Placeholders only work as separate selectors!!!
$css .= <<<CSS
/* Text color */
body,
mark,
ins,
input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
textarea,
.main-navigation a,
.menu-social-container a:before,
.posts-navigation .nav-previous a,
.posts-navigation .nav-next a,
.entry-meta-item,
.entry-meta-item a,
#infinite-handle button,
.wpcf7 .placeheld,
.post-navigation .nav-link a:before,
.post-navigation .nav-link a:hover {
	color: {$colors[3]};
}

.menu-toggle:before,
.menu-toggle:after {
	background-color: {$colors[3]};
}

::-webkit-input-placeholder { color: {$colors[3]}; }
::-moz-placeholder          { color: {$colors[3]}; }/* Firefox 19+ */
:-moz-placeholder           { color: {$colors[3]}; }/* Firefox 18- */
input:-ms-input-placeholder { color: {$colors[3]}; }

CSS;
endif;

/*
 * Light Text.
 * ========================================================================= *
 */
if ( $colors[4] ) :

$css .= <<<CSS
/* Light text color. */
mark,
ins,
thead th,
code,
hr,
#content .wp-playlist-playing,
.pingback .comment-body {
    background-color: {$colors[4]};
}

fieldset,
input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
textarea,
.posts-navigation .nav-previous a,
.posts-navigation .nav-next a,
.widget-area .widget,
#infinite-handle button,
.post-navigation .nav-link {
    border-color: {$colors[4]};
}

#content .wp-playlist-tracks,
.site-info,
.comment-list,
.site-footer-widgets,
.main-navigation ul ul ul {
    border-top-color: {$colors[4]};
}

.main-navigation ul ul {
    border-right-color: {$colors[4]};
}

td,
th,
#content .wp-playlist-item,
.site-header,
.main-navigation,
.comment-body,
.widget.widget_recent_comments li,
.widget.widget_recent_entries li,
.widget.widget_rss li,
.main-navigation ul ul {
    border-bottom-color: {$colors[4]};
}

.main-navigation ul ul {
    border-left-color: {$colors[4]};
}

CSS;
endif;

/*
 * Panels
 * ========================================================================= *
 */

// Spin the panel custom colors loop.
foreach ( $colors[5] as $i => $panel ) :
/**
 * Panel Background.
 * ========================================================================= *
 */
if ( $panel[0] ) :

$css .= <<<CSS
/* Panel {$i} background */
#panel-{$i},
#panel-{$i} .lead-dots span:first-child,
#panel-{$i} .lead-dots span + span {
	background-color: {$panel[0]};
}

CSS;
endif;

/*
 * Panel Accent.
 * ========================================================================= *
 */
if ( $panel[1] ) :

$css .= <<<CSS
/* Panel {$i} accent color */
#panel-{$i} a:not(.btn),
#panel-{$i} a:not(.btn):hover,
#panel-{$i} a:not(.btn):active,
#panel-{$i} a:not(.btn):focus {
	color: {$panel[1]};
}

#panel-{$i} .entry-title a,
#panel-{$i} .entry-title a:hover,
#panel-{$i} .entry-title a:focus,
#panel-{$i} .entry-meta-item a,
#panel-{$i} .entry-meta-item a:hover,
#panel-{$i} .entry-meta-item a:focus {
	color: inherit;
}

#panel-{$i} .btn.btn-accent,
#panel-{$i} #content .mejs-time-current {
	background-color: {$panel[1]};
}

#panel-{$i} .btn.btn-accent,
#panel-{$i} input[type="text"]:focus,
#panel-{$i} input[type="email"]:focus,
#panel-{$i} input[type="url"]:focus,
#panel-{$i} input[type="password"]:focus,
#panel-{$i} input[type="search"]:focus,
#panel-{$i} textarea:focus {
	border-color: {$panel[1]};
}

CSS;
endif;

/*
 * Panel Headings.
 * ========================================================================= *
 */
if ( $panel[2] ) :

$css .= <<<CSS
/* Panel {$i} headings */
#panel-{$i} h1,
#panel-{$i} h2,
#panel-{$i} h3,
#panel-{$i} h4,
#panel-{$i} h5,
#panel-{$i} h6,
#panel-{$i} .entry-title a {
	color: {$panel[2]};
}

CSS;
endif;

/*
 * Panel Text.
 * ========================================================================= *
 */
if ( $panel[3] ) :

$css .= <<<CSS
/* Panel {$i} text color */
#panel-{$i},
#panel-{$i} mark,
#panel-{$i} ins,
#panel-{$i} input[type="text"],
#panel-{$i} input[type="email"],
#panel-{$i} input[type="url"],
#panel-{$i} input[type="password"],
#panel-{$i} input[type="search"],
#panel-{$i} textarea,
#panel-{$i} .entry-meta-item,
#panel-{$i} .entry-meta-item a,
#panel-{$i} .wpcf7 .placeheld {
	color: {$panel[3]};
}

#panel-{$i} ::-webkit-input-placeholder { color: {$panel[3]}; }
#panel-{$i} ::-moz-placeholder          { color: {$panel[3]}; }/* Firefox 19+ */
#panel-{$i} :-moz-placeholder           { color: {$panel[3]}; }/* Firefox 18- */
#panel-{$i} input:-ms-input-placeholder { color: {$panel[3]}; }
}

CSS;
endif;

/*
 * Panel Text Light.
 * ========================================================================= *
 */
if ( $panel[4] ) :

$css .= <<<CSS

/* Panel {$i} light text color */
#panel-{$i} mark,
#panel-{$i} ins,
#panel-{$i} thead th,
#panel-{$i} code,
#panel-{$i} hr,
#panel-{$i} #content .wp-playlist-playing {
    background-color: {$panel[4]};
}

#panel-{$i} fieldset,
#panel-{$i} input[type="text"],
#panel-{$i} input[type="email"],
#panel-{$i} input[type="url"],
#panel-{$i} input[type="password"],
#panel-{$i} input[type="search"],
#panel-{$i} textarea {
	border-color: {$panel[4]};
}

#panel-{$i} #content .wp-playlist-tracks {
    border-top-color: {$panel[4]};
}

#panel-{$i} td,
#panel-{$i} th,
#panel-{$i} #content .wp-playlist-item {
    border-bottom-color: {$panel[4]};
}

CSS;
endif;

endforeach;

// Phew. Looks like this is it.
return $css;

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
 * Split-Left Panel.
 * ========================================================================= *
 */
if ( 'left' == get_theme_mod( 'panel_layout_' . $i ) ) :

$css .= <<<CSS
#panel-{$i} .panel-thumbnail {
	padding: {$v}% 0 {$v}% {$v}%;
}

CSS;

/*
 * Split-Right Panel.
 * ========================================================================= *
 */
elseif ( 'right' == get_theme_mod( 'panel_layout_' . $i ) ) :

$css .= <<<CSS
#panel-{$i} .panel-thumbnail {
	padding: {$v}% {$v}% {$v}% 0;
}

CSS;

/*
 * Other Panels
 * ========================================================================= *
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
 * Return an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function counter_color_scheme_css_template() {
	$scheme = array(
		'{{ data.color_bg }}',
		'{{ data.color_accent }}',
		'{{ data.color_headings }}',
		'{{ data.color_text }}',
		'{{ data.color_text_light }}',
	);

	// Build color scheme for panels.
	for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) {
		$scheme[5][ $i ] = array(
			'{{ data.panel_color_bg_' . $i . ' }}',
			'{{ data.panel_color_accent_' . $i . ' }}',
			'{{ data.panel_color_headings_' . $i . ' }}',
			'{{ data.panel_color_text_' . $i . ' }}',
			'{{ data.panel_color_text_light_' . $i . ' }}',
		);
	}
	?>
	<script type="text/html" id="tmpl-counter-color-scheme">
		<?php echo counter_get_color_scheme_css( $scheme ); // WPCS: XSS OK. ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'counter_color_scheme_css_template' );

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
 * Adds inline CSS with custom CSS.
 */
function counter_color_scheme_css() {
	wp_add_inline_style( 'counter-style', counter_get_color_scheme_css( counter_get_color_scheme( 'actual' ) ) );
	wp_add_inline_style( 'counter-style', counter_get_panel_spacings_css( counter_get_panel_spacings() ) );
}
add_action( 'wp_enqueue_scripts', 'counter_color_scheme_css', 11 );
