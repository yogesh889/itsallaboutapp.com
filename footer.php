 <!-- Footer Start -->
 <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Get in Touch</h3>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i>116/5 Agarwal Farm Mansrover, Jaipur, India</p>
                                <p><i class="fa fa-envelope"></i>Itsallaboutapp@gmail.com</p>
                                <p><i class="fa fa-phone"></i>+91 88751 47212</p>
                                <div class="social">
                                    <a href="https://twitter.com/ItsallaboutApp" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.facebook.com/Itsallaboutapp-102830555508565" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.linkedin.com/company/itsallaboutapp/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.instagram.com/itsallaboutapp/" target="_blank"><i class="fab fa-instagram"></i></a>
                                    <!-- <a href=""><i class="fab fa-youtube" target="_blank"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Useful Links</h3>
                            <ul>
                                <?php
                                while ($m = mysqli_fetch_array($query_page_result1)) {
                                    ?>
                                        <li><a href="page.php?page=<?php echo $m['id'] ?>"><?php echo $m['page_title'] ?></a></li>

                                    <?php
                                 } 
                            ?>
                   <li><a href="contact.php">Contact us</a></li> 
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">

                            <h3 class="title">Quick Links</h3>
                            <ul>
                                <?php
                                $query_post = "select * from categories order by total_post_views desc  ";


                                $result_post_c = mysqli_query($con,$query_post) or die(mysqli_error($con));

                                        while ($dt = mysqli_fetch_array($result_post_c)) {
                                            ?>
                                               <li> <a href="category.php?category_name=<?php echo $dt['category_name'] ?>" >
                                                    <?php echo $dt['category_name'] ?>
                                                </a></li>

                                            <?php
                                        }
                                     ?>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3 class="title">Newsletter</h3>
                            <div class="newsletter">
                                <p>
                                   Update with us
                                </p>
                                <form>
                                    <input class="form-control" type="email" placeholder="Your email here">
                                    <button class="btn">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        


        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script src="js/login-register.js" type="text/javascript"></script>
        <?php 
            if(!isset($_SESSION['userid']) & isset($_REQUEST['comment']) )
            { ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        openLoginModal();
                    });
                </script>
                <?php

            }
        ?>
        

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <?php
            if(isset($_REQUEST['success'])  ){
                ?>
                <script type="text/javascript">
                    toastr.success('Thank you! for message,We will respond you ASAP');
                </script>
                <?php
            }
           

            
         ?>


 <?php
            if(isset($_REQUEST['register'])  ){
                ?>
                <script type="text/javascript">
                    toastr.success('Thank you! for registration,Please login Now ');
                </script>
                <?php
            }
           

            
         ?>

         <?php
            if(isset($_REQUEST['register'])  ){
                ?>
                <script type="text/javascript">
                    toastr.success('Login successfully!');
                </script>
                <?php
            }
           

            
         ?>

         <script type="text/javascript">
             $(document).ready(function(){
                $(".reply").click(function(){
                    var com_id = $(this).attr('cm_id');
                    $(".reply_div").html("");
                    $(".sub_reply_div").html("");

                    var html = '<form action="" method="post" ><input class="form-control"  type="text" name="reply_to_comm"><input type="hidden" name="com_id" value="'+com_id+'" ><?php if(isset($_SESSION['userid'])) { ?> <button name="btnreply" class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Reply</button><?php } else { ?> <button name="btnreply" onclick="openLoginModal()" class="btn btn-sm btn-primary pull-right" type="button"><i class="fa fa-pencil fa-fw"></i> Reply</button> <?php } ?> </form>';

                    $(".reply_div"+com_id).html(html);
                });

                 $(".sub_reply").click(function(){
                    var com_id = $(this).attr('cm_id');
                    $(".sub_reply_div").html("");
                    $(".reply_div").html("");

                    var html = '<form action="" method="post" ><input class="form-control"  type="text" name="reply_to_comm"><input type="hidden" name="com_id" value="'+com_id+'" ><?php if(isset($_SESSION['userid'])) { ?> <button name="btnreply" class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Reply</button><?php } else { ?> <button name="btnreply" onclick="openLoginModal()" class="btn btn-sm btn-primary pull-right" type="button"><i class="fa fa-pencil fa-fw"></i> Reply</button> <?php } ?> </form>';

                    $(".sub_reply_div"+com_id).html(html);
                })
             });

             
         </script>

         <script type="text/javascript">
             $("#google_login").click(function(){
                <?php
                    $_SESSION['google_log'] = true; 
                ?>
             });

             $("#facebook_login").click(function(){
                <?php
                    $_SESSION['fb_log'] = true; 
                ?>
             });
         </script>

    </body>
</html>