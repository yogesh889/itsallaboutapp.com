<?php 
include_once('connection.php');



include_once('header.php');

?>

       

        <!-- Main News Start-->
        <div class="main-news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <?php
                            if(isset($msg1)){
                            	?>
                            	<h2>No result found</h2>
                            	<?php 
                            }
                            else {
                            	?>
                            	<?php
                                while ($k = mysqli_fetch_array($result_post2)) {
                            ?>
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                             <img src="img/post/<?php echo $k['post_image'] ?>" />
                                                            <div class="tn-title">
                                                            <a href="post.php?post_id=<?php echo $k['post_id'] ?>"><?php echo $k['post_title'] ?></a>
                                                            </div>
                                        </div>
                                    </div>
                            <?php  
                                 } 
                             }
                            ?>
                            
                            
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>
        <!-- Main News End-->

       
<?php include_once('footer.php') ?>
