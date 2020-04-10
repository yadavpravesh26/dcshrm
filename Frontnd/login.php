<?php

require_once('config.php');
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
									<a href="'.LIVE_SITE.'reset.php?encrypt='.$data['encrypt'].'&action=reset" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Reset password</a>
								</td>
							</tr>
							<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
									You can also copy and paste this URL into your web browser:<br/>
									'.LIVE_SITE.'reset.php?encrypt='.$data['encrypt'].'&action=reset

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
switch($method)
{
	case 'login':
		$email = $_POST['txtusername'];
		$password = ($_POST['txtpassword']);
		$log = array();
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			$log = $prop->get_Disp('SELECT id,email,name,c_name,password,department_id,u_type,permission,status,u_id FROM `'.USERS.'` WHERE 1=1 AND '."email='$email' AND status!=2 ");

		if(!empty($log) && $log['email']==$email && authenticateuser($password,$log['password']))
		{
			if($log['u_type']!=4){
				$_SESSION['U']['id']	=	$log['id'];
				$_SESSION['U']['uid']	=	$log['u_id'];
				$_SESSION['U']['email']	=	$log['email'];
				$_SESSION['U']['name']	=	$log['name'];
				$_SESSION['U']['pass']	=	$password;
				$_SESSION['U']['user_type'] = $log['u_type'];
				$_SESSION['U']['type'] = $log['u_type'];
				if($log['u_type']===0){
					$_SESSION['U']['menu'] = 1;
					$_SESSION['U']['permission'] = 1;
				}else{
					$_SESSION['U']['menu'] = 0;
				}
				header('Location:'.ADMIN_SITE.'dashboard.php'); break;
			}
			$CompanyLog = $prop->get('industry_type,permission', USERS, array('id'=>$log['u_id']));
			
			$departLog = $prop->get('dep_status', DEPARTMENT_NEW, array('dept_id'=>$log['department_id']));
			
			$industLog = $prop->get('permission', DEPARTMENT, array('dept_id'=>$CompanyLog['industry_type']));
			if($log['status']===0 && $departLog['dep_status']===0){
				$adminLog = $prop->get_Disp('SELECT id,end_date,status FROM `'.USERS.'` WHERE 1=1 AND status!=2 AND u_type=2 AND id='.$log['u_id']);
				if($adminLog['status']===0 && ($adminLog['end_date']==NULL || $adminLog['end_date']>=date('Y-m-d'))){
					$_SESSION['US']['user_id'] = $log['id'];
					$_SESSION['US']['user_email'] = $log['email'];
					$_SESSION['US']['user_name'] = $log['name'];
					$_SESSION['US']['company_name'] = $log['c_name'];
					$_SESSION['US']['type'] = $log['u_type'];
					$_SESSION['US']['department'] = $log['department_id'];
					$_SESSION['US']['perm_reject'] = $log['permission'];
					$_SESSION['US']['permission'] = $CompanyLog['permission'];
					if(isset($_POST['rememberuser'])){
						setcookie("your_cunameuser", $_POST['txtusername'], time()+60*60*24*100,'/');
						setcookie("your_cpassuser", $_POST['txtpassword'], time()+60*60*24*100,'/');
						setcookie("cremuser", $_POST['rememberuser'], time()+60*60*24*100,'/');
					} else {
						setcookie("your_cunameuser", $_POST['txtusername'], time()-60*60*24*100,'/');
						setcookie("your_cpassuser", $_POST['txtpassword'], time()-60*60*24*100,'/');
						setcookie("cremuser", $_POST['rememberuser'], time()-60*60*24*100,'/');
					}
					echo $industLog['permission'];
					//header('Location: dashboard.php');
				}
				setcookie('err', 'Please contact your company', time()+10);
				header('Location:'.LIVE_SITE.'login.php'); break;

			}else{
				setcookie('err', 'Your Account Temporarily Blocked', time()+10);
				header('Location:'.LIVE_SITE.'login.php');
			}
		}
		else
		{
			setcookie('err', 'Username or Password Not Match!', time()+10);
			header('Location:'.LIVE_SITE.'login.php');
		}
	break;
	case 'logout':
		unset($_SESSION['US']);
		setcookie('err', 'Successfully signedout ', time()+10);
		header('Location:'.LIVE_SITE.'login.php');
		break;
	case 'forget';
		$email      = $_POST['formail'];
		$row = array();
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			$row=$prop->get_Disp("SELECT id,email FROM `".USERS."` where email='$email' AND status!=2 AND u_type=4");

		if(count($row)===1 && $row['email']===$email)
        {
            $encrypt=	md5(1290*3+$row['id']);
            $message=	'Your password reset link send to your e-mail address.';
            $to		=	$email;
            $subject=	'Forget Password';
            $from	=	'info@daks.me';
            $body	=	restTemplate(array('email'=>$email,'encrypt'=>$encrypt));
            $headers=	'From: ' . strip_tags($from) . '\r\n';
            $headers .= 'Reply-To: '. strip_tags($from) . '\r\n';
            $headers .= 'MIME-Version: 1.0\r\n';
            $headers .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';
            mail($to,$subject,$body,$headers);
			setcookie('success', 'Check your mail and reset your password ', time()+5);
	        header('Location:'.LIVE_SITE.'login.php');
        }
        else
        {
			setcookie('err', 'Email Account not found.', time()+5);
			header('Location:'.LIVE_SITE.'login.php');
        }
		break;
}
if(isset($_SESSION['US']['user_id']) && $_SESSION['US']['user_id']>0){header('Location: dashboard.php');exit;}
if(isset($_SESSION['U']['id']) && $_SESSION['U']['id']>0){header('Location: '.ADMIN_SITE.'dashboard.php');exit;}

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  
    <title>DCSHRM - SIGNIN</title>
    <meta name="description" content="">
    <meta name="author" content="">

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Favicons
  ================================================== -->
  <link rel="icon" href="img/favicon/favicon-32x32.png" type="image/x-icon" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/favicon-144x144.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/favicon/favicon-72x72.png">
  <link rel="apple-touch-icon-precomposed" href="img/favicon/favicon-54x54.png">


  <!-- CSS
  ================================================== -->

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/custom-login.css">
    <!-- FontAwesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
