<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "jobs";
if(bckPermission($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	case 'add':
		$last_date_apply = $_POST['last_date_apply'];
		$last_date_apply = explode('/',$last_date_apply);
		$mm = $last_date_apply[0];
		$dd = $last_date_apply[1];
		$yyyy = $last_date_apply[2];
		$date_make = $yyyy.'-'.$mm.'-'.$dd;
		$insdata = array(
					'job_id'		=>$_POST['job_id'],
					'job_title'		=>$_POST['job_title'],
					'company_name'		=>$_POST['company_name'],
					'job_city'		=>$_POST['job_city'],
					'job_state'		=>$_POST['job_state'],
					'duration'	=>$_POST['duration'],
					'pay_range'	=>$_POST['pay_range'],
					'last_date_apply'	=>$date_make,
					'job_responsibilities'	=>$_POST['job_responsibilities'],
					'job_requirements'	=>$_POST['job_requirements'],
					'created_date'	=>DB_DATE
			);
		$result = 1;
		$msg = 'Job Creation Error';
		
		if($result)
		$res = $prop->addID($table_name, $insdata);
		
        if ($res != 0) {
		
				$sql =  "SELECT DISTINCT your_email FROM job_alerts WHERE alert_type = 1";
				$row = $prop->getAll_Disp($sql);
				$AllEmails = count($row);
				$all_emails='';
				for($i=0;$i<$AllEmails;$i++){
					$all_emails .= $row[$i]['your_email'].",";
				}			
			send_email_to_all($all_emails,$res,$insdata);			
			setcookie("status", "Success", time()+10);
			setcookie("title", "Job Created Successfully", time()+10);
			setcookie("err", "success", time()+10);
			header('Location: manage-jobs.php');
		}
	    else{
			setcookie("status", "Error", time()+10);
            setcookie("title", $msg, time()+10);
            setcookie("err", "error", time()+10);
			header('Location: add-jobs.php');
		}
	break;
	case 'update':
		$last_date_apply = $_POST['last_date_apply'];
		$last_date_apply = explode('/',$last_date_apply);
		$mm = $last_date_apply[0];
		$dd = $last_date_apply[1];
		$yyyy = $last_date_apply[2];
		$date_make = $yyyy.'-'.$mm.'-'.$dd;
		//$last_date_apply = date("Y-m-d",);
		$t_cond = array("id" => $_REQUEST['id']);
		$value = array(
					'job_id'		=>$_POST['job_id'],
					'job_title'		=>$_POST['job_title'],
					'company_name'		=>$_POST['company_name'],
					'job_city'		=>$_POST['job_city'],
					'job_state'		=>$_POST['job_state'],
					'duration'	=>$_POST['duration'],
					'pay_range'	=>$_POST['pay_range'],
					'last_date_apply'	=> $date_make,
					'job_responsibilities'	=>$_POST['job_responsibilities'],
					'job_requirements'	=>$_POST['job_requirements'],
					'created_date'	=>DB_DATE
			);
		$result = 1;
		$msg = 'Job Updated Error';
		
		if($result)
			$res = $prop->update($table_name, $value, $t_cond);
		if($res)
		{
			setcookie("status", "Success", time()+10);
			setcookie("title", "Job Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			header('Location: manage-jobs.php');
		}else{
			setcookie("status", "Error", time()+10);
            setcookie("title", $msg, time()+10);
            setcookie("err", "error", time()+10);
			header('Location: add-jobs.php?method=modify&id='.$_REQUEST['id']);
		}

	break;
}
$titleTag = 'Add';
if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',$table_name, array("id"=>$_REQUEST['id']));
	if(empty($curr_val)){
		header('Location: manage-jobs.php');
		exit;
	}
}

function send_email_to_all($your_email,$job_id,$post){
	$to = $your_email;		
	$from = 'admin@dcshrm.com';		 
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$message = '<html lang="en">
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
		<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello Dear,</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Job Alert</p>
		<div style="padding:10px 10px 10px 137px;">
	<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Company Name : </span>'.$post['company_name'].'</h5>
	<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Position Title : </span>'.$post['job_title'].'</h5>
    <h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Pay Range : </span>'.$post['pay_range'].'</h5>
    <h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Job Location : </span>'.$post['job_city'].','.$post['job_state'].'</h5>
    <h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Duration : </span>'.$post['duration'].'</h5>
    <h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 110px;display: inline-block;text-align:right;    margin-right: 3px;">Last Date Apply : </span>'.$post['last_date_apply'].'</h5>
	</div>
		
		<div style="text-align:center; padding-bottom:20px; padding-top:20px;">
		<a href="https://dcshrm.com/newchanges/job-details.php?jobID='.$job_id.'" style="text-decoration:none;">
		<span style="padding:8px 30px; border-radius:2px; color:#ffffff; font-size:17px; background-color:#e40303; text-align:center; font-weight:600">Click to Apply</span>		</a>		</div>
		<div style="border-bottom: 1px solid #e5e5e5;">
		<div style="width:50%; float:left;">
		<p style="font-size:14px; font-weight:400; color:#353535;margin-bottom: 5px;">info@dcshrm.com</p>
		<p style="font-size:14px; font-weight:400; color:#353535;margin-top: 0px;margin-bottom: 5px;">91+7005757512</p>
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
	
	$subject = 'New Job alert on DCSHRM';
	if(mail($to, $subject, $message, $headers)){
		$msg = true;
	} else{
		$msg =  false;
	}
}
?>
<!DOCTYPE html>

<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
	<title><?php echo $titleTag; ?> Job Details</title>
	<!-- Bootstrap Core CSS -->
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	<!-- Footable CSS -->
	<link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
	<link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css"/>
	<link href="plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
	<!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	<!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<!-- Animation CSS -->
	<link href="css/animate.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="css/style.css" rel="stylesheet">
	<link href="css/custom-style.css" rel="stylesheet">
	<!-- color CSS you can use different color css from css/colors folder -->
	<!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
	<link href="plugins/bower_components/icheck/skins/all.css" rel="stylesheet">
	<link href="css/colors/default-dark.css" id="theme" rel="stylesheet">
    
	<!--<link href="css/colors/blue.css" id="theme" rel="stylesheet">-->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
	<style>
		.file-box td {
    height: 73px !important;
    vertical-align: middle;
    text-overflow: ellipsis;
    /* white-space: nowrap; */
}
		span.input-group-addon.btn.btn-default.btn-file {
    width: 100px;
    margin: -3px -2px;
    padding: 10px 0;
}
		.navigation ul li:first-child:before {
			top: 0;
		}

		.navigation ul li {
			position: relative;
			list-style: none;
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

		.navigation ul li:after,
		.navigation ul li:before {
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

		.navigation ul li:after,
		.navigation ul li:before {
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

		.footable-row-detail-inner {
			width: 100%;
		}
		.wid100 {width:100%}
		.file-box {
    border: 1px dashed #c0dbfc;
    padding: 10px 10px 0;
    border-radius: 6px;
}

		h3.m-t-0.m-b-10 {
    background: #429aec;
    overflow: hidden;
    padding: 7px 23px 7px 15px;
    margin-bottom: -10px !important;
    color: #fff;
}
.mce-tinymce{width:100%;}

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
						<h4 class="page-title"><?php echo $titleTag; ?> Job Details</h4> </div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a>
							</li>
							<li class="active"><?php echo $titleTag; ?> Job Details</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="white-box">
							<h3 class="box-title"><?php echo $titleTag; ?> Job Details</h3>

							<?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');?>

							<form data-toggle="validator" method="post" action="add-jobs.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" id='categoryform'>
								<div class="row">
                               		<div class="form-group col-md-4">
										<label for="exampleInputuname1">Job ID</label>

										<div class="input-group">

											<input type="text" class="form-control" value="<?php echo $curr_val['job_id'];?>" name="job_id" id="job_id" placeholder="Enter Job ID" required>
										</div>
										<div class="help-block with-errors"></div>
									</div>
									<div class="form-group col-md-4">
										<label for="exampleInputuname">Job Title</label>

										<div class="input-group">

											<input type="text" class="form-control" name="job_title" value="<?php echo $curr_val['job_title'];?>" id="job_title" placeholder="Enter Title" required>
										</div>
										<div class="help-block with-errors"></div>
									</div>
                                    
                                    <div class="form-group col-md-4">
										<label for="exampleInputuname">Company Name</label>

										<div class="input-group">

											<input type="text" class="form-control" name="company_name" value="<?php echo $curr_val['company_name'];?>" id="company_name" placeholder="Enter Company Name">
										</div>
										<div class="help-block with-errors"></div>
									</div>
                                    
                                        
                                    <div class="form-group col-md-4">
										<label for="exampleInputuname1">City</label>

										<div class="input-group">

											<input class="form-control"
                                            name="job_city"
                                            id="job_city"
                                            value="<?php echo $curr_val['job_city'];?>"
                                            placeholder="Enter your City Name"
                                            type="text"/>
										</div>
										<div class="help-block with-errors"></div>
										</div>
                                    
                                    <div class="form-group col-md-4">
										<label for="exampleInputuname1">State</label>

										<div class="input-group">
											<select name="job_state" id="job_state" class="form-control"> 
                                            <option value="">Select State</option> <option value="AL">Alabama</option> <option value="AK">Alaska</option> <option value="AZ">Arizona</option> <option value="AR">Arkansas</option> <option value="CA">California</option> <option value="CO">Colorado</option> <option value="CT">Connecticut</option> <option value="DE">Delaware</option> <option value="DC">District Of Columbia</option> <option value="FL">Florida</option> <option value="GA">Georgia</option> <option value="HI">Hawaii</option> <option value="ID">Idaho</option> <option value="IL">Illinois</option> <option value="IN">Indiana</option> <option value="IA">Iowa</option> <option value="KS">Kansas</option> <option value="KY">Kentucky</option> <option value="LA">Louisiana</option> <option value="ME">Maine</option> <option value="MD">Maryland</option> <option value="MA">Massachusetts</option> <option value="MI">Michigan</option> <option value="MN">Minnesota</option> <option value="MS">Mississippi</option> <option value="MO">Missouri</option> <option value="MT">Montana</option> <option value="NE">Nebraska</option> <option value="NV">Nevada</option> <option value="NH">New Hampshire</option> <option value="NJ">New Jersey</option> <option value="NM">New Mexico</option> <option value="NY">New York</option> <option value="NC">North Carolina</option> <option value="ND">North Dakota</option> <option value="OH">Ohio</option> <option value="OK">Oklahoma</option> <option value="OR">Oregon</option> <option value="PA">Pennsylvania</option> <option value="RI">Rhode Island</option> <option value="SC">South Carolina</option> <option value="SD">South Dakota</option> <option value="TN">Tennessee</option> <option value="TX">Texas</option> <option value="UT">Utah</option> <option value="VT">Vermont</option> <option value="VA">Virginia</option> <option value="WA">Washington</option> <option value="WV">West Virginia</option> <option value="WI">Wisconsin</option> <option value="WY">Wyoming</option> </select>
										</div>
										<div class="help-block with-errors"></div>
										</div>
									<div class="form-group col-md-4">
										<label for="exampleInputuname1">Duration</label>

										<div class="input-group">

											<input type="text" class="form-control" value="<?php echo $curr_val['duration'];?>" name="duration" id="duration" placeholder="Enter Duration">
										</div>
										<div class="help-block with-errors"></div>
										</div>
                                    <div class="clearfix"></div> 
                                    <div class="form-group col-md-4">
										<label for="exampleInputuname1">Pay range</label>

										<div class="input-group">

											<input type="text" class="form-control" value="<?php echo $curr_val['pay_range'];?>" name="pay_range" id="pay_range" placeholder="Enter Pay range">
										</div>
										<div class="help-block with-errors"></div>
										</div> 
                                     
                                    <div class="form-group col-md-4">
										<label for="exampleInputuname1">Last Date to Apply</label>

										<div class="input-group date" data-provide="datepicker">
                                            <input type="text" value="<?php 
											$last_date_apply = $curr_val['last_date_apply'];
											$last_date_apply = explode('-',$last_date_apply);
											$yyyy = $last_date_apply[0];
											$dd = $last_date_apply[1];
											$mm = $last_date_apply[2];
											$date_make = $dd.'/'.$mm.'/'.$yyyy;
											echo $date_make;?>" class="form-control" name="last_date_apply" id="last_date_apply">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
										<div class="help-block with-errors"></div>
										</div>  
                                    <div class="clearfix"></div> 
                                   
                                    <section class="wid100">

                                        <h3 class="box-title col-sm-12" style="margin: 0 0 15px !important; margin-top: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px;">Job Responsibilities</h3>

                                        <div class="clearfix"></div>



                                        <div class="col-sm-12">
                                                <textarea class="mymce" name="job_responsibilities" id="job_responsibilities" >
												<?php echo $curr_val['job_responsibilities'];?>
                                                </textarea>
                                        </div>



                                    </section>       
                                    <div class="clearfix"></div>
                                    <section class="wid100">

                                        <h3 class="box-title col-sm-12" style="margin: 0 0 15px !important; margin-top: 30px !important; margin-right: 0px; margin-bottom: 15px; margin-left: 0px;">Job Requirements</h3>

                                        <div class="clearfix"></div>



                                        <div class="col-sm-12">

											<textarea class="mymce" name="job_requirements" id="job_requirements">
													<?php echo $curr_val['job_requirements'];?>                                            </textarea>
										</div>



                                    </section>
                                         
									<div class="clearfix"></div>
									<div class="col-sm-12" style="margin-top:30px;">
										<a href="manage-jobs.php"><button type="button" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button></a>
										<button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10"><?php echo (isset($_REQUEST['id'])?'Update':'Save'); ?>
										</button>
									</div>

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
<!-- sample modal content -->

                            <!-- /.modal -->


	<!-- sample modal content -->

                            <!-- /.modal -->

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
	<!--Wave Effects -->
	<script src="js/waves.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="js/custom.min.js"></script>
	<script src="js/jasny-bootstrap.js"></script>
	<!--Style Switcher -->
	<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
	<script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<!-- icheck -->
    <script src="plugins/bower_components/icheck/icheck.min.js"></script>
    <script src="plugins/bower_components/icheck/icheck.init.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="js/custom.min.js"></script>
	<script src="js/validator.js"></script>
	<script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
	<script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
	<script src="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
	<script src="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
	<script>
		jQuery( document ).ready( function () {
			// For select 2
			$( ".select2" ).select2();
			$( '.selectpicker' ).selectpicker();
			$('.datepicker').datepicker();			
	</script>
	<!-- Footable -->
	<script src="plugins/bower_components/footable/js/footable.all.min.js"></script>
	<script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
	<!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
	<!--FooTable init-->
	<script src="js/footable-init.js"></script>
<!-- wysuhtml5 Plugin JavaScript -->
    <script src="plugins/bower_components/tinymce/tinymce.min.js"></script>
    <script>
    $(document).ready(function() {
        if ($("#job_responsibilities").length > 0) {
            tinymce.init({
                selector: "textarea#job_responsibilities",
                theme: "modern",
                height: 300,
				plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"
                ],
                 toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
				toolbar2: "print preview media | forecolor backcolor emoticons",
				image_advtab: true,
				file_picker_callback: function(callback, value, meta) {
				  if (meta.filetype == 'image') {
					$('#upload').trigger('click');
					$('#upload').on('change', function() {
					  var file = this.files[0];
					  var reader = new FileReader();
					  reader.onload = function(e) {
						callback(e.target.result, {
						  alt: ''
						});
					  };
					  reader.readAsDataURL(file);
					});
				  }
				},
            });
        }
		
		if ($("#job_requirements").length > 0) {
            tinymce.init({
                selector: "textarea#job_requirements",
                theme: "modern",
                height: 300,
				plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"
                ],
                 toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
				toolbar2: "print preview media | forecolor backcolor emoticons",
				image_advtab: true,
				file_picker_callback: function(callback, value, meta) {
				  if (meta.filetype == 'image') {
					$('#upload').trigger('click');
					$('#upload').on('change', function() {
					  var file = this.files[0];
					  var reader = new FileReader();
					  reader.onload = function(e) {
						callback(e.target.result, {
						  alt: ''
						});
					  };
					  reader.readAsDataURL(file);
					});
				  }
				},
            });
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
			setcookie('status', $_COOKIE['status'], time()-100);
			setcookie('title', $_COOKIE['title'], time()-100);
			setcookie('err', $_COOKIE['err'], time()-100);
		}
		if(isset($curr_val['job_state']))
		{
			$state_val = $curr_val['job_state'];
			?>
			$('#job_state option[value="<?php echo $state_val;?>"]').attr("selected", "selected");
			<?php 
		}
	?>
	
    </script>
	<!--Style Switcher -->
	<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
   
     
</body>

</html>
