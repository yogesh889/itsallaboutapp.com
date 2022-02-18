<?php

    include_once('../connection.php');
    include_once('auth.php'); 

    $query = "select * from posts order by post_id desc";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));

    extract($_REQUEST);
    if( isset($postdeleteid))
    {
        $query = "delete from posts where post_id =".$postdeleteid;
        mysqli_query($con,$query) or die(mysqli_error($con));

        header('location:allpost.php');
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
                                    <div class="page-header-icon"><i data-feather="layout"></i></div>
                                    <span>All Posts</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Posts</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Category</th>
                                                <th>Author</th>
                                                <th>Image</th>
                                                <th>Date</th>
                                                <th>Tags</th>
                                                <th>Comments</th>
                                                <th>Views</th>
                                                <th>Likes</th>
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
                                                            <a style="width:70px; height: 50px" href="#"><?php echo $data['post_title'] ?></a>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if($data['post_status'] == 'published' ){
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
                                                        <td><?php echo $data['post_category'] ?></td>
                                                        <td><?php echo $data['post_author'] ?></td>
                                                        <td>
                                                            <img style="width:70px; height: 50px" src="../img/post/<?php echo $data['post_image'] ?>">
                                                        </td>
                                                        <td><?php echo date("Y-m-d",strtotime($data['created_on'])); ?></td>
                                                       
                                                        <td><?php echo $data['post_tags'] ?></td>
                                                        <td>
                                                            <a href="#"><?php echo $data['post_comment_count'] ?></a>
                                                        </td>
                                                        <td><?php echo $data['post_views'] ?></td>
                                                        <td>
                                                            <?php 
                                                                 $like_query = "SELECT COUNT(like_id) AS likes FROM likes where post_id = ".$data['post_id'];
                                                                 
                                            $result_like = mysqli_query($con,$like_query) or die(mysqli_error($con));
                                        
                                            $likes_post = mysqli_fetch_array($result_like);
                                            echo $likes_post['likes'];
                                                                    ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <a href="add-new.php?pid=<?php echo $data['post_id'] ?>" class="btn btn-blue btn-icon"><i data-feather="edit"></i></a>
                                                        </td>
                                                        <td>
                                                            <a onclick="return confirm('Are you sure you want to Remove?');"  href="?postdeleteid=<?php echo $data['post_id'] ?>" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></a>
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
<?php
    if(isset($_REQUEST['toster']) && $_REQUEST['toster'] == 'add' ){
        ?>
        <script type="text/javascript">
            toastr.success('Post Added Successfully!');
        </script>
        <?php
    }
    if(isset($_REQUEST['toster']) && $_REQUEST['toster'] == 'update' )
    {
         ?>
        <script type="text/javascript">
            toastr.success('Post Updated Successfully!');
        </script>
        <?php
    }
 ?>