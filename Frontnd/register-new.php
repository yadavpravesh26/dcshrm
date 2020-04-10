<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('stripe/vendor/autoload.php');
$pk_code = 'pk_test_eE4wYu24WJVUE6pfBVRDZghx';
$sk_code = 'sk_test_TqfOMmbnKfk0gYeeaJkh905K';

$amount = 350;
$plan_id = 'plan_DG73oLeRJzqYNT';
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$ipAdd = $_SERVER['REMOTE_ADDR'];
$post = array();
$arrCompanySize = array('50','100','150','200','250','300','400','500','Above');
$post['company']=$post['email']=$post['name']=$post['mobile']=$post['company_size']=$post['FirstName']=$post['LastName']=$post['Address']=$post['City']=$post['State']=$post['Zipcode']=$post['phone']='';
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
$msg = '';
function loginCredentialTemplate($data){
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login Detail</title>


<style type="text/css">
.form-control{height:32px;}
.login-box1 .form-group {
    margin-bottom: 5px !important;
}
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
                        Dear '.$data['name'].'
                    </td>
                </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                    login credentials For DCSHRM account.
                                </td>
                            </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                    <p>Username :  '.$data['email'].'</p>
                                    <p>Password :  '.$data['pass'].' </p>

                                </td>
                            </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                    <a href="'.ADMIN_SITE.'" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Login Now</a>
                                </td>
                            </tr>
                            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                    You can also copy and paste this URL into your web browser:<br/>
                                    '.ADMIN_SITE.'
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

$script_redirect = '';
if(isset($_POST) && $_POST['regSubmit']=='regSubmit'){
    $post = $_POST;
	$alert = array();
	$logo = '';
	$alert['status'] = 'Error';
	$alert['err'] = 'error';
		/* Email Address Check */
		$msg = '';
		$count = $prop->getName('COUNT(id)', USERS, " 1=1 AND status!=2 AND email='".$post['email']."'");
		if($count===0){
			/* #### logo upload section */
			if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
				$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');
				
				/* $extension = end(explode('.',strtolower($_FILES['file']['name']))); */
				$extension = pathinfo(strtolower($_FILES['file']['name']), PATHINFO_EXTENSION);
				if(in_array($extension, $allowedExtensions)){
					$logo = time().'.'.$extension;
					if (!move_uploaded_file($_FILES['file']['tmp_name'], 'images/logo/'.$logo)) {
						$logo = '';
						$msg = ' / Logo uploaded failed!';
					}
				}else{
					$msg = ' / Logo file invalid format';
				}
			}
			
			
			$merchantCustomerId = time();
			$desc = date('F Y').' Transactions';
			/* $invoiceNumber = substr(str_shuffle(str_repeat("QWERTYUIOPLKJHGFDSAZXCVBNM", 5)), 0, 3).time(); */
			$email = $post['email'];
			/* $name_card = $_POST['FirstName'].' '.$_POST['LastName'];
			$firstName = $_POST['FirstName'];
			$lastName = $_POST['LastName'];
			$phoneNumber = $_SESSION['phone']; */
			$cardNumber = $_POST['cardNumber'];
			$expirationDate = $_POST['expYear'].'-'.str_pad($_POST['expMonth'], 2, '0', STR_PAD_LEFT);
			$cardCode = $_POST['cvcNumber'];
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d',strtotime('+29 days',time()));
			/* Stripe Payment Start */
			
			$error = '';
			\Stripe\Stripe::setApiKey($pk_code);
			try {
				$createToken = \Stripe\Token::create(array(
				  "card" => array(
					"number" => $cardNumber,
					"exp_month" => $_POST['expMonth'],
					"exp_year" => $_POST['expYear'],
					"cvc" => $cardCode
				  )
				));
			} catch (\Stripe\Error\ApiConnection $e) {
				$e_json = $e->getJsonBody();
				$error = $e_json['error']['message'];
			} catch (\Stripe\Error\InvalidRequest $e) {
				$e_json = $e->getJsonBody();
				$error = $e_json['error']['message'];
			} catch (\Stripe\Error\Api $e) {
				$e_json = $e->getJsonBody();
				$error = $e_json['error']['message'];
			} catch (\Stripe\Error\Card $e) {
				$e_json = $e->getJsonBody();
				$error = $e_json['error']['message'];
			}
			if($error=='')
			{
				$TokenArr = $createToken->__toArray(true);
				\Stripe\Stripe::setApiKey($sk_code); 
				try {
					$createCustomer = \Stripe\Customer::create(array(
					  "description" => 'Customer '.$_POST['company'].' '.$email,
					  "email" => $email,
					  "source" => $createToken->id 
					));
				} catch (\Stripe\Error\ApiConnection $e) {
					$e_json = $e->getJsonBody();
					$error = $e_json['error']['message'];
				} catch (\Stripe\Error\InvalidRequest $e) {
					$e_json = $e->getJsonBody();
					$error = $e_json['error']['message'];
				} catch (\Stripe\Error\Api $e) {
					$e_json = $e->getJsonBody();
					$error = $e_json['error']['message'];
				} catch (\Stripe\Error\Card $e) {
					$e_json = $e->getJsonBody();
					$error = $e_json['error']['message'];
				}
				if($error=='')
				{
					$customerArr = $createCustomer->__toArray(true);
					\Stripe\Stripe::setApiKey($sk_code); 
					try {
						$createCharge = \Stripe\Charge::create(array(
						  "amount" => $amount,
						  "currency" => "usd",
						  "description" => 'Payment '.$_POST['company'].' '.$email,
						  "customer" => $createCustomer->id,
						  'receipt_email' => $email,
						));
					} catch (\Stripe\Error\ApiConnection $e) {
						$e_json = $e->getJsonBody();
						$error = $e_json['error']['message'];
					} catch (\Stripe\Error\InvalidRequest $e) {
						$e_json = $e->getJsonBody();
						$error = $e_json['error']['message'];
					} catch (\Stripe\Error\Api $e) {
						$e_json = $e->getJsonBody();
						$error = $e_json['error']['message'];
					} catch (\Stripe\Error\Card $e) {
						$e_json = $e->getJsonBody();
						$error = $e_json['error']['message'];
					}
					if($error=='')
					{
						$chargeArr = $createCharge->__toArray(true);
						if($chargeArr['paid']){
							$invoiceNumber = '';
							try {
								$getInvoice = \Stripe\Invoice::retrieve($chargeArr['invoice']);
								$invoiceArr = $getInvoice->__toArray(true);
								$invoiceNumber = $invoiceArr['number'];
							} catch (\Stripe\Error\ApiConnection $e) {
								$e_json = $e->getJsonBody();
								$error = $e_json['error']['message'];
							} catch (\Stripe\Error\InvalidRequest $e) {
								$e_json = $e->getJsonBody();
								$error = $e_json['error']['message'];
							} catch (\Stripe\Error\Api $e) {
								$e_json = $e->getJsonBody();
								$error = $e_json['error']['message'];
							} catch (\Stripe\Error\Card $e) {
								$e_json = $e->getJsonBody();
								$error = $e_json['error']['message'];
							}
							$inputs = array(
								'c_name'			=>	$post['company'],
								'name'				=>	$post['name'],
								'email'				=>	$post['email'],
								'password'			=>	crypt($post['pass']),
								'de_pass'			=>	$post['pass'],
								'contact_no'		=>	$post['mobile'],
								'c_size'			=>	$post['company_size'],
								'c_logo'			=>	$logo,
								'status'			=>	1,
								'u_type'            =>  2,
								'plan'				=>	$plan_id,
								'customerProfileId'	=>$createCustomer->id,
								'customerPaymentProfileId'=>$createCharge->id,
								'created_date'		=>	date('Y-m-d H:i:s'),
								'created_ip'		=>	$ipAdd
								);
							$result = $prop->addID(USERS, $inputs);
							if($result>0){
								$insert = array(
								'reg_id'=>$result,
								'plan'=>$plan_id,
								'amount'=>$amount/100,
								'start_date'=>$start_date,
								'end_date'=>$end_date,
								'card_number'=>$chargeArr['source']['last4'],
								'result'=>$createCharge,
								'card_type'=>$chargeArr['source']['brand'],
								'payment_date'=>date('Y-m-d'),
								'payment_status'=>1,
								'email'=>$post['email'],
								'invoice'=>$invoiceNumber,
								'created_date'=>date('Y-m-d'),
								'created_ip'=>$ipAdd
								);				
								$insert['customerProfileId'] = $createCustomer->id;
								$insert['customerPaymentProfileId'] = $createCharge->id;
								$res = $prop->addID(PAYMENT, $insert);
								if($res>0){
									$payment_last_id = $res;
									$append_post = array();
									$append_post['pay_id'] = $payment_last_id;
									$append_post['status'] = 0;
									$append_post['start_date'] = $start_date;
									$append_post['end_date'] = $end_date;
									$prop->update(USERS, $append_post, array('id'=>$result));
									\Stripe\Stripe::setApiKey($sk_code); 
									try {
										$createSubscription = \Stripe\Subscription::create(array(
										  "customer" => $createCustomer->id,
										  "items" => array(
											array(
											  "plan" => $plan_id,
											),
										  ),
										  'billing' => 'send_invoice',
										  'days_until_due' => 2,
										));
									} catch (\Stripe\Error\ApiConnection $e) {
										$e_json = $e->getJsonBody();
										$error = $e_json['error']['message'];
									} catch (\Stripe\Error\InvalidRequest $e) {
										$e_json = $e->getJsonBody();
										$error = $e_json['error']['message'];
									} catch (\Stripe\Error\Api $e) {
										$e_json = $e->getJsonBody();
										$error = $e_json['error']['message'];
									} catch (\Stripe\Error\Card $e) {
										$e_json = $e->getJsonBody();
										$error = $e_json['error']['message'];
									}
									$to=$post['email'];
									$subject='Your login credentials for DCSHRM ';
									$from = 'info@daks.me';
									$body = loginCredentialTemplate(array('name'=>$post['name'],'email'=>$post['email'],'pass'=>$post['pass']));
									$headers = "From: " . strip_tags($from) . "\r\n";
									$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
									$headers .= "MIME-Version: 1.0\r\n";
									$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
									mail($to,$subject,$body,$headers);
									$script_redirect = 'setTimeout(function(){ window.location = \''.LIVE_SITE.'\'; }, 1500);';
									$alert['status'] = 'Success';
									$alert['err'] = 'success';
									if($error=='')
									{
										$subArr = $createSubscription->__toArray(true);
										$subscriptionId = $createSubscription->id;
										if($createSubscription->status==='active'){
											$prop->update(USERS, array('subscriptionId'=>$subscriptionId), array('id'=>$result));
											$prop->update(PAYMENT, array('subscriptionId'=>$subscriptionId), array('id'=>$payment_last_id));
											$error = 'Registered successfully';
										}									
										
									}else{
										$error = 'Registered successfully and same time '.$error;
									}
									$alert['title'] = $error;
									setcookie("status", $alert['status'], time()+10);
									setcookie("title", $alert['title'], time()+10);
									setcookie("err", $alert['err'], time()+10);
									header('Location: '.$_SERVER['PHP_SELF']);
									die;
								}
							}
						}
						$error = $chargeArr['failure_message'];
					}
				}
			}
		}else{
			$error = 'Email id already exists';
		}
		if($logo!='')
		unlink('images/logo/'.$logo);
		$alert['title'] = $error.$msg;
		/* Stripe Payment End */
		/* end */
		$_POST = array();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title>DCSHRM | REGISTER</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
     <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/custom-style.css" rel="stylesheet">
    <link href="css/style-own.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="//www.w3schools.com/lib/w3data.js"></script>
    <style type="text/css">
        .form-horizontal .form-group {
    margin-left: 0px;
    margin-right: 0px;
    /* margin-bottom: 25px; */
}
.login-box1 .form-group {
    margin-bottom: 10px !important;
}
.fileinput {
    margin-bottom: 0px;
    
}
.login-box1 {
    background: #fff;
    width: 800px;
    margin: 2% auto 0;
}
.fileinput-new .input-group-addon {
    position: absolute;
    right: 3px;
    top: 2px;
    z-index: 10!important;
}
.form-control{
  height: 35px;
}
select.form-control:not([size]):not([multiple]) {
    height: calc(3.50rem);
}
label {
  
    margin-bottom: 1px;
   
}
    </style>
</head>

<body>
    <!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box1">
        <div class="white-box" style="padding-bottom:0px;">
            <a href="<?php echo LIVE_SITE; ?>"><img class="responsive sign-top" src="images/logo.png" /></a>

            <form class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" method="post" id="loginform" action="register.php?method=add">

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" placeholder="Company Name" name="company" value="<?php echo $post['company']; ?>" class="form-control" required="">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="Email" name="email" value="<?php echo $post['email']; ?>" class="form-control" required="">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" placeholder="Password" name="pass" data-toggle="validator" data-minlength="6" required="" data-error="Enter Password Minimum 6 letters" class="form-control" autocomplete="off" id="passw">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="cpass" data-match="#passw"  data-error="Enter Confirm Password"  data-match-error="Whoops, Passwords don't match" class="form-control" required="" autocomplete="off" placeholder="Confirm Password">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Name</label>
                            <input type="text" name="name" placeholder="Name" value="<?php echo $post['name']; ?>" class="form-control" required="">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">Contact Number</label>
                            <input type="text" placeholder="Contact Number" name="mobile" value="<?php echo $post['mobile']; ?>" class="form-control" required="">
                        </div>
						<div class="help-block with-errors"></div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Size</label>
                            <select name="company_size" class="form-control">
							<?php 
							$size = count($arrCompanySize);
							for($i=0;$i<$size;$i++){
								echo '<option value="'.$arrCompanySize[$i].'" '.($arrCompanySize[$i]===$post['company_size']?'selected':'').'>'.$arrCompanySize[$i].'</option>';
							}
							
							?>
                            </select>
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">Company Logo</label>

                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"> 
									<i class="glyphicon glyphicon-file fileinput-exists"></i> 
									<span class="fileinput-filename"></span>
								</div>
                                <span class="input-group-addon btn btn-default btn-file"> 
									<span class="fileinput-new">Select file</span> 
									<span class="fileinput-exists">Change</span>
									<input type="file" name="file" accept="image/x-png,image/gif,image/jpeg" required>
                                </span> 
								<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
							</div>

                        </div>
                    </div>
					<div class="col-md-12">
						<h3>PAYMENT INFORMATION</h3>
					</div>
					<!--<div class="col-md-6">
                        <div class="form-group">
                            <label class="">First Name</label>
                            <input type="text" placeholder="First Name" name="FirstName" id="FirstName" value="<?php echo $post['FirstName']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label class="">Last Name</label>
                            <input type="text" placeholder="Last Name" name="LastName" id="LastName" value="<?php echo $post['LastName']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="">Address</label>
                            <input type="text" placeholder="Address" name="Address" id="Address" value="<?php echo $post['Address']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label class="">City</label>
                            <input type="text" placeholder="City" name="City" id="City" value="<?php echo $post['City']; ?>" class="form-control" autocomplete="off" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label class="">State</label>
                            <input type="text" placeholder="State" name="State" id="State" value="<?php echo $post['State']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label class="">Zip Code</label>
                            <input type="text" placeholder="Zip Code" name="Zipcode" id="Zipcode" value="<?php echo $post['Zipcode']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label class="">Phone Number</label>
                            <input type="text" placeholder="Phone Number" name="phone" id="phone" value="<?php echo $post['phone']; ?>" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>-->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="">Card Number</label>
                            <input placeholder="Card Number" maxlength="20" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" name="cardNumber" id="cardNumber" autocomplete="off" class="form-control" required />
                        </div>
						<div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-5 p-l-0">
							<label class="col-md-12 p-l-0 p-r-0">Expiration Month</label>
							<div class="form-group">
								<select name="expMonth" class="form-control" required>
								<?php
									for($mo=1;$mo<=12;$mo++)
										echo '<option value="'.$mo.'">'.$mo.'</option>';
								?>
								</select>
							</div>
							<div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-3">
							<label class="col-md-12 p-l-0 p-r-0">Year</label>
                            <div class="form-group">
                                <select name="expYear" class="form-control" required>
								<?php
									$exp_year = date("Y") + 30;
									for($yr=date("Y");$yr<=$exp_year;$yr++)
										echo '<option value="'.$yr.'">'.$yr.'</option>';
								?>
								</select>
                            </div>
							<div class="help-block with-errors"></div>
                        </div>
						<div class="col-md-4 p-l-0">
							<label class="col-md-12 p-l-0 p-r-0">CVV/CVC</label>
							<div class="form-group">
								<input type="password" placeholder="CVV/CVC" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" name="cvcNumber" id="cvcNumber" autocomplete="off" class="form-control">
							</div>
							<div class="help-block with-errors"></div>
						</div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-md-12 p-l-0 p-r-0">
                        <div class="checkbox checkbox-primary p-t-0">
                            <input id="checkbox-signup" type="checkbox" required>
                            <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12 p-l-0 p-r-0">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" value="regSubmit" name="regSubmit" type="submit">Sign Up</button>
                    </div>
                </div>
                <div class="form-group m-b-0 " style="margin-bottom: 0px !important">
                    <div class="col-sm-12 text-center">
                        <p>Already have an account? <a href="<?php echo LIVE_SITE; ?>" class="text-primary m-l-5"><b>Sign In</b></a></p>
                    </div>
                </div>

                <div class="clearfix"></div>
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
    <script src="js/validator.js"></script>
	<script src="js/jasny-bootstrap.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script>
    $(document).ready(function() {
        <?php if($_COOKIE['err'] !='')
            {
                echo 'swal("'.$_COOKIE['status'].'", "'.$_COOKIE['title'].'", "'.$_COOKIE['err'].'");';
                setcookie("status", $_COOKIE['status'], time()-100);
                setcookie("title", $_COOKIE['title'], time()-100);
                setcookie("err", $_COOKIE['err'], time()-100);
            }
			if($alert['status']!='' && $alert['err']!='' && $alert['title']!=''){
				echo 'swal("'.$alert['status'].'", "'.$alert['title'].'", "'.$alert['err'].'");';
			}
            ?>
        // ajax radio
        $(".catrad").on('change', function(e){

			var catid = $(this).val();
			if(catid==1)
			{
				$("#subcat").prop('required',true);
				$('#subcat').prop('disabled', false);
				$('.tes').show();
			}
			else{
				$("#subcat").prop('required',false);
				  $('#subcat').prop('disabled', 'disabled');
				  $('.tes').hide();
			}
            $.ajax( {
				type: "POST",
				url: "ajax.php",
				data:{ catid :catid,meth :"subcatlist"},
				success: function( response ) {
					$('.rescl').html(response);
				}
            });
        });
    });
	<?php echo $script_redirect; ?>
    </script>
</body>

</html>
