<?php
ini_set('max_execution_time', 300);
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once dirname(__FILE__) . '/stripe.com-php-curl-master/stripe_class.php';
if(isset($_SESSION['US']['user_id']) && $_SESSION['US']['user_id']>0){header('Location: dashboard.php');exit;}
if(isset($_SESSION['U']['id']) && $_SESSION['U']['id']>0){header('Location: '.ADMIN_SITE.'dashboard.php');exit;}

$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$ipAdd = $_SERVER['REMOTE_ADDR'];

$tbl_name = DEPARTMENT;
$arrAllIndustries = $prop->getAll('*',$tbl_name,'where dep_status !=2','');

$tab = 0;
$meta_title = 'Register Page';
if(isset($_REQUEST['tab'])){
	if($_REQUEST['tab']==='payment' && $_SESSION['reg_id']!='')
	{
		$meta_title = 'Payment Page';
		$tab = 1;

	}else{
		header('location:register.php'); exit;
	}
}
$post = array();
$arrCompanySize = array('50','100','150','200','250','300','400','500','Above');
$post['company']=$post['email']=$post['name']=$post['mobile']=$post['company_size']=$post['FirstName']=$post['LastName']=$post['Address']=$post['City']=$post['State']=$post['Zipcode']=$post['phone']='';
$msg = '';

