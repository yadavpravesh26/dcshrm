<?php

require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
function restTemplate($data){
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width" />

<title>Email address verification</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; overflow:hidden !important;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
body {
padding: 0 !important;
}
h1 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h2 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h3 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h4 {
font-weight: 800 !important; margin: 20px 0 5px !important;
}
h1 {
font-size: 22px !important;
}
h2 {
font-size: 18px !important;
}
h3 {
font-size: 16px !important;
}
.container {
padding: 0 !important; width: 100% !important;
}
.content {
padding: 0 !important;
}
.content-wrap {
padding: 10px !important;
}
.invoice {
width: 100% !important;
}
}
</style>
</head>

<body itemscope itemtype="EmailMessage" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
	<td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
		<div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
			<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #FF9F00; margin: 0; padding: 20px;" align="left" bgcolor="#FF9F00" valign="top">
						Dear '.$data['email'].'
					</td>
				</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									We received a request to change the password for your DCSHRM account.
								</td>
							</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									If you did not make this request, just ignore this email. Otherwise, please click the button below to reset your password:

								</td>
							</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									<a href="'.ADMIN_SITE.'reset.php?encrypt='.$data['encrypt'].'&action=reset" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Reset password</a>
								</td>
							</tr>
							<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									You can also copy and paste this URL into your web browser:<br/>
									'.ADMIN_SITE.'reset.php?encrypt='.$data['encrypt'].'&action=reset

								</td>
							</tr>
							<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									Thanks for choosing Us.
								</td>
							</tr></table></td>
				</tr></table><div class="footer" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
				<table width="100%" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top"></td>
					</tr></table></div></div>
	</td>
	<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
</tr></table></body>
</html>';
}

/* ######### Login Session Set Please also change accesss-permission.php ######### */
switch($method)
{
	case 'login':
	   
		$email		=	$_POST['txtusername'];
		$password	=	($_POST['txtpassword']);
		$log		=	array();
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		   $log = $prop->get_Disp('SELECT id,u_id,email,name,c_name,password,user_type,u_type,de_pass,status FROM `'.USERS.'` WHERE 1=1 AND '."email='$email' AND status!=2");
		   
	    
		//if(!empty($log) && $log['email']==$email && authenticateuser($password,$log['password']))
		if(!empty($log) && $log['email']==$email && $password==$log['de_pass'] && $log['status'] != 1)
		{
		   
		    
		    $_SESSION['U']['id']	=	$log['id'];
		    $_SESSION['U']['uid']	=	$log['u_id'];
			$_SESSION['U']['email']	=	$log['email'];
			$_SESSION['U']['name']	=	$log['name'];
			$_SESSION['U']['pass']	=	$password;
			$_SESSION['U']['user_type'] = $log['user_type'];
			$_SESSION['U']['type'] = $log['u_type'];
			if($log['u_type']===0){
				$_SESSION['U']['menu'] = 1;
				$_SESSION['U']['permission'] = 1;
			}else{
				$_SESSION['U']['menu'] = 0;
			}
			if(isset($_POST['remember'])){
				setcookie("your_cuname", $_POST['txtusername'], time()+60*60*24*100,'/');
				setcookie("your_cpass", $_POST['txtpassword'], time()+60*60*24*100,'/');
				setcookie("crem", $_POST['remember'], time()+60*60*24*100,'/');
			} else {
				setcookie("your_cuname", $_POST['txtusername'], time()-60*60*24*100,'/');
				setcookie("your_cpass", $_POST['txtpassword'], time()-60*60*24*100,'/');
				setcookie("crem", $_POST['remember'], time()-60*60*24*100,'/');
			}
			header('Location: dashboard.php');
		}
		else if($log['status'] == 1)
		{
			setcookie('err', 'Please contact admin on info@dcshrm.com', time()+10);
			header('Location: '.ADMIN_SITE);
		}
		else
		{
			setcookie('err', 'Username or Password Not Match!', time()+10);
			header('Location: '.ADMIN_SITE);
		}
	break;
	case 'logout':
		unset($_SESSION['U']);
		setcookie('err', 'Successfully signedout ', time()+10);
		header('Location: '.ADMIN_SITE);
 	break;
	case 'forget';
		$email      = $_POST['formail'];
        $row = array();
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			$row=$prop->get_Disp("SELECT id,email FROM `".USERS."` where email='$email' AND status!=2 ");
		
        if(count($row)===1 && $row['email']===$email)
        {
            $encrypt=	md5(1290*3+$row['id']);
            $message=	'Your password reset link send to your e-mail address.';
            $to		=	$email;
            $subject=	'Forget Password';
            $from	=	MAIL_ADD;
            $body	=	restTemplate(array('email'=>$email,'encrypt'=>$encrypt));
            $headers=	'From: ' . strip_tags($from) . '\r\n';
            $headers .= 'Reply-To: '. strip_tags($from) . '\r\n';
            $headers .= 'MIME-Version: 1.0\r\n';
            $headers .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';
            mail($to,$subject,$body,$headers);
			setcookie('success', 'Check your mail and reset your password ', time()+5);
	        header('Location:'.ADMIN_SITE);
        }
        else
        {
			setcookie('err', 'Email Account not found.', time()+5);
			header('Location:'.ADMIN_SITE);
        }
		break;
}
if(isset($_SESSION['U']['id'])){header('Location: dashboard.php'); exit;}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16"  href="img/DCSHRM_logo-g.png">
    <title>DCSHRM </title>
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

                <form class="form-horizontal form-material" id="loginform" action="index.php?method=login" method="post">
                   <div class="text-center"><img src="img/DCSHRM_logo-g.png"></div>
				    <?php if($_COOKIE["err"] !='')
							{
								echo '<div class="col-md-12 text-center">
										<span class="text-danger ">'.$_COOKIE["err"].'</div>';
							}
							?>
							<?php if($_COOKIE["success"] !='')
							{
								echo '<div class="col-md-12 text-center">
										<span class="text-succss ">'.$_COOKIE["success"].'</div>';
							}
							?>
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" value="<?php if($_COOKIE["your_cuname"] !=''){ echo $_COOKIE["your_cuname"]; } ?>" name="txtusername" id="login_username" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="login_pass" name="txtpassword" required="" value="<?php if($_COOKIE["your_cpass"] !=''){ echo $_COOKIE["your_cpass"]; } ?>" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" name="remember" <?php if($_COOKIE["crem"] == 1){ echo "checked"; } ?> type="checkbox" value="1" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"  name="login">Log In</button>

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
