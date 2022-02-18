<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    extract($_REQUEST);
 

       //  header('Location: cmt-reply.php'); 
    $query = "select * from cmt_reply where comm_id = '".$_REQUEST['cm_id']."'  order by reply_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    if( isset($reply_id))
    {
        $query = "delete from cmt_reply where reply_id =".$reply_id;
        mysqli_query($con,$query) or die(mysqli_error($con));

         header('Location: cmt-reply.php'); 
    }
    if( isset($rep_app_id))
    {
         $query="update cmt_reply set status = 'approved'   where reply_id =  ".$_REQUEST['rep_app_id'];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('Location: cmt-reply.php'); 
    }
    if( isset($rep_unapp_id))
    {
         $query="update cmt_reply set status = 'unapproved'   where reply_id =  ".$_REQUEST['rep_unapp_id'];
         
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('Location: cmt-reply.php'); 
    }

    if(isset($_REQUEST['btnreply'])){
         if(isset($_SESSION['admin_id'])){
            $input = date('Y-M-d H:i:s'); 
            $d = date("Y-M-d H:i:s",strtotime($input));
         
             $insert = "insert into cmt_reply values (NULL,'".$_REQUEST['cm_id']."','$d',0,'unapproved','".$_SESSION['admin_id']."','".$_REQUEST['reply']."') ";
            
            mysqli_query($con,$insert) or die(mysqli_error($con));

            $q = "select * from posts where post_id=".$_REQUEST['post_id'];
            $d = mysqli_query($con,$q) or die(mysqli_error($con));

            $post = mysqli_fetch_array($d);

             $view = $post['post_comment_count'] + 1;
             $query="update posts set post_comment_count = '$view'   where post_id =  '".$_REQUEST['post_id']."' ";
            mysqli_query($con,$query) or die(mysqli_error($con));


            //send mail
            
            // $to = 'mayaonly18@gmail.com';
            // $subject = $_SESSION['username'].' has reply in comment on Post ' ;
            
            // $htmlContent = $_REQUEST['subject'];
            
            // // Set content-type header for sending HTML email
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // // Additional headers
            // $headers .= 'From: donlymaya1@gmail.com>' . "\r\n";
            // $headers .= 'Cc: donlymaya1@gmail.com' . "\r\n";
            
            
            // // Send email
            // if(mail($to,$subject,$htmlContent,$headers)):
            //     $successMsg = 'Email has sent successfully.';
            // else:
            //     $errorMsg = 'Email sending fail.';
            // endif;
        
             //header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
             //exit;
        }
    }
 ?>
<?php include_once("include/head.php") ?>
<?php include_once('include/menu.php') ?>
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Reply To Comment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="" >
           <div class="modal-body mx-3">

        <div class="md-form mb-5">
            <input type="hidden" name="com_id" value="" id="com_id" >
            <input type="hidden" name="post_id" value="" id="post_id" >
          <textarea name="reply" class="form-control" placeholder="Reply here....."  ></textarea>
        
        </div>

       

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <input type="submit" name="btnreply" class="btn btn-success" value="Submit" >
      </div>
      </form>
     
    </div>
  </div>
</div>


            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="package"></i></div>
                                    <span> Comments Reply</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header"> Comments Reply </div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Details</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Approve</th>
                                                <th>Decline</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($data  = mysqli_fetch_array($result)) {
                                                   if($data['admin_id'] == NULL || $data['admin_id'] == 0 ){
                                                        $q = "select * from users where user_id =".$data['user_id'];
                                                        $qd = mysqli_query($con,$q) or die(mysqli_error($con));
                                                        $ud = mysqli_fetch_array($qd);
                                                        $name = $ud['user_nickname'];
                                                        $email = $ud['user_email'];


                                                    }
                                                    else
                                                    {
                                                          $q = "select * from admin where id =".$data['admin_id'];
                                                        $qd = mysqli_query($con,$q) or die(mysqli_error($con));
                                                        $ud = mysqli_fetch_array($qd);
                                                        $name = $ud['username']." : admin";
                                                        $email = $ud['email'];
                                                    }
                                            ?>
                                                       <tr>
                                                            <td>
                                                                <?php echo $name ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $email ?>
                                                                
                                                            </td>
                                                            
                                                            <td><?php echo $data['reply'] ?></td>
                                                            <td><?php echo $data['reply_on'] ?></td>
                                                           <td>
                                                                 <?php
                                                                if($data['status'] == 'unapproved' ){
                                                                    ?>
                                                                     <div class="badge badge-primary">   Unapproved
                                                                        </div>
                                                                            
                                                                    <?php
                                                                } 
                                                                else
                                                                { ?>
                                                                 <div class="badge badge-success">   Approved
                                                                   </div>
                                                                   
                                                                <?php
                                                                }
                                                            ?>
                                                            </td>
                                                            <td>
                                                                <a href="?rep_app_id=<?php echo $data['reply_id'] ?>" class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                            </td>
                                                            <td>
                                                                <a href="?rep_unapp_id=<?php echo $data['reply_id'] ?>" class="btn btn-red btn-icon"><i data-feather="delete"></i></a>
                                                            </td>
                                                            <td>
                                                                

                                                                   <a class="reply_modal" post_id="<?php echo $_REQUEST['post_id'] ?>" com_id="<?php echo $_REQUEST['com_id'] ?>" href="javascript:void(0)"  data-toggle="modal" data-target="#modalLoginForm" ><i class="fa fa-reply"></i></a>

                                                                  <a onclick="return confirm('Are you sure you want to Remove?');" href="?reply_id=<?php echo $data['reply_id'] ?>" ><i class="fa fa-trash"></i></a>

                                                               

                                                            </td>
                                                        </tr>  
                                                    
                                            <?php
                                                 } 
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->

                </main>

<?php include_once('include/footer.php') ?>
<script type="text/javascript">
    $(document).on("click", ".reply_modal", function () {
        
     var com_id = $(this).attr('com_id');
     $(".modal-body #com_id").val(com_id);
     
      var post_id = $(this).attr('post_id');
     $(".modal-body #post_id").val(post_id);
});
</script>