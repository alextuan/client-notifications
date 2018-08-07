<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) )  {
	exit;
}
?>

<div class="client-notification <?php echo ( $dismissible ? 'dismissible' : '' ); ?> <?php echo $type; ?>">

	<?php if ( ! empty( $img_url ) ) { ?>
	<div class="client-notification-logo" style="background-image:url(<?php echo esc_url( $img_url ); ?>)"><span></span></div>
	<?php } ?>

	<div class="client-notification-content">
	
		<div class="notification-title"><strong><?php echo $title; ?></strong></div>

		<div class="notification-message"><?php echo $message; ?></div>

	</div>
	<div class="client-notification-dismiss">
		<a href="#" class="client-dismiss-icon" data-notification-id="<?php echo $notification_id; ?>"><?php echo __( 'Dismiss' ); ?></a>
	</div>

</div>