<?php
    include_once('../connection.php');
    include_once('auth.php'); 
 ?>
 
<?php
    
$query="select * from admin where id= ".$_SESSION["admin_id"];
            $datas=mysqli_query($con,$query) or die(mysqli_error($con));
            $data=mysqli_fetch_array($datas);

    if(isset($_POST['btnsubmit'])){
        extract($_POST);
      
            if($_FILES['photo']['name'] != ""){

              $filename=date("y-m-s").$_FILES["photo"]["name"];
                move_uploaded_file($_FILES["photo"]["tmp_name"],"../img/".$filename);

            }
            else{
                $filename = "";
            }
            $query="update admin set username = '$username' , email = '$email' , image = '$filename'  where id =  ".$_SESSION["admin_id"];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('location:profile.php'); 
        
       
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
                                    <div class="page-header-icon"><i data-feather="user"></i></div>
                                    <span>Your Profile</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Profile</div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data" >
                                    <div class="form-group">
                                        <label for="user-name">User Name:</label>
                                        <input name="username" value="<?php echo $data['username'] ?>" class="form-control" id="user-name" type="text" placeholder="User Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-email">User Email:</label>
                                        <input name="email" value="<?php echo $data['email'] ?>" class="form-control" id="user-email" type="email" placeholder="User Email..." />
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input class="form-control" id="post-title" name="photo" type="file" />
                                    </div>
                                    </div>
                                    <input type="submit" name="btnsubmit" value="Update Now"  class="btn btn-primary mr-2 my-1" type="button">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php include_once('include/footer.php') ?>
