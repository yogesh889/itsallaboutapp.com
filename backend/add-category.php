<?php
    include_once('../connection.php');
    include_once('auth.php'); 
 ?>
<?php
    $query ="select * from categories ";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
?>
<?php
     if(isset($_REQUEST["cid"]))
    {
        $query="select * from categories where category_id= ".$_REQUEST["cid"];
        $datas=mysqli_query($con,$query) or die(mysqli_error($con));
        $data=mysqli_fetch_array($datas);
    }

    if(isset($_POST['btnsubmit'])){
        extract($_POST);
         if(isset($_REQUEST["cid"]))
        {
            $query="select * from categories where category_id= ".$_REQUEST["cid"];
            $datas=mysqli_query($con,$query) or die(mysqli_error($con));
            $data=mysqli_fetch_array($datas);

          
            $query="update categories set category_name = '$category_name'  where category_id =  ".$_REQUEST['cid'];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('location:categories.php'); 
        }
        else
        {
          
            $query="insert into categories values(null,'$category_name',0,0,'$category_status',now(),'".$_SESSION['admin_name']."') ";
             
            mysqli_query($con,$query) or die(mysqli_error($con));
            header("location:categories.php");
          
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
                                    <span>Create New Category</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New Category</div>
                            <div class="card-body">
                                <form action="" method="post" >
                                    <div class="form-group">
                                        <label for="post-title">Category Name:</label>
                                        <input name="category_name" value="<?php if(isset($data)) echo $data['category_name'] ?>" class="form-control" id="post-title" type="text" placeholder="Category Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-status">Status:</label>
                                         <select name="category_status" class="form-control" id="post-status">
                                            <option value="published" <?php if( isset($data) && $data['category_status'] == "published") echo "selected"; ?> >Published</option>
                                            <option value="draft" <?php if( isset($data) && $data['category_status'] == "draft") echo "selected"; ?> >Draft</option>
                                        </select>
                                    </div>
                                    <input type="submit" class="btn btn-primary mr-2 my-1" name="btnsubmit" value="Submit Now" >
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>
<?php include_once('include/footer.php') ?>

            