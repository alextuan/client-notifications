<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Client_Notifications_Ajax
{

	public function __construct() {

		$this->add_ajax_events();
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public function add_ajax_events() {

		$ajax_events = array(
			'remove' => false
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_client_notifications_' . $ajax_event, array( $this, $ajax_event . '_ajax' ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_client_notifications_' . $ajax_event, array( $this, $ajax_event . '_ajax' ) );
			}
		}
	}

	public function remove_ajax() {
		
		check_ajax_referer( 'client-notifications-event', 'security' );

		$json_var = array(
			'status' => 'error'
		);

		$notification_id = $_POST['notification_id'];

		if ( empty( $notification_id ) ) {
			wp_send_json( $json_var );
			die();
		}

		global $client_notifications;
		$client_notifications->dismiss_notification( $notification_id );

		$json_var['status'] = 'success';

		wp_send_json( $json_var );
		die();
	}
}

new Client_Notifications_Ajax();

?>