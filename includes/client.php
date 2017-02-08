<?
	require("../../../../wp-load.php");
	$clientData = get_userdata( $_REQUEST["clientid"] );
?>



<?php if( current_user_can('editor') || current_user_can('administrator') ) { ?>


<div class="col-md-8">
	<div class="panel panel-default">
		<div class="panel-body">
		<?php echo $clientData->data->user_login; ?><hr>
		<?php echo $clientData->data->user_email; ?><br>
		</div>
	</div>
</div>


<?php } else { ?>

	<h3>You cannot access this information!</h3>

<?php } ?>