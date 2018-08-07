<?php
/*
Plugin Name: Client Notifications
Description: Getting notifications from the server and displaying on the Dashboard
Version: 1.0.0
Plugin URI: https://github.com/alextuan/client-notifications
Author: Nguyen Cong Tuan
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'CLIENT_NOTIFICATIONS_PATH', dirname(__FILE__) );
define( 'CLIENT_NOTIFICATIONS_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'CLIENT_NOTIFICATIONS_JS_URL', CLIENT_NOTIFICATIONS_URL . '/assets/js' );
define( 'CLIENT_NOTIFICATIONS_CSS_URL', CLIENT_NOTIFICATIONS_URL . '/assets/css' );
define( 'CLIENT_NOTIFICATIONS_TEMPLATE_PATH', CLIENT_NOTIFICATIONS_PATH . '/templates' );

define( 'CLIENT_NOTIFICATIONS_VERSION', '1.0.0' );

include( 'includes/notifications-templates.php' );
include( 'includes/notifications-ajax.php' );

include( 'includes/class-notifications.php' );

?>