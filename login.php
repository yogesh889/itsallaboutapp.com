<?php
        include('connection.php');
        include('config.php');
        include('hybridauth/Hybrid/Auth.php');
        if(isset($_GET['provider']))
        {
        	$provider = $_GET['provider'];
        	
        	try{
        	
        	$hybridauth = new Hybrid_Auth( $config );
        	
        	$authProvider = $hybridauth->authenticate($provider);

	        $user_profile = $authProvider->getUserProfile();
	        
			if($user_profile && isset($user_profile->identifier))
	        {

                        echo "<b>Name</b> :".$user_profile->displayName."<br>";
	        	echo "<b>Id</b> :".$user_profile->id."<br>";
	        	echo "<b>Profile URL</b> :".$user_profile->profileURL."<br>";
	        	echo "<b>Image</b> :".$user_profile->photoURL."<br> ";
	        	echo "<img src='".$user_profile->photoURL."'/><br>";
	        	echo "<b>Email</b> :".$user_profile->email."<br>";	        		        		        	
	        	echo "<br> <a href='logout.php'>Logout</a>";
	        }	        
                       $query = "select * from users where fbid = '".$user_profile->id."' ";
                        $status = mysqli_query($con,$query);
                        $row = mysqli_num_rows($status);
                        if($row == 1){
                            $row_data = mysqli_fetch_array($status);

                            $_SESSION['username'] = $user_profile->displayName;
                            $_SESSION['nickname'] = $user_profile->displayName;
                            $_SESSION['userid'] = $row_data['user_id'];
                            $_SESSION['image'] = $user_profile->profileURL;
                            $_SESSION['email'] = $user_profile->email;

                            $query="update  users set user_name = '$fbfullname' where user_id =".$row_data['user_id'];
                     
                            mysqli_query($con,$query) or die(mysqli_error($con));
                            
                        }
                        else
                        {
                            $query="insert into users values(NULL,'','$name','$email','','',now(),'subscriber',$id) ";
                     
                            mysqli_query($con,$query) or die(mysqli_error($con));
                            $id = mysql_insert_id($con);
                             $_SESSION['username'] = $user_profile->displayName;
                            $_SESSION['nickname'] = $user_profile->displayName;
                            $_SESSION['userid'] = $id;
                            $_SESSION['image'] = $user_profile->profileURL;
                            $_SESSION['email'] = $user_profile->email;

                        }

                       
			}
			catch( Exception $e )
			{ 
			
				 switch( $e->getCode() )
				 {
                        case 0 : echo "Unspecified error."; break;
                        case 1 : echo "Hybridauth configuration error."; break;
                        case 2 : echo "Provider not properly configured."; break;
                        case 3 : echo "Unknown or disabled provider."; break;
                        case 4 : echo "Missing provider application credentials."; break;
                        case 5 : echo "Authentication failed. "
                                         . "The user has canceled the authentication or the provider refused the connection.";
                                 break;
                        case 6 : echo "User profile request failed. Most likely the user is not connected "
                                         . "to the provider and he should to authenticate again.";
                                 $twitter->logout();
                                 break;
                        case 7 : echo "User not connected to the provider.";
                                 $twitter->logout();
                                 break;
                        case 8 : echo "Provider does not support this feature."; break;
                }

                // well, basically your should not display this to the end user, just give him a hint and move on..
                echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

                echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";

			}
        
        }
?>