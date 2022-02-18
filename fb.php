<?php
   include_once 'connection.php';

        $fb = new Facebook\Facebook([

     'app_id' => '569525460710076',

     'app_secret' => '2f90d5b2ecf4ba7ec3404141880a1631',

     'default_graph_version' => 'v2.5',

    ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email']; // optional

    try {

    if (isset($_SESSION['facebook_access_token'])) {

    $accessToken = $_SESSION['facebook_access_token'];

    } else {

      $accessToken = $helper->getAccessToken();

    }

    } catch(Facebook\Exceptions\facebookResponseException $e) {

    // When Graph returns an error

    echo 'Graph returned an error: ' . $e->getMessage();

      exit;

    } catch(Facebook\Exceptions\FacebookSDKException $e) {

    // When validation fails or other local issues

    echo 'Facebook SDK returned an error: ' . $e->getMessage();

      exit;

    }

    if (isset($accessToken)) {

    if (isset($_SESSION['facebook_access_token'])) {

    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

    } else {

    // getting short-lived access token

    $_SESSION['facebook_access_token'] = (string) $accessToken;

      // OAuth 2.0 client handler

    $oAuth2Client = $fb->getOAuth2Client();

    // Exchanges a short-lived access token for a long-lived one

    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

    // setting default access token to be used in script

    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

    }

    // redirect the user to the profile page if it has "code" GET variable

    if (isset($_GET['code'])) {

      header("Location: index.php");

    }

    // getting basic info about user

    try {

    $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');

    $requestPicture = $fb->get('/me/picture?redirect=false&height=200'); //getting user picture


    $picture = $requestPicture->getGraphUser();

    $profile = $profile_request->getGraphUser();

    $fbid = $profile->getProperty('id');           // To Get Facebook ID

    $fbfullname = $profile->getProperty('name');   // To Get Facebook full name

    $fbemail = $profile->getProperty('email');    //  To Get Facebook email

    $fbpic = "<img src='".$picture['url']."' class='img-rounded'/>";


        $query = "select * from users where fbid = '$fbid'  ";
        $status = mysqli_query($con,$query);
        $row = mysqli_num_rows($status);
        if($row == 1){
            $row_data = mysqli_fetch_array($status);

            $_SESSION['username'] = $fbfullname;
            $_SESSION['nickname'] = $fbfullname;
            $_SESSION['userid'] = $row_data['user_id'];
            $_SESSION['image'] = $picture['url'];
            $_SESSION['email'] = $fbemail;

            $query="update  users set user_name = '$fbfullname' where user_id =".$row_data['user_id'];
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            
        }
        else
        {
            $query="insert into users values(NULL,'','$fbfullname','$fbemail','','',now(),'subscriber',$fbid) ";
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            $id = mysql_insert_id($con);
            $_SESSION['username'] = $fbfullname;
            $_SESSION['nickname'] = $fbfullname;
            $_SESSION['userid'] = $id;
            $_SESSION['image'] = $picture['url'];
            $_SESSION['email'] = $fbemail;
        }


        

    } catch(Facebook\Exceptions\FacebookResponseException $e) {

    // When Graph returns an error

    echo 'Graph returned an error: ' . $e->getMessage();

    session_destroy();

    // redirecting user back to app login page

    header("Location: index.php");




    } catch(Facebook\Exceptions\FacebookSDKException $e) {

    // When validation fails or other local issues

    echo 'Facebook SDK returned an error: ' . $e->getMessage();

    exit;

    }

    } else {

    // replace your website URL same as added in the developers.Facebook.com/apps e.g. if you used http instead of https and you used            

    $loginUrl = $helper->getLoginUrl('https://itsfashionworld.com/', $permissions);
   header('Location : '.$loginUrl);

    }

?>