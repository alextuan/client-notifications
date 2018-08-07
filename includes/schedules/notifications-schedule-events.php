<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Client_Notifications_Schedule_Events
{

	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'register_schedule_events' ) );
	}

	public function register_schedule_events() {

		// register event for auto get notifications
		if ( ! wp_next_scheduled( 'client_get_notifications_scheduled_jobs' ) ) {
			$next_day  = date( 'Y-m-d H:i:s', strtotime('+1 day') );
			$next_time = strtotime( $next_day );
			$next_time = get_option( 'gmt_offset' ) > 0 ? $next_time - ( 60 * 60 * get_option( 'gmt_offset' ) ) : $next_time +
( 60 * 60 * get_option( 'gmt_offset' ) );

			wp_schedule_event( $next_time, 'daily', 'client_get_notifications_scheduled_jobs' );
		}
		
		add_action( 'client_get_notifications_scheduled_jobs', array( $this, 'get_notifications_scheduled' ) );
	}


	public function get_notifications_scheduled() {
		global $client_notifications;

		$client_notifications->get_notifications( false );
	}

}

new Client_Notifications_Schedule_Events();

?>