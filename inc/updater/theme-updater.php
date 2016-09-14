<?php
/**
 * Owner Theme Updater.
 *
 * @package Owner
 */

// Includes the files needed for the theme updater.
if ( ! class_exists( 'Owner_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes.
$updater = new Owner_Theme_Updater_Admin(
	// Config settings.
	$config = array(
		'remote_api_url' => 'https://themepatio.com', // Site where EDD is hosted.
		'item_name'      => 'Owner', // Name of theme.
		'theme_slug'     => 'owner', // Theme slug.
		'version'        => '0.1.0', // The current version of this theme.
		'author'         => 'ThemePatio', // The author of this theme.
		'download_id'    => '', // Optional, used for generating a license renewal link.
		'renew_url'      => '', // Optional, allows for a custom license renewal link.
	),
	// Strings.
	$strings = array(
		'theme-license'             => __( 'Theme License', 'owner' ),
		'enter-key'                 => __( 'Enter the license key.', 'owner' ),
		'license-key'               => __( 'License Key', 'owner' ),
		'license-action'            => __( 'License Action', 'owner' ),
		'deactivate-license'        => __( 'Deactivate', 'owner' ),
		'activate-license'          => __( 'Activate', 'owner' ),
		'status-unknown'            => __( 'License status is unknown.', 'owner' ),
		'renew'                     => __( 'Renew?', 'owner' ),
		'unlimited'                 => __( '&infin;', 'owner' ),
		'license-key-is-active'     => __( 'Active.', 'owner' ),
		'expires%s'                 => __( 'Expires %s.', 'owner' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'owner' ),
		'license-key-expired-%s'    => __( 'License expired %s.', 'owner' ),
		'license-key-expired'       => __( 'License has expired.', 'owner' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'owner' ),
		'license-is-inactive'       => __( 'Inactive.', 'owner' ),
		'license-key-is-disabled'   => __( 'License is disabled.', 'owner' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'owner' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'owner' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'owner' ),
		'update-available'          => _x( '%s is available.', 'Theme Name X.X.X is available.', 'owner' ),
		'what-is-new'               => _x( 'Check out what\'s new', 'Part of the sentence: Check out what\'s new or update now.', 'owner' ),
		'or'                        => _x( 'or', 'Part of the sentence: Check out what\'s new or update now.', 'owner' ),
		'update-now'                => _x( 'update now', 'Part of the sentence: Check out what\'s new or update now.', 'owner' ),
		'where-is-the-license'      => __( 'Where do I get it?', 'owner' ),
	)
);