$script_redirect = '';
if(isset($_POST) && $_POST['regSubmit']=='regSubmit'){
	$errStatus = 1;
    $post = $_POST;
	$alert = array();
	$alert['status'] = 'Error';
	$alert['err'] = 'error';
	if($tab===0){
		$msg = 'Email id already exits';
		$count = $prop->getName('COUNT(id)', USERS, " 1=1 AND status!=2 AND email='".$post['email']."'");
		if($count===0){
			if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
				$msg = 'Logo file invalid format';
				$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png');
				$extension = pathinfo(strtolower($_FILES['file']['name']), PATHINFO_EXTENSION);
				if(in_array($extension, $allowedExtensions))
				{
					$msg = 'Logo uploaded failed!';
					$logo = time().'.'.$extension;
					if (move_uploaded_file($_FILES['file']['tmp_name'], 'images/logo/'.$logo))
					{
						//$planArr = explode('|',$_POST['plan']);
						//$plan_id = $planArr[0];
						$msg = 'Registration Error';
						$inputs = array(
							'c_name'			=>	$post['company'],
							'name'				=>	$post['adminname'],
							'email'				=>	$post['email'],
							'password'			=>	crypt($post['pass']),
							'de_pass'			=>	$post['pass'],
							'c_type'			=>	$post['company_type'],
							'industry_type'		=>	$post['industry_type'],
							'taxId'			    =>	$post['taxId'],
							'contact_person'    =>	$post['conPerson'],
							'ProAnuVal'    		=>	$post['ProAnuVal'],
							'state'    			=>	$post['us_state'],
							'c_size'			=>	$post['company_size'],
							'contact_no'		=>	$post['mobile'],
							'c_logo'			=>	$logo,
							'status'			=>	0,
							'u_type'            =>  2,
							//'plan'				=>	$plan_id,
							'created_date'		=>	date('Y-m-d H:i:s'),
							'created_ip'		=>	$ipAdd
							);
						$result = $prop->add(USERS, $inputs);
						$msg = $result;
						if($result){
							$msg = 'Registered successfully';
							//Admin email Template Start
								$admin_to = 'mohaneorchids@gmail.com,';
								$alladminsql = "SELECT  * from ".USERS." WHERE `u_type`= 0 or `u_type`= 1";
								$alladminfet=$prop->getAll_Disp($alladminsql);
								for($i=0; $i<count($alladminfet); $i++){
									$admin_to .=  $alladminfet[$i]['email'].",";
								}
								$subject = 'New Company Registered';
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
								<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['company'].'</p></td>
                                    <td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Company Logo</h5>
								<img src="'.LIVE_SITE.'images/logo/'.$logo.'" style="width:116px;" alt="logo" /></td>
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
								<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['email'].'</p></td>
                                  </tr>
                                  <tr>
                                    <td style="padding:10px;width:178px"><h5 style="margin: 0px 0px 5px;color:#7e7e7e;font-weight: 400;font-size: 13px;">Password</h5>
								<p style="margin: 0px;color: #484747;font-size: 14px;font-weight: 500;">'.$post['pass'].'</p></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
								</div>
								</div>
								<p style="text-align:left; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; padding-bottom:30px;line-height:25px;border-bottom: 1px solid #e5e5e5;">If you don’t know why you got this email, please tell us straight away so we can fix this for you.</p>
								<div style="width:50%; float:left;">
								<p style="font-size:14px; font-weight:400; color:#353535;margin-bottom: 5px;">dcshrm.com</p>
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
								</body>';
								$message .= '</html>';
								 
								// Sending email
								//if(mail($admin_to, $subject, $message, $headers)){
								if(sendemail($admin_to,$subject,$message)){
									$EmailTest = 'Your mail has been sent successfully.';
								} else{
									$EmailTest =  'Unable to send email. Please try again.';
								}
								//Admin email Template end 
								
								//Company email Template Start
								$to_company = $post['email'];
								$subject_company = 'Thank you for registering with DCSHRM ';
								$from_company = 'admin@dcshrm.com';
								$headers .= 'From: '.$from_company."\r\n".
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
								<p style="text-align:center; font-size:16px; font-weight:800; color:#353535; padding-top:10px; margin-bottom:10px; margin-top: 0px;">Hello '.$post['company'].',</p>
								<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Thank you for Registering with us</p>
								<p style="text-align:center; font-size:15px; font-weight:400; color:#757575; margin-bottom: 5px; margin-top:0px;line-height:25px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry content of a page when looking at its layout.</p>
								<p style="text-align:center; font-size:15px; font-weight:600; color:#353535; margin-bottom: 5px; margin-top:20px; line-height:25px;">Credentials to Login to '.$post['company'].'</p>
								<div style="padding:10px 10px 10px 137px;">
								<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">User Name : </span>'.$post['email'].'</h5>
								<h5 style="margin: 0px 0px 5px;font-size: 13px;color:#7e7e7e;font-weight: 400;"><span style="color:#353535;font-weight: 600;width: 80px;display: inline-block;text-align:right;    margin-right: 3px;">Password : </span>'.$post['pass'].'</h5>
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
								//if(mail($to_company, $subject_company, $message_company, $headers_company)){
								if(sendemail($to_company,$subject_company,$message_company)){
									$EmailTest = 'Your mail has been sent successfully.';
								} else{
									$EmailTest =  'Unable to send email. Please try again.';
								}
								//Company email Template end 
							
						}
						if($logo!='')
							unlink('images/logo/'.$logo);
					}
				}
			}
		}
   		$alert['title'] = $msg;
		/*unset($_SESSION['reg_id']);
		unset($_SESSION['reg_cname']);
		unset($_SESSION['reg_name']);
		unset($_SESSION['reg_email']);
		unset($_SESSION['reg_pass']);
		unset($_SESSION['reg_plan_id']);
		unset($_SESSION['reg_plan_amt']);*/
	}
	if($tab===1){
		$reg_id = $_SESSION['reg_id'];
		$cname = $_SESSION['reg_cname'];
		$name = $_SESSION['reg_name'];
		$email = $_SESSION['reg_email'];
		$pass = $_SESSION['reg_pass'];
		$plan_id = $_SESSION['reg_plan_id'];
		$amount = $_SESSION['reg_plan_amt'];
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d',strtotime('+29 days',time()));
    $expiry = explode('-',$_POST['expiry']);
    $expMonth = $expiry[0];
    $expYear = $expiry[1];
		$request = array (
			'card' => array(
				'number' => $_POST['cardNumber'],
				'exp_month' => $expMonth,
				'exp_year' => $expYear,
				'cvc' => $_POST['cvc']
			),
		);
		/* Token Generate */
		$Stripe = new VK_Stripe();
		$Stripe->secret_key = $public_key;
		$Stripe->url = 'https://api.stripe.com/v1/tokens';
		$Stripe->fields = $request;
		$token = $Stripe->process();
		if(!isset($token['error'])){
			/* Customer Create */
			$desc = date('d/m/Y').' '.$email;
			$request = array (
					'description' => $desc,
					'email' => $email,
					'source' => $token['id']
			);
			$Stripe->secret_key = $secret_key;
			$Stripe->url = 'https://api.stripe.com/v1/customers';
			$Stripe->fields = $request;
			$customer = $Stripe->process();
			if(!isset($customer['error'])){
				/* Charges */
				$request = array(
						  "amount" => $amount,
						  "currency" => "usd",
						  "description" => 'Payment '.$desc,
						  "customer" => $customer['id'],
						  'receipt_email' => $email,
						);
				$Stripe->secret_key = $secret_key;
				$Stripe->url = 'https://api.stripe.com/v1/charges';
				$Stripe->fields = $request;
				$charge = $Stripe->process();
				if(!isset($charge['error'])){
					$invoiceNumber = '';
					if($charge['paid']){
						if($charge['invoice']!=null && $charge['invoice']!=''){
							/* Invoice */
							$Stripe->secret_key = $secret_key;
							$Stripe->url = 'https://api.stripe.com/v1/invoices/'.$charge['invoice'];
							$invoice = $Stripe->process();
							if(!isset($invoice['error']) && $invoice['paid']){
								$invoiceNumber = $invoice['number'];
							}
						}


						$errStatus = 0;
						$errCode = 'Registered successfully';
						$errMsg = 'Plan activated failed manually renewal your account or contact to customer';
						$insert = array(
						'reg_id'=>$reg_id,
						'plan'=>$plan_id,
						'amount'=>$amount/100,
						'start_date'=>$start_date,
						'end_date'=>$end_date,
						'card_number'=>$charge['source']['last4'],
						'result'=>json_encode($charge),
						'card_type'=>$charge['source']['brand'],
						'payment_date'=>date('Y-m-d'),
						'payment_status'=>1,
						'email'=>$email,
						'invoice'=>$invoiceNumber,
						'created_date'=>date('Y-m-d'),
						'created_ip'=>$ipAdd
						);
						$insert['customerProfileId'] = $customer['id'];
						$insert['customerPaymentProfileId'] = $charge['id'];
						$res = $prop->addID(PAYMENT, $insert);

						$payment_last_id = $res;
						$append_post = array();
						$append_post['customerProfileId'] = $customer['id'];
						$append_post['customerPaymentProfileId'] = $charge['id'];
						$append_post['pay_id'] = $payment_last_id;
						$append_post['status'] = 0;
						$append_post['start_date'] = $start_date;
						$append_post['end_date'] = $end_date;
						$prop->update(USERS, $append_post, array('id'=>$reg_id));

						$subject='Your login credentials for DCSHRM ';
						$from = MAIL_ADD;
						$body = loginCredentialTemplate(array('name'=>$cname,'email'=>$email,'pass'=>$pass));
						$headers = "From: " . strip_tags($from) . "\r\n";
						$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						mail($email,$subject,$body,$headers);
						$script_redirect = 'setTimeout(function(){ window.location = \''.ADMIN_SITE.'\'; }, 1500);';
						setcookie("redirect", $script_redirect, time()+50);
						unset($_SESSION['reg_id']);
						unset($_SESSION['reg_cname']);
						unset($_SESSION['reg_name']);
						unset($_SESSION['reg_email']);
						unset($_SESSION['reg_pass']);
						unset($_SESSION['reg_plan_id']);
						unset($_SESSION['reg_plan_amt']);
						/* Subscription */
						$request = array(
									  "customer" => $customer['id'],
									  "items" => array(
										array(
										  "plan" => $plan_id,
										),
									  ),
									  'billing' => 'charge_automatically'
									);
						$Stripe->secret_key = $secret_key;
						$Stripe->url = 'https://api.stripe.com/v1/subscriptions';
						$Stripe->fields = $request;
						$subscriptions = $Stripe->process();
						if(!isset($subscriptions['error'])){
							if($subscriptions['status']==='active'){
								$errCode = 'Registered successfully';
								$errMsg = 'Plan activated automatically amount deducted your account';
								$prop->update(USERS, array('subscriptionId'=>$subscriptions['id']), array('id'=>$reg_id));
								$prop->update(PAYMENT, array('subscriptionId'=>$subscriptions['id']), array('id'=>$payment_last_id));
								setcookie("status", $errCode, time()+10);
								setcookie("title", $errMsg, time()+10);
								setcookie("err", 'success', time()+10);
								header('Location: register.php');
								die;
							}
						}
					}else{
						$errCode = $charge['failure_code'];
						$errMsg = $charge['failure_message'];
					}
				}else{
					$errCode = $charge['error']['code'];
					$errMsg = $charge['error']['message'];
				}
			}else{
				$errCode = $customer['error']['code'];
				$errMsg = $customer['error']['message'];
			}
		}else{
			$errCode = $token['error']['code'];
			$errMsg = $token['error']['message'];
		}
		setcookie("status", $errCode, time()+10);
		setcookie("title", $errMsg, time()+10);
		setcookie("err", $alert['err'], time()+10);
		header('Location: register.php?tab=payment');
		die;
	}
	$_POST = array();
}
/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/plans?product=$stripe_product_key");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":" . "");

