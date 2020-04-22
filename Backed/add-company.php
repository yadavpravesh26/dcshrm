<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(bckPermission($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
$tbl_name = DEPARTMENT;
$arrAllIndustries = $prop->getAll('*',$tbl_name,'where dep_status !=2','');
$arrCompanySize = array('50','100','150','200','250','300','400','500','Above');
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	case 'add':
	extract($_POST);
	$msg = 'Fill all mandatory fields';
	if($_POST['cfname']!='' && $_POST['adminname']!='' && $_POST['clname']!='' && $_POST['connewpass']!='' && $_POST['mobile']!=''){
		$msg = 'Enter valid email id';
		if(filter_var($_POST['clname'], FILTER_VALIDATE_EMAIL)){
			$msg = 'Email id already exists';
			$exits = $prop->getName('count(id)', USERS, "status!=2 AND email='".$_POST['clname']."'");
			if($exits===0){
				if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
					$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');
					
					$extension = end(explode('.',strtolower($_FILES['file']['name'])));
					if(in_array($extension, $allowedExtensions)){
						$logo = time().'.'.$extension;
						if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/logo/'.$logo)) {
						/*Permission*/	
						$msg = 'please select permission on program details tab';
						$category = array();
							if(isset($_POST['category'])){
								$cat = implode(',', $_POST['category']);
								$category['c'] = $cat;
								if(isset($_POST['SubCategory'])){
									$sub = array();
									foreach($_POST['SubCategory'] as $key => $value){
										foreach($value as $key2 => $value2){
											$sub[] = $value2;
										}
									}
									$sub = implode(',', $sub);
									$category['s'] = $sub;
								}
								if(isset($_POST['pagename'])){
									$page = array();
									foreach($_POST['pagename'] as $key => $value){
										foreach($value as $key2 => $value2){
											foreach($value2 as $key3 => $value3){
													$page[] = $value3;
											}
										}
									}
									$page = implode(',', $page);
									$category['p'] = $page;
								}
							
								$insdatalog   = array(
										'c_name'	=>$_POST['cfname'],
										'name'		=>$_POST['adminname'],
										'email'		=>$_POST['clname'],
										'password'	=>crypt($_POST['connewpass']),
										'de_pass'	=>$_POST['connewpass'],
										'c_type'	=>$_POST['company_type'],
										'permission'	=>json_encode($category),										
										'industry_type'	=>$_POST['industry_type'],
										'taxId'	=>$_POST['taxId'],
										'contact_person'	=>$_POST['conPerson'],
										'ProAnuVal'	=>$_POST['ProAnuVal'],
										'state'	=>$_POST['us_state'],
										'c_size'	=>$_POST['company_size'],
										'c_logo'	=>$logo,
										'contact_no'=>$_POST['mobile'],
										'u_type'	=>2,
										'created_date'=>DB_DATE,
										'created_id'=>$session['bid'],
										'created_ip'=>IP
										);
										
								$result = $prop->add(USERS, $insdatalog);
								if ($result) {
									
									$post = array();
									$post = $_POST;
									$admin_to = '';
									$alladminsql = "SELECT  * from ".USERS." WHERE `u_type`= 0 or `u_type`= 1";
									$alladminfet=$prop->getAll_Disp($alladminsql);
									for($i=0; $i<count($alladminfet); $i++){
										$admin_to .=  $alladminfet[$i]['email'].",";
									}
									$cfname = sendingemailaftercompanyregistration($post,'New Company Registered',$admin_to);
									setcookie('status', 'Success', time()+10);
									setcookie('title', 'Company Created Successfully', time()+10);
									setcookie('err', 'success', time()+10);
									header('Location: manage-company.php');
									break;
								}
							}
						}else{
							$msg = 'Logo uploaded failed!';
						}
					}else{
						$msg = 'Logo file invalid format';
					}
				}
			}
		}
	}
	setcookie('status', 'Error', time()+10);
	setcookie('title', $msg, time()+10);
	setcookie('err', 'success', time()+10);
	break;
	case 'update':
	$msg = 'Fill all mandatory fields';
	if($_POST['cfname']!='' && $_POST['adminname']!='' && $_POST['connewpass']!='' && $_POST['mobile']!=''){
		$msg = '';
		$t_cond = array("id" => $_REQUEST['id']);
		/*Permission*/	
		$category = array();
		if(isset($_POST['category'])){
			$cat = implode(',', $_POST['category']);
			$category['c'] = $cat;
			if(isset($_POST['SubCategory'])){
				$sub = array();
				foreach($_POST['SubCategory'] as $key => $value){
					foreach($value as $key2 => $value2){
						$sub[] = $value2;
					}
				}
				$sub = implode(',', $sub);
				$category['s'] = $sub;
			}
			if(isset($_POST['pagename'])){
				$page = array();
				foreach($_POST['pagename'] as $key => $value){
					foreach($value as $key2 => $value2){
						foreach($value2 as $key3 => $value3){
								$page[] = $value3;
						}
					}
				}
				$page = implode(',', $page);
				$category['p'] = $page;
			}
		}	
		$insdatalog   = array(
			'c_name'	=>$_POST['cfname'],
			'name'		=>$_POST['adminname'],
			'password'	=>crypt($_POST['connewpass']),
			'de_pass'	=>$_POST['connewpass'],
			'c_size'	=>$_POST['company_size'],			
			'email'		=>$_POST['clname'],
			'c_type'	=>$_POST['company_type'],
			'permission'	=>json_encode($category),
			'industry_type'	=>$_POST['industry_type'],
			'taxId'	=>$_POST['taxId'],
			'contact_person'	=>$_POST['conPerson'],
			'ProAnuVal'	=>$_POST['ProAnuVal'],
			'state'	=>$_POST['us_state'],			
			'contact_no'=>$_POST['mobile'],
			'updated_date'=>DB_DATE,
			'updated_id'=>$session['bid'],
			'updated_ip'=>IP
			);
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
			$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');
			
			$extension = end(explode('.',strtolower($_FILES['file']['name'])));
			if(in_array($extension, $allowedExtensions)){
				$logo = time().'.'.$extension;
				if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/logo/'.$logo)) {
					$insdatalog['c_logo'] = $logo;
					$msg = '';
				}else{
					$msg = 'Logo uploaded failed!';
				}
			}else{
				$msg = 'Logo file invalid format';
			}
		}
		if($prop->update(USERS, $insdatalog, $t_cond))
		{
			
			$post = array();
			$post = $_POST;
			$admin_to = '';
			$alladminsql = "SELECT  * from ".USERS." WHERE `u_type`= 0 or `u_type`= 1";
			$alladminfet=$prop->getAll_Disp($alladminsql);
			for($i=0; $i<count($alladminfet); $i++){
				$admin_to .=  $alladminfet[$i]['email'].",";
			}
			$cfname = sendingemailaftercompanyregistration($post,'Company Updated Successfully',$admin_to);
			setcookie('status', 'Success', time()+10);
			setcookie('title', 'Company Updated Successfully', time()+10);
			setcookie('err', 'success', time()+10);
			header('Location: manage-company.php');
			exit;
		}
	}
	setcookie('status', 'Error', time()+10);
	setcookie('title', $msg, time()+10);
	setcookie('err', 'success', time()+10);
	break;
}
$titleTag = 'Add';
if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',USERS, array('id'=>$_REQUEST['id'],'u_type'=>2));
	if(empty($curr_val)){
		header('Location: manage-company.php');
		exit;
	}
	if($curr_val['status']===2){
		header('Location: manage-company.php');
		exit;
	}
}
function sendingemailaftercompanyregistration($post,$subject_msg,$admin_to){
	
	//Admin email Template Start
	$subject = $subject_msg;
	$from = 'admin@dcshrm.com';
	
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$BccEmailList = 'm.kamal@hexagonitsolutions.com';
	$headers .= "Bcc: $BccEmailList\r\n";
	 
	$message = '<html>';
	$message .= '<body style="background-color:#ffffff; font-family: Roboto, sans-serif;">
	<div style="width:575px; margin:30px auto;padding:0px 25px; background-color:#f9f9f9; border-top:4px solid #e40303">
	<div style="text-align:center; margin:25px;">
	<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/logo.png" alt="logo" />
	</div>
	<div style="padding:0px 0px 40px; display: inline-block;">
	<div>
	<img src="'.ADMIN_SITE.'/plugins/email_tempate_images/banner-com.png" alt="banner" width="575px" style="" />
	</div>
	<div style="background-color:#fff;padding: 0px 20px 10px; overflow: hidden;">
	<p style="text-align:left; font-size:16px; font-weight:800; color:#353535; padding-top:30px; margin-bottom:10px;margin-top: 0px;">Hi Admin,</p>
	<div style="display: inline-block;width: 100%;padding:0px; border:1px solid #eaeaea">
	<h2 style="border-bottom: 2px solid #e6e6e6;margin: 0px;padding:10px;font-size: 16px;font-weight: 500;">Company Details</h2>
	<div style="display:flex; flex-wrap:wrap;padding:10px 0px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Company Name </h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['cfname'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Company Logo</h5>
	<img src="'.LIVE_SITE.'/images/logo/'.$logo.'" style="width:116px;" alt="logo" /></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Company Type </h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['company_type'].'</p></td>
	  </tr>
	  <tr>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Industry</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['industry_text'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Legal Name</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['adminname'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Tax ID</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['taxId'].'</p></td>
	  </tr>
	  <tr>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">State of Business</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['us_state'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Size</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['company_size'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Contact Person</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['conPerson'].'</p></td>
	  </tr>
	  <tr>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Phone Number </h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['mobile'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Projected Annual Value</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">US$'.$post['ProAnuVal'].'</p></td>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Email</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['clname'].'</p></td>
	  </tr>
	  <tr>
		<td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Password</h5>
	<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['connewpass'].'</p></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	</div>
	</div>
	<p style="text-align:left; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; padding-bottom:30px;line-height:25px;border-bottom: 1px solid #e5e5e5;">If you don’t know why you got this email, please tell us straight away so we can fix this for you.</p>
	<div style="width:50%; float:left;">
	<p style="font-size:14px; font-weight:400; color:#353535;margin-bottom: 5px;">dcshrm.com</p>
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
	</body>';
	$message .= '</html>';
	 
	// Sending email
	if(mail($admin_to, $subject, $message, $headers)){
		$EmailTest = 'Your mail has been sent successfully1.';
	} else{
		$EmailTest =  'Unable to send email. Please try again.1';
	}
	//Admin email Template end 
	
	//Company email Template Start
	$to_company = $post['clname'];
	$subject_company = 'Thank you for registering with DCSHRM ';
	$from_company = 'admin@dcshrm.com';
	 
	$headers_company .= 'From: '.$from_company."\r\n".
		'Reply-To: '.$from_company."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$headers_company  = 'MIME-Version: 1.0' . "\r\n";
	$headers_company .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$BccEmailList = 'm.kamal@hexagonitsolutions.com';
	$headers_company .= "Bcc: $BccEmailList\r\n";
	 
	$message_company = '<html lang="en">
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
	<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$post['cfname'].',</p>
	<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Thank you for Registering with us</p>
	<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry content of a page when looking at its layout.</p>
	<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Credentials to Login to '.$post['cfname'].'</p>
	<div style="padding:10px 10px 10px 137px;">
	<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">User Name : </span>'.$post['clname'].'</h5>
	<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">Password : </span>'.$post['connewpass'].'</h5>
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
	if(mail($to_company, $subject_company, $message_company, $headers_company)){
		$EmailTest = 'Your mail has been sent successfully.';
	} else{
		$EmailTest = 'Unable to send email. Please try again.';
	}
	//Company email Template end +
	return $EmailTest;
}

?>
<!DOCTYPE html>

<html lang="en">

<head>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
    <title>Manage Category</title>
    <!-- Bootstrap Core CSS -->
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	<!-- Footable CSS -->
	<link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css"/>
	<link href="plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
	<!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<!-- Animation CSS -->
	<link href="css/animate.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="css/style.css" rel="stylesheet">
	<link href="css/custom-style.css" rel="stylesheet">
	<!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	<!-- color CSS you can use different color css from css/colors folder -->
	<!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
	<link href="css/colors/default-dark.css" id="theme" rel="stylesheet">
    <link href="css/jquery.bonsai.css" rel="stylesheet" type="text/css">
    <!--<link href="css/colors/blue.css" id="theme" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
	<style>
	.navigation .pull-right a {
    padding: 0;
}
	.navigation ul li:first-child:before {
    top: 0;
}
		.navigation ul li {
    position: relative; list-style: none;
}
		.navigation ul {
    padding-left: 0px;
}
		.navigation ul li:after {
    position: absolute;
    top: 20px;
    width: 20px;
    border-bottom: 1px dashed #4f5366;
}

.navigation ul li:after, .navigation ul li:before {
    left: 0;
    content: "";
}
.navigation ul li:before {
    position: absolute;
    top: -20px;
    bottom: 20px;
    width: 1px;
    border-left: 1px dashed #4f5366;
}
.navigation ul li a:before {
    content: "";
    position: absolute;
    top: 18px;
    left: 18px;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background-color: #4f5366;
}
.navigation ul li:after, .navigation ul li:before {
    left: 0;
    content: "";
}
.navigation ul li a {
    padding-left: 40px;
    padding-right: 25px;
    line-height: 40px;
    color: #2e2e2e;
    font-size: 12px;
    white-space: nowrap;
    font-weight: 400;
    display: inline-block;
}

		.footable-row-detail-name {
    display: table-cell;
    font-weight: 500;
    padding-right: 3px;
    padding-bottom: 5px;
    /* display: none; */
}
		.footable-row-detail-inner {width:100%;}
	</style>
<style>
#myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

#myUL .caret {
display:block;
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

#myUL .caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

#myUL .caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0e5589;
    border-color: #0e5589 #0e5589 #0e5589;
}
.nav-tabs {
    border: 1px solid #ecf0f4;
}
ol.auto-checkboxes.bonsai label {
    margin-left: 7px;
}
.nav-tabs>li>a {
    border-radius: 0;
    color: #2b2b2b;
    font-weight: 600;
}
</style>
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
                	<div class="col-md-12">
                    	<ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" href="#Company-Details" role="tab" data-toggle="tab">Company Details</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#Program-Details" role="tab" data-toggle="tab">Program Details</a>
                          </li>
                        </ul>
                    </div>
                    <!--<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?php echo $titleTag; ?> Company </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active"><?php echo $titleTag; ?> Companies</li>
                        </ol>
                    </div>-->
                    <!-- /.col-lg-12 -->
                </div>
                <?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');?>

                <form data-toggle="validator" id="formadvertiser" enctype="multipart/form-data" method="post" action="add-company.php?method=<?php echo $foraction; ?>" >
               <div class="tab-content">
               
                	<div role="tabpanel" class="tab-pane fade in active" id="Company-Details">
                		<div class="row">

                    <div class="col-md-12">

                        <div class="white-box" >
							<h3 class="box-title"><?php echo $titleTag; ?> Company</h3>
							
                                       <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Company Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleInputuname" name="cfname" placeholder="Company Name" value="<?php echo $curr_val['c_name'];?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Company Logo</label>
                                            <div class="input-group">
                                            	<input type="file" class="form-control" name="file" accept="image/x-png,image/gif,image/jpeg" <?php echo (isset($_REQUEST['id'])?'':'required'); ?>>
                                                <?php echo ((isset($_REQUEST['id']) && $curr_val['c_logo']!='')?'<img src="'.LIVE_SITE.'images/logo/'.$curr_val['c_logo'].'" width="60">':''); ?>
                                                <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
													<div class="form-control" data-trigger="fileinput"> 
														<i class="glyphicon glyphicon-file fileinput-exists"></i> 
														<span class="fileinput-filename"></span>
													</div>
													<span class="input-group-addon btn btn-default btn-file"> 
														<span class="fileinput-new">select file</span> 
														<span class="fileinput-exists">Change</span>
														<input type="file" class="form-control" name="file" accept="image/x-png,image/gif,image/jpeg" <?php echo (isset($_REQUEST['id'])?'':'required'); ?>>
													</span> 
													<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
													<?php echo ((isset($_REQUEST['id']) && $curr_val['c_logo']!='')?'<img src="'.LIVE_SITE.'images/logo/'.$curr_val['c_logo'].'" width="60">':''); ?>
												</div><?php */?>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Company Type</label>
                                            <div class="input-group">
                                                <select name="company_type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option value="Limited Liability Company" <?php if($curr_val['c_type']=='Limited Liability Company'){echo "selected";}?>>Limited Liability Company</option>
                                                    <option value="Private Corporation" <?php if($curr_val['c_type']=='Private Corporation'){echo "selected";}?>>Private Corporation</option>
                                                    <option value="Public Corporation" <?php if($curr_val['c_type']=='Public Corporation'){echo "selected";}?>>Public Corporation</option>
                                                    <option value="Sole Proprietorship" <?php if($curr_val['c_type']=='Sole Proprietorship'){echo "selected";}?>>Sole Proprietorship</option>
                                                    <option value="Partnership-LLP" <?php if($curr_val['c_type']=='Partnership-LLP'){echo "selected";}?>>Partnership / LLP</option>
                                                    <option value="Tax Exempt" <?php if($curr_val['c_type']=='Tax Exempt'){echo "selected";}?>>Tax Exempt</option>
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Industry</label>
                                            <div class="input-group">
                                                <select name="industry_type" class="form-control" required>
                                                    <option value="">Select Industry</option>
                                                    <?php
                                                    
													$Indus_size = count($arrAllIndustries);
													for($i=0;$i<$Indus_size;$i++){
													echo '<option value="'.$arrAllIndustries[$i]['dept_id'].'" '.($arrAllIndustries[$i]['dept_id']===$curr_val['industry_type']?'selected':'').'>'.$arrAllIndustries[$i]['dep_name'].'</option>';
													}
													?>                                                    
                                                </select>
                                                <input type="hidden" id="industry_text" name="industry_text">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Legal Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleInputuname" name="adminname" placeholder="Legal Name" value="<?php echo $curr_val['name'];?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Tax ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="exampleInputuname" name="taxId" placeholder="Tax ID" value="<?php echo $curr_val['c_name'];?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">State of Business</label>
                                            <div class="input-group">
                                                <select name="us_state" class="form-control" required>
                                                <?php if($curr_val['state']!=''){?>
                                                <option value="<?php echo $curr_val['state'];?>" selected><?php echo $curr_val['state'];?></option>
                                                <?php } ?>
                                                    <option value="">Select State</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District of Columbia">District of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Guam">Guam</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Northern Marianas Islands">Northern Marianas Islands</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Puerto Rico">Puerto Rico</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Virgin Islands">Virgin Islands</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option></select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Size</label>
                                            <div class="input-group">
                                                <select name="company_size" class="form-control" required>
												<option value="">Select Size</option>
												<?php 
												$size = count($arrCompanySize);
												for($i=0;$i<$size;$i++){
													echo '<option value="'.$arrCompanySize[$i].'" '.($arrCompanySize[$i]===$curr_val['c_size']?'selected':'').'>'.$arrCompanySize[$i].'</option>';
												}
												
												?>
												</select>
                                            </div>
                                            <div class="help-block with-errors "></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Contact Person</label>
                                            <div class="input-group">
                                                <!--<div class="input-group-addon"><i class="ti-user"></i></div>-->
                                                <input type="text" class="form-control" id="exampleInputuname" name="conPerson" placeholder="Contact Person" value="<?php echo $curr_val['contact_person'];?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputuname">Email</label>
                                            <div class="input-group">
                                                <!--<div class="input-group-addon"><i class="ti-email"></i></div>-->
                                                <input type="email" class="form-control" id="inputemail" placeholder="Email" name="clname" data-error="Please enter valid email address" value="<?php echo $curr_val['email'];?>" <?php echo (isset($_REQUEST['id'])?'readonly':'required'); ?>>
                                            </div>
                                            <div class="help-block with-errors alexist"></div>
                                        </div>
										<div class="form-group col-md-4">
                                            <label for="exampleInputuname">Phone Number</label>
                                            <div class="input-group">
                                                <!--<div class="input-group-addon"><i class="ti-mobile"></i></div>-->
												<input type="number" min="1000000000" max="9999999999" name="mobile" value="<?php echo $curr_val['contact_no']; ?>" data-error="Please enter valid phone number" class="form-control" placeholder="Phone Number" required="">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
										<div class="form-group col-md-4">
                                            <label for="exampleInputuname">Projected annual Value</label>
                                            <div class="input-group">
                                                <input type="text" name="ProAnuVal" value="<?php echo $curr_val['ProAnuVal']; ?>" class="form-control" placeholder="Projected annual Value" required="">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inputEmail" class="control-label">Password</label>
											<div class="input-group">
                                                <!--<div class="input-group-addon"><i class="ti-key"></i></div>-->
                                                <input type="password" data-toggle="validator" data-minlength="6" name="newpass" rel='showalt' value="<?php echo $curr_val['de_pass'];?>" class="form-control" id="inputPassword4" placeholder="Password" autocomplete="off" required>

											</div>
											<span style='color:red;display:none;' id='showalt'>Space Not Allowed</span>
											<div class="help-block with-errors"></div>
										</div>

										<div class="form-group col-md-4">
                                            <label for="exampleInputuname">Confirm password</label>
                                            <div class="input-group">
                                                <!--<div class="input-group-addon"><i class="ti-key"></i></div>-->
                                                <input type="password" class="form-control" name="connewpass" id="inputPasswordConfirm4" value="<?php echo $curr_val['de_pass'];?>" rel='showalt1' data-match="#inputPassword4" data-match-error="Whoops, Passwords don't match" autocomplete="off"  placeholder="Confirm" required>
                                            </div>
											<span style='color:red;display:none;' id='showalt1'>Space Not Allowed</span>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        
                                        
                                        

                                        </div>
							
                         </div>   


                    </div>

                </div>
                	</div>
                    <div role="tabpanel" class="tab-pane fade" id="Program-Details">
                		<div class="row">
                        	<div class="col-lg-12">
                            	<div class="white-box">
                                <h3 class="box-title m-b-0">List Of Categories</h3>
                                <div class="row">
                                
                                 	<?php
									$permission = array();
									if(isset($curr_val['permission']) && $curr_val['permission']!=''){
										$per = json_decode($curr_val['permission'], TRUE);
										$permission['c'] = explode(",",@$per['c']);
										$permission['s'] = explode(",",@$per['s']);
										$permission['p'] = explode(",",@$per['p']);
									}
									$sqlm = 'SELECT c_id,c_name as name from `'.MAIN_CATEGORY.'` WHERE status=0 ';
									$row_m=$prop->getAll_Disp($sqlm);
									$count_m = count($row_m);
									for($i=0; $i<$count_m; $i++){?>
									<div class="col-lg-4">
										<ol class="auto-checkboxes" data-name="category[]">
										  <li class="expanded" data-value="<?php echo $row_m[$i]['c_id']; ?>" <?php if (in_array($row_m[$i]['c_id'], $permission['c'])){?> data-checked='true'<?php } ?>><?php echo $row_m[$i]['name']; ?>
											<ol>
											  <?php
											  $sqls = "SELECT c_id as id,c_name as c_id, sc_name as name  from `".SUB_CATEGORY."` WHERE status=0 AND c_name='".$row_m[$i]['c_id']."'";
												$row_s=$prop->getAll_Disp($sqls);
												$count_s = count($row_s);
												for($j=0; $j<$count_s; $j++){?>
												<li data-name="SubCategory[<?php echo $row_m[$i]['c_id']; ?>][]" data-value="<?php echo $row_s[$j]['id']; ?>" data-id="<?php echo $row_s[$j]['id']; ?>" <?php if (in_array($row_s[$j]['id'], $permission['s'])){?> data-checked='true'<?php } ?>>
												<?php echo $row_s[$j]['name']; ?>
												<ol>
												  <?php
													$sqlp = 'SELECT p_id,title from `'.PAGES.'` WHERE category='.$row_s[$j]['id'].' AND page_status=0 order by title ASC';
													$row_p=$prop->getAll_Disp($sqlp);
													$count_p = count($row_p);
													for($k=0; $k<$count_p; $k++){?>
													<li data-name="pagename[<?php echo $row_m[$i]['c_id']; ?>][<?php echo $row_s[$j]['id']; ?>][]" data-value="<?php echo $row_p[$k]['p_id']; ?>"<?php if (in_array($row_p[$k]['p_id'], $permission['p'])){?> data-checked='true'<?php } ?>> <?php echo $row_p[$k]['title']; ?></li>
													<?php }?>
												</ol>
											  </li>
											  <?php } ?>
											</ol>
										  </li>
										</ol>
									</div>
									<?php } ?>
                                </div>                                    
                            </div>
                            </div>
                            
                        </div>
                	</div>
               
                 
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12" style="margin-bottom:40px;">
                    <button type="button" class="btn btn-inverse waves-effect waves-light pull-right" onClick="ResetFormVal();">Cancel</button>
                    <button type="submit" id="add_new_company" class="btn btn-success waves-effect waves-light pull-right m-r-10">
                    <?php if(isset($_REQUEST['id'])){	?> Update <?php } else { ?> Add <?php } ?>
                    </button>
                </div> 
                </form>  
            </div>
            <!-- /.container-fluid -->
              <?php include "footer.php" ?>

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
	<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="bootstrap/dist/js/tether.min.js"></script>
	<script src="bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
	<script src="js/custom.min.js"></script>
	<script src="js/validator.js"></script>
	<!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
	<!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/validator.js"></script>
    
    
	<script>
	
	$('#add_new_company').click(function() {
	  console.log('okkkk');
	  if ($('input[name="category[]"]').is(':checked')) 
	  {
	  	return true;
	  }
	  else
	  {
	  	swal('Please select Permission');
		setTimeout(function() {
			$(".confirm").trigger('click');
		}, 3000);
		return false;
	   }	
	});
	<?php 
		if($_COOKIE['err'] !='')
		{
			echo 'swal("'.$_COOKIE['status'].'", "'.$_COOKIE['title'].'", "'.$_COOKIE['err'].'");';
				?>
				setTimeout(function() {
					$(".confirm").trigger('click');
				  }, 3000);
				<?php
			setcookie('status', $_COOKIE['status'], time()-10);
			setcookie('title', $_COOKIE['title'], time()-10);
			setcookie('err', $_COOKIE['err'], time()-10);
		}
	?>
	$(document).ready(function () { //newly added
		$("select[name='industry_type']").change(function(){
			$("#industry_text").val($(this).find(":selected").text());
		});
		
		<?php //if(!(isset($_REQUEST['id']) && $_REQUEST['id']>0)){ ?>
        $('#inputemail').keyup(function () {
			//alert($(this).val());
            var inputemail = $(this).val(); // assuming this is a input text field
			
				$.ajax({
						type: "POST",
						url: "ajax.php",
						cache:false,
						data: 'emailid='+inputemail+'&meth=companyemailexist',
						dataType: 'json',
						success: function(data)
						{
							if(data.status) {
								console.log(data.status+"ppp");
								$("#inputemail").css("border", "1px solid #CC2424");
								$(".alexist").html("Email ID already exist");
								$(".alexist").css("color", "#CC2424");
								$("#inputemail").focus();
								 $(':input[type="submit"]').prop('disabled', true);
								return false;
							}
							else {
								console.log(data.status);
								$("#inputemail").css("border", "1px solid #E4E7EA");
								$(".alexist").html("");
								 $(':input[type="submit"]').prop('disabled', false);
							}
						}
					});
					
                
        });
		<?php //} ?>
		$("#inputPassword4, #inputPasswordConfirm4").keydown(function(e){
		 if (e.keyCode == 32) { 
		var ID=$(this).attr('rel');
		 $("#"+ID).fadeIn(1000).fadeOut(1000);
       return false; 
     }
	});	
    });
	function ResetFormVal(){
		$("#formadvertiser")[0].reset();
	}
	</script>
<script src="js/jquery.qubit.js"></script>
<script src="js/jquery.json-list.js"></script>
<script src="js/jquery.bonsai.js"></script>
<script>
$('.auto-checkboxes').bonsai({
  expandAll: true,
  checkboxes: true, // depends on jquery.qubit plugin
  createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
});
</script>
<script>
$(document).ready(function () {
	$( 'input[type="checkbox"]' ).click(function() {
		setInterval(function(){ 
			$( 'input[type="checkbox"]' ).each(function( index ) {
				console.log($(this).val());
				if ($(this).prop("indeterminate")) {
					$(this).prop("indeterminate", false);
					$(this).prop("checked", true);
					console.log( index + ": " + $( this ).val() );
				}
			});
		}, 3000);
	  	
	  
	});
	
})
</script>
</body>

</html>