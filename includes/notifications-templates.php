<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get templates passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @return void
 */
function client_notifications_get_template( $template_name, $args = array() ) {
	
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$template_file_path = client_notifications_get_template_file_path( $template_name );

	// Allow 3rd party plugin filter template file from their plugin
	$template_file_path = apply_filters( 'client_notifications_get_template', $template_file_path, $template_name, $args );

	if ( empty( $template_file_path ) ) {
		return;
	}

	include( $template_file_path );
}

/**
 *
 * This is the load order:
 *
 *		yourtheme							/	client-notifications	/	$file
 *		yourtheme							/	$file
 *		CLIENT_NOTIFICATIONS_TEMPLATE_PATH	/	$file
 *
 * @access public
 * @param $file string filename
 * @return PATH to the file
 */
function client_notifications_get_template_file_path( $file = '' ) {

	// If we're not looking for a file, do not proceed
	if ( empty( $file ) ) {
		return;
	}

	// Look for file in stylesheet
	if ( file_exists( get_stylesheet_directory() . '/client-notifications/' . $file ) ) {
		$file_path = get_stylesheet_directory() . '/client-notifications/' . $file;

	// Look for file in stylesheet
	} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
		$file_path = get_stylesheet_directory() . '/' . $file;

	// Look for file in template
	} elseif ( file_exists( get_template_directory() . '/client-notifications/' . $file ) ) {
		$file_path = get_template_directory() . '/client-notifications/' . $file;

	// Look for file in template
	} elseif ( file_exists( get_template_directory() . '/' . $file ) ) {
		$file_path = get_template_directory() . '/' . $file;

	// Get default template
	} else {
		$file_path = CLIENT_NOTIFICATIONS_TEMPLATE_PATH . '/' . $file;
	}

	// Return filtered result
	return apply_filters( 'client_notifications_get_template_file_path', $file_path, $file );
}

function client_notification_item( $args = array() ) {
	$template_name = 'notification-item.php';
	client_notifications_get_template( $template_name, $args );
}

?>