<?php
/**
 * Theme updater class.
 *
 * @package Owner
 */

/**
 * Handles theme updates.
 */
class Owner_Theme_Updater {

	/**
	 * Site where EDD is hosted.
	 *
	 * @var string
	 */
	private $remote_api_url;

	/**
	 * Request data.
	 *
	 * @var string
	 */
	private $request_data;

	/**
	 * Response key.
	 *
	 * @var string
	 */
	private $response_key;

	/**
	 * Theme slug.
	 *
	 * @var string
	 */
	private $theme_slug;

	/**
	 * License key.
	 *
	 * @var string
	 */
	private $license_key;

	/**
	 * Theme version.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Theme author.
	 *
	 * @var string
	 */
	private $author;

	/**
	 * Translatable strings.
	 *
	 * @var null
	 */
	protected $strings = null;

	/**
	 * Class constructor.
	 *
	 * @param array $args    Array of arguments.
	 * @param array $strings Array of strings.
	 */
	function __construct( $args = array(), $strings = array() ) {

		$args = wp_parse_args( $args, array(
			'remote_api_url' => 'http://easydigitaldownloads.com',
			'request_data' => array(),
			'theme_slug' => get_template(),
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => '',
		) );
		extract( $args );

		$this->license = $license;
		$this->item_name = $item_name;
		$this->version = $version;
		$this->theme_slug = sanitize_key( $theme_slug );
		$this->author = $author;
		$this->remote_api_url = $remote_api_url;
		$this->response_key = $this->theme_slug . '-update-response';
		$this->strings = $strings;

		add_filter( 'site_transient_update_themes', array( &$this, 'theme_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-update-core.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'load_themes_screen' ) );
	}

	/**
	 * Adds thickbox and registers the notification.
	 */
	function load_themes_screen() {
		add_thickbox();
		add_action( 'admin_notices', array( &$this, 'update_nag' ) );
	}

	/**
	 * Prints update notification.
	 */
	function update_nag() {

		$strings = $this->strings;

		$theme = wp_get_theme( $this->theme_slug );

		$api_response = get_transient( $this->response_key );

		if ( false === $api_response ) {
			return;
		}

		$update_url = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( $strings['update-notice'] ) . '\') ) {return true;}return false;"';

		if ( version_compare( $this->version, $api_response->new_version, '<' ) ) {

			echo '<div id="update-nag">';

			// Theme Name X.X.X is available.
			printf(
				'<strong>' . esc_html( $strings['update-available'] ) . '</strong> ',
				esc_html( $theme->get( 'Name' ) . ' ' . esc_html( $api_response->new_version ) )
			);

			// Check out what's new or update now.
			printf( // WPCS: XSS OK.
				'<a href="%1$s" class="thickbox" title="%2$s">%3$s</a> %4$s <a href="%5$s"%6$s>%7$s</a>.',
				esc_url( '#TB_inline?width=640&amp;inlineId=' . $this->theme_slug . '_changelog' ),
				esc_attr( $theme->get( 'Name' ) ),
				esc_html( $strings['what-is-new'] ),
				esc_html( $strings['or'] ),
				esc_url( $update_url ),
				$update_onclick,
				esc_html( $strings['update-now'] )
			);

			echo '</div>';

			printf(
				'<div id="%s" style="display: none;">%s</div>',
				esc_attr( $this->theme_slug . '_changelog' ),
				wp_kses_post( $api_response->sections['changelog'] )
			);
		}
	}

	/**
	 * Updates transient.
	 *
	 * @param  string $value Message content.
	 * @return string        Message content.
	 */
	function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}

	/**
	 * Delete the transient.
	 */
	function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	/**
	 * Check for theme update.
	 *
	 * @return array Update data.
	 */
	function check_for_update() {

		$update_data = get_transient( $this->response_key );

		if ( false === $update_data ) {
			$failed = false;

			$api_params = array(
				'edd_action' 	=> 'get_version',
				'license' 		=> $this->license,
				'name' 			=> $this->item_name,
				'slug' 			=> $this->theme_slug,
				'author'		=> $this->author,
			);

			$response = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'body' => $api_params ) );

			// Make sure the response was successful.
			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// If the response failed, try again in 30 minutes.
			if ( $failed ) {
				$data = new stdClass;
				$data->new_version = $this->version;
				set_transient( $this->response_key, $data, strtotime( '+30 minutes' ) );
				return false;
			}

			// If the status is 'ok', return the update arguments.
			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );
				set_transient( $this->response_key, $update_data, strtotime( '+12 hours' ) );
			}
		}

		if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}
}