$plan_list = json_decode(curl_exec($ch),TRUE);
curl_close ($ch);

$opt_list = '<option value="">No Plans</option>';
if(!isset($plan_list['error'])){
	$opt_list = '<option value="">Choose Plan</option>';
	$count = count($plan_list['data']);
	for($i=0;$i<$count;$i++){
		$opt_list .= '<option value="'.$plan_list['data'][$i]['id'].'|'.$plan_list['data'][$i]['amount'].'">'.$plan_list['data'][$i]['nickname'].' / '.$plan_list['data'][$i]['interval_count'].$plan_list['data'][$i]['interval'].' / $'.($plan_list['data'][$i]['amount']/100).'</option>';
	}
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  
    <title>DCSHRM | <?php echo $meta_title; ?></title>
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
  <?php if($tab===0){ ?>
  <link rel="stylesheet" href="css/dropify.css">
  <?php } if($tab===1){ ?>
  <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
  <?php } ?>
</head>

<body>

  <section class="signup-page">

    <div class="container">

        <div class="row">

        <div class="col-sm-12">

            <div class="content-center">

            <div class="col-sm-9 col-md-12 col-xs-12">

                <div class="sp-wrapper">

                <div class="sp-logo text-center">

                    <img src="images/logo-login.png">

                    </div>

                    <hr>
                    <form class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" autocomplete="off" method="post" id="loginform" action="">
                      <div style="text-align:center;" class="sp-content">
                      <?php
                          if($_COOKIE['err'] !='')
                          {
                              /*echo '<div style="color:'.($_COOKIE['err']==='success'?'green':'red').';font-size:14px;">'.$_COOKIE['status'].'</div>';*/
                              echo '<div style="color:'.($_COOKIE['err']==='success'?'green':'red').';font-size:12px;">'.$_COOKIE['title'].'</div>';
                          }
                    			if($alert['status']!='' && $alert['err']!='' && $alert['title']!=''){
                              echo '<div style="color:'.($alert['err']==='success'?'green':'red').';font-size:12px;">'.$alert['title'].'</div>';
                    			}
                          ?>
                        </div>
                    <?php if($tab===0){ ?>
                    <div class="sp-content">

                       <div class="mb-20">
                        <span class="sp-title">Sign Up</span>
                        </div>

                        <?php /*?><div class="sp-component ">
                        <label>Plan <span>*</span></label>
                        <select name="plan" class="form-control" required>
                          <?php
            							echo $opt_list;
            							?>
                        </select>
                        </div><?php */?>
						<div class="row">
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>Company Name <span>*</span></label>
                                <input type="text" placeholder="Company Name" name="company" value="<?php echo $post['company']; ?>" class="form-control" required="">
                                </div>
                            </div>
                       	  	<div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label class="">Company Logo</label>
                                    <input type="file" id="input-file-now" class="dropify" name="file" accept="image/x-png,image/gif,image/jpeg" required />

                                    </div>
                            </div>
                          	<div class="col-sm-4 col-md-4 col-xs-12">
                            <div class="sp-component">
                            <label>Company Type <span>*</span></label>
                            <select name="company_type" class="form-control" required="">
                                <option value="">Select Type</option>
                                <option value="Limited Liability Company">Limited Liability Company</option>
                                <option value="Private Corporation">Private Corporation</option>
                                <option value="Public Corporation">Public Corporation</option>
                                <option value="Sole Proprietorship">Sole Proprietorship</option>
                                <option value="Partnership-LLP">Partnership / LLP</option>
                                <option value="Tax Exempt">Tax Exempt</option>
                            </select>
                            </div>
						</div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-4 col-md-4 col-xs-12">
                            <div class="sp-component">
                            	<label for="exampleInputuname">Industry</label>
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
							</div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>Legal Name <span>*</span></label>
                                <input type="text" class="form-control" name="adminname" placeholder="Legal Name" value="<?php echo $post['name'];?>" required>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>Tax ID <span>*</span></label>
                                <input type="text" class="form-control" id="exampleInputuname" name="taxId" placeholder="Tax ID" value="<?php echo $post['c_name'];?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>State of Business <span>*</span></label>
                                <select name="us_state" class="form-control" required>
                                                <?php if($post['state']!=''){?>
                                                <option value="<?php echo $post['state'];?>" selected><?php echo $post['state'];?></option>
                                                <?php } ?>
                                                    <option value="">Select State</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District of Columbia">District of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Guam">Guam</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Northern Marianas Islands">Northern Marianas Islands</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Puerto Rico">Puerto Rico</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Virgin Islands">Virgin Islands</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option></select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>Size <span>*</span></label>
                                <select name="company_size" class="form-control">
              							<?php
              							$size = count($arrCompanySize);
              							for($i=0;$i<$size;$i++){
              								echo '<option value="'.$arrCompanySize[$i].'" '.($arrCompanySize[$i]===$post['company_size']?'selected':'').'>'.$arrCompanySize[$i].'</option>';
              							}

              							?>
                            </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="sp-component">
                                <label>Contact Person <span>*</span></label>
									<input type="text" class="form-control" id="exampleInputuname" name="conPerson" placeholder="Contact Person" value="<?php echo $post['contact_person'];?>" required>                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-4 col-md-4 col-xs-12">
                            	<div class="sp-component">
                        <label>Email <span>*</span></label>
                        <input type="email" placeholder="Email" name="email" value="<?php echo $post['email']; ?>" class="form-control" required="">
                        </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                            <div class="sp-component">
                           		<label>Phone Number <span>*</span></label>
                            <input type="number" placeholder="Contact Number" name="mobile" value="<?php echo $post['mobile']; ?>" class="form-control" required="" min='1000000000' max="9999999999">
                            </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-12">
                            	<div class="sp-component">
                           		<label>Projected Annual Value <span>*</span></label>
                            	<input type="text" name="ProAnuVal" value="<?php echo $post['ProAnuVal']; ?>" class="form-control" placeholder="Projected annual Value" required="">
                                
                          	  </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-sm-4 col-md-4 col-xs-12">
                            <div class="sp-component">
                            <label>Password <span>*</span></label>
                            <input type="password" placeholder="Password" name="pass" data-toggle="validator" data-minlength="6" required="" data-error="Enter Password Minimum 6 letters" class="form-control" autocomplete="off" id="passw">
                            </div>
                         </div>
                         	<div class="col-sm-4 col-md-4 col-xs-12">
                            <div class="sp-component">
                            <label>Confirm Password <span>*</span></label>
                            <input type="password" name="cpass" data-match="#passw"  data-error="Enter Confirm Password"  data-match-error="Whoops, Passwords don't match" class="form-control" required="" autocomplete="off" placeholder="Confirm Password">
                            </div>
                            </div>
                            
                        </div>    
                        <div class="row">

                            <div class="col-sm-12 col-md-12 col-xs-12 text-right">
                            <div class="sp-component ">
                            <div class="mt-10">
                             <em class="">I already have an account</em>
                        <a class="sp-text-signin" href="login.php">Sign In</a>
                            </div>

                        </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-xs-12 pull-right">
                              <div class="sp-component">
                                <div class="mt-15">
                                  <button value="regSubmit" name="regSubmit" type="submit" class="btn btn-danger sp-btn btn-block">Sign Up
                                  </button>
                                </div>
                              </div>
                            </div>

                        </div>



                    </div>
                  <?php } if($tab===1){ ?>
                    <div class="sp-content mt-10">
                      <div class="mb-20">
                        <span><img src="images/dcshrm-lock-img.png"></span>
                        <span class="sp-sub-title">Payment Info</span>
                      </div>
                    </div>
                    <hr>
                    <div class="sp-content">
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="sp-component input-icon icon1">
                              <label>Card Number <span>*</span></label>
                              <input type="text" placeholder="Card Number" maxlength="20" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" name="cardNumber" id="cardNumber" autocomplete="nope" value="" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component input-icon icon2">
                              <label>Expiration <span>*</span></label>
                              <input  type='text' name="expiry" placeholder="Ex:<?php echo date('m-Y',strtotime("1 year")); ?>"class="datepicker form-control" required />
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component input-icon icon3">
                              <label>CVV/CVC <span>*</span></label>
                              <input type="password" placeholder="CVV/CVC" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" name="cvcNumber" id="cvcNumber" autocomplete="new-password" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component mt-10">
                              <div class="theme-checkbox">
                                  <input type="checkbox" id="f-option2" name="selector2" required>
                                    <label for="f-option2">I agree to all terms</label>
                                    <div class="check"></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6 col-xs-12 text-right">
                            <div class="sp-component mt-10">
                              <a class="theme-hover" href="javascript:void(0);"><em class="v-middle">Read Policy</em></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12 pull-right">
                          <div class="sp-component">
                            <div class="mt-15">
                              <button class="btn btn-danger sp-btn btn-block" value="regSubmit" name="regSubmit" type="submit">Payment Confirm</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
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

   <?php if($tab===0){ ?>
   <!-- jQuery file upload -->
    <script src="js/dropify.js"></script>
    <script>
        $(document).ready(function () {
		
		$("select[name='industry_type']").change(function(){
			$("#industry_text").val($(this).find(":selected").text());
		});
		
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez'
                    , replace: 'Glissez-déposez un fichier ou cliquez pour remplacer'
                    , remove: 'Supprimer'
                    , error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                }
                else {
                    drDestroy.init();
                }
            })
        });
    </script>
  <?php } if($tab===1){ ?>
  <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript">
        $(function () {
             $('.datepicker').datepicker({
                 format: 'mm-yyyy',
                 startView: "months",
                 minViewMode: "months"
             });
        });
  </script>
  <?php } ?>
</body>
</html>
