<?php
session_start();


$url = 'index.php';
if(isset($_SESSION['facebook_access_token'])){
	$token = $_SESSION['facebook_access_token'];
	$url = 'https://www.facebook.com/logout.php?next=' . 'https://itsfashionworld.com/' .
  '&access_token='.$token;
}


session_destroy();
header("Location: ".$url);
?>