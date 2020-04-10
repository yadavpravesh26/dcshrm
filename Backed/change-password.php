<?php

require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');

$cdb = new DB();

$db = $cdb->getDb();

$prop = new PDOFUNCTION($db);
if(isset($_POST[resetpass]))
{
//print_r($_POST);exit;
$t_cond = array("id" =>  $_SESSION['U']['id']);
	$insdata   = array(
             'password'           =>crypt($_POST['newpass'])
			);
		if($prop->update(USERS, $insdata, $t_cond))
		 {
			//setcookie("status", "Password Changed", time()+10);
			//setcookie("title", "Password Updated Successfully", time()+10);
			setcookie("err", "Password Changed", time()+10);
			 header('Location: index.php?method=logout');
		 }
}


?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
    <title>Change Password - DCSHRM</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
   <link href="css/colors/default-dark.css" id="theme" rel="stylesheet">
    <!--<link href="css/colors/blue.css" id="theme" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- include header -->
        <?php include 'header.php';?>
        <!-- header ends-->
        <!-- Left navbar-header -->
        <?php include 'left-sidebar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Change Password </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Change Password</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Change Password</h3>




                            <form data-toggle="validator" method="post">
                                       <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Current Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                <input type="Password" class="form-control" id="oldpass" rel="showalt" placeholder="Current Password" required>
                                            </div>
											<span style='color:red;display:none;' id='showalt'>Space Not Allowed</span>
                                            <div class="help-block with-errors tet"></div>
                                        </div>
										   <div class="clearfix"></div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">New Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                <input type="password" class="form-control" id="newpass" rel="showalt1" placeholder="New Password" data-toggle="validator" data-minlength="6" data-error="Minimum of 6 characters" required>

                                            </div>
											<span style='color:red;display:none;' id='showalt1'>Space Not Allowed</span>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                       <div class="clearfix"></div>
                                       <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Confirm Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                <input type="password" class="form-control" id="exampleInputuname" placeholder="Confirm Password" data-match="#newpass" data-match-error="Passwords doesn't match" name="newpass" rel="showalt2" placeholder="Confirm" required>
                                            </div>
											<span style='color:red;display:none;' id='showalt2'>Space Not Allowed</span>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-sm-12"><a href="change-password.php"><button type="button" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button></a><button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10 sub" name="resetpass">Submit</button></div>

                                        </div>

                                    </div>
							</form>


                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
              <?php include "footer.php" ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/validator.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
	  <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
	<script>
		<?php if($_COOKIE[err] !='')
			{

				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';
				setcookie("status", $_COOKIE[status], time()-10);
				setcookie("title", $_COOKIE[title], time()-10);
				setcookie("err", $_COOKIE[err], time()-10);
			}
			?>
$(document).ready(function(){
	$("#oldpass").focus();
    $("#oldpass,#newpass").blur(function(){
        var oldpasstext = $("#oldpass").val();
		var oldpass = '<?php echo $_SESSION['U']['pass'];?>';
		if(oldpasstext!=oldpass)
		{
			$(".tet").html('Old Password Wrong');
			$("#oldpass").css("border", "1px solid #CC2424");
            $(".tet").css("color", "#C66C6B");
			$("#oldpass").focus();
			$( ".sub" ).last().addClass( "disabled" );

		}
		else
		{
			$(".tet").html('');
			$("#oldpass").css("border", "1px solid #E4E7EA");
			$( ".sub" ).last().removeClass( "disabled" );
         	}
    });
	$("#oldpass, #newpass, #exampleInputuname").keydown(function(e){
		 if (e.keyCode == 32) { 
		var ID=$(this).attr('rel');
		 $("#"+ID).fadeIn(1000).fadeOut(1000);
       return false; 
     }
	});	
});
</script>
</body>

</html>
