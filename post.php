<?php 
    
    include_once('connection.php');

    $query_post = "select * from posts where post_id  = ".$_REQUEST['post_id'];
    $result_post = mysqli_query($con,$query_post) or die(mysqli_error($con));
    $post = mysqli_fetch_array($result_post);

    $like_query = "SELECT COUNT(like_id) AS likes FROM likes where post_id = ".$_REQUEST['post_id'];
    $result_like = mysqli_query($con,$like_query) or die(mysqli_error($con));

    $likes_post = mysqli_fetch_array($result_like);


    $query_post_view_tags = "select * from posts where post_id = ".$_REQUEST['post_id'];
    $query_post_view_tags_result = mysqli_query($con,$query_post_view_tags) or die(mysqli_error($con));

    $tags = mysqli_fetch_array($query_post_view_tags_result);

    $tag = $tags['post_tags'];
    $tag_arr = explode(',', $tag);


    $category_post = "select * from posts where post_category = '".$post['post_category']."' LIMIT 5 ";
    $category_post_result = mysqli_query($con,$category_post) or die(mysqli_error($con));
    
    $category_post1 = "select * from posts where post_category = '".$post['post_category']."' LIMIT 5 ";
    $category_post_result1 = mysqli_query($con,$category_post1) or die(mysqli_error($con));

    $c = $post['post_category'];
    $c1 = $post['post_id'];
    
    if(isset($_REQUEST['showmore']) == true ){
         $comment = "select * from comments,users where users.user_id =  comments.com_user_id and com_post_id = '".$_REQUEST['post_id']."'    order by com_id desc ";
        $comment_result=mysqli_query($con,$comment) or die(mysqli_error($con));
    }
    else
    {
         $comment = "select * from comments,users where users.user_id =  comments.com_user_id and com_post_id = '".$_REQUEST['post_id']."'    order by com_id desc LIMIT 15 ";
        $comment_result=mysqli_query($con,$comment) or die(mysqli_error($con));
        
        
    }
    
   
        
        
    if(!isset($_SESSION["n".$c1])){
         $_SESSION["n".$c1] = true ;
        $view  = $post['post_views'] + 1;
        $query="update posts set post_views = '$view'   where post_id =  ".$_REQUEST['post_id'];
        mysqli_query($con,$query) or die(mysqli_error($con));


         $q = "select * from categories where category_name = '".$post['post_category']."' " ;
        $q1 = mysqli_query($con,$q) or die(mysqli_error($con));
        $q2 = mysqli_fetch_array($q1);

        $view = $q2['total_post_views'] + 1;
         $query="update categories set total_post_views = '$view'   where category_name =  '".$post['post_category']."' ";
        mysqli_query($con,$query) or die(mysqli_error($con));

        

    }

    if(isset($_REQUEST['btncm'])  ){
        if(isset($_SESSION['userid'])){
            $input = date('Y-M-d H:i:s'); 
            $d = date("Y-M-d H:i:s",strtotime($input));
             $insert = "insert into comments values (NULL,'".$_REQUEST['post_id']."','".$_REQUEST['subject']."','".$_SESSION['userid']."','".$_SESSION['nickname']."','$d','unapproved') ";
           
             mysqli_query($con,$insert) or die(mysqli_error($con));
            $view = $post['post_comment_count'] + 1;
             $query="update posts set post_comment_count = '$view'   where post_id =  '".$_REQUEST['post_id']."' ";

            mysqli_query($con,$query) or die(mysqli_error($con));


            //send mail
            
            $to = 'itsallaboutapp@gmail.com';
            $subject = $_SESSION['username'].' has comment on Post ' ;
            
            $htmlContent = $_REQUEST['subject'];
            
            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // Additional headers
            $email = $_SESSION['email'];
            $headers .= 'From:'.$email . "\r\n";
            $headers .= 'Cc: '. $email . "\r\n";
              
            
            // Send email
            if(mail($to,$subject,$htmlContent,$headers)):
                $successMsg = 'Email has sent successfully.';
            else:
                $errorMsg = 'Email sending fail.';
            endif;
        
            header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            exit;
        }
        else{
            header("Location: posts.php?post_id=".$_REQUEST['post_id']."&comment=true");

        }

    }

    if(isset($_REQUEST['btnreply'])){
         if(isset($_SESSION['userid'])){
            $input = date('Y-M-d H:i:s'); 
            $d = date("Y-M-d H:i:s",strtotime($input));
            $insert = "insert into cmt_reply values (NULL,'".$_REQUEST['com_id']."','$d','".$_SESSION['userid']."','unapproved',NULL,'".$_REQUEST['reply_to_comm']."') ";
            mysqli_query($con,$insert) or die(mysqli_error($con));

            $view = $post['post_comment_count'] + 1;
             $query="update posts set post_comment_count = '$view'   where post_id =  '".$_REQUEST['post_id']."' ";
            mysqli_query($con,$query) or die(mysqli_error($con));


            //send mail
            
            // $to = 'mayaonly18@gmail.com';
            // $subject = $_SESSION['username'].' has reply in comment on Post ' ;
            
            // $htmlContent = $_REQUEST['subject'];
            
            // // Set content-type header for sending HTML email
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // // Additional headers
            // $headers .= 'From: donlymaya1@gmail.com>' . "\r\n";
            // $headers .= 'Cc: donlymaya1@gmail.com' . "\r\n";
            
            
            // // Send email
            // if(mail($to,$subject,$htmlContent,$headers)):
            //     $successMsg = 'Email has sent successfully.';
            // else:
            //     $errorMsg = 'Email sending fail.';
            // endif;
        
             header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
             exit;
        }
    }

    include_once('header.php');



