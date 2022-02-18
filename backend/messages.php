<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from contact_msg order by msg_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($uid))
    {
        $query = "delete from contact_msg where msg_id =".$uid;
        mysqli_query($con,$query) or die(mysqli_error($con));

        header('location:messages.php');
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
                                    <span>Messages</span>
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
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Response</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                         
                                                <?php
                                                    while ($data = mysqli_fetch_array($result) ) {
                                                         ?>
                                                            <tr>
                                                             <td>
                                                               <?php echo $data['user_name'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['user_email'] ?>
                                                            </td>
                                                            <td><?php echo $data['msg'] ?></td>
                                                            <td><?php echo $data['msg_date'] ?></td>
                                                            <td>
                                                                   <?php
                                                                if($data['is_reply'] == 'yes' ){
                                                                    ?>
                                                                        <div class="badge badge-success">   Replied
                                                                        </div>
                                                                    <?php
                                                                } 
                                                                else
                                                                { ?>
                                                                    <div class="badge badge-primary">   Pending
                                                                        </div>
                                                                <?php
                                                                }
                                                            ?>
                                                            </td>
                                                            <td>
                                                                <a href="reply.php?msg_id=<?php echo $data['msg_id'] ?>" class="btn btn-success btn-icon"><i data-feather="mail"></i></a>
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
