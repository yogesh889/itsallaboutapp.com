<?php 
include_once('connection.php');

 $query_post1 = "select * from pages where id = '".$_REQUEST['page']."'    ";
$result_post1 = mysqli_query($con,$query_post1) or die(mysqli_error($con));
$k = mysqli_fetch_array($result_post1);


include_once('header.php');

?>

       

        <!-- Main News Start-->
        <div class="main-news">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="row">
                              <div class="col-md-8">
                                        <div class="mn-img">
                                            
                                                            <div class="tn-title">
                                                            <h2>
                                                                <a href="#"><?php echo $k['page_title'] ?></a>
                                                            </h2>
                                                            </div>
                                                            <div>
                                                                <?php echo $k['page_data'] ?>
                                                            </div>
                                        </div>
                                    </div>
                          
                            
                            
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>
        <!-- Main News End-->

       
<?php include_once('footer.php') ?>