?>
<style type="text/css">
    .img-sm {
    width: 46px;
    height: 46px;
}

.panel {
    box-shadow: 0 2px 0 rgba(0,0,0,0.075);
    border-radius: 0;
    border: 0;
    margin-bottom: 15px;
}

.panel .panel-footer, .panel>:last-child {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.panel .panel-heading, .panel>:first-child {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.panel-body {
    padding: 25px 20px;
}


.media-block .media-left {
    display: block;
    float: left
}

.media-block .media-right {
    float: right
}

.media-block .media-body {
    display: block;
    overflow: hidden;
    width: auto
}

.middle .media-left,
.middle .media-right,
.middle .media-body {
    vertical-align: middle
}

.thumbnail {
    border-radius: 0;
    border-color: #e9e9e9
}

.tag.tag-sm, .btn-group-sm>.tag {
    padding: 5px 10px;
}

.tag:not(.label) {
    background-color: #fff;
    padding: 6px 12px;
    border-radius: 2px;
    border: 1px solid #cdd6e1;
    font-size: 12px;
    line-height: 1.42857;
    vertical-align: middle;
    -webkit-transition: all .15s;
    transition: all .15s;
}
.text-muted, a.text-muted:hover, a.text-muted:focus {
    color: #acacac;
}
.text-sm {
    font-size: 0.9em;
}
.text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
    line-height: 1.25;
}

.btn-trans {
    background-color: transparent;
    border-color: transparent;
    color: #929292;
}

.btn-icon {
    padding-left: 9px;
    padding-right: 9px;
}

.btn-sm, .btn-group-sm>.btn, .btn-icon.btn-sm {
    padding: 5px 10px !important;
}

.mar-top {
    margin-top: 15px;
}
.fas{
  color: #448aff;
  transition: .4s;
}

.fas:hover{
  color: #2962ff;
}

#savebtn i{
    color:#ff6f61
}

#savebtn i:hover{
  color: #111;
}

.tw{
    color:#ff6f61;
}
.tw:hover{
    color:#111;
}
a:hover{
  color: #111;
}


