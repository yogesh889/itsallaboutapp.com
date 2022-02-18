<?php
include_once('../connection.php');
include_once('auth.php'); 
  $query = "select count(post_id) as total_post from posts";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
    $post = mysqli_fetch_array($result);

     $query1 = "select count(com_id) as total_comments from comments";

    $result1 = mysqli_query($con,$query1);
    $comments = mysqli_fetch_array($result1);

    $query2 = "select count(category_id) as total_category from categories";
    $result2 = mysqli_query($con,$query2) or die(mysqli_error($con));
    $category = mysqli_fetch_array($result2);

    $query3 = "select count(id) as total_page from pages";
    $result3 = mysqli_query($con,$query3) or die(mysqli_error($con));
    $page = mysqli_fetch_array($result3);

     $query_post = "select * from posts order by post_views desc LIMIT 5";
    $result_post = mysqli_query($con,$query_post) or die(mysqli_error($con));
    


 ?>
<?php include_once("include/head.php") ?>
    <?php include_once('include/menu.php') ?>


            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="activity"></i></div>
                                    <span>Dashboard</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Table-->
                    <div class="container-fluid mt-n10">

                    <!--Card Primary-->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>All Posts</p>
                                    <p><?php echo $post['total_post']; ?></p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="allpost.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Comments</p>
                                    <p><?php echo $comments['total_comments']; ?></p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="comments.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Categories</p>
                                    <p><?php echo $category['total_category']; ?></p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="categories.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <p>Pages</p>
                                    <p><?php echo $page['total_page']; ?></p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="pages.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Card Primary-->

                        <div class="card mb-4">
                            <div class="card-header">Most Popular Posts:</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Post Title</th>
                                                <th>Post Category</th>
                                                <th>Total Views</th>
                                                <th>Photo</th>
                                                <th>Author</th>
                                                <th>Posted On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($data = mysqli_fetch_array($result_post)) {
                                                   ?>
                                                     <tr>
                                                <td>
                                                    <a href="#">
                                                        <?php echo $data['post_title'] ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $data['post_category'] ?></td>
                                                <td><?php echo $data['post_views'] ?></td>
                                                 <td>
                                                            <img style="width:100px" src="../img/post/<?php echo $data['post_image'] ?>">
                                                        </td>
                                                        <td><?php echo $data['post_author'] ?></td>
                                                 <td><?php echo date("Y-m-d",strtotime($data['created_on'])); ?></td>
                                               
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