<?php 
include_once('connection.php');

if(!isset($_SESSION['userid'])){
    header('location:index.php');
}




 $query_post1 = "select * from saved_post,posts where posts.post_id = saved_post.post_id and user_id =   ".$_SESSION['userid'];
$result_post1 = mysqli_query($con,$query_post1) or die(mysqli_error($con));


if(isset($_REQUEST['unsaved']) && isset($_REQUEST['post_id']) ){
    $q = " delete from saved_post where post_id= '".$_REQUEST['post_id']."' and user_id = ".$_SESSION['userid'];
            mysqli_query($con,$q) or die(mysqli_error($con));
            header('location:savedposts.php');
}

include_once('header.php');

?>

       

        <!-- Main News Start-->
        <div class="main-news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <?php
                                while ($k = mysqli_fetch_array($result_post1)) {
                            ?>
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                             <img src="img/post/<?php echo $k['post_image'] ?>" />
                                                            <div class="tn-title">
                                                            <a href="post.php?post_id=<?php echo $k['post_id'] ?>"><?php echo $k['post_title'] ?></a>

                                                            </div>
                                                            <a class="btn btn-danger" href="?unsaved=true&post_id=<?php echo $k['post_id'] ?>">Unsaved</a>
                                        </div>
                                    </div>
                            <?php  
                                 } 
                            ?>
                            
                            
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>
        <!-- Main News End-->

       
<?php include_once('footer.php') ?>
