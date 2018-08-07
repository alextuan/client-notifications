<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Client_Notifications
{

	public $notifications_option_key      = 'client_notifications';
	public $dismissed_notification_prefix = 'client_dismissed_notification_';
	public $notifications                 = null;

	public function __construct() {

		include( CLIENT_NOTIFICATIONS_PATH . '/includes/connections/notifications-connection.php' );
		include( CLIENT_NOTIFICATIONS_PATH . '/includes/schedules/notifications-schedule-events.php' );

		add_action( 'plugins_loaded', array( $this, 'init' ), 1 );

		add_action( 'admin_enqueue_scripts', array( $this, 'plugin_scripts' ) );

		add_action( 'admin_notices', array( $this, 'show_notifications_on_dashboard' ) );
	}

	public function init() {

		if ( ! is_admin() ) {
			return;
		}

		$notifications = $this->get_notifications();
		if ( ! empty( $notifications ) ) {
			$this->notifications = $notifications;
		}
	}

	public function plugin_scripts() {

		wp_enqueue_style( 'client-notifications', CLIENT_NOTIFICATIONS_CSS_URL . '/notifications.css', null, CLIENT_NOTIFICATIONS_VERSION );

		wp_enqueue_script( 'client-notifications', CLIENT_NOTIFICATIONS_JS_URL . '/notifications.js', array( 'jquery' ), CLIENT_NOTIFICATIONS_VERSION, true );

		wp_localize_script( 'client-notifications',
			'client_notifications_vars',
			apply_filters( 'client_notifications_vars', array(
				'ajax_url'       => admin_url( 'admin-ajax.php', 'relative' ),
				'security_nonce' => wp_create_nonce( 'client-notifications-event' ),
			) )
		);
	}

	public function show_notifications_on_dashboard() {

		if ( empty( $this->notifications ) ) {
			return;
		}

		foreach ( $this->notifications as $notification ) {

			// Check for don't show the notification without an invalid time
			if ( $notification->start_date > time() || $notification->end_date < time() ) {
				continue;
			}

			$dismissible = ( 1 == $notification->dismissible ? true : false );

			$this->show_notification_item( $notification->id, $notification->title, $notification->message, $notification->img_url, $notification->type, $dismissible );
		}
	}

	public function get_notifications( $cache = true ) {

		$notifications = false;

		if ( $cache ) {
			$notifications = get_option( $this->notifications_option_key, false );

			if ( ! empty( $notifications ) && is_string( $notifications ) ) {
				$notifications = json_decode( $notifications );
			}
		}

		if ( false === $notifications ) {
			global $client_notifications_connection;

			$notifications = $client_notifications_connection->get_notifications();

			$json_notifications = json_encode( $notifications );
			update_option( $this->notifications_option_key, $json_notifications );
		}

		return $notifications;
	}

	public function dismiss_notification( $notification_id = '' ) {

		update_option( $this->dismissed_notification_prefix . $notification_id , 1 );
	}

	public function is_dismissed( $notification_id = '' ) {

		$is_dismissed = get_option( $this->dismissed_notification_prefix . $notification_id, 0 );

		if ( 1 == $is_dismissed ) {
			return true;
		}

		return false;
	}

	public function show_notification_item( $notification_id, $title = '', $message = '', $img_url = '', $type = 'info', $dismissible = true ) {

		if ( $this->is_dismissed( $notification_id ) || empty( $message ) ) {
			return;
		}

		$args = array(
			'notification_id' => $notification_id,
			'title'           => $title,
			'message'         => $message,
			'img_url'         => $img_url,
			'type'            => $type,
			'dismissible'     => $dismissible,
		);

		client_notification_item( $args );

	}
}

global $client_notifications;
$client_notifications = new Client_Notifications();

?>