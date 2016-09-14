<?php
/**
 * Theme updater admin page and functions.
 *
 * @package Owner
 */

/**
 * Handles license actions in the dashboard.
 */
class Owner_Theme_Updater_Admin {

	/**
	 * Site where EDD is hosted.
	 *
	 * @var string
	 */
	protected $remote_api_url = null;

	/**
	 * Theme slug.
	 *
	 * @var string
	 */
	protected $theme_slug = null;

	/**
	 * Theme version.
	 *
	 * @var string
	 */
	protected $version = null;

	/**
	 * Theme author.
	 *
	 * @var string
	 */
	protected $author = null;

	/**
	 * Download ID.
	 *
	 * @var string
	 */
	protected $download_id = null;

	/**
	 * Renew URL.
	 *
	 * @var string
	 */
	protected $renew_url = null;

	/**
	 * Translatable strings.
	 *
	 * @var array
	 */
	protected $strings = null;

	/**
	 * Initialize the class.
	 *
	 * @param array $config  Array of configurations.
	 * @param array $strings Array of translatable strings.
	 */
	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'remote_api_url' => '',
			'theme_slug'     => '',
			'item_name'      => '',
			'license'        => '',
			'version'        => '',
			'author'         => '',
			'download_id'    => '',
			'renew_url'      => '',
		) );

		// Set config arguments.
		$this->remote_api_url = $config['remote_api_url'];
		$this->item_name      = $config['item_name'];
		$this->theme_slug     = sanitize_key( $config['theme_slug'] );
		$this->version        = $config['version'];
		$this->author         = $config['author'];
		$this->download_id    = $config['download_id'];
		$this->renew_url      = $config['renew_url'];

		// Populate version fallback.
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config.
		$this->strings = $strings;

		add_action( 'admin_init', array( $this, 'updater' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'license_action' ) );

		add_action( 'owner_theme_info_screen_sidebar', array( $this, 'license_page' ), 100 );

		add_action( 'update_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license' ), 10, 2 );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );

	}

	/**
	 * Creates the updater class.
	 *
	 * @since 0.2.0
	 */
	function updater() {

		// If there is no valid license key status, don't allow updates.
		if ( get_option( $this->theme_slug . '_license_key_status', false ) != 'valid' ) {
			return;
		}

		if ( ! class_exists( 'Owner_Theme_Updater' ) ) {
			// Load our custom theme updater.
			include( dirname( __FILE__ ) . '/theme-updater-class.php' );
		}

		new Owner_Theme_Updater(
			array(
				'remote_api_url' => $this->remote_api_url,
				'version'        => $this->version,
				'license'        => trim( get_option( $this->theme_slug . '_license_key' ) ),
				'item_name'      => $this->item_name,
				'author'         => $this->author,
				'theme_slug'     => $this->theme_slug,
			),
			$this->strings
		);
	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * @since 0.2.0
	 */
	function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key',
			array( $this, 'sanitize_license' )
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * @since 0.2.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {

		$old = get_option( $this->theme_slug . '_license_key' );

		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate.
			delete_option( $this->theme_slug . '_license_key_status' );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		return $new;
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 0.2.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	 function get_api_response( $api_params ) {

		// Call the custom API.
		$response = wp_remote_post(
			$this->remote_api_url,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params,
			)
		);

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response;
	 }

	/**
	 * Activates the license key.
	 *
	 * @since 0.2.0
	 */
	function activate_license() {

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name ),
		);

		$license_data = $this->get_api_response( $api_params );

		// $response->license will be either "active" or "inactive"
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			delete_transient( $this->theme_slug . '_license_message' );
		}

	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 0.2.0
	 */
	function deactivate_license() {

		// Retrieve the license from the database.
		$license = trim( get_option( $this->theme_slug . '_license_key' ) );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name ),
		);

		$license_data = $this->get_api_response( $api_params );

		// $license_data->license will be either "deactivated" or "failed"
		if ( $license_data && ( 'deactivated' == $license_data->license ) ) {
			delete_option( $this->theme_slug . '_license_key_status' );
			delete_transient( $this->theme_slug . '_license_message' );
		}
	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 0.2.0
	 */
	function get_renewal_link() {

		// If a renewal link was passed in the config, use that.
		if ( '' != $this->renew_url ) {
			return $this->renew_url;
		}

		// If download_id was passed in the config, a renewal link can be constructed.
		$license_key = trim( get_option( $this->theme_slug . '_license_key', false ) );
		if ( '' != $this->download_id && $license_key ) {
			$url = esc_url( $this->remote_api_url );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
			return $url;
		}

		// Otherwise return the remote_api_url.
		return $this->remote_api_url;

	}

	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 0.2.0
	 */
	function license_action() {

		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST[ $this->theme_slug . '_license_deactivate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}

	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * @since 0.2.0
	 */
	function license_page() {

		$strings = $this->strings;

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );
		$status  = get_option( $this->theme_slug . '_license_key_status', false );

		// Checks license status to display under license key.
		if ( ! $license ) {
			$message = $strings['enter-key'];
			$message .= sprintf(
				' <a href="%s" target="_blank">%s</a>',
				'https://themepatio.com/docs/where-do-i-find-theme-license/',
				$strings['where-is-the-license']
			);
		} else {
			if ( ! get_transient( $this->theme_slug . '_license_message', false ) ) {
				set_transient( $this->theme_slug . '_license_message', $this->check_license(), ( 60 * 60 * 24 ) );
			}
			$message = get_transient( $this->theme_slug . '_license_message' );
		}

		require_once( get_template_directory() . '/inc/theme-info-screen/partials/widget-license.php' );
	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 0.2.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		$license = trim( get_option( $this->theme_slug . '_license_key' ) );

		$strings = $this->strings;

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name ),
			'url'        => home_url(),
		);

		$license_data = $this->get_api_response( $api_params );

		// If response doesn't include license data, return.
		if ( ! isset( $license_data->license ) ) {
			$message = $strings['license-status-unknown'];
			return $message;
		}

		// We need to update the license status at the same time the message is updated.
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
		}

		// Get expire date.
		$expires = false;
		if ( isset( $license_data->expires ) ) {
			$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
			$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings['renew'] . '</a>';
		}

		// Get site counts.
		$site_count = $license_data->site_count;
		$license_limit = $license_data->license_limit;

		// If unlimited.
		if ( 0 == $license_limit ) {
			$license_limit = $strings['unlimited'];
		}

		if ( 'valid' == $license_data->license ) {
			$message = '<span class="tp-license-active">' . $strings['license-key-is-active'] . '</span> ';
			if ( $expires ) {
				$message .= sprintf( $strings['expires%s'], $expires );
			}
		} else if ( 'expired' == $license_data->license ) {
			if ( $expires ) {
				$message = '<span class="tp-license-unknown">' . sprintf( $strings['license-key-expired-%s'], $expires ) . '</span>';
			} else {
				$message = '<span class="tp-license-unknown">' . $strings['license-key-expired'] . '</span>';
			}
			if ( $renew_link ) {
				$message .= ' ' . $renew_link;
			}
		} else if ( 'invalid' == $license_data->license ) {
			$message = '<span class="tp-license-unknown">' . $strings['license-keys-do-not-match'] . '</span>';
		} else if ( 'inactive' == $license_data->license ) {
			$message = '<span class="tp-license-inactive">' . $strings['license-is-inactive'] . '</span>';
		} else if ( 'disabled' == $license_data->license ) {
			$message = '<span class="tp-license-unknown">' . $strings['license-key-is-disabled'] . '</span>';
		} else if ( 'site_inactive' == $license_data->license ) {
			$message = '<span class="tp-license-inactive">' . $strings['site-is-inactive'] . '</span>';
		} else {
			$message = '<span class="tp-license-unknown">' . $strings['license-status-unknown'] . '</span>';
		}

		return $message;
	}

	/**
	 * Disable requests to wordpressp.org repository for this theme.
	 *
	 * @since 0.2.0
	 *
	 * @param  string $r   Request.
	 * @param  string $url URL.
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		// Decode the JSON response.
		$themes = json_decode( $r['body']['themes'] );

		// Remove the active parent and child themes from the check.
		$parent = get_option( 'template' );
		$child = get_option( 'stylesheet' );
		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		// Encode the updated JSON response.
		$r['body']['themes'] = json_encode( $themes );

		return $r;
	}
}
