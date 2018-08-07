jQuery( document ).ready( function( $ ) {

	// Ajax remove notification from data
	$(document).on( 'click', '.client-dismiss-icon', function(){

		var button = $(this);

		var notification_id = button.data('notification-id');
		var submit_data     = {
			action: 			'client_notifications_remove',
			notification_id: 	notification_id,
			security: 			client_notifications_vars.security_nonce
		};

		$.ajax({
			type: 	'POST',
			url: 	client_notifications_vars.ajax_url,
			data: 	submit_data,
			success: function ( response ) {
				button.parents('div.client-notification').remove();
			}
		});

		return false;
	});
});