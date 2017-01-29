<?php
/**
 * The header for our theme
 *
 * @package Counter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content">
		<?php esc_html_e( 'Skip to content', 'counter' ); ?>
	</a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header-wrap">
			<div class="site-branding">
				<?php the_custom_logo(); ?>
				<?php counter_site_title_tagline(); ?>
			</div><!-- .site-branding -->
		</div><!-- .site-header-wrap -->

		<?php if ( has_nav_menu( 'primary' ) ) : ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id' => 'primary-menu',
					'container' => false,
				) );
			?>
		</nav><!-- #site-navigation -->

		<button id="site-navigation-toggle" class="menu-toggle" >
			<span class="menu-toggle-icon"></span>
			<?php esc_html_e( 'Primary Menu', 'counter' ); ?>
		</button><!-- #site-navigation-toggle -->

		<?php endif; ?>

	</header><!-- #masthead -->

	<div id="main" class="site-main" role="main">
		<div id="content" class="site-content wrap">