</style>
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Post</a></li>
                    <li class="breadcrumb-item active">Read Post</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Single News Start-->
        <div class="single-news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="sn-container">
                            <div class="sn-img">
                                <img  src="img/post/<?php echo $post['post_image'] ?>" />
                                
                            </div>
                            <div class="sn-content">
                                <h1 class="sn-title"><?php echo $post['post_title'] ?></h1>
                                <?php echo $post['post_detail'] ?>
                                <hr>
                                <div>
                                    <?php
                                        if(isset($_SESSION['userid'])){
                                             $like_query1 = "SELECT COUNT(like_id) AS likes FROM likes where user_id = '".$_SESSION['userid']."' and post_id = ".$_REQUEST['post_id'];
                                            $result_like1 = mysqli_query($con,$like_query1) or die(mysqli_error($con));

                                            $likes_post1 = mysqli_fetch_array($result_like1);

                                            if($likes_post1['likes'] == 1){
                                                ?>
                                                <a href="javascript:void(0)" ><i onclick="toggle()" id='likebtn' style="font-size:28px" class="fas fa-thumbs-up"></i> </a><span id="likes_number" >(<?php echo $likes_post['likes'] ?>)</span>
                                                <?php
                                            }
                                            else
                                            { ?>
                                                <a href="javascript:void(0)" ><i onclick="toggle()" id='likebtn' style="font-size:28px" class="far fa-thumbs-up"></i></a> <span id="likes_number" >(<?php echo $likes_post['likes'] ?>)</span>
                                            <?php
                                            }
                                           
                                        }
                                         else
                                            { ?>

                                                <a href="javascript:void(0)" ><i onclick="toggle()" id='likebtn4' style="font-size:28px" class="far fa-thumbs-up"></i></a> <span id="likes_number" >(<?php echo $likes_post['likes'] ?>)</span>

                                            <?php
                                            }
                                         
 
                                    ?>

                                    <?php
                                        if(isset($_SESSION['userid'])){
                                             $like_query2 = "SELECT COUNT(save_id) AS save FROM saved_post where user_id = '".$_SESSION['userid']."' and post_id = ".$_REQUEST['post_id'];
                                            $result_like2 = mysqli_query($con,$like_query2) or die(mysqli_error($con));

                                            $likes_post2 = mysqli_fetch_array($result_like2);

                                            if($likes_post2['save'] == 1){
                                                ?>
                                                 <a onclick="alert('Already Saved Post')" href="javascript:void(0)">
                                                     <i  id='' style="font-size:28px" class="fa fas ml-4 fa-bookmark"></i> 
                                                 </a>

                                                <?php
                                            }
                                            else
                                            { ?>
                                                <a id="savebtn" href="javascript:void(0)">
                                                     <i  style="font-size:28px;" class="fa fas ml-4 fa-bookmark-o"></i> 
                                                 </a>
                                            <?php
                                            }
                                           
                                        }
                                         else
                                            { ?>

                                                <a id='savebtn' href="javascript:void(0)">
                                                     <i   style="font-size:28px" class="fa fas ml-4 fa-bookmark-o"></i> 
                                                 </a>

                                            <?php
                                            }
                                         
 
                                    ?>
                                     
                                    <div class="pull-right" >
                                           <a  target="_blank" href="https://web.whatsapp.com/send?text=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
                                            <i  style="font-size:29px" class="fab fa-whatsapp ml-2"></i>
                                    </a> 
                                    
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
                                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                       target="_blank" title="Share on Facebook">
                                       <i class="fab fa-facebook-f ml-1"  style="font-size:26px" ></i>
                                    </a>

                                    <a  target="_blank"  type="button" role="button" title="Share on twitter"
                                   href="https://twitter.com/intent/tweet?url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
                                   >
                                  <i class=" tw fab fa-twitter ml-1" style="font-size:29px"></i>
</a>
                                    </div>
                                  

                                </div>
                                 
                            </div>
                        </div>
                        <div class="sn-related">
                            <h2>Related News</h2>
                            <div class="row sn-slider">
                                
                                    <?php
                                        while ($k = mysqli_fetch_array($category_post_result)) {
                                             ?>
                                             <div class="col-md-4">
                                                <div class="sn-img">
                                                    <img style="height:140px" src="img/post/<?php echo $k['post_image'] ?>" />
                                                    <div class="sn-title">
                                                        <a  href="post.php?post_id=<?php echo $k['post_id'] ?>"><?php echo $k['post_title'] ?></a>
                                                    </div>
                                                </div>
                                                </div>
                                             <?php
                                         } 
                                    ?>
                                    
                                
                                
                            </div>
                        </div>
                        <hr/>
                                    <div class="container bootdey" style="padding-left: 0px;padding-right: 0px;" >
        <div class="col-md-12 bootstrap snippets" style="padding-left: 0px;padding-right: 0px;" >
        <div class="panel" style="padding-left: 0px;padding-right: 0px;" >
          <div class="panel-body" style="padding-left: 0px;padding-right: 0px;">
            <form action="" method="post">

            <textarea required="" class="form-control" rows="2" name="subject" placeholder="Comment here....."></textarea>
            <div class="mar-top clearfix">
                <?php
                    if(isset($_SESSION['userid']))
                    { ?>
                        <button name="btncm" class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Comment</button>
                        <?php
                    } 
                    else
                    { ?>
                        <button  onclick="openLoginModal();" class="btn btn-sm btn-primary pull-right" type="button"><i class="fa fa-pencil fa-fw"></i> Comment</button>
                        <?php
                    }
                ?>
              
          </form>
          <?php
            if(isset($_SESSION['userid'])){
                ?>
                <img style="width:45px;border-radius:50%;padding-top:1px"  src="<?php echo $_SESSION['image'] ?>">
                                 <span>Hi , <?php echo $_SESSION['nickname'] ?></span>
                <?php
            }
            else
            { ?>
                <a class="btn btn-trans btn-icon fa fa-user add-tooltip" href="#"  onclick="openLoginModal();"> Login</a>
                <?php
            }
          ?>
              
             
            </div>
          </div>
        </div>
