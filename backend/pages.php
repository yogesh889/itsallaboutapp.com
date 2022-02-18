<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from pages order by id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($page_id))
    {
        $query = "delete from pages where id =".$page_id;
        mysqli_query($con,$query) or die(mysqli_error($con));

        header('location:pages.php');
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
                                    <div class="page-header-icon"><i data-feather="book-open"></i></div>
                                    <span>All Pages</span>
                                </h1>
                                <a href="new-page.php" title="Add New Page" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
            
                    <!--Table-->
                    <div class="container-fluid mt-n10">

                        <div class="card mb-4">
                            <div class="card-header">All Pages</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Page Title</th>
                                                <th>Page Details</th>
                                                <th>Views</th>
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
                                                                    
                                                                    <?php echo $data['page_title'] ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                    <?php echo $data['page_data'] ?>
                                                                
                                                            </td>
                                                            <td><?php echo $data['views'] ?></td>
                                                            <td><?php echo $data['created_by'] ?></td>
                                                           
                                                             <td>
                                                                 <?php
                                                                if($data['status'] == 'published' ){
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
                                                                <a href="new-page.php?page_id=<?php echo $data['id'] ?>" class="btn btn-blue btn-icon"><i data-feather="edit"></i></a>
                                                            </td>
                                                            <td>
                                                                <a onclick="return confirm('Are you sure you want to Remove?');" href="?page_id=<?php echo $data['id'] ?>" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></a>
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
                </main>
<?php include_once('include/footer.php') ?>

         