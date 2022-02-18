<?php 

include_once('../connection.php');

if(!isset($_SESSION['code_auth'])){
    header('location:index.php');
}
extract($_POST);

if(isset($btnsubmit)){
    $query = "select * from admin where email='$email' and password='$password' and isactive = 1 ";
    $status = mysqli_query($con,$query);
    $row = mysqli_num_rows($status);
    if($row == 1){
        $row_data = mysqli_fetch_array($status);
        $_SESSION['admin_name'] = $row_data['username'];
        $_SESSION['admin_id'] = $row_data['id'];
        if($row_data['image'] == NULL)
        {
            $_SESSION['photo']='nouser.jpg';
        }
        else
        {
        $_SESSION['photo'] = $row_data['image'];
            
        }
   
       header('location:dashboard.php');
    }
    else
    {
        $msg='Login Credentials are wrong!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>SIGN IN || Admin Panel</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="js/all.min.js"></script>
        <script src="js/feather.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">


                                    <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">SIGN IN</h3></div>
                                    <center>
                                        <div class="mt-3 text-warning" ><?php if(isset($msg)) echo $msg; ?>        
                                        </div>
                                    </center>
                                    <div class="card-body">
                                        <form action="" method="post" >
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input required="" name="email" class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address" /></div>
                                            <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input required="" name="password" class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" /></div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="#"></a><input type="submit" name="btnsubmit" class="btn btn-primary btn-block" value="Submit"></div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
  </div>
</div>


                </main>
            </div>
        </div>

        <!--Script JS-->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {

    $('#modalLoginForm').modal('show');

});
        </script>
    </body>
</html>
