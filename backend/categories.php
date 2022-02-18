<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from categories order by category_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($categorydeleteid))
    {
        $query = "delete from categories where category_id =".$categorydeleteid;
        mysqli_query($con,$query) or die(mysqli_error($con));

        header('location:categories.php');
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
                                    <div class="page-header-icon"><i data-feather="chevrons-up"></i></div>
                                    <span>Categories</span>
                                </h1>
                                <a href="add-category.php" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Table-->
                    <div class="container-fluid mt-n10">

                        <div class="card mb-4">
                            <div class="card-header">All Categories</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Category Name</th>
                                                <th>Total Posts</th>
                                                <th>Post Views</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($data = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#">
                                                                   <?php echo $data['category_name'] ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['category_total_post'] ?>
                                                            </td>
                                                                   
                                                            <td>
                                                                <?php echo $data['total_post_views'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data['created_by'] ?>

                                                            </td>
                                                            <td>
                                                                 <?php
                                                                if($data['category_status'] == 'published' ){
                                                                    ?>
                                                                        <div class="badge badge-success">   Published
                                                                        </div>
                                                                    <?php
                                                                } 
                                                                else
                                                                { ?>
                                                                    <div class="badge badge-primary">   Draft
                                                                        </div>
                                                                <?php
                                                                }
                                                            ?>
                                                            </td>
                                                            <td>
                                                                <a href="add-category.php?cid=<?php echo $data['category_id'] ?>" class="btn btn-blue btn-icon"><i data-feather="edit"></i></a>
                                                            </td>
                                                            <td>
                                                                <a onclick="return confirm('Are you sure you want to Remove?');" href="?categorydeleteid=<?php echo $data['category_id'] ?>" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></a>
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

<?php include_once('include/footer.php') ?>

               
