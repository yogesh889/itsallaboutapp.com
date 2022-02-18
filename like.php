<?php

include_once('connection.php');

	if(isset($_REQUEST['post_id']) && isset($_SESSION['userid'])){
		$like = "select * from likes where post_id = '".$_REQUEST['post_id']."' and user_id = ".$_SESSION['userid'];

		$k=mysqli_query($con,$like) or die(mysqli_error($con));

		$row = mysqli_num_rows($k);
    	if($row == 1){
    		// unlike

    		$q = " delete from likes where post_id= '".$_REQUEST['post_id']."' and user_id = ".$_SESSION['userid'];
    		mysqli_query($con,$q) or die(mysqli_error($con));
		} 
		else
		{
			// like

			$l = "insert into likes values(NULL,'".$_SESSION['userid']."','".$_REQUEST['post_id']."',NOW()) ";
			mysqli_query($con,$l) or die(mysqli_error($con));
		}
		$like_query = "SELECT COUNT(like_id) AS likes FROM likes where post_id = ".$_REQUEST['post_id'];
    $result_like = mysqli_query($con,$like_query) or die(mysqli_error($con));

    $likes_post = mysqli_fetch_array($result_like);
    echo $likes_post['likes'];
	}
?>