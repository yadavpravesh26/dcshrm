<?php 
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$com_id = $_SESSION['US']['user_id'];
$t_cond = array("id" => $com_id);
$get_user = $prop->get('*', USERS, $t_cond);

if(isset($_POST['updatepass'])){	
	$st = 'Error';
	$err = 'error';
	$msg = 'Change password failed';
	$t_cond = array("id" => $com_id);	
	$input   = array(             
	'password'		=>crypt($_POST['newpass']),               
	'de_pass'		=>$_POST['newpass'],               
	'updated_id'	=>$com_id,
	'updated_date'	=>DB_DATE,
	'updated_ip'	=>IP
	);	
	if($prop->update(USERS, $input, $t_cond)){	
		$msg = 'Changed password successfully!';		
		$st = 'Success';
		$err = 'success';
		$userdata = $prop->get('*', USERS, $t_cond);
		$subject = 'Employee Password Updated';
		$subject_emp = 'Your DCSHRM Password Updated';
		$comp_cond = array("id" => $userdata['u_id']);
		$comp_data = $prop->get('email', USERS, $comp_cond);
		$company_to = $comp_data['email'];
		$departName = $prop->get('dep_name', DEPARTMENT_NEW, array('dept_id'=>$userdata['department_id']));
		$departName = $departName['dep_name'];
		$post = $userdata;		
		$new_password = $_POST['newpass'];	
		sendemailafteremployee($post,$subject,$subject_emp,$company_to,$departName,$new_password);	
	}
	setcookie("status", $st, time()+10);		
	setcookie("title", $msg, time()+10);		
	setcookie("err", $err, time()+10);
	header('Location: '.$_SERVER['PHP_SELF']);		
	exit;
}
function sendemailafteremployee($post,$subject,$subject_emp,$company_to,$departName,$new_password){							
	$from = 'admin@dcshrm.com';
	$headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion(); 
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$BccEmailList = 'm.kamal@hexagonitsolutions.com';
	$headers .= "Bcc: $BccEmailList\r\n";
	$message = '<!DOCTYPE html>
				<html lang="en">
				<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="description" content="">
				<meta name="author" content="">
				<title>DCSHRM</title>
				<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
				</head>
				<body style="background-color:#ffffff; font-family: Roboto, sans-serif;">
				<div style="width:575px; margin:30px auto;padding:0px 25px; background-color:#f9f9f9; border-top:4px solid #e40303">
				<div style="text-align:center; margin:25px;">
				<img src="http://e-orchids.com/DCSHRM-email-templates/images/logo.png" alt="logo" />
				</div>
				<div style="padding:0px 0px 40px; display: inline-block;">
				<div>
				<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/banner-emp.png" alt="img" width="100%" style="" />
				</div>
				<div style="background-color:#fff;padding: 0px 20px 10px; overflow: hidden;">
				<p style="text-align:left; font-size:16px; font-weight:800; color:#353535; padding-top:30px; margin-bottom:10px;margin-top: 0px;">Hi '.$post['name'].',</p>
				<div style="display: inline-block;width: 100%;padding:0px; border:1px solid #eaeaea">
				<h2 style="border-bottom: 2px solid #e6e6e6;margin: 0px;padding:10px;font-size: 16px;font-weight: 500;">Employee Details</h2>
				<div style="display:flex; flex-wrap:wrap; padding:10px 0px;">
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td style="padding:10px;width:178px">
							<h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Name</h5>
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['name'].'</p>
						</td>
						<td style="padding:10px;width:178px">
							<h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Department</h5>
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$departName.'</p>
						</td>
						<td style="padding:10px;width:178px">
							<h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Phone</h5>
				<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['contact_no'].'</p>
						</td>
					  </tr>
					  <tr>
						<td style="padding:10px;width:178px">
							<h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Email</h5>
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['email'].'</p>
						</td>
						<td style="padding:10px;width:178px">
							<h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Password</h5>
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$new_password.'</p>
						</td>
						<td style="padding:10px;width:178px">
							
						</td>
					  </tr>
				</table>
				</div>
				</div>
				<p style="text-align:left; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; padding-bottom:30px;line-height:25px;border-bottom: 1px solid #e5e5e5;">If you don’t know why you got this email, please tell us straight away so we can fix this for you.</p>
				<div style="width:50%; float:left;">
				<p style="font-size:14px; font-weight:400; color:#353535;margin-bottom: 5px;">info@dcshrm.com</p>
				<p style="font-size:14px; font-weight:400; color:#353535;margin-top: 0px;margin-bottom: 5px;">Call Us: +1 (801) 360-5036</p>
				</div>
				<div style="width:50%;float:left;">
				<ul style="width:100%;list-style:none; padding:0px; text-align:right;">
				<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images/fb.png" alt="social" /></a></li>
				<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images/tw.png" alt="social" /></a></li>
				<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images/lnk.png" alt="social" /></a></li>
				</ul>
				</div>
				</div>
				</div>
				</div>
				</body>
				</html>';
				// Sending email
		//if(mail($company_to, $subject, $message, $headers)){
		if(sendemail($company_to,$subject,$message)){
			$EmailTest = 'Your mail has been sent successfully1.';
		} else{
			$EmailTest =  'Unable to send email. Please try again1.';
		}							
	/*Send Email to Company END*/
	//Employee email Template Start
		$to_emp = $post['email'];
		
		$from_emp = 'admin@dcshrm.com';
		 
		$headers_emp .= 'From: '.$from_emp."\r\n".'Reply-To: '.$from_emp."\r\n" . 'X-Mailer: PHP/' . phpversion();
		$headers_emp  = 'MIME-Version: 1.0' . "\r\n";
		$headers_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$BccEmailList = 'm.kamal@hexagonitsolutions.com';
		$headers_emp .= "Bcc: $BccEmailList\r\n";	
		 
		$message_emp = '<html lang="en">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>DCSHRM</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
		</head>
		<body style="background-color:#ffffff; font-family: Roboto, sans-serif;">
		<div style="width:575px; margin:30px auto;padding:0px 25px; background-color:#f9f9f9; border-top:4px solid #e40303">
		<div style="text-align:center; margin:25px;">
		<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/logo.png" alt="logo" />
		</div>
		<div style="padding:0px 0px 40px; display: inline-block;">
		<div class="position:relative;">
		<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/th-reg.png" alt="edifice-logo" width="100%" style="" />
		</div>
		<div style="background-color:#fff;padding: 0px 20px 10px; overflow: hidden;">
		<div style="text-align:center;padding-top: 20px;">
		<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/tick4.png" alt="img" width="45px" style="" />
		</div>
		<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$post['name'].',</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Thank you for Registering with us</p>
		<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;">You are very important to us, all information received will always remain confidential. We will contact you as soon as we review your message.</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Credentials to Login to '.$post['name'].'</p>
		<div style="padding:10px 10px 10px 137px;">
		<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">User Name : </span>'.$post['email'].'</h5>
		<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">Password : </span>'.$new_password.'</h5>
		</div>
		<div style="text-align:center; padding-bottom:20px; padding-top:20px;">
		<a href="'.ADMIN_SITE.'" style="text-decoration:none;">
		<span style="padding:8px 30px; border-radius:2px; color:#ffffff; font-size:17px; background-color:#e40303; text-align:center; font-weight:600">Click to Login</span>
		</a>
		</div>
		<div style="border-bottom: 1px solid #e5e5e5;">
		<div style="width:50%; float:left;">
		<p style="font-size:14px; font-weight:400; color:#353535;margin-bottom: 5px;">info@dcshrm.com</p>
		<p style="font-size:14px; font-weight:400; color:#353535;margin-top: 0px;margin-bottom: 5px;">Call Us: +1 (801) 360-5036</p>
		</div>
		<div style="width:50%;float:left;">
		<ul style="width:100%;list-style:none; padding:0px; text-align:right;">
		<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images//fb.png" alt="social" /></a></li>
		<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images/tw.png" alt="social" /></a></li>
		<li style="margin-right:5px;float:right;"><a href="javascript:void(0);"><img src="'.ADMIN_SITE.'/plugins/email_tempate_images/lnk.png" alt="social" /></a></li>
		</ul>
		</div>
		</div>
		</div>
		</div>
		</div>
		</body>
		</html>';
		// Sending email
		//if(mail($to_emp, $subject_emp, $message_emp, $headers_emp)){
		if(sendemail($to_emp,$subject_emp,$message_emp)){
			$EmailTest = 'Your mail has been sent successfully.';
		} else{
			$EmailTest =  'Unable to send email. Please try again12.';
		}
		return $EmailTest;
		//Company email Template end 	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title>DCSHRM | HOME | DASHBOARD</title>   
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
	<link href="css/style-own.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <link href="css/new_style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <link href="css/colors/green-dark.css" id="theme" rel="stylesheet">
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
       <?php include 'header.php';?>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
       <?php include 'navbar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!--<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Starter Page</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            
                        </ol>
                    </div>
                    
                </div>-->
                <div class="clearfix"></div>
               <div class="row m-t-15">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                   
                                    <p><img class="img-responsive" src="img/first-banner.jpg"></p>
                                    
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-default panel-m" style="box-shadow:none;">
                            <div class="panel-heading pannel-tttl" style="padding-left:5px"><img src="img/paper.png">DCSHRM - B-Safe Programs</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body" style="padding-top:5px">
									<div class="">
										<ul class="document">
										<?php  
			if($_cat_sub != ''){
				$where_1 = " AND category IN ($_cat_sub) ";
				
				if(isset($_cat_sub_page) and $_cat_sub_page != ''){
					$where_1 = 'AND p_id IN ('.$_cat_sub_page.') ';
				}	
				$catsql = "SELECT * FROM  `pages` WHERE page_status= 0 $where_1 order by p_id desc limit 5";
				$catfet=$prop->getAll_Disp($catsql);
				//echo count($catfet).$catsql;
				if(count($catfet) > 0){
					for($i=0; $i<count($catfet); $i++)
											{  
						?>
												<a href="category-detail.php?id=<?php echo $catfet[$i]['p_id']; ?>" target='_blank'><li><img class="arr-img" src="img/right-arrow.png"><?php echo $catfet[$i]['title']; //echo $_cat_sub_page;?></li></a>
												
				<?php }  }
			}	
else{ ?>
	<p style='font-weight:600px;'>No Details to Display!</p>
<?php }
	?>
										</ul>
										
										
										
									</div>
                               <div class="text-center" style='display:none;'><a href="saved-forms.php" target='_blank'><button class="btn btn-info btn-rounded waves-effect waves-light">View All</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-default panel-m" style="box-shadow:none;">
                            <div class="panel-heading pannel-tttl" style="padding-left:5px"><img src="img/diskette.png">Completed Courses</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body" style="padding-top:5px">
									<div class="">
										<ul class="document">
										<?php  
			
			$catsql = "SELECT k.emp_id,k.page_id,p.p_id,p.title FROM  `acknowledge` k join pages p ON k.page_id = p.p_id  WHERE k.emp_id = ".$com_id." order by p.p_id desc limit 5";
			$catfet=$prop->getAll_Disp($catsql);
			if(count($catfet)>0){
				for($i=0; $i<count($catfet); $i++)
					                    {  
					?>
											<a href="category-detail.php?id=<?php echo $catfet[$i]['p_id']; ?>" target='_blank'><li><img class="arr-img" src="img/right-arrow.png"><?php echo $catfet[$i]['title'];?></li></a>
											
			<?php }  }
else{ ?>
	<p style='font-weight:600px;'>No Details to Display!</p>
<?php }
	?>
										</ul>
										
										
										
									</div>
                               <div class="text-center" style='display:none;'><a href="saved-forms.php" target='_blank'><button class="btn btn-info btn-rounded waves-effect waves-light">View All</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
				<div class="clearfix"></div>
                <div class="row m-t-15">
                    <!--<div class="col-md-12">
                        <div class="">
                            <div class="row">
                        
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-default panel-m">
                            <div class="panel-heading pannel-tttl"><img src="img/diskette.png">DCSHRM - Saved Forms</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
									<div class="max-285 min-285">
										<ul class="document">
										<?php  
					
					$sql = "SELECT * FROM `form_fields` f JOIN dynamic_form d ON d.d_form_id=f.form_id  WHERE 1=1 AND f.`created_by`='$com_id' AND f.`is_deleted`=0 order by d_form_id desc LIMIT 0,5";
        $catfet=$prop->getAll_Disp($sql); 
		if(count($catfet)>0){
		for($i=0; $i<count($catfet); $i++)
					                    { 
					?>
											<a href="pdf/formpdprint.php?id=<?php echo $catfet[$i]['d_form_id'];?>&row_id=<?php echo $catfet[$i]['id'];?>&type=I&method=frm" target='_blank'><li><img class="arr-img" src="img/right-arrow.png"><?php echo $catfet[$i]['d_template_name'];?></li></a>
										
		<?php } } else{ ?>
			<p style='font-weight:600px;'>No Saved Forms to Display!</p>
		<?php }			?>
										</ul>
										
										
										
									</div>
									<?php if(count($catfet)>4){ ?>
                               <div class="text-center" style='display:none;'><a href="saved-forms.php" target='_blank'><button class="btn btn-info btn-rounded waves-effect waves-light">View All</button></a></div>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-default panel-m">
                            <div class="panel-heading pannel-tttl"><img src="img/paper.png">DCSHRM - Details Page</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
									<div class="max-285 min-285">
										<ul class="document">
										<?php  
			
			$where_1 = " AND category IN ($_cat_sub) ";
			if(isset($nav_main) && $nav_main===1){
				$where_1 = '';
			}	
			$catsql = "SELECT * FROM  `pages` WHERE page_status= 0 $where_1 order by p_id desc limit 5";
			$catfet=$prop->getAll_Disp($catsql);
			if(count($catfet)>0){
				for($i=0; $i<count($catfet); $i++)
					                    {  
					?>
											<a href="category-detail.php?id=<?php echo $catfet[$i]['p_id']; ?>" target='_blank'><li><img class="arr-img" src="img/right-arrow.png"><?php echo $catfet[$i]['title'];?></li></a>
											
			<?php }  }
else{ ?>
	<p style='font-weight:600px;'>No Details to Display!</p>
<?php }
	?>
										</ul>
										
										
										
									</div>
                               <div class="text-center" style='display:none;'><a href="saved-forms.php" target='_blank'><button class="btn btn-info btn-rounded waves-effect waves-light">View All</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
					 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-default panel-m">
                            <div class="panel-heading pannel-tttl"><img src="img/circular-clock.png">DCSHRM - Recent Forms</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
									<div class="max-285 min-285">
										<ul class="document">
										<?php  
		
		$where_1 = " AND scat_id IN ($_cat_sub) ";
		if(isset($nav_main) && $nav_main===1){
			$where_1 = '';
		}
		$catsql = "SELECT * FROM  `dynamic_form` WHERE d_detele_status= 0 $where_1 order by d_form_id desc limit 5";
        $catfet=$prop->getAll_Disp($catsql); 
		if(count($catfet)>0){
		for($i=0; $i<count($catfet); $i++)
					                    {  
					?>
											<a href="form-page.php?id=<?php echo $catfet[$i]['d_form_id'];?>"><li><img class="arr-img" src="img/right-arrow.png"><?php echo $catfet[$i]['d_template_name'];?></li></a>
											
		<?php } }
else{ ?>
	<p style='font-weight:600px;'>No Forms Found to Display!</p>
<?php }	?>
										</ul>
										
										
										
									</div>
                               <div class="text-center" style='display:none;'><a href="saved-forms.php" target='_blank'><button class="btn btn-info btn-rounded waves-effect waves-light">View All</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
             
                                
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid --><?php include 'footer.php';?>
            
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
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
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
	 <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <!-- accordian script -->
	<!-- Date Picker Plugin JavaScript -->		    <script src="js/validator.js"></script>
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script>
	$(function(){
  $(".accordian h3").click(function(e){
    $($(e.target).find('.ti-plus').toggleClass('open'));
  $(".accordian ul ul").slideUp();
    if ($(this).next().is(":hidden")){
    $(this).next().slideDown();
    }
  });
  
  

});
</script>
 <!-- accordian script ends-->
 <!-- On load Popup-->   
<?php
if($get_user['de_pass'] == 'dcshrm@123' and !isset($_SESSION['popup']))
{
$_SESSION['popup'] = 'true';
?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<div class="modal fade" id="myModal" style="max-width:400px; height:400px; margin:auto;background:#FFFFFF;padding:0px;">
<form method="post">
  <div class="modal-header" style="padding: 0 20px;">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Update Password</h3>
  </div>
  <div class="modal-body">
    <label for="exampleInputEmail1">New Password</label><br>
    <input type="password" data-toggle="validator" data-minlength="6" name="newpass" value="" class="form-control" id="inputPassword4" rel="showalt" placeholder="Password" required><br>
    <label for="exampleInputEmail1">Confirm Password</label><br>
										<input type="password" class="form-control"  name="connewpass" id="inputPasswordConfirm4" value="" rel="showalt1" data-match="#inputPassword4" data-error="Enter Confirm Password"  data-match-error="Whoops, Passwords don't match" placeholder="Confirm" required ><br>
  </div>
  <div class="modal-footer">
    <button type='submit' class="btn btn-block btn-success" id="updatepass" name='updatepass'>Update</button>
  </div>
</form>  
</div>
<?php }?>
</body>

</html>