<div class="panel">
    <div class="panel-body">
    <!-- Newsfeed Content -->
    <!--===================================================-->

    <!-- article add -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9997477233710348"
    crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
        style="display:block; text-align:center;"
        data-ad-layout="in-article"
        data-ad-format="fluid"
        data-ad-client="ca-pub-9997477233710348"
        data-ad-slot="5156294651"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <!-- ------------------------------------- -->

    
    <?php
    $i =0;
    while ($cm = mysqli_fetch_array($comment_result) ) { 
        $i++;
    ?>
    <div class="media-block">

      <a class="media-left" href="#"><img class="img-circle img-sm" alt="Profile Picture" src="img/<?php echo $cm['user_photo']  ?>"></a>
      <div class="media-body">
        <div class="mar-btm ml-2">
             <div class="pull-right" >
                <?php
                    if(isset($_SESSION['userid']) && $_SESSION['userid'] == $cm['com_user_id'])
                    { 
                        if($cm['com_status'] == 'unapproved')
                        {
                            ?>
                            <label class="text-warning" > Unapproved </label>
                            <?php
                        }
                        else
                        { ?>
                            <label class="text-success" >Approved</label>
                        <?php
                        }
                     
                    } 

                ?>
          </div>
          <a href="#" class="btn-link text-semibold media-heading box-inline"><?php echo $cm['com_user_name'] ?></a>
           <p class="text-muted text-sm"><i class="fa fa-clock fa-lg"></i>  <?php echo  substr($cm['com_date'], 0, 11);  ?>

       </p>
      
         
          <div class="pull-right" >
               <a  class="btn btn-sm btn-default btn-hover-primary reply" cm_id = "<?php echo $cm['com_id'] ?>" href="javascript:void(0)"> <i class="fa fa-pencil" ></i> Reply</a>
          </div>

        </div>
        <p><?php echo $cm['com_detail'] ?></p>
         <div class="reply_div<?php echo $cm['com_id'] ?> reply_div" >
           
       </div>
       <br>
        <hr>

        <!-- Comments -->
        <?php
            $comment_reply = "select * from cmt_reply where comm_id = '".$cm['com_id']."'    order by comm_id  ";
        $comment_reply_result=mysqli_query($con,$comment_reply) or die(mysqli_error($con)); 
        while ($c = mysqli_fetch_array($comment_reply_result)) {
            if($c['admin_id'] == NULL || $c['admin_id'] == 0 ){
                $q = "select * from users where user_id =".$c['user_id'];
                $qd = mysqli_query($con,$q) or die(mysqli_error($con));
                $ud = mysqli_fetch_array($qd);
                $name = $ud['user_nickname'];
                $photo = $ud['user_photo'];

            }
            else
            {
                $q = "select * from admin where id =".$c['admin_id'];
                $qd = mysqli_query($con,$q) or die(mysqli_error($con));
                $ud = mysqli_fetch_array($qd);
                $name = $ud['username']." : admin";
                if($ud['image'] == "")
                
                    $photo = 'nouser.jpg';
                else

                    $photo = $ud['image'];
            }
            ?>
            <div>
          <div class="media-block">
            <a class="media-left" href="#"><img class="img-circle img-sm" alt="Profile Picture" src="img/<?php echo $photo ?>"></a>
            <div class="media-body">
              <div class="mar-btm">
                <div class="pull-right" >
                <?php
                    if(isset($_SESSION['userid']) && $_SESSION['userid'] == $c['user_id'])
                    { 
                        if($c['status'] == 'unapproved')
                        {
                            ?>
                            <label class="text-warning" > Unapproved </label>
                            <?php
                        }
                        else
                        { ?>
                            <label class="text-success" >Approved</label>
                        <?php
                        }
                     
                    } 

                ?>
          </div>
                <a href="#" class="btn-link ml-2 text-semibold media-heading box-inline"><?php echo $name ?></a>
                 <p class="text-muted text-sm ml-2 "><i class="fa fa-clock fa-lg"></i> <?php echo  substr($c['reply_on'], 0, 11);  ?>
              </div>
              <p><?php echo $c['reply'] ?></p>
               <div class="pull-right" >
              <a  class="btn btn-sm btn-default btn-hover-primary sub_reply" cm_id = "<?php echo $cm['com_id'] ?>" href="javascript:void(0)"> <i class="fa fa-pencil" ></i> Reply</a>
          </div>
            <div class="sub_reply_div<?php echo $cm['com_id'] ?> sub_reply_div" >
           
       </div>
       <br>
              <hr>
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
    <!--===================================================-->
    <!-- End Newsfeed Content -->


    <?php
                    if(!isset($_REQUEST['showmore']) && $i > 15 ){
                        ?>
                            <div class="row" >
                                <div class="col-md-12" >
                                     <center>
                                    <a style="background-color:#ff6f61;border-color:#ff6f61;" href="?post_id=<?php echo $_REQUEST['post_id'] ?>&showmore=true" class="btn btn-primary" >See All Comments</a>
                                </center>
                                </div>
                   
                            </div>
                            <br/>
                            <br/>
                        <?php
                    } 
                ?>
                
    <!--===================================================-->
    <!-- End Newsfeed Content -->
  </div>
</div>
</div>
</div>
        
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h2 class="sw-title">In This Category</h2>
                                <div class="news-list">
                                    <?php 
                                        while ($j = mysqli_fetch_array($category_post_result1
                                            )) {
                                        ?>
                                            <div class="nl-item">
                                                <div class="nl-img">
                                                    <img style="height:90px" src="img/post/<?php echo $j['post_image'] ?>" />
                                                   
                                                </div>
                                                <div class="nl-title">
                                                    <a href="post.php?post_id=<?php echo $j['post_id'] ?>"><?php echo $j['post_title'] ?></a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    ?>
                                    
                                    
                                </div>
                            </div>
                            
                           
                            
                           

                            <div class="sidebar-widget">
                                <h2 class="sw-title">Categories</h2>
                                <div class="category">
                                    <ul>
                                        
                                        <?php
                                         while ($da = mysqli_fetch_array($result_post_c))
                                         {
                                             ?>
                                             <li><a href="category.php?category_name=<?php echo $da['category_name'] ?>"> <?php echo $da['category_name'] ?></a><span></span></li>
                                             <?php
                                         }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            
                            <div class="sidebar-widget">
                                <h2 class="sw-title">Tags Cloud</h2>
                                <div class="tags">
                                    <?php
                                        foreach ($tag_arr as $key => $value) {
                                            ?>
                                    <a href=""><?php echo $value ?></a>

                                            <?php
                                         } 
                                    ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single News End-->        
        
<?php
    include_once('footer.php');

?>
<script type="text/javascript">
    const btn = document.getElementById("likebtn");

function toggle() {

    <?php
        if(isset($_SESSION['userid']))
        { ?>
            btn.classList.toggle("far");
   btn.classList.toggle("fas");
            <?php

        }
        else
        { ?>
            openLoginModal();
        <?php
        }
     ?>
   
}
$("#savebtn").click(function(){
    
   
         var post_id = <?php echo $_REQUEST['post_id'] ?>;
        $.ajax({
          url: "save.php",
          method:'post',
          data:{post_id:post_id},
          success: function(html){
            location.reload();
          }
        });
        
});
$("#likebtn").click(function(){
    
     var post_id = <?php echo $_REQUEST['post_id'] ?>;
        $.ajax({
          url: "like.php",
          method:'post',
          data:{post_id:post_id},
          success: function(html){
            $("#likes_number").html('('+html+')' );
          }
        });
});
</script>