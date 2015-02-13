<?php
	require 'discuss_functions.php';
	if($_POST['post_send']) {
		if($query_settings_name_req=="0" && !$_POST['post_name']) {
		return 1;
		}
	}
?>
