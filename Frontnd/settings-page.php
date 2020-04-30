<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$com_id = $_SESSION['US']['user_id'] ;
$t_cond = array("id" => $com_id);
$row = $prop->get('*', USERS, $t_cond);

if(isset($_POST['updatepass'])){	
	$st = 'Error';
	$err = 'error';
	$msg = 'Old password is not match';
	if($_POST['currentpass']===$_POST['oldpass']){
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
		 
		$headers_emp  = 'MIME-Version: 1.0' . "\r\n";
		$headers_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		$headers_emp .= 'From: '.$from_emp."\r\n".
			'Reply-To: '.$from_emp."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
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
    <title>DCSHRM | PROFILE</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">

	  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- animation CSS -->
	<!-- Date picker plugins css -->
    <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

	<link href="css/style-own.css" rel="stylesheet">
			 <link href="css/new_style.css" rel="stylesheet">
				 <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


	<!-- Custom CSS -->

    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <link href="css/colors/green-dark.css" id="theme" rel="stylesheet">
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
   <div id="page-wrapper" class="search-result">
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
                 <!-- forms-->			
                    <div class="row m-t-15">
                    <div class="col-md-12 txt-center">
                        <div class="white-box p-0">

                        <h3 class="box-title m-b-0 emp-own h-head-u">Change Passowrd</h3>
						<form class="form-horizontal form-material" data-toggle="validator" data-minlength="6" method="post" id="passwordform" >
                            <div class="col-sm-12">
								<div class="col-sm-4 col-md-4">
									<div>
										<label for="exampleInputEmail1">Current Password</label>
										<input type="password" class="form-control" data-toggle="validator" data-minlength="6"id="currentpass1" name='currentpass' placeholder="Current Password" required>
										<input type="hidden" class="form-control" id="oldpass" name='oldpass' value=<?php echo $row['de_pass']?>>
									 </div>
									 <div class="help-block with-errors"></div>
								</div>
                           <div class="col-sm-4 col-md-4">
									<div >
										<label for="exampleInputEmail1">New Password</label>
										<!--<input type="test" class="form-control" id="newpass" name='newpass' placeholder="New Password">-->
										 <input type="password" data-toggle="validator" data-minlength="6" name="newpass" value="" class="form-control" id="inputPassword4" rel="showalt" placeholder="Password" required>
										 
									</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="help-block with-errors"></div>
                           <div class="col-sm-4 col-md-4">
									<div>
										<label for="exampleInputEmail1">Confirm Password</label>
										<input type="password" class="form-control"  name="connewpass" id="inputPasswordConfirm4" value="" rel="showalt1" data-match="#inputPassword4" data-error="Enter Confirm Password"  data-match-error="Whoops, Passwords don't match" placeholder="Confirm" required >
									 </div>
									 <div class="help-block with-errors"></div>
								</div>
								<div class="help-block with-errors"></div>
								<div class="col-sm-2 col-md-2 pull-right">
									<div>
                                           <label for="exampleInputuname" class="lab-head-u">&nbsp;</label>
                                          <button type='submit' class="btn btn-block btn-success" id="updatepass" name='updatepass'>Update</button><br>
                                    </div>
								</div>
                            </div>			
						</form>
							<div class="clearfix"></div>
                        </div>
                        </div>
							<div class="clearfix"></div>
                            </div>
                        </div>
            </div>
				<div class="clearfix"></div>
                 <!-- forms ends -->
                 
                
                </div>
                
            </div>
            <!-- /.container-fluid --><?php include 'footer.php';?>

        </div>
        <!-- /#page-wrapper -->
    </div>
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

	<!--end -->
    <script>	
	$(document).ready(function() {
		/* $("#currentpass1").blur(function(){
			var current= $(this).val();
			var oldpass = $("#oldpass").val();
			if(current!=oldpass)
		{
			$(".tet").html('Old Password Wrong').fadeOut(2000);
			$("#currentpass1").css("border", "1px solid #CC2424");
            $(".tet").css("color", "#C66C6B");
			$("#currentpass1").val('').focus();
		}else{
			$(".tet").html('');
			$("#currentpass1").css("border", "1px solid #E4E7EA");
			$('#inputPassword4, #inputPasswordConfirm4').removeAttr('disabled');
		}
		});
		$("#inputPassword4").blur(function(){
			var newpass=$(this).val();
			var ID=$("#inputPassword4").attr('rel');
			if(newpass.length<=5){
				$('#'+ID).html('Password must contain 6 or above').fadeIn('1000').fadeOut(2000);
			}
		});
		$("#inputPasswordConfirm4").blur(function(){
			var newpasscon=$(this).val();
			var newpass=$("#inputPassword4").val();
			if(newpass=='') {
				alert('Enter  new Password first');
			$("#inputPasswordConfirm4").val('');				
			}
			 var ID=$(this).attr('rel');
			if(newpass!=newpasscon){
				$('#'+ID).html('Whoops, Passwords dont match').fadeIn('1000').fadeOut(2000);
			}
			else{
				$("#updatepass").removeAttr('disabled');
			}
		});
		$("#updatepass").click(function(){	
		var newpass=$("#inputPassword4").val();
		$.ajax({
			url:'ajax.php',
			type:'post',
			data: 'newpass='+newpass+'&math=passupdate',
			success: function(data) {
				swal('success','Passowrd Updated Successfully','success');
				window.location.reload();
			}
		});
		
		});	 */	
		<?php if($_COOKIE[err] !='')	
		{
			echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';	
			setcookie("status", $_COOKIE[status], time()-10);	
			setcookie("title", $_COOKIE[title], time()-10);	
			setcookie("err", $_COOKIE[err], time()-10);	
			}	
			?>  
			var dataTable = $('#myTable').DataTable( {		
			"columnDefs": [ {            "targets": [0], // column or columns numbers        
			"orderable": false,  // set orderable for selected columns        
			}],		 
			"bFilter": false,		
			"bInfo" : true,		 
			"lengthChange":true,       
			"processing": true,          
			"serverSide": true,     
			"ajax":{             
			url :"form-grid-data.php", // json datasource  
			type: "post",  // method  , by default get	
			"data": function ( data ) {           
			data.formname = $('#formname').val(); 
			data.datec = $('#datec').val();       
			},              
			error: function(){  // error handling           
			$(".form-grid-error").html("");         
			$("#form-grid").append('<tbody class="form-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');         
			$("#form-grid_processing").css("display","none");          
			}          
			}     
			} );	
			$('#search').click(function(){ //button filter event click     
			dataTable.ajax.reload(null,false);  //just reload table   
			});	
			$('body').tooltip({
				selector: '.createdDiv'
				});   
			} );
			$(function(){  
			$(".accordian h3").click(function(e){  
			$($(e.target).find('.ti-plus').toggleClass('open')); 
			$(".accordian ul ul").slideUp(); 
			if ($(this).next().is(":hidden")){    
			$(this).next().slideDown();    
			}  
			});
			});
			// Date Picker
			jQuery('.mydatepicker, #datepicker').datepicker();  
			jQuery('#datepicker-autoclose').datepicker({       
			autoclose: true,    
			todayHighlight: true   
			});	
			
</script>
    <!-- accordian script ends-->
</body>

</html>