</head>

<body>

  <section class="signup-page">

    <div class="container">

        <div class="row">

        <div class="col-sm-12">

            <div class="content-center">

            <div class="col-sm-9 col-md-6 col-xs-12">

                <div class="sp-wrapper">

                <div class="sp-logo text-center">

                    <img src="images/logo-login.png">

                    </div>

                    <hr>
                    <form class="form-horizontal login-form" data-toggle="validator" method="post" id="loginform" action="login.php?method=login">
                      <div style="text-align:center;" class="sp-content">
                      <?php
                          if($_COOKIE['err'] !='')
                          {
                              echo '<div style="color:red;font-size:12px;">'.$_COOKIE['err'].'</div>';
                          }
													if($_COOKIE['success'] !='')
                          {
                              echo '<div style="color:green;font-size:12px;">'.$_COOKIE['success'].'</div>';
                          }
                          ?>
                        </div>
                    <div class="sp-content">

                        <div class="mb-20">
                        	<span class="sp-title">Sign Login</span>
                        </div>

                        <div class="sp-component">
                        <label>Email <span>*</span></label>
                        <input class="form-control" type="email" required="" value="<?php if($_COOKIE["your_cunameuser"] !=''){ echo $_COOKIE["your_cunameuser"]; } ?>" name="txtusername" id="login_username" placeholder="Email">
                        </div>
                        <div class="sp-component">
                        <label>Password <span>*</span></label>
                        <input class="form-control" type="password" id="login_pass" name="txtpassword" required="" value="<?php if($_COOKIE["your_cpassuser"] !=''){ echo $_COOKIE["your_cpassuser"]; } ?>" placeholder="Password">
                        </div>
												<div class="row">
												<div class="col-sm-6 col-md-6 col-xs-12">
													<div class="sp-component mt-10">
														<div class="theme-checkbox">
																<input id="checkbox-signup" name="rememberuser" <?php if($_COOKIE["cremuser"] == 1){ echo "checked"; } ?> type="checkbox" value="1" type="checkbox">
																	<label for="checkbox-signup"> Remember me </label>
																	<div class="check"></div>
														</div>
													</div>
												</div>
												<div class="col-sm-6 col-md-6 col-xs-12 text-right">
													<div class="sp-component mt-10">
														<a class="theme-hover btn-forgot" href="javascript:void(0);"><em class="v-middle"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</em></a>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 col-md-12 col-xs-12 text-right">
                          <div class="sp-component ">
                            <div class="mt-10">
                             <em class="">Create Account</em>
                        			<a class="sp-text-signin" href="register.php">Sign Up</a>
                            </div>
                        	</div>
                        </div>
												<div class="col-sm-6 col-md-6 col-xs-12 pull-right">
                          <div class="sp-component">
                            <div class="mt-15">
                              <button type="submit"  name="login" class="btn btn-danger sp-btn btn-block">Sign In</button>
                            </div>
                          </div>
                        </div>
                        </div>
                    </div>

                    </form>
										<form style="display:none" class="form-horizontal forgot-form" data-toggle="validator" method="post" id="forgotform" action="login.php?method=forget">
                      <div style="text-align:center;" class="sp-content">
                      <?php
                          if($_COOKIE['err'] !='')
                          {
                              echo '<div style="color:red;font-size:12px;">'.$_COOKIE['err'].'</div>';
                          }
													if($_COOKIE['success'] !='')
                          {
                              echo '<div style="color:green;font-size:12px;">'.$_COOKIE['success'].'</div>';
                          }
                          ?>
                        </div>
                    <div class="sp-content">

                        <div class="mb-20">
                        	<span class="sp-title">Reset Password</span>
                        </div>

                        <div class="sp-component">
                        <label>Email <span>*</span></label>
                        <input class="form-control" type="email" name="formail" required="" placeholder="Email">
                        </div>
												<!--<div class="col-sm-12 col-md-12 col-xs-12 text-right">
													<div class="sp-component mt-10">
														<a class="theme-hover btn-login" href="javascript:void(0);"><em class="v-middle"><i class="fa fa-sign-in m-r-5"></i> Login</em></a>
													</div>
												</div>-->

                        <div class="row">

                            <div class="col-sm-6 col-md-6 col-xs-12">
	                            <div class="sp-component ">
																<div class="mt-15">
																	<a href="javascript:void(0);"><button type="button"  class="btn btn-default btn-block btn-login">Cancel
																	</button></a>
																</div>
			                        </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-12 pull-right">
                              <div class="sp-component">
                                <div class="mt-15">
                                  <button type="submit"  name="submit" class="btn btn-danger sp-btn btn-block">Reset
                                  </button>
                                </div>
                              </div>
                            </div>

                        </div>



                    </div>

                    </form>

                </div>

                </div>



            </div>



            </div>



        </div>

        </div>

    </section>

    <section class="bg-theme-section">

    </section>

  <!-- Javascript Files
  ================================================== -->

  <!-- initialize jQuery Library -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <!-- Bootstrap jQuery -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- SmoothScroll -->
  <script type="text/javascript" src="js/smoothscroll.js"></script>
	<script>
		$(".btn-forgot").click(function(){
        $('.login-form').hide(500);
				$('.forgot-form').show(500);
    });
		$(".btn-login").click(function(){
        $('.login-form').show(500);
				$('.forgot-form').hide(500);
    });
	</script>
</body>
</html>
