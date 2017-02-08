<?
	require("../../../../wp-load.php");

		$savedRows =  get_bmibmr_users();

		print_r(json_encode($savedRows));
?>