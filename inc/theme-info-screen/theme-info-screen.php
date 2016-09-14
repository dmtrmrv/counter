<?php
/**
 * Owner Theme Info Screen.
 *
 * @package Owner
 */

/**
 * Creates Theme info screen.
 */
class Owner_Theme_Info_Screen {

	/**
	 * Current theme object.
	 *
	 * @var object
	 */
	private $theme;

	/**
	 * Current theme URL.
	 *
	 * @var string
	 */
	private $theme_url;

	/**
	 * Current theme Author URL
	 *
	 * @var string
	 */
	private $theme_author_url;

	/**
	 * Class Constructor.
	 */
	public function __construct() {

		$this->theme = wp_get_theme();
		$this->theme_url = $this->theme->get( 'ThemeURI' );
		$this->theme_author_url = $this->theme->get( 'AuthorURI' );

		add_action( 'admin_menu', array( $this, 'owner_theme_info_screen_register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'owner_theme_info_screen_style' ), 999 );

		add_action( 'owner_theme_info_screen', array( $this, 'owner_theme_info_screen_info' ), 10 );
		add_action( 'owner_theme_info_screen', array( $this, 'owner_theme_info_screen_tab_nav' ), 20 );

		add_action( 'owner_theme_info_screen_tabs', array( $this, 'owner_theme_info_screen_tab_title_getting_started' ), 30 );
		add_action( 'owner_theme_info_screen_tabs', array( $this, 'owner_theme_info_screen_tab_title_plugins' ), 40 );
		add_action( 'owner_theme_info_screen_tabs', array( $this, 'owner_theme_info_screen_tab_title_support' ), 50 );

		add_action( 'owner_theme_info_screen', array( $this, 'owner_theme_info_screen_tab_getting_started' ), 60 );
		add_action( 'owner_theme_info_screen', array( $this, 'owner_theme_info_screen_tab_plugins' ), 70 );
		add_action( 'owner_theme_info_screen', array( $this, 'owner_theme_info_screen_tab_support' ), 80 );

		add_action( 'owner_theme_info_screen_sidebar', array( $this, 'owner_theme_info_screen_sidebar_docs' ), 110 );
	}

	/**
	 * Enqueue theme info screen JS and CSS.
	 */
	public function owner_theme_info_screen_style() {
		wp_enqueue_style(
			'owner-theme-info-screen',
			get_template_directory_uri() . '/inc/theme-info-screen/css/theme-info-screen.css',
			array(),
			OWNER_VERSION
		);

		wp_enqueue_script(
			'owner-theme-info-screen',
			get_template_directory_uri() . '/inc/theme-info-screen/js/theme-info-screen.js',
			array( 'jquery' ),
			OWNER_VERSION,
			true
		);
	}

	/**
	 * Creates the dashboard page.
	 */
	public function owner_theme_info_screen_register_menu() {
		add_theme_page(
			'Getting Started',
			'Getting Started',
			'read',
			'owner-getting-started',
			array( $this, 'owner_theme_info_screen_screen' )
		);
	}

	/**
	 * Theme Info Screen.
	 */
	public function owner_theme_info_screen_screen() {
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );

		echo '<div class="wrap tp-theme-info">';

			do_action( 'owner_theme_info_screen' );

			echo '<div class="theme-info-sidebar">';

				do_action( 'owner_theme_info_screen_sidebar' );

			echo '</div>';

		echo '</div>';

	}

	/**
	 * Welcome screen intro.
	 */
	public function owner_theme_info_screen_info() {
		require_once( get_template_directory() . '/inc/theme-info-screen/partials/intro.php' );
	}

	/**
	 * Welcome screen tabs.
	 */
	public function owner_theme_info_screen_tab_nav() {
		echo '<h2 class="nav-tab-wrapper tp-nav-tab-wrapper">';
			do_action( 'owner_theme_info_screen_tabs' );
		echo '</h2>';
	}

	/**
	 * Features Tab Title.
	 */
	public function owner_theme_info_screen_tab_title_getting_started() {
		printf(
			'<a href="#getting-started" class="nav-tab nav-tab-active">%s</a>',
			esc_html__( 'Getting Started', 'owner' )
		);
	}

	/**
	 * Plugins Tab Title.
	 */
	public function owner_theme_info_screen_tab_title_plugins() {
		printf(
			'<a href="#plugins" class="nav-tab">%s</a>',
			esc_html__( 'Plugins', 'owner' )
		);
	}

	/**
	 * Support Tab Title.
	 */
	public function owner_theme_info_screen_tab_title_support() {
		printf(
			'<a href="#support" class="nav-tab">%s</a>',
			esc_html__( 'Support', 'owner' )
		);
	}

	/**
	 * Features Tab.
	 */
	public function owner_theme_info_screen_tab_getting_started() {
		require_once( get_template_directory() . '/inc/theme-info-screen/partials/tab-getting-started.php' );
	}

	/**
	 * Plugins Tab.
	 */
	public function owner_theme_info_screen_tab_plugins() {
		require_once( get_template_directory() . '/inc/theme-info-screen/partials/tab-plugins.php' );
	}

	/**
	 * Support Tab.
	 */
	public function owner_theme_info_screen_tab_support() {
		require_once( get_template_directory() . '/inc/theme-info-screen/partials/tab-support.php' );
	}

	/**
	 * Sidebar Docs.
	 */
	public function owner_theme_info_screen_sidebar_docs() {
		require_once( get_template_directory() . '/inc/theme-info-screen/partials/widget-docs.php' );
	}

	/**
	 * Checks if given plugin is installed.
	 *
	 * @param  string $path Path to the main plugin file relative to the 'plugins' folder.
	 *
	 * @return bool True if plugin is installed.
	 */
	public function owner_theme_info_screen_is_plugin_installed( $path ) {
		if ( $path ) {
			// Get the list of all plugins.
			$plugins = get_plugins();

			// Check if given plugin is in the list.
			if ( array_key_exists( $path, $plugins ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Displays the Install button for a plugin.
	 *
	 * @param  string $slug  The slug of the plugin.
	 * @param  string $path  Path to the main file of the plugin.
	 * @param  string $class Class name to check for.
	 */
	public function owner_theme_info_screen_plugin_install_button( $slug, $path, $class ) {

		// Check if plugin is installed or not.
		if ( $this->owner_theme_info_screen_is_plugin_installed( $path ) ) {
			// Check if plugin is activated or not.
			if ( is_plugin_inactive( $path ) ) {
				printf(
					'<p class="description">%s</p>',
					esc_html__( 'This plugin is installed but not activated. You need to go to the Plugins page and activate it.', 'owner' )
				);

				printf(
					'<p class="tp-theme-feature-buttons"><a href="%s" target="_blank" class="button">%s</a></p>',
					esc_url( self_admin_url( 'plugins.php' ) ),
					esc_html( 'Go to Plugins Page and Activate', 'owner' )
				);

			} else {
				printf(
					'<p class="tp-theme-feature-buttons"><span class="button button-disabled">%s</span></p>',
					esc_html__( 'Installed & Activated', 'owner' )
				);
			}
		} else {
			printf(
				'<p class="tp-theme-feature-buttons"><a href="%s" target="_blank" class="button button-primary">%s</a></p>',
				esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ) ),
				esc_html( 'Install', 'owner' )
			);
		}
	}
}

$GLOBALS['Owner_Theme_Info_Screen'] = new Owner_Theme_Info_Screen();
