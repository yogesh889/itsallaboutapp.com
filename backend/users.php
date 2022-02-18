<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from users order by user_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($uid))
    {
        $query = "delete from users where user_id =".$uid;
        mysqli_query($con,$query) or die(mysqli_error($con));

        header('location:users.php');
    }
 ?>
<?php include_once("include/head.php") ?>
<?php include_once('include/menu.php') ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content d-flex align-items-center justify-content-between text-white">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="users"></i></div>
                                    <span>All Users</span>
                                </h1>
                                <a href="new-user.html" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Users</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Photo</th>
                                                <th>Registered on</th>
                                                <th>Role</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                            while ($data = mysqli_fetch_array($result)) {
                                                ?>
                                                    <tr>
                                                <td>
                                                                    <?php echo $data['user_name'] ?>
                                                    
                                                </td>
                                                <td>
                                                                    <?php echo $data['user_email'] ?>
                                                    
                                                </td>
                                                <td>-</td>
                                                <td>
                                                                    <?php echo $data['registered_on'] ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="badge badge-success">
                                                        <?php echo $data['user_role'] ?>
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <a onclick="return confirm('Are you sure you want to Remove?');" href="?uid=<?php echo $data['user_id'] ?>" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></a>
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
               