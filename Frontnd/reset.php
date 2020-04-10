<?php 
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
if(isset($_GET['action']))
{          
    if($_GET['action']=="reset")
    {
		$encrypt = $_GET['encrypt'];
		$catfet=$prop->getAll_Disp("SELECT id FROM ".USERS." where md5(1290*3+id)='".$encrypt."'");
        if(count($catfet)<=0)
        {
			header('Location:'.LIVE_SITE);
			exit;
        }
    }
}
else{
	header('Location:'.LIVE_SITE);
	exit;
}   
if(isset($_POST['resetSubmit']))
{
    $encrypt      = $_GET['encrypt'];
    $password     = $_POST['password'];
    $query = "SELECT r_id FROM ".USERS." where md5(1290*3+id)='".$encrypt."'";
	$result = $prop->getAll_Disp($query);
	if(count($result)>0)
	{
		$t_cond = array("id" =>  $result[0]['id']);
		$insdata   = array(
			'password'	=>crypt($password),
			'de_pass'	=>$password
		);	
		if($prop->update(USERS, $insdata, $t_cond))
		{
			setcookie("success", "Password Reset Successfully sign in now ", time()+5);
			header('Location:'.LIVE_SITE);
			exit;
		}
		else
		{
			setcookie("err", "Password Reset Failed.", time()+15);
			header('Location: reset.php');
			exit;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">
    <title>DCSHRM | RESET</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
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
    <section id="wrapper" class="login-register">
	
        <div class="login-box">
            <div class="white-box">
			
                <form class="form-horizontal form-material"  data-toggle="validator" id="loginform" method="post">
                   <div class="text-center"><img src="img/maca-logo.png"></div>
				    <?php if($_COOKIE["err"] !='')
							{
								echo '<div class="col-md-12 text-center">
										<span class="text-danger ">'.$_COOKIE["err"].'</div>'; 
							}
							?>
							
                    <h3 class="box-title m-b-20">Reset Password</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" id="password" name="password" placeholder="Enter Password" type="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="cpassword" name="cpassword" placeholder="Enter Confirm Password" type="password" required>
                        </div>
                    </div>
                   
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-cons" name="resetSubmit" type="submit" >Reset Password</button>
                        </div>
                    </div>
                   
                   
                </form>
                <form class="form-horizontal" id="recoverform" method="POST" action="index.php?method=forget">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="formail" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
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
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
