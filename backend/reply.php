<?php
    include_once('../connection.php');
    include_once('auth.php'); 
 ?>
<?php
    $query ="select * from contact_msg where msg_id =".$_REQUEST['msg_id'];
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
    $msg_result = mysqli_fetch_array($result);
    
?>
<?php
    

    if(isset($_POST['btnsubmit'])){
        extract($_POST);
         if(isset($_REQUEST["msg_id"]))
        {
            $reply = mysqli_real_escape_string($con, $reply);
            $query="update contact_msg set msg_reply = '$reply' , reply_by = '".$_SESSION['admin_id']."' , replied_on = now(), is_reply = 'yes' where msg_id =  ".$_REQUEST["msg_id"];
            
            mysqli_query($con,$query) or die(mysqli_error($con));
             //send mail
            
             $to =  $_REQUEST['user_email'];
            $subject = 'itsfishionworld  has reply for your message' ;
            
            $htmlContent = $_REQUEST['reply'];
            
            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // Additional headers
            $headers .= 'From: itsfashionworld2021@gmail.com' . "\r\n";
            $headers .= 'Cc: itsfashionworld2021@gmail.com' . "\r\n";
            
            
            // Send email
            if(mail($to,$subject,$htmlContent,$headers)):
                $successMsg = 'Email has sent successfully.';
            else:
                $errorMsg = 'Email sending fail.';
            endif;
        
             header("Location:messages.php");
             exit;
        }
      
    } 
    
 ?>
  <?php include_once("include/head.php") ?>
<?php include_once('include/menu.php') ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="mail"></i></div>
                                    <span>Reply</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Reponse Area:</div>
                            <div class="card-body">
                                <form action="" method="post" >
                                    <div class="form-group">
                                        <label for="post-content">Message:</label>
                                        <textarea class="form-control" placeholder="Type here..." id="post-content" rows="9" readonly="true"><?php echo $msg_result['msg'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">User email:</label>
                                        <input class="form-control" id="user-name" type="text" placeholder="User name ..." readonly="true" name="user_email" value="<?php echo $msg_result['user_email'] ?>" />
                                    </div>                               

                                    <div class="form-group">
                                        <label for="post-tags">Reply:</label>
                                        <textarea id="editor" class="form-control" name="reply" placeholder="Type your reply here..." id="post-tags" rows="9"></textarea>
                                    </div>

                                    <input type="submit" value="submit" class="btn btn-primary mr-2 my-1" name="btnsubmit">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

<?php include_once('include/footer.php');  ?>