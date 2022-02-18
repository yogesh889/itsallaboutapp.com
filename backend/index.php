<?php 

include_once('../connection.php');

extract($_POST);

if(isset($btnsubmit)){
    if($code == "accessit"){
    	$_SESSION['code_auth'] = true;
    	header('location:login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Code Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="js/all.min.js"></script>
        <script src="js/feather.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        	<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Access Authentication </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" >
      	
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <input type="text" name="code" id="defaultForm-email" placeholder="code here" class="form-control validate">
          <label data-error="wrong" data-success="right" for="defaultForm-email">Write Code</label>
        </div>

      

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <input type="submit" value="submit"  name="btnsubmit" class="btn btn-success">
      </div>
      </form>

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
