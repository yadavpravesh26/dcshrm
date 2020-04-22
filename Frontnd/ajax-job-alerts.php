<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
extract($_REQUEST);
//$msg = 'Error:- Sign Up For Job Alerts';
//echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
if($meth=="jobAlertForm")
{
	$table_name = "job_alerts";
	$insdata = array(
			'alert_type'		=>1,
			'job_id'		=>$job_id,
			'your_email'		=>$your_email,
			'alert_status'		=>0
	);
	//$msg = 'Error:- Sign Up For Job Alerts';
	//echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	$lastId = $prop->addID($table_name, $insdata);
	if ($lastId == 0)
	$msg = 'Sign Up For Job Alerts Faild';
	
	if ($lastId != 0) {
	
		$to = $your_email;		
		$from = 'admin@dcshrm.com';		 
		$headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion(); 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$BccEmailList = 'm.kamal@hexagonitsolutions.com';
		$headers .= "Bcc: $BccEmailList\r\n";	
		
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
		<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$your_email.',</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Thank you for Registering with us.</p>
		<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;">From now you will receive all the jobs to your registered email. Thank you.</p>
		
		<div style="text-align:center; padding-bottom:20px; padding-top:20px;">
		<a href="https://dcshrm.com/newchanges/job-details.php?jobID='.$job_id.'" style="text-decoration:none;">
		<span style="padding:8px 30px; border-radius:2px; color:#ffffff; font-size:17px; background-color:#e40303; text-align:center; font-weight:600">Click to view job</span>		</a>		</div>
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
	
		$subject = 'Job From DCSHRM';
		if(mail($to, $subject, $message, $headers)){
			$msg = 'Sign Up For Job Alerts Success';
		} else{
			$msg =  'Unable to send email. Please try again.';
		}
		//$msg = ' Sign Up For Job Alerts Success';
		echo json_encode(array('lastId'=>$lastId,'err'=>0,'msg'=>$msg)); exit;
		
	}
	else{
		echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	}
}
if($meth=="emailJobForm")
{
	$table_name = "job_alerts";
	$insdata = array(
			'alert_type'		=>2,
			'job_id'		=>$job_id,
			'your_name'		=>$your_name,
			'your_email'		=>$your_email,
			'friend_name'		=>$recipient_name,
			'friend_email'		=>$recipient_email,
			'alert_status'		=>0
	);
	//$msg = 'Error:- Sign Up For Job Alerts';
	//echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	$lastId = $prop->addID($table_name, $insdata);
	if ($lastId == 0)
	$msg = 'Send Email of this Job Faild';
	
	if ($lastId != 0) {
		$to = $recipient_email;		
		$from = 'admin@dcshrm.com';		 
		$headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion(); 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$BccEmailList = 'm.kamal@hexagonitsolutions.com';
		$headers .= "Bcc: $BccEmailList\r\n";
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
		<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$recipient_name.',</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Job From DCSHRM</p>
		<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;"><strong>'.$your_name.'</strong> sent you  <strong>"'.$job_title.'"</strong> to apply for it. Please click the below button to apply</a>.</p>
		
		<div style="text-align:center; padding-bottom:20px; padding-top:20px;">
		<a href="https://dcshrm.com/newchanges/job-details.php?jobID='.$job_id.'" style="text-decoration:none;">
		<span style="padding:8px 30px; border-radius:2px; color:#ffffff; font-size:17px; background-color:#e40303; text-align:center; font-weight:600">Click to view job</span>		</a>		</div>
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
		$msg = 'Email send Success for this Job';
		$subject = 'Job From DCSHRM';
		if(mail($to, $subject, $message, $headers)){
			$msg = 'Email send Success for this Job';
		} else{
			$msg =  'Unable to send email. Please try again.';
		}
		//$msg = ' Sign Up For Job Alerts Success';
		echo json_encode(array('lastId'=>$lastId,'err'=>0,'msg'=>$msg)); exit;
	}
	else{
		echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	}
}
if($meth=="ReferFriendForm")
{
	$table_name = "job_alerts";
	$insdata = array(
			'alert_type'		=>3,
			'job_id'		=>$job_id,
			'your_name'		=>$your_name,
			'your_email'		=>$your_email,
			'friend_name'		=>$friend_name,
			'friend_email'		=>$friend_email,
			'alert_status'		=>0
	);
	//$msg = 'Error:- Sign Up For Job Alerts';
	//echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	$lastId = $prop->addID($table_name, $insdata);
	if ($lastId == 0)
	$msg = 'Refer a Friend Faild';
	
	if ($lastId != 0) {
		$to = $friend_email;		
		$from = 'admin@dcshrm.com';		 
		$headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion(); 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$BccEmailList = 'm.kamal@hexagonitsolutions.com';
		$headers .= "Bcc: $BccEmailList\r\n";
		
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
		<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$friend_name.',</p>
		<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Job From DCSHRM</p>
		<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;">Your Friend <strong>"'.$your_name.'"</strong> Referred you to this job. Please click the below link to take a look and apply for this job.</p>
		
		<div style="text-align:center; padding-bottom:20px; padding-top:20px;">
		<a href="https://dcshrm.com/newchanges/job-details.php?jobID='.$job_id.'" style="text-decoration:none;">
		<span style="padding:8px 30px; border-radius:2px; color:#ffffff; font-size:17px; background-color:#e40303; text-align:center; font-weight:600">Click to view job</span>		</a>		</div>
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
		$msg = 'Email send Success for this Job';
		$subject = 'Job From DCSHRM';
		if(mail($to, $subject, $message, $headers)){
			$msg = 'Email send Success for this Job';
		} else{
			$msg =  'Unable to send email. Please try again.';
		}
		//$msg = ' Sign Up For Job Alerts Success';
		echo json_encode(array('lastId'=>$lastId,'err'=>0,'msg'=>$msg)); exit;
	}
	else{
		echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	}
}
?>