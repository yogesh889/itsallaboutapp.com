<?php
	unset($_SESSION['admin_id']); 
	unset($_SESSION['admin_name']); 
	session_destroy();
	header('location:index.php');
?>