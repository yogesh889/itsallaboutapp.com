<?php 
include_once('connection.php');





if(isset($_REQUEST['seemore'])){
    $query_c = "select * from categories order by total_post_views desc  ";
    $result_c = mysqli_query($con,$query_c) or die(mysqli_error($con)); 
}
else
{
    $query_c = "select * from categories order by total_post_views desc LIMIT 4  ";
    $result_c = mysqli_query($con,$query_c) or die(mysqli_error($con));
}


$latest_post = "select * from posts order by created_on desc LIMIT 2 ";
$latest_post_result = mysqli_query($con,$latest_post) or die(mysqli_error($con));


$query_post_view = "select * from posts order by post_views desc LIMIT 4";
$query_post_view_result = mysqli_query($con,$query_post_view) or die(mysqli_error($con));

$query_post_view_a = "select * from posts order by created_on desc LIMIT 9";
$query_post_view_a_result = mysqli_query($con,$query_post_view_a) or die(mysqli_error($con));

$query_post_view_b = "select * from posts order by post_views desc LIMIT 10";
$query_post_view_b_result = mysqli_query($con,$query_post_view_b) or die(mysqli_error($con));

include_once('header.php');

?>

        <!-- Top News Start-->
        <div class="top-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 tn-left">
                        <div class="row tn-slider">

                            <?php
                                while ($latest=mysqli_fetch_array($latest_post_result)) {
                                     ?>
                                        <div class="col-md-6">
                                            <div class="tn-img">
                                                <img style="height:380px" src="img/post/<?php echo $latest['post_image'] ?>" />
                                                <div class="tn-title">
                                                    <a href="post.php?post_id=<?php echo $latest['post_id'] ?>"><?php echo $latest['post_title'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                     <?php
                                 } 
                            ?>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-6 tn-right">
                        <div class="row">
                            <?php
                                while ($most_view=mysqli_fetch_array($query_post_view_result)) {

                            ?>
                            
                                    <div class="col-md-6">
                                <div class="tn-img">
                                   <img style="height:190px" src="img/post/<?php echo $most_view['post_image'] ?>" />
                                                <div class="tn-title">
                                                    <a href="post.php?post_id=<?php echo $most_view['post_id'] ?>"><?php echo $most_view['post_title'] ?></a>
                                                </div>
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
        <!-- Top News End-->

        <!-- Category News Start-->
        <div class="cat-news">
            <div class="container">
                <div class="row">
                    <?php
                        while ($rc = mysqli_fetch_array($result_c)) {
                            ?>
                                <div class="col-md-6">
                                    <h2><?php echo $rc['category_name'] ?></h2>
                                    <div class="row cn-slider">
                                        <?php
                                             $category_wise = "select * from posts where post_category = '".$rc['category_name']."' order by post_views desc LIMIT 4";
                                            $category_wise_result = mysqli_query($con,$category_wise) or die(mysqli_error($con)); 

                                            while ($d = mysqli_fetch_array($category_wise_result)) {
                                            ?>
                                                <div class="col-md-6">
                                                    <div class="cn-img">
                                                         <img style="height:190px" src="img/post/<?php echo $d['post_image'] ?>" />
                                                            <div class="tn-title">
                                                            <a href="post.php?post_id=<?php echo $d['post_id'] ?>"><?php echo $d['post_title'] ?></a>
                                                            </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        ?>
                                       
                                    </div>
                                </div>
                            <?php
                        }
                     ?>
                    
                </div>
                <?php
                    if(!isset($_REQUEST['seemore'])){
                        ?>
                            <div class="row" >
                                <div class="col-md-12" >
                                     <center>
                                    <a style="background-color:#ff6f61;border-color:#ff6f61;" href="?seemore=true" class="btn btn-primary" >Show More</a>
                                </center>
                                </div>
                   
                            </div>
                            <br/>
                            <br/>
                        <?php
                    } 
                ?>
                
            </div>
        </div>
        <!-- Category News End-->

       
        
        <!-- Tab News Start-->
       <!--  <div class="tab-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#featured">Featured News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#popular">Popular News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#latest">Latest News</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="featured" class="container tab-pane active">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-1.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-2.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-3.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                            <div id="popular" class="container tab-pane fade">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-4.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-5.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-1.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                            <div id="latest" class="container tab-pane fade">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-2.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-3.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-4.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#m-viewed">Most Viewed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#m-recent">Most Recent</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="m-viewed" class="container tab-pane active">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-5.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-4.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-3.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                            <div id="m-read" class="container tab-pane fade">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-2.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-1.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-3.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                            <div id="m-recent" class="container tab-pane fade">
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-4.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-5.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="img/news-350x223-1.jpg" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="">Lorem ipsum dolor sit amet</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Tab News Start-->

        <!-- Main News Start-->
        <div class="main-news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <?php
                                while ($k = mysqli_fetch_array($query_post_view_a_result)) {
                            ?>
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                             <img style="height:190px" src="img/post/<?php echo $k['post_image'] ?>" />
                                                            <div class="tn-title">
                                                            <a href="post.php?post_id=<?php echo $k['post_id'] ?>"><?php echo $k['post_title'] ?></a>
                                                            </div>
                                        </div>
                                    </div>
                            <?php  
                                 } 
                            ?>
                            
                            
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="mn-list">
                            <h2>Read More</h2>
                            <ul>
                                <?php
                                    while ($x = mysqli_fetch_array($query_post_view_b_result)) {
                                         ?>
                                            <li><a href="post.php?post_id=<?php echo $x['post_id'] ?>"><?php echo $x['post_title'] ?></a></li>

                                         <?php
                                     } 
                                 ?>
                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main News End-->

       
<?php include_once('footer.php') ?>
