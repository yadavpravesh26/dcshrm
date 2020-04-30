<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
if(bckPermissionCompany($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
switch($method)
{
	case 'bulk':
		$msg = '';
		$file = $_FILES['csfile']['tmp_name'];
		$allowedExtensions = array('csv');
		$extension = end(explode('.',strtolower($_FILES['csfile']['name'])));
		$msg = 'File invalid format, Only CSV format valid';
		if(in_array($extension, $allowedExtensions)){		
			$handle = fopen($file, "r");
			$i=0;
			$a=0;
			$email_test='';
			while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
			{
				if($i!=0){
					$msg = 'Invalide Email id';
					if(filter_var($filesop[1], FILTER_VALIDATE_EMAIL)){
						$msg = 'Email id already exists';
						$exits = $prop->getName('count(id)', USERS, "email='".$filesop[1]."'");
						if($exits===0){
							$input   = array(
							'department_id'	=>$_POST['dept_id'],
							'name'			=>$filesop[0],
							'email'			=>$filesop[1],
							'password'		=>crypt($filesop[2]),
							'de_pass'		=>$filesop[2],
							'contact_no'	=>$filesop[3],
							'u_id'			=>$session['bid'],
							'u_type'		=>4,
							'created_id'	=>$session['bid'],
							'created_ip'	=>IP,
							'created_date'	=>DB_DATE
							);
							$result = $prop->add(USERS, $input);
							if($result)
							{
								$a=1;
								/*Send Email to Company Start*/
								$post = array('name'=>$filesop[0],'dept_id'=>$_POST['dept_id'],'email'=>$filesop[1],'password'=>$filesop[2],'contact_no'	=>$filesop[3]);
								$company_to = '';
								
								$allcompanysql = "SELECT  * from ".USERS." WHERE `u_type`= 2 and `id`= ".$session['bid'];
								$allcompanyfet=$prop->getAll_Disp($allcompanysql);
								$subject = 'New Employee Registered';
								$subject_emp = 'Thank you for registering with DCSHRM ';
								for($i=0; $i<count($allcompanyfet); $i++){
									$company_to .=  $allcompanyfet[$i]['email'].",";
								}
								$email_msg = sendemailafteremployee($post,$subject,$subject_emp,$company_to);
							}	
						}
					}
				}
				$i++;
			}
			if ($a>0) {
				
				
				setcookie('status', 'Success', time()+10);
				setcookie('title', 'Employee Created Successfully', time()+10);
				setcookie('err', 'success', time()+10);
				header('Location: employee-details.php');
			}
			else{
				setcookie('status', 'Error', time()+10);
				setcookie('title', 'Employee Creation Error', time()+10);
				setcookie('err', 'error', time()+10);
				header('Location: employee-details.php');
			}
		}
		else
		{
				setcookie('status', 'Error', time()+10);
				setcookie('title', $msg, time()+10);
				setcookie('err', 'error', time()+10);
				header('Location: employee-details.php');
		}	
	break;
}
$titleTag = 'Add';
if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',USERS, array('id'=>$_REQUEST['id'],'u_type'=>4));
	if(empty($curr_val)){
		header('Location: employee-details.php');
		exit;
	}
	if($curr_val['status']===2){
		header('Location: employee-details.php');
		exit;
	}
	if($curr_val['u_id']!=$session['bid'] && $session['b_type']!=0){
		header('Location: dashboard.php');
		exit;
	}
}
$where = ' AND u_id='.$session['bid'];
if($session['b_type']===0)
	$where = '';
	
$where_dep = ' where company_id='.$session['bid'];
$listDepart = $prop->getAll('*',DEPARTMENT_NEW, $where_dep, '', 0, 0);

function sendemailafteremployee($post,$subject,$subject_emp,$company_to){
	$cdb = new DB();
	$db = $cdb->getDb();
	$prop = new PDOFUNCTION($db);
	$departLog = $prop->get('dep_name', DEPARTMENT_NEW, array('dept_id'=>$post['dept_id']));							
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
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$departLog['dep_name'].'</p>
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
							<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['password'].'</p>
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
		if(sendemail($company_to,$subject,$message)){
			$EmailTest = 'Your mail has been sent successfully1.';
		} else{
			$EmailTest =  'Unable to send email. Please try again1.';
		}							
	/*Send Email to Company END*/
	//Employee email Template Start
		$to_emp = $post['email'];
		
		$from_emp = 'admin@dcshrm.com';
		 
		$headers_emp .= 'From: '.$from_emp."\r\n".
			'Reply-To: '.$from_emp."\r\n" .
			'X-Mailer: PHP/' . phpversion();
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
		<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">Password : </span>'.$post['password'].'</h5>
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
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
    <title>Employee Bulk Import</title>
    <!-- Bootstrap Core CSS -->
     <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	   <!-- Footable CSS -->
    <link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
	   <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
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
        .new-ad{margin-top:25px;}

.dcs-bot .btn {
height: 32px !important;
}

.dcs-bot .input-group-addon {
padding: 8px 95px 8px 26px;
font-size: 14px;
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
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Employee Bulk Import</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Employee Bulk Import</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <form data-toggle="validator" method="post" action="add-bulk-employee.php?method=bulk" enctype="multipart/form-data">
                                <div class="row">
                
                                    <div class="col-md-12">
                                        <div class="white-box" style="overflow:hidden;">
                
                
                                 <h3 class="box-title">Bulk Import</h3>
                
                                 <div class="col-md-4">
                                <div class="form-group">
                
                                     <label class="control-label">Department</label>
                                         <select class="form-control" name="dept_id" required>
                                             <option value="">Select</option>
                                        <?php
                                            $count = count($listDepart);
                                            for($i=0; $i<$count; $i++){ 
                                                echo '<option value="'.$listDepart[$i]['dept_id'].'">'.$listDepart[$i]['dep_name'].'</option>';
                                            }
                                        ?>
                                         </select>
                                         <div class="help-block with-errors"></div>
                                     </div>
                
                                     </div>
                                         <div class="form-group dcs-bot col-md-8" >
                                                    <label >Upload CSV</label>
                                                    <div >
                                                    <input type="file" class="form-control" required name="csfile" id="bulk_import_file">
                                                        <?php /*?><div class="fileinput fileinput-new input-group" style="margin-bottom:0" data-provides="fileinput" style="display:block">
                                                            <div class="form-control" data-trigger="fileinput">
                                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                <span class="fileinput-filename"></span>
                                                            </div>
                                                            <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">Select file</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" required name="csfile" id="bulk_import_file">
                                                            </span>
                                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div><?php */?>
                                                    </div>
                                                     <div class="help-block with-errors"></div>
                                                </div>
                
                                        <div class="form-actions col-md-4 pull-right">
                                            <div class="form-group text-right">
                                                <a href="bulk-import-employee.csv"><span  class="btn btn-dark" style=" background: #0d558a;color: #fff;height: 34px !important;padding: .8rem 10px;border-radius: 4px !important;"><i class="icon-cloud-download"></i> Sample File</span></a>
                                                <button type="submit" class="btn btn-success">Import</button>
                                                <button type="reset" class="btn btn-default">Reset</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                </form>
            </div>
        <footer class="footer text-center"> <?php include 'footer.php';?> </footer>
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
 <!-- Sweet-Alert  -->
    <script src="js/validator.js"></script>
    <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
	   <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
    
    <script>
	$(document).ready(function () { //newly added
		$("select[name='dept_id']").change(function(){
			$("#dept_id_text").val($(this).find(":selected").text());
		});
		$("#bulk_import_file").change(function () {
			var fileExtension = ['csv'];
			if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
				swal("Cancelled", "File invalid format, Only CSV format valid", "error");
				$(this).val('');
			}
		});
	//Start
	 <?php if(isset( $_COOKIE['err']))
  			{

  				echo 'swal("'.$_COOKIE['status'].'", "'.$_COOKIE['title'].'", "'.$_COOKIE['err'].'");';
				?>
				setTimeout(function() {
					$(".confirm").trigger('click');
				  }, 3000);
				<?php
  				setcookie("status", $_COOKIE['status'], time()-100);
  				setcookie("title", $_COOKIE['title'], time()-100);
  				setcookie("err", $_COOKIE['err'], time()-100);
  			}
			else
			{
				
			}
  			?>
		
	});	
   

  </script>
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
	<!-- Footable -->
    <script src="plugins/bower_components/footable/js/footable.all.min.js"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->

    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- end - This is for export functionality only -->
    

</body>

</html>