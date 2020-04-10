<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "docs";
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
 case 'add':
	$msg = 'Enter valid email id';
	if(filter_var($_POST['clname'], FILTER_VALIDATE_EMAIL)){
		$msg = 'Email id already exists';
		$exits = $prop->getName('count(id)', USERS, "status!=2 AND email='".$_POST['clname']."'");
		if($exits===0){
			$insdatalog   = array(
				'name'		=>$_POST['cfname'],
				'email'		=>$_POST['clname'],
				'password'	=>crypt($_POST['connewpass']),
				'de_pass'	=>$_POST['connewpass'],
				'user_type'	=>'R',
				'u_type'	=>1,
				'created_ip'=>IP,
				'created_date'=>DB_DATE,
				'created_id'=>$session['bid']
				);
			$result = $prop->add(USERS, $insdatalog);
			if ($result) {
				setcookie('status', 'Success', time()+10);
				setcookie('title', 'Admin Created Successfully', time()+10);
				setcookie('err', 'success', time()+10);
				header('Location: manage-accounts.php');
				break;
			}
		}
	}
	setcookie('status', 'Error', time()+10);
	setcookie('title', 'Admin Created Failed', time()+10);
	setcookie('err', 'error', time()+10);
	break;
	case 'update':
	$t_cond = array("id" => $_REQUEST['id']);
	$insdatalog   = array(
            'name'		=>$_POST['cfname'],
            'password'	=>crypt($_POST['connewpass']),
			'de_pass'	=>$_POST['connewpass'],
			'updated_ip'=>IP,
			'updated_date'=>DB_DATE,
			'updated_id'=>$session['bid']
            );
		if($prop->update(USERS, $insdatalog, $t_cond))
		{
			setcookie('status', 'Success', time()+10);
			setcookie('title', 'Admin Updated Successfully', time()+10);
			setcookie('err', 'success', time()+10);
			header('Location: manage-accounts.php');
			break;
		}
	setcookie('status', 'Error', time()+10);
	setcookie('title', 'Admin Updated Failed', time()+10);
	setcookie('err', 'error', time()+10);
	break;
}
$titleTag = 'Add';
if(isset($_REQUEST['id'])){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',USERS, array('id'=>$_REQUEST['id'],'u_type'=>1));
	if($curr_val['status']===2){
		header('Location: manage-admin.php');
		exit;
	}
	if($curr_val['u_id']!=$session['bid'] && $session['b_type']!=0){
		header('Location: manage-admin.php');
		exit;
	}
}

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
  	<title><?php echo $titleTag; ?> Admin</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
   <link href="css/colors/default-dark.css" id="theme" rel="stylesheet">
    <!--<link href="css/colors/blue.css" id="theme" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/hmanage-categories.phptml5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
