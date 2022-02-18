<?php
	if(!isset($_SESSION['admin_name']) || $_SESSION['admin_name'] == NULL) {
		header('location:login.php');
	}
?>