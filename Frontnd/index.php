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
			$log = $prop->get_Disp('SELECT id,email,name,c_name,password,department_id,u_type,permission,status,u_id FROM `'.USERS.'` WHERE 1=1 AND '."email='$email' AND status!=2 AND u_type=4");
	
		if(!empty($log) && $log['email']==$email && authenticateuser($password,$log['password']))
		{
			$departLog = $prop->get('dep_status,permission', DEPARTMENT_NEW, array('dept_id'=>$log['department_id']));
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
					$_SESSION['US']['permission'] = $departLog['permission'];
					if(isset($_POST['rememberuser'])){
						setcookie("your_cunameuser", $_POST['txtusername'], time()+60*60*24*100,'/');
						setcookie("your_cpassuser", $_POST['txtpassword'], time()+60*60*24*100,'/');
						setcookie("cremuser", $_POST['rememberuser'], time()+60*60*24*100,'/');
					} else {
						setcookie("your_cunameuser", $_POST['txtusername'], time()-60*60*24*100,'/');
						setcookie("your_cpassuser", $_POST['txtpassword'], time()-60*60*24*100,'/');
						setcookie("cremuser", $_POST['rememberuser'], time()-60*60*24*100,'/');
					}
					header('Location: dashboard.php');
				}
				setcookie('err', 'Please contact your company', time()+10);
				header('Location:'.LIVE_SITE); break;
				
			}else{
				setcookie('err', 'Your Account Temporarily Blocked', time()+10);
				header('Location:'.LIVE_SITE);
			}
		}
		else
		{
			setcookie('err', 'Username or Password Not Match!', time()+10);
			header('Location:'.LIVE_SITE);
		}
	break;
	case 'logout':
		unset($_SESSION['US']);
		setcookie('err', 'Successfully signedout ', time()+10);
		/*header('Location:'.LIVE_SITE);*/
		header('Location:index.html');
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
	        header('Location:'.LIVE_SITE);
        }
        else
        {
			setcookie('err', 'Email Account not found.', time()+5);
			header('Location:'.LIVE_SITE);
        }
		break;
}
if(isset($_SESSION['US']['user_id']) && $_SESSION['US']['user_id']>0){header('Location: dashboard.php');exit;}

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	
    <title>Welcome to DCSHRM</title>
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
	<link rel="stylesheet" href="old-css/bootstrap.min.css">
	<!-- Template styles-->
	<link rel="stylesheet" href="old-css/style.css">
	<!-- Responsive styles-->
	<link rel="stylesheet" href="old-css/responsive.css">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="old-css/font-awesome.min.css">
	<!-- Animation -->
	<link rel="stylesheet" href="old-css/animate.css">
	<!-- Prettyphoto -->
	<link rel="stylesheet" href="old-css/prettyPhoto.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="old-css/owl.carousel.css">
	<link rel="stylesheet" href="old-css/owl.theme.css">
	<!-- Flexslider -->
	<link rel="stylesheet" href="old-css/flexslider.css">
	<!-- Style Swicther -->
	<link id="style-switch" href="old-css/presets/preset6.css" media="screen" rel="stylesheet" type="text/css">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
	
