<?php
    include_once('../connection.php');
    include_once('auth.php'); 
 ?>
<?php
    $query ="select * from pages ";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
?>
<?php
     if(isset($_REQUEST["page_id"]))
    {
        $query="select * from pages where id= ".$_REQUEST["page_id"];
        $datas=mysqli_query($con,$query) or die(mysqli_error($con));
        $data=mysqli_fetch_array($datas);
    }

    if(isset($_POST['btnsubmit'])){
        extract($_POST);
         if(isset($_REQUEST["page_id"]))
        {
             $page_data = mysqli_real_escape_string($con, $page_data);
            $query="select * from pages where id= ".$_REQUEST["page_id"];
            $datas=mysqli_query($con,$query) or die(mysqli_error($con));
            $data=mysqli_fetch_array($datas);

          
            $query="update pages set page_title = '$page_title' , page_data = '$page_data'  where id =  ".$_REQUEST['page_id'];
            
            mysqli_query($con,$query) or die(mysqli_error($con));

            header('location:pages.php'); 
        }
        else
        {
            $page_data = mysqli_real_escape_string($con, $page_data);
          
            $query="insert into pages values(null,'$page_title','$page_data',0,now(),'".$_SESSION['admin_name']."','$status') ";
             
            mysqli_query($con,$query) or die(mysqli_error($con));
            header("location:pages.php");
          
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
                                    <span>Create New Page</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New Page</div>
                            <div class="card-body">
                                <form action="" method="post" >
                                    <div class="form-group">
                                        <label for="post-title">Page Title:</label>
                                        <input name="page_title" class="form-control" id="post-title" type="text" placeholder="Page Title..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="post-status">Status:</label>
                                         <select name="status" class="form-control" id="post-status">
                                            <option value="published" <?php if( isset($data) && $data['status'] == "published") echo "selected"; ?> >Published</option>
                                            <option value="draft" <?php if( isset($data) && $data['status'] == "draft") echo "selected"; ?> >Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-content">Page Details:</label>
                                        <textarea id="editor" name="page_data" class="form-control" placeholder="Type here..." id="post-content" rows="9"><?php if(isset($data)) echo $data['page_data'] ?></textarea>
                                    </div>
                                    <input type="Submit" name="btnsubmit" value="Submit Now" class="btn btn-primary mr-2 my-1" >
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php include_once('include/footer.php') ?>
             