<?php


$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


if (strpos($url,'index.php') !== false) {
    $google = true;
} 

// init configuration
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
if (isset($_GET['code']) && isset($google)) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);

  $google_account_info = $google_oauth->userinfo->get();

  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $picture_pic = $google_account_info->picture;
  $id = $google_account_info->id;
 
    try {
        $query = "select * from users where fbid = '$id'  ";
        $status = mysqli_query($con,$query);
        $row = mysqli_num_rows($status);
        if($row >= 1){
            $row_data = mysqli_fetch_array($status);

            $_SESSION['username'] = $name;
            $_SESSION['nickname'] = $name;
            $_SESSION['userid'] = $row_data['user_id'];
            $_SESSION['image'] = $picture_pic;
            $_SESSION['email'] = $email;

             $query="update  users set user_name = '$name' where user_id =".$row_data['user_id'];
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            
        }
        else
        {
            $query="insert into users values(NULL,'','$name','$email','','',now(),'subscriber','$id') ";
     
            mysqli_query($con,$query) or die(mysqli_error($con));
            $id = mysql_insert_id($con);
            $_SESSION['username'] = $name;
            $_SESSION['nickname'] = $name;
            $_SESSION['userid'] = $id;
            $_SESSION['image'] = $picture_pic;
            $_SESSION['email'] = $email;
        }
    } catch (Exception $e) {
        print_r($e);
    }
       
    header("Location: https://itsallaboutapp.com/index.php");
  // now you can use this profile info to create account in your website and make user logged in.
} else {
    $google_login_url = $client->createAuthUrl();

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

      header("Location: https://itsallaboutapp.com");

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

    header("Location: https://itsallaboutapp.com");




    } catch(Facebook\Exceptions\FacebookSDKException $e) {

    // When validation fails or other local issues

    echo 'Facebook SDK returned an error: ' . $e->getMessage();

    exit;

    }

    } else {

    // replace your website URL same as added in the developers.Facebook.com/apps e.g. if you used http instead of https and you used            

    $loginUrl = $helper->getLoginUrl('https://itsallaboutapp.com/', $permissions);
    
}

}

   


extract($_POST);

if(isset($btnlogin)){
     $query = "select * from users where user_email='$email' and user_password='$password' ";
    $status = mysqli_query($con,$query);
    $row = mysqli_num_rows($status);
    if($row == 1){
        $row_data = mysqli_fetch_array($status);
        $_SESSION['username'] = $row_data['user_name'];
        $_SESSION['nickname'] = $row_data['user_nickname'];
        $_SESSION['userid'] = $row_data['user_id'];
        $_SESSION['image'] = "img/".$row_data['user_photo'];
        $_SESSION['email'] = $row_data['user_email'];
            header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?login=true");
        
    }
    else
    {
        $msg='Login Credentials are wrong!';
    }
}

if(isset($_REQUEST['search'])){
    if(basename($_SERVER['PHP_SELF']) != 'search.php'){
        header('location:search.php?search='.$_REQUEST['search']);
    }
    $search = $_REQUEST['search'];
 $query_post2 = "SELECT * FROM posts WHERE
    (
    post_category LIKE '%".$search."%'
    OR post_tags LIKE '%".$search."%'
    OR post_title LIKE '%".$search."%'
    )";
$result_post2 = mysqli_query($con,$query_post2) or die(mysqli_error($con));

$row = mysqli_num_rows($result_post2);
    if($row == 0){
        $msg1 = true;
        
    }
     
}

 if(isset($_POST['btnregister'])){
        extract($_POST);
        
            $filename=date("y-m-s").$_FILES["avtar"]["name"];
            move_uploaded_file($_FILES["avtar"]["tmp_name"],"img/".$filename);

                 $query="insert into users values(null,'','$nickname','$email','$password','$filename',now(),'subscriber','') ";
             
            mysqli_query($con,$query) or die(mysqli_error($con));
            header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?register=true");
            exit;
          
        
    } 

    $query_page = "select * from pages where status = 'published'";
    $query_page_result = mysqli_query($con,$query_page) or die(mysqli_error($con));
    $query_page_result1 = mysqli_query($con,$query_page) or die(mysqli_error($con));
    
    $query_post = "select * from categories order by total_post_views desc  ";
$result_post = mysqli_query($con,$query_post) or die(mysqli_error($con));


