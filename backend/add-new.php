<?php
include_once('../connection.php');
include_once('auth.php'); 
 ?>
<?php
    $query ="select * from categories ";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
?>
<?php
     if(isset($_REQUEST["pid"]))
    {
        $query="select * from posts where post_id= ".$_REQUEST["pid"];
        $datas=mysqli_query($con,$query) or die(mysqli_error($conn));
        $data=mysqli_fetch_array($datas);
    }

    if(isset($_POST['btnsubmit'])){
        extract($_POST);
         if(isset($_REQUEST["pid"]))
        {
            $query="select * from posts where post_id= ".$_REQUEST["pid"];
            $datas=mysqli_query($con,$query) or die(mysqli_error($con));
            $data=mysqli_fetch_array($datas);

            unlink('../img/post/'.$data['post_image']);
            $filename=date("y-m-s").$_FILES["post_image"]["name"];
            move_uploaded_file($_FILES["post_image"]["tmp_name"],"../img/post/".$filename);
            
            $post_detail = mysqli_real_escape_string($con, $post_detail);
            $query="update posts set post_title = '$post_title' , post_detail = '$post_detail' , post_category = '$post_category' , post_image = '$filename' , post_status = '$post_status', post_tags = '$post_tags' where post_id =  ".$_REQUEST['pid'];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('location:allpost.php?toster=update'); 
        }
        else
        {
            $filename=date("y-m-s").$_FILES["post_image"]["name"];
            move_uploaded_file($_FILES["post_image"]["tmp_name"],"../img/post/".$filename);
             $post_detail = mysqli_real_escape_string($con, $post_detail);
                $query="insert into posts values(null,'$post_title','$post_detail','$post_category','$filename','$post_status','".$_SESSION['admin_name']."',0,0,'$post_tags',now(),1) ";
             
            mysqli_query($con,$query) or die(mysqli_error($con));

             $q = "select * from categories where category_name = '$post_category' " ;
            $q1 = mysqli_query($con,$q) or die(mysqli_error($con));
            $q2 = mysqli_fetch_array($q1);

            $view = $q2['category_total_post'] + 1;
             $query="update categories set category_total_post = '$view'   where category_name =  '$post_category' ";
            mysqli_query($con,$query) or die(mysqli_error($con));
            header("location:allpost.php?toster=add");
          
        }
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
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Try Creating New Post</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">
                                <?php
                                    if(isset($data)){
                                        echo "Edit Post";
                                    } 
                                    else
                                    {
                                        echo "Create New Post";
                                    }
                                ?>
                                
                            </div>
                            <div class="card-body">
                                <form action="" enctype="multipart/form-data"  method="post">
                                    <div class="form-group">
                                        <label for="post-title">Post Title:</label>
                                        <input value="<?php if(isset($data)) { echo $data['post_title']; } ?>" class="form-control" name="post_title" id="post-title" type="text" placeholder="Post title ..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-status">Post Status:</label>
                                        <select name="post_status" class="form-control" id="post-status">
                                            <option value="published" <?php if( isset($data) && $data['post_status'] == "published") echo "selected"; ?> >Published</option>
                                            <option value="draft" <?php if( isset($data) && $data['post_status'] == "draft") echo "selected"; ?> >Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="select-category">Select Category:</label>
                                        <select name="post_category" class="form-control" id="select-category">
                                            <?php
                                                while ($category = mysqli_fetch_array($result)) {

                                                    if( isset($data) && $category['category_name'] == $data['post_category'] ){
                                                        ?>
                                                             <option selected="" value="<?php echo $category['category_name'] ?>" ><?php echo $category['category_name'] ?></option>
                                                        <?php
                                                    }
                                                    else
                                                    { ?>
                                                         <option value="<?php echo $category['category_name'] ?>" ><?php echo $category['category_name'] ?></option>
                                                    <?php
                                                    }
                                            ?>
                                                   
                                            <?php
                                                 } 
                                            ?>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <hr>
                                        <?php
                                            if(isset($data)) {
                                                ?>
                                                    <img width="150" src="../img/post/<?php echo $data['post_image'] ?>">
                                                <?php
                                            }
                                        ?>
                                        <br>
                                        <input  name="post_image" class="form-control" id="post-title" type="file" />
                                    </div>`

                                    <div class="form-group">
                                        <label for="post-content">Post Details:</label>
                                        <textarea style="width: 100px; height: 100px" id="editor" name="post_detail" class="form-control" placeholder="Type here..." id="post-content" rows="9"><?php if(isset($data)){ echo $data['post_detail']; } ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="post-tags">Post Tags:</label>
                                        <textarea name="post_tags" class="form-control" placeholder="Tags..." id="post-tags" rows="3"><?php if(isset($data)){ echo $data['post_tags']; } ?></textarea>
                                    </div>
                                    <input class="btn btn-primary mr-2 my-1" type="submit" name="btnsubmit"  value="Submit Now">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

               


<?php include_once('include/footer.php') ?>
