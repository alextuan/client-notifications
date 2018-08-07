<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Client_Notifications_Connection
{
	protected $api_url = 'http://localhost/server/wp-json/sys_notification/v1';

	public function request_api( $request = '', $options = array(), $method = 'POST' ) {

		$args = array(
			'method'  => $method,
			'timeout' => 10,
			'body'    => $options,
		);

		$api = wp_remote_request( $this->api_url . $request, $args );
		
		if ( is_wp_error( $api ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $api );
		$data = json_decode( $body );

		if ( ! isset( $data->code ) ) {
			return $data;
		}

		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			error_log( $body );
		}

		return false;
	}

	public function get_notifications() {

		$data = $this->request_api( '/get/', null, 'GET' );

		return $data;
	}
}

global $client_notifications_connection;
$client_notifications_connection = new Client_Notifications_Connection();

?>