$result_post_c = mysqli_query($con,$query_post) or die(mysqli_error($con));


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="google-site-verification" content="1ZNKZ1z8SFgIqmCnQWmg9JZt0qFqdjTAVQN-l-O-e38" />
        <script data-ad-client="ca-pub-7908348097657161" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <title>It's AllAboutApp - Think beyond</title>
        <link rel = "icon" href = "../img/title_logo.png" type = "image/x-icon">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet"> 

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9997477233710348"crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/login-register.css" rel="stylesheet" />

        <!-- google analytics -->
        <meta name="google-site-verification" content="5ysnWGZ_Ysi_Jrp0GvrV7kGm6hfGqSbl9AsWt6sF6Ow" />
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KN6QDQF');</script>
        <!-- End Google Tag Manager -->

        <!-- google ads link -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9997477233710348"
        crossorigin="anonymous"></script>
        <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
        </script>
        <amp-auto-ads type="adsense"
        data-ad-client="ca-pub-9997477233710348">
        </amp-auto-ads>

        <!-- bing webmaster -->
        <meta name="msvalidate.01" content="0921BE64FD9DA9EF7B457362FF4CC4E2" />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-9MWPXCQ9F4"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-9MWPXCQ9F4');
        </script>
        <!-- --------------------------------------------- -->

        <!-- XSS header protection -->
        <?php header("X-XSS-Protection: 1; mode=block"); ?>

        <!-- CSP header protection -->
        <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; img-src https://*; child-src 'none';">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          
          <style>
                                  .date {
                        font-size: 11px
                    }
                    
                    .comment-text {
                        font-size: 12px
                    }
                    
                    .fs-12 {
                        font-size: 12px
                    }
                    
                    .shadow-none {
                        box-shadow: none
                    }
                    
                    .name {
                        color: #007bff
                    }
                    
                    .cursor:hover {
                        color: blue
                    }
          </style>

    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KN6QDQF"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- add unit -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9997477233710348"
            crossorigin="anonymous"></script>
        <!-- Display_add -->
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-9997477233710348"
            data-ad-slot="4055660501"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

      <div class="modal fade login" id="loginModal">
              <div class="modal-dialog login animated">
                  <div class="modal-content">
                     <div class="modal-header">
                       <button style="padding:0px;margin:0px" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <hr>
                        <h4 style="margin-right:80px" class="modal-title">Login with</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                             <div class="content">
                                <div class="social">
                                    
                                    <a id="google_login" class="circle google" href="<?php echo $google_login_url ?>">
                                        <i class="fa fa-google-plus "></i>
                                    </a>
                                    <a id="facebook_login" class="circle facebook btn btn-primary" href="<?php echo $loginUrl ?>">
                                        <i class="fa fa-facebook "></i> 
                                        
                                    </a>
                                </div>
                                <div class="division">
                                    <div class="line l"></div>
                                      <span>or</span>
                                    <div class="line r"></div>
                                </div>
                                <div class="error"><?php if(isset($msg))  echo $msg ?></div>
                                <div class="form loginBox">
                                    <form method="post" action="" accept-charset="UTF-8">
                                    <input id="email" required=""  class="form-control" type="text" placeholder="Email" name="email">
                                    <input id="password" required="" class="form-control" type="password" placeholder="Password" name="password">
                                    <input class="btn btn-default btn-login" type="submit" name="btnlogin" value="Login" >
                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form">
                                <form method="post" enctype="multipart/form-data"   action="">
                                <input id="email" required="" class="form-control" type="text" placeholder="Email" name="email">
                                <input id="password" required="" class="form-control" type="password" placeholder="Password" name="password">
                                <input id="image" required="" class="form-control" type="file"  style="background: white;color: black;"  name="avtar">                                                                    
                                <input id="nickname" required="" class="form-control" placeholder="Nick Name"  type="text" name="nickname">

                                <input class="btn btn-default btn-register" type="submit" value="Create account" name="btnregister">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                             <span>Already have an account?</span>
                             <a href="javascript: showLoginForm();">Login</a>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
        <!-- Top Bar Start -->
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tb-contact">
                            <p><i class="fas fa-envelope"></i>itsallaboutapp.com</p>
                            <!-- <p><i class="fas fa-phone-alt"></i>+91 6367267830</p> -->
                        </div>
                    </div>

                  
                    <div class="col-md-6">
                        <div class="tb-menu">
                            <?php
                                while ($p = mysqli_fetch_array($query_page_result)) {
                                    ?>
                                        <a href="page.php?page=<?php echo $p['id'] ?>"><?php echo $p['page_title'] ?></a>

                                    <?php
                                 } 
                            ?>
                            <a href="contact.php">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Bar Start -->
        
        <!-- Brand Start -->
        <div class="brand">
            <div class="container">
                <div  class="row align-items-center">
                    <div class="col-lg-4 col-md-4">
                        <div class="b-logo">
                            <a href="index.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4">
                        <div class="b-search">
                            <form method="post" action="" >
                                <input type="text" name="search" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
                            </form>
                            
                        </div>
                    </div>
                      <div style="color: red;" class="col-md-4" >
                        <div class="b-search" style="padding-top:10px" >
                       
                                
                            <?php if(isset($_SESSION['username'])) {
                                ?>
                                    <div class="dropdown">
                              <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    
                                 <img style="width:45px;border-radius:50%;padding-top:1px"  src="<?php echo $_SESSION['image'] ?>">
                                 <span>Hi , <?php echo $_SESSION['nickname'] ?></span>
                              </a>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="savedposts.php">Saved Post</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                               
                              </div>
                            </div>

                                <?php
                            } else{
                                ?>
                                
                                <a class="btn btn-trans btn-icon fa fa-user add-tooltip" href="#"  onclick="openLoginModal();"> Login</a>
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Brand End -->

        <!-- Nav Bar Start -->
        <div class="nav-bar">
            <div class="container">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Category</a>
                                <div class="dropdown-menu">
                                    <?php
                                        while ($data = mysqli_fetch_array($result_post)) {
                                            ?>
                                                <a href="category.php?category_name=<?php echo $data['category_name'] ?>" class="dropdown-item">
                                                    <?php echo $data['category_name'] ?>
                                                </a>

                                            <?php
                                        }
                                     ?>
                                </div>
                            </div>
                          <!--   <a href="single-page.html" class="nav-item nav-link">Single Page</a> -->
                            <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                        </div>
                        
                        <div class="social ml-auto">

                                        
                            <a href="https://twitter.com/ItsallaboutApp" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/Itsallaboutapp-102830555508565" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.linkedin.com/company/itsallaboutapp/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.instagram.com/itsallaboutapp/" target="_blank"><i class="fab fa-instagram"></i></a>
                            <!-- <a href=""><i class="fab fa-youtube" target="_blank"></i></a> -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->
