<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from comments c , users u , posts p where c.com_post_id = p.post_id and u.user_id = c.com_user_id  order by com_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($cm_id))
    {
        $query = "delete from comments where com_id =".$cm_id;
        mysqli_query($con,$query) or die(mysqli_error($con));
           $query = "delete from cmt_reply where comm_id =".$cm_id;
        mysqli_query($con,$query) or die(mysqli_error($con));

         header('Location: comments.php'); 
    }
    if( isset($comm_app_id))
    {
         $query="update comments set com_status = 'approved'   where com_id =  ".$_REQUEST['comm_app_id'];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('Location: comments.php'); 
    }
    if( isset($comm_unapp_id))
    {
         $query="update comments set com_status = 'unapproved'   where com_id =  ".$_REQUEST['comm_unapp_id'];
         
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('Location: comments.php'); 
    }

    if(isset($_REQUEST['btnreply'])){
         if(isset($_SESSION['admin_id'])){
            $input = date('Y-M-d H:i:s'); 
            $d = date("Y-M-d H:i:s",strtotime($input));
         
             $insert = "insert into cmt_reply values (NULL,'".$_REQUEST['com_id']."','$d',0,'unapproved','".$_SESSION['admin_id']."','".$_REQUEST['reply']."') ";
            
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
        
             header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
             exit;
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
                                    <span>All Comments</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Comments</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>In response to</th>
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
                                            ?>
                                                       <tr>
                                                            <td>
                                                                <?php echo $data['com_user_name'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['user_email'] ?>
                                                                
                                                            </td>
                                                            <td>
                                                                <a href="#">
                                                                   <?php echo $data['post_title'] ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $data['com_detail'] ?></td>
                                                            <td><?php echo $data['com_date'] ?></td>
                                                           <td>
                                                                 <?php
                                                                if($data['com_status'] == 'unapproved' ){
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
                                                                <a href="?comm_app_id=<?php echo $data['com_id'] ?>" class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                            </td>
                                                            <td>
                                                                <a href="?comm_unapp_id=<?php echo $data['com_id'] ?>" class="btn btn-red btn-icon"><i data-feather="delete"></i></a>
                                                            </td>
                                                            <td>
                                                                <a  href="cmt-reply.php?cm_id=<?php echo $data['com_id'] ?>&post_id=<?php echo $data['post_id'] ?>"  title="See Reply"  ><i class="fa fa-eye" ></i></a>

                                                                   <a class="reply_modal" post_id="<?php echo $data['post_id'] ?>" com_id="<?php echo $data['com_id'] ?>" href="javascript:void(0)"  data-toggle="modal" data-target="#modalLoginForm" ><i class="fa fa-reply"></i></a>

                                                                  <a onclick="return confirm('Are you sure you want to Remove?');" href="?cm_id=<?php echo $data['com_id'] ?>" ><i class="fa fa-trash"></i></a>

                                                               

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