.select2-choices li:nth-child(2) {
    visibility:hidden;
}
.sel2{
	padding: 0;
box-shadow: none;
border: none;
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
                        <h4 class="page-title"><?php
          		if(isset($_REQUEST['id']))
          		{
          	 ?> Edit <?php } else { ?> Add New <?php } ?> Admin </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                          <li><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="active"><?php
              		if(isset($_REQUEST['id']))
              		{
              	 ?> Edit <?php } else { ?> Add New <?php } ?> Admin</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div class="white-box">
							<h3 class="box-title">Add New Admin</h3>
						 <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>

                             <form data-toggle="validator" id="formadvertiser"  method="post" action="add-account.php?method=<?php echo $foraction; ?>" >
                                       <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                                <input type="text" class="form-control" id="exampleInputuname" name="cfname" placeholder="Name" value="<?php echo $curr_val['name'];?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-email"></i></div>
                                                <input type="email" class="form-control" id="inputemail" placeholder="Email" name="clname" data-error="Please enter valid email address" value="<?php echo $curr_val['email'];?>" required>
                                            </div>
                                            <div class="help-block with-errors alexist"></div>
                                        </div>
                                            <div class="form-group col-sm-6">
                                            <label for="inputEmail" class="control-label">Password</label>
                                   <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-key"></i></div> <input type="text" data-toggle="validator" data-minlength="6" name="newpass" value="<?php echo $curr_val['de_pass'];?>" class="form-control" id="inputPassword4" rel="showalt" placeholder="Password" required>

											</div>
											<span style='color:red;display:none;' id='showalt'>Space Not Allowed</span>
                                      <div class="help-block with-errors"></div>
                                    </div>

                                       <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Confirm password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-key"></i></div>
                                                <input type="text" class="form-control"  name="connewpass" id="inputPasswordConfirm4" value="<?php echo $curr_val['de_pass'];?>" rel="showalt1" data-match="#inputPassword4" data-match-error="Whoops, Passwords don't match" placeholder="Confirm" required>
                                            </div>
											<span style='color:red;display:none;' id='showalt1'>Space Not Allowed</span>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12"><button type="button" class="btn btn-inverse waves-effect waves-light pull-right" onclick="RestFormval();">Cancel</button><button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10"><?php
                          		if(isset($_REQUEST['id']))
                          		{
                          	 ?> Update <?php } else { ?>Add <?php } ?></button></div>

                                        </div>

                                    </div>
							</form>
                            </div>


                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->
            <?php include "footer.php" ?>
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
	  <script src="js/validator.js"></script>
    <!-- add button script -->


  <!-- add row starts-->

    <!-- add button script ends -->

     <!-- Date Picker Plugin JavaScript -->
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script>
		// Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker({
        autoclose: true,
		endDate: '+0d',
        todayHighlight: true
    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
	</script>
   <!-- select 2 -->
   <!-- select 2 ends -->
   <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
	<script>
	// For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
		</script>
			<!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
     <?php if(isset($_REQUEST['id'])) { ?>
  <script type="text/javascript">
$(document).ready(function(){
	
var $modal = $('#load_popup_modal_show_id');
$('#click_to_load_modal_popup').on('click', function(){
$modal.load('load-modal.php',{'id': <?php echo $_REQUEST['id']?>,'method' : "popup"},
function(){
$modal.modal('show');
});

});
$(document).on('click', '#submit_popup', function() {
//$('#submit_popup').on('click', function(){
	var pass = $("#company_password").val();
	var conpass = $("#company_confirm_password").val();
	if(conpass.length>=5 && pass == conpass)
	{
		$.ajax ({
                        type: "POST",
                        url: "load-modal.php",
                       data: 'pass='+conpass+'&id='+<?php echo $_REQUEST['id']?>+'&method=changepass',
                        success: function() {
							$modal.modal('hide');
							 $( "div.alert-success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
							return false;

						}


                    });
				//	$modal.modal('hide');

				//	return false;


	}
});

});

</script>

<?php } ?>
<script>
	$(document).ready(function () { //newly added
        $('#inputemail').keyup(function () {
            var inputemail = $('#inputemail').val(); // assuming this is a input text field
                $.post('ajax.php', {'emailid': inputemail,'meth':'emailexist'}, function (data) {
                if (data == 'exist') {
                    $("#inputemail").css("border", "1px solid #CC2424");
                    $(".alexist").html("Email ID already exist");
                    $(".alexist").css("color", "#CC2424");
                    $("#inputemail").focus();
					 $(':input[type="submit"]').prop('disabled', true);
                    return false;
                }
                else {
                    $("#inputemail").css("border", "1px solid #E4E7EA");
                    $(".alexist").html("");
					 $(':input[type="submit"]').prop('disabled', false);
                }

            });
        });
	$("#inputPassword4,#inputPasswordConfirm4").keydown(function(e){
		 if (e.keyCode == 32) { 
		var ID=$(this).attr('rel');
		 $("#"+ID).fadeIn(1000).fadeOut(1000);
       return false; 
     }
	});
    });
	function RestFormval(){
	$("#formadvertiser")[0].reset();
}
	</script>
</body>

</html>
