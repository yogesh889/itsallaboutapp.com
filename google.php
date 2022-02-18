<?php 
     // init configuration
   include_once 'connection.php';
    $clientID = '1069503353192-rfioff04t3jhofdbbdpbpn4hntjibs9g.apps.googleusercontent.com';
    $clientSecret = 'nGaPeXIgjKq8IXz6ZaOjZf5v';
    $redirectUri = 'https://itsallaboutapp.com/index.php';
       
    // create Client Request to access Google API
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");
      
    // authenticate code from Google OAuth Flow
    if (isset($_GET['code'])) {
      $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
      $client->setAccessToken($token['access_token']);
      $_SESSION['access_token']= $token['access_token'];
       
      // get profile info
      $google_oauth = new Google_Service_Oauth2($client);
      
       $google_account_info = $google_oauth->userinfo->get();
       $email =  $google_account_info->email;
      $name =  $google_account_info->name;
      $id =  $google_account_info->id;
      $picture = $google_account_info->picture;


       $query = "select * from users where fbid = '$id'  ";
        $status = mysqli_query($con,$query);
        $row = mysqli_num_rows($status);
        if($row == 1){
            $row_data = mysqli_fetch_array($status);

            $_SESSION['username'] = $name;
            $_SESSION['nickname'] = $name;
            $_SESSION['userid'] = $row_data['user_id'];
            $_SESSION['image'] = $picture;
            $_SESSION['email'] = $email;

            $query="update  users set user_name = '$fbfullname' where user_id =".$row_data['user_id'];
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            
        }
        else
        {
            $query="insert into users values(NULL,'','$name','$email','','',now(),'subscriber',$id) ";
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            $id = mysql_insert_id($con);
            $_SESSION['username'] = $name;
            $_SESSION['nickname'] = $name;
            $_SESSION['userid'] = $id;
            $_SESSION['image'] = $picture;
            $_SESSION['email'] = $email;

        }

      header('Location : index.php');
      
      // now you can use this profile info to create account in your website and make user logged in.
    } else {
      $url_google = $client->createAuthUrl();
    header('Location : '.$url_google);

    }
?>