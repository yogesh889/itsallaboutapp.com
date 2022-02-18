<?php

include_once('connection.php');

	if(isset($_REQUEST['post_id']) && isset($_SESSION['userid'])){
		$like = "select * from saved_post where post_id = '".$_REQUEST['post_id']."' and user_id = ".$_SESSION['userid'];

		$k=mysqli_query($con,$like) or die(mysqli_error($con));

		$row = mysqli_num_rows($k);
    	if($row == 1){
    		// unlike

    		$q = " delete from saved_post where post_id= '".$_REQUEST['post_id']."' and user_id = ".$_SESSION['userid'];
    		mysqli_query($con,$q) or die(mysqli_error($con));
		} 
		else
		{
			// like

			$l = "insert into saved_post values(NULL,'".$_REQUEST['post_id']."','".$_SESSION['userid']."',NOW()) ";
			mysqli_query($con,$l) or die(mysqli_error($con));
		}
		
	}
?>