<?php
	$cpatch=$_REQUEST["g-recaptcha-response"];
	$namefp=$_REQUEST["cname"];
	$cemailfp=$_REQUEST["cemail"];
	$phonefp=$_REQUEST["phone"];
	$addfp=$_REQUEST["add"];
	$contentfp=$_REQUEST["content"];
	$subjectfp="Contact form";
	$from_emailfp=$_REQUEST["sender_email"];
	$emailnotififp=$_REQUEST["email_notifi"];
	$projectidfp=$_REQUEST["pro_id"];
	$page_namefp= $_REQUEST["page_name"];	
	$capval=$cpatch;
	$name=$namefp[0];
	$cemail=$cemailfp[0];
	$phone=$phonefp[0];
	$add=$addfp[0];
	$content=$contentfp[0];
	$subject=$subjectfp;
	$from_email=$from_emailfp;
	$emailnotifi=$emailnotififp;
	$projectid=$projectidfp;
	$page_name=$page_namefp;
	if($cpatch != "")
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://edificecms.com/curl/dynamic-email.php");			
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array("cname" => $name,"cemail" => $cemail,"phone" => $phone,"add" => $add,"content" => $content,"subject" => $subject,"frm_mail" => $from_email,"emailnotifi" => $emailnotifi,"projectid" => $projectid,"page_name" => $page_name,"g-recaptcha-response" => $cpatch));
		$response = curl_exec($curl);
		curl_close($curl);
		$result_array = json_decode($response, true);
		 echo '<div class="success-message">Thank you , your message was sent successfully.</div>';
	}
	else
	{
		 echo '<div class="error-captcha">Please verfiy you are not a robot</div>';
	}
	?>
	