<body>

	<div class="body-inner">

	<!-- Header start -->
	<header id="header" class="header" role="banner">
	
		<!-- Top bar start -->
		<div id="top-bar" class="top-bar">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-6">
						<div class="top-social">
							<a class="fb" href="#"><i class="fa fa-facebook"> </i></a>
							<a class="twt" href="#"><i class="fa fa-twitter"> </i></a>
							<a class="gplus" href="#"><i class="fa fa-google-plus"> </i></a>
							<a class="youtube" href="#"><i class="fa fa-youtube"> </i></a>
							<a class="linkdin" href="#"><i class="fa fa-linkedin"> </i></a>
						</div>
					</div>
					<div class="col-md-2 visible-lg visible-md">
					</div>
					<div class="col-md-4 col-sm-6 col-xs-6 col-md-offset-2">
						<ul class="top-info">
							<li><i class="fa fa-envelope">&nbsp;</i> Info@dcshrm.com</li>
							<li><i class="fa fa-phone">&nbsp;</i> Call Us: (20) 3893-837</li>
						</ul>
					</div>
					
				</div><!-- Row end -->
			</div><!-- Container end -->
		</div><!-- Top bar end -->

		<!-- Navigation start -->
		<div class="navbar ts-mainnav">
			<div class="container">
				<!-- Logo start -->
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				    <div class="navbar-brand">
					    <a href="index.html">
					    	<div class="logo"></div>
					    </a> 
				    </div>                   
				</div><!--/ Logo end -->

				<nav class="collapse navbar-collapse navbar-right" role="navigation">
					<ul class="nav navbar-nav">
            <li class="active"> <a href="#">Home</a> </li>
                        <li > <a href="#">About Us </a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse by Category <i class="fa fa-angle-down"></i></a>
              <div class="dropdown-menu">
                <ul id="nav-category-dev">
                  <li><a href="#">Automotive</a></li>
                  <li><a href="#">Heavy Manufacturing</a></li>
                  <li><a href="#">Light Manufacturing </a></li>
                  <li><a href="#">Health Care</a></li>
                  <li><a href="#">Office/Education </a></li>
                  <li><a href="#">Distribution</a></li>
                  <li><a href="#">Oil & Gas</a></li>
                  <li><a href="#">Electrical</a></li>
                </ul>
              </div>
            </li>
            
            <!-- Mega menu end -->
            
            <li > <a href="#">Blog </a> </li>
			<li > <a href="b-safe.html">B-Safe Program</a> </li>
            <li > <a href="#">Contact Us </a> </li>
            <a class="readmore dcs-mod" href="login.php">Login / Sign up</a>      
          </ul><!--/ Navbar-nav end -->
                    
				</nav><!--/ Navigation end -->
                
                  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog dcs-own">
    
      <!-- Modal content-->
      <div class="modal-content dcs-mod">
        <div class="modal-header dcs">
          <button type="button" class="close dcs" data-dismiss="modal">&times;</button>
          <h4 class="modal-title dcs-sig">Sign Up</h4>
        </div>
        <div class="modal-body">
          
            <form> <div class="form-row dcs-form"> <div class="form-group col-md-6 ls"> <label for="inputPassword4">Company name</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div> <div class="form-group col-md-6 rs"> <label for="inputEmail4">Email</label> <input type="email" class="form-control" id="inputEmail4" placeholder=""> </div><div class="form-group col-md-6 ls"> <label for="inputPassword4">Mobile Number</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div><div class="form-group col-md-6 rs"> <label for="inputPassword4">Telephone Number</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div><div class="form-group col-md-6 ls"> <label for="inputPassword4">Address</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div><div class="form-group col-md-6 rs"> <label for="inputPassword4">City</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div><div class="form-group col-md-6 ls"> <label for="inputPassword4">Password</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div><div class="form-group col-md-6 rs"> <label for="inputPassword4">Confirm Password</label> <input type="text" class="form-control" id="inputPassword4" placeholder=""> </div> </div>    </form>
            
            <div class="clearfix"></div>
                
        </div>
        <div class="modal-footer no-btm">
          <button type="button" class="btn btn-default dcs-clo" data-dismiss="modal">Sign Up</button> <div class="ald"><p>Already Member? <a href="#"><span>Sign in</span></a></p></div>
        </div>
      </div>
      
    </div>
  </div>      
			</div><!--/ Container end -->
		</div> <!-- Navbar end -->
	</header><!--/ Header end -->

	<!-- Slider start -->
	<section id="slideshow-wrapper" class="no-padding top-gap">	
		<!-- Carousel -->
    	<div id="main-slide" class="carousel slide" data-ride="carousel">

			<!-- Indicators -->
			<ol class="carousel-indicators visible-lg visible-md">
			  	 <li data-target="#main-slide" data-slide-to="1"></li>
			    <li data-target="#main-slide" data-slide-to="2"></li>
			</ol><!--/ Indicators end-->

			<!-- Carousel inner -->
			<div class="carousel-inner">
			    <!--/ Carousel item end -->
				<div class="item">
			    	<img class="img-responsive" src="images/slider/bg2.jpg" alt="slider">
                    <div class="slider-content">
                        <div class="col-md-12 text-center">
                            <h2 class="animated4"> Quality Safety Training</h2>
                            
                            <p class="animated6"><a href="#" class="slider btn btn-primary white">Login for Demo <i class="fa fa-long-arrow-right"> </i></a></p>	     
                        </div>
                    </div>
			    </div>

			    <!--/ Carousel item end -->
			    
			    <div class="item active">
			    	<img class="img-responsive" src="images/slider/bg3.jpg" alt="slider">
                    <div class="slider-content">
                    	<div class="col-md-12">
                    		<div class="slider-text">
	                        	<h2 class="animated7">We Offer Our Clients</h2>
	                        	                        	</div>
	                        <div class="slider-smalltext">
	                        	<div class="slider-small-text-content">
	                        		<h4 class="wow slideInRight" data-wow-delay=".5s">
	                        			<i class="fa fa-legal"> </i> Making workplace safety a reality
	                        		</h4>
		                        	<h4 class="wow slideInRight" data-wow-delay=".7s">
		                        		<i class="fa fa-dollar"> </i> A unique solution
		                        	</h4>
		                        	<h4 class="wow slideInRight" data-wow-delay=".9s">
		                        		<i class="fa fa-book"> </i> Value
		                        	</h4>
		                        	<h4 class="wow slideInRight" data-wow-delay="1.1s">
		                        		<i class="fa fa-magic"> </i> Knowledge
		                        	</h4>
		                        	<h4 class="wow slideInRight" data-wow-delay="1.3s">
		                        		<i class="fa fa-compass"> </i>Taking the time to care
		                        	</h4>
                                    <h4 class="wow slideInRight" data-wow-delay="1.3s">
		                        		<i class="fa fa-compass"> </i>BSAFE program
		                        	</h4>									
	                        	</div>
	                        </div>
                    	</div>
                    </div>
			    </div><!--/ Carousel item end -->
			</div><!-- Carousel inner end-->

			<!-- Controllers -->
			<a class="left carousel-control" href="#main-slide" data-slide="prev">
		    	<span><i class="fa fa-angle-left"></i></span>
			</a>
			<a class="right carousel-control" href="#main-slide" data-slide="next">
		    	<span><i class="fa fa-angle-right"></i></span>
			</a>

		</div><!--/ Carousel end -->    	
    </section><!--/ Slider end -->
    

    <!-- Intro section start -->
	<section id="intro" class="intro">
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-sm-6 wow slideInLeft intro-content" data-wow-delay=".3s">
					<h3 class="title">Welcome to DCSHRM.</h3>
					
					<p><img class="pull-left img-thumbnail" src="images/about-image.jpg" alt=""></p>
					<p>DCSHRM is an hr and safety solution website that emphasizes simplicity and value over gimmicks that wont add to the bottom line.</p>
					
					<p>This platform offers hr and payroll safety management tools that are unity on knowledge acquired through years of leadership in the hr/safety market.</p> 
					
				</div><!-- End intro -->

				<div class="col-md-5 col-sm-6 wow slideInRight" data-wow-delay=".5s">
					<h3 class="title">Why Choose Us?</h3>
					<div class="panel-group" id="accordion">
		              	<div class="panel panel-default">
			                <div class="panel-heading">
				                <h4 class="panel-title"> 
				                	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Why would I want an outside provider? </a> 
				                </h4>
			                </div>
			                <div id="collapseOne" class="panel-collapse collapse in">
			                  <div class="panel-body">
			                    <p><span class="list-icon pull-right"> <i class="fa fa-thumbs-up"> </i> </span>content....</p>
			                    <a href="#">Read More</a>
			                  </div>
			                </div>
		              	</div><!--/ Panel 1 end-->

		              	<div class="panel panel-default">
			                <div class="panel-heading">
				                <h4 class="panel-title">
				                	<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo"> What if my business grows?</a>
				            	</h4>
			                </div>
			                <div id="collapseTwo" class="panel-collapse collapse">
			                  <div class="panel-body">
			                    <p><span class="list-icon pull-right"> <i class="fa fa-star"> </i> </span>content.....</p>
			                    <a href="#">Read More</a>
			                  </div>
			                </div>
		              	</div><!--/ Panel 2 end-->

		              	<div class="panel panel-default">
			                <div class="panel-heading">
				                <h4 class="panel-title">
				                <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseThree"> How do I know I’m in compliance?</a> 
				            	</h4>
			                </div>
			                <div id="collapseThree" class="panel-collapse collapse">
			                  <div class="panel-body">
			                    <p><span class="list-icon pull-right"> <i class="fa fa-coffee"> </i> </span>content.....</p>
			                    <a href="#">Read More</a>
			                  </div>
			                </div>
		              	</div><!--/ Panel 3 end-->
		            </div>
				</div><!--/ End why us -->
			</div><!-- Content row end -->
		</div><!-- Container end -->
	</section><!-- Intro section end -->


	<!-- Service start -->
	<section id="service" class="service parallax parallax1">
		<div class="parallax-overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-delay=".5s">
						<div class="service-content text-center">
							<span class="service-icon"><i class="fa fa-trophy"></i></span>
							<h3>Unique solution</h3>
							<p>DCSHRM Offers unique solution through intuitive hr and payroll management platform and b-safe app.</p>
							<a class="readmore" href="#">Read More</a>
						</div>
					</div><!--/ End 1st service -->

					<div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-delay=".8s" >
						<div class="service-content text-center">
							<span class="service-icon"><i class="fa fa-globe"></i></span>
							<h3>Value</h3>
							<p>Offering you unlimited access for unlimited individuals in your organization for a fair monthly subscription.</p>
							<a class="readmore" href="#">Read More</a>
						</div>
					</div><!--/ End 2nd service -->

					<div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-delay="1.1s">
						<div class="service-content text-center">
							<span class="service-icon"><i class="fa fa-thumbs-o-up"></i></span>
							<h3>Knowledge</h3>
							<p>Industry leading specialists that have developed custom solutions to meet your businesses needs.</p>
							<a class="readmore" href="#">Read More</a>
						</div>
					</div><!--/ End 3rd service -->

					<div class="col-md-3 col-sm-6 wow fadeInDown" data-wow-delay="1.4s">
						<div class="service-content text-center">
							<span class="service-icon"><i class="fa fa-users"></i></span>
							<h3>Taking the time to care</h3>
							<p>Customer service is always available on site with the ability to customize your programs and training.</p>
							<a class="readmore" href="#">Read More</a>
						</div>
					</div><!--/ End 4th service -->
				</div>
			</div><!-- Content row end -->
		</div><!--/ Container end -->
	</section><!--/ Service box end -->

	

	<!-- Content start -->
	<section id="content" class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h3 class="title">You Should Know About Law</h3>
					<div class="video-embed wow fadeIn" data-wow-duration="1s">
						<!-- Change the url -->
						<iframe width="560" height="315" src="//www.youtube.com/embed/f_A7LnCfu98" allowfullscreen></iframe>
					</div>
				</div>
				
				<div class="col-md-4 col-sm-6">
					<h3 class="title">Latest News</h3>
					<div class="media latest-post">
						<img class="pull-left" src="images/news/news1.jpg" alt="img">
						<div class="media-body post-body">
							<h4><a href="#">Court Gives Final Approval of Class Action for Students Settlement</a></h4>
							<p class="post-meta">
								<span class="post-meta-author">By <a href="#">John</a></span>
								<span class="date">On Aug 19, 2014</span>
								<span class="post-meta-comments"><i class="fa fa-comments"></i> <a href="#">11</a></span>
							</p>
						</div>
					</div><!-- Latest Post end -->
					<div class="media latest-post">
						<img class="pull-left" src="images/news/news2.jpg" alt="img">
						<div class="media-body post-body">
							<h4><a href="#">White &amp; Case opens Florida legal support centre</a></h4>
							<p class="post-meta">
								<span class="post-meta-author">By <a href="#">Monca</a></span>
								<span class="date">On Sep 21, 2014</span>
								<span class="post-meta-comments"><i class="fa fa-comments"></i> <a href="#">17</a></span>
							</p>
						</div>	
					</div><!-- Latest Post end -->
					<div class="media latest-post">
						<img class="pull-left" src="images/news/news2.jpg" alt="img">
						<div class="media-body post-body">
							<h4><a href="#">White &amp; Case opens Florida legal support centre</a></h4>
							<p class="post-meta">
								<span class="post-meta-author">By <a href="#">Monca</a></span>
								<span class="date">On Sep 21, 2014</span>
								<span class="post-meta-comments"><i class="fa fa-comments"></i> <a href="#">17</a></span>
							</p>
						</div>	
					</div><!-- Latest Post end -->
					<div class="media latest-post">
						<img class="pull-left" src="images/news/news3.jpg" alt="img">
						<div class="media-body post-body">
							<h4><a href="#">Tloses Bristol and Colchester outposts to consolidate</a></h4>
							<p class="post-meta">
								<span class="post-meta-author">By <a href="#">Tina</a></span>
								<span class="date">On Nov 27, 2014</span>
								<span class="post-meta-comments"><i class="fa fa-comments"></i> <a href="#">09</a></span>
							</p>
						</div>	
					</div><!-- Latest Post end -->
				</div>
			</div>
		</div>
	</section><!-- Content end -->

	

    <!-- Content bottom start -->
	<section id="content-bottom" class="content-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="newsletter">
						<h3 class="title">Signup For Newsletter</h3>
						<div class="newsletter-introtext">
							Enter your email address and hit / return to subscribe. You will be informed about upcoming events.
						</div>
						<form action="#" method="post" id="newsletter-form" class="newsletter-form">
						<div class="form-group">
							<input type="email" name="email" id="newsletter-form-email" class="form-control form-control-lg" placeholder="Enter your email address" autocomplete="off">
							<button class="sub-button">Subscribe</button>
						</div>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="testimonial">
						<h3 class="title">Client Testimonials</h3>

						    <div id="testimonial-carousel" class="owl-carousel owl-theme testimonial-slide">
						        <div class="item">
						          	<div class="testimonial-content">
							            <p class="testimonial-text">
							              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
							            </p>
							           	<div class="testimonial-thumb">
						            		<img class="pull-left" src="images/clients/testimonial1.png" alt="testimonial">
						            		<h3 class="name">Sarah Arevik<span>Chief Executive Officer</span></h3>

						          		</div>
						          	</div>
						        </div>
						        <div class="item">
							        <div class="testimonial-content">
							            <p class="testimonial-text">
							              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
							            </p>
							         <div class="testimonial-thumb">
						            	<img class="pull-left" src="images/clients/testimonial2.png" alt="testimonial">
						            	<h3 class="name">Narek Bedros<span>Sr. Manager</span></h3>
						          	</div>
							            
							        </div>
						        </div>
						        <div class="item">
						          	<div class="testimonial-content">
							            <p class="testimonial-text">
							              Lorem Ipsum as their default model text, and a search for ‘lorem ipsum’ will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose. Lorem Ipsum is that it as opposed to using.
							            </p>
							            <div class="testimonial-thumb">
							            	<img class="pull-left" src="images/clients/testimonial3.png" alt="testimonial">
							            	<h3 class="name">Taline Lucine<span>Sales Manager</span></h3>
							        	</div>
						          	</div>
						        </div>
						    </div><!--/ Testimonial carousel end-->
						    <!-- Navigation start -->
					      	<div class="customNavigation ts-carousel-controller">
						        <a class="prev left">
						        	<i class="fa fa-angle-left"></i>
						       	</a>
						        <a class="next right">
						          <i class="fa fa-angle-right"></i>
						        </a>
					    	</div><!--/ Navigation end -->

					</div><!-- Testimonial end -->
				</div>
			</div><!--/ Row end -->
		</div> <!--/ Container end -->
	</section> <!--/ Content bottom end -->

	

	<!-- Footer start -->
	<footer id="footer" class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="footer-about-us">
						<h3 class="footer-title">Get In Touch</h3>
						<address class="footer-address">
						<p><i class="fa fa-globe"> </i> 1102 Saint Marys, Junction City, KS</p>
						<p><i class="fa fa-phone"> </i>+123 455 755</p>
						<p><i class="fa fa-envelope-o"> </i> contact@dcshrm.com</p>
						<p><i class="fa fa-link"> </i> http://www.dcshrm.com</p>
						<p><i class="fa fa-compass"> </i>9.00 am to 7.00 pm</p>
						</address>
						<p class="footer-social social">
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-google-plus"></i></a>
							<a href="#"><i class="fa fa-linkedin"></i></a>
							<a href="#"><i class="fa fa-pinterest"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
						</p>
					</div>
				</div><!--/ end about us -->
				
				<div class="col-md-3 col-sm-6">
					<h3 class="footer-title">Our Firm</h3>
					<ul class="arrow">
						<li><a href="#">What We Do</a></li>
						<li><a href="#">How We Help</a></li>
						<li><a href="#">Our Lawyer</a></li>
						<li><a href="#">Our Success</a></li>
						<li><a href="#">Our FAQ</a></li>
						<li><a href="#">Fill a Form</a></li>
						<li><a href="#">Practice Area</a></li>
						<li><a href="#">Latest News</a></li>
						<li><a href="#">Popular Blog</a></li>
						<li><a href="#">Resources</a></li>
					</ul>
				</div><!--/ end recent post -->

				<div class="col-md-3 col-sm-6">
					<h3 class="footer-title">Twitter Feed</h3>
					<ul class="twitter-list">
						<li>
							<span><i class="fa fa-twitter"> </i></span>
							<a href="#" class="date">About 1 Month Ago</a>
							Newsline - Joomla Magazine Template updated with Full Width Layout http://t.co/QSrd7OtMLm http://t.co/MAosFNi35q
						</li>
						<li>
							<span><i class="fa fa-twitter"> </i></span>
							<a href="#" class="date">About 16 Days Ago</a>
							Dart - HTML5 Business Template updated with One Page version #Onepage http://t.co/q2iXJScly0 http://t.co/2znU71ieyD
						</li>
					</ul>
						
				</div><!--/ end flickr -->

				<div class="col-md-3 col-sm-6">
					<h3 class="footer-title">Quick Contact</h3>
					<div class="qc-form">
						<div class="row">
		                    <div class="col-xs-6 col-sm-6 col-md-6">
		                    	<div class="form-group">
		                            <input class="form-control" name="firstname" placeholder="Name" type="text" required />
		                        </div>
		                    </div>
		                   	<div class="col-xs-6 col-sm-6 col-md-6">
		                    	<div class="form-group">
		                            <input class="form-control" name="email" placeholder="E-mail" type="text" required />
		                        </div>
		                    </div>
	                	</div>
	                    <div class="row">
	                    	<div class="col-xs-12 col-md-12">
	                    		<div class="form-group">
	                            	<textarea class="form-control" placeholder="Message..." rows="4" name="comment" required></textarea>
	                    		</div>
	                    	</div>
	                    </div>
					 	<div class="form-group">
							<button type="submit">Send</button>
						</div>
					</div>
				</div><!--/ End quick contact -->
			</div><!-- Row end -->
		</div><!-- Container end -->
	</footer><!-- Footer end -->


	<!-- Copyright start -->
	<section id="copyright" class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="footer-logo">
						<img src="images/logo-final.png" alt="logo">
					</div>
				</div>
			</div><!--/ Row end -->
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="nav footer-nav">
						<li><a href="#">Terms and Condition</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Legals</a></li>
					</ul>
				</div>
			</div><!--/ Row end -->

			<div class="row">
				<div class="col-md-12 text-center">
					<div class="copyright-info">
         			 &copy; Copyright 2015 DCSHRM
        			</div>
				</div>
			</div><!--/ Row end -->
		   <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top affix">
				<button class="btn btn-primary" title="Back to Top"><i class="fa fa-angle-double-up"></i></button>
			</div>
		</div><!--/ Container end -->
	</section><!--/ Copyright end -->

	<!-- Javascript Files
	================================================== -->

	<!-- initialize jQuery Library -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<!-- Bootstrap jQuery -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- Style Switcher -->
	<script type="text/javascript" src="js/style-switcher.js"></script>
	<!-- Owl Carousel -->
	<script type="text/javascript" src="js/owl.carousel.js"></script>
	<!-- PrettyPhoto -->
	<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
	<!-- Bxslider -->
	<script type="text/javascript" src="js/jquery.flexslider.js"></script>
	<!-- Isotope -->
	<script type="text/javascript" src="js/isotope.js"></script>
	<script type="text/javascript" src="js/ini.isotope.js"></script>
	<!-- Wow Animation -->
	<script type="text/javascript" src="js/wow.min.js"></script>
	<!-- SmoothScroll -->
	<script type="text/javascript" src="js/smoothscroll.js"></script>
	<!-- Eeasing -->
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<!-- Counter -->
	<script type="text/javascript" src="js/jquery.counterup.min.js"></script>
	<!-- Waypoints -->
	<script type="text/javascript" src="js/waypoints.min.js"></script>
	<!-- Google Map API Key Source -->
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<!-- For Google Map -->
	<script type="text/javascript" src="js/gmap3.js"></script>
	<!-- Doc http://www.mkyong.com/google-maps/google-maps-api-hello-world-example/ -->
	<!-- Template custom -->
	<script type="text/javascript" src="js/custom-index.js"></script>
	<script>
		function navMenuCategory(){
			$.ajax({
				type: "GET",
				url: "ajax-menu.php",
				cache:true,
				success: function(response)
				{
				  $('#nav-category-dev').html(response);
				}
			});
		}
		navMenuCategory();
	</script>
	</div><!-- Body inner end -->

</body>
</html>