<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "cat_sub";
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';

switch($method)
{
	case 'add':
		$count = $prop->counts('c_id',SUB_CATEGORY, array('c_name'=>$_POST['category_id'],'sc_name'=>$_POST['scat_name'],'status'=>0));
		if($count==0){
			$input = array(
					'c_name'	=>$_POST['category_id'],
					'sc_name'	=>$_POST['scat_name'],
					);
			$result = $prop->add(SUB_CATEGORY, $input);
			if ($result) {
				setcookie("status", "Success", time()+10);
				setcookie("title", "Subcategory Created Successfully", time()+10);
				setcookie("err", "success", time()+10);
				header('Location: manage-category.php');
			}
			else{
				setcookie("status", "Error", time()+10);
				setcookie("title", "Category Creation Error", time()+10);
				setcookie("err", "error", time()+10);
				header('Location: manage-category.php');
			}
		}else{
			setcookie("status", "Error", time()+10);
			setcookie("title", "Subcategory Already Exits", time()+10);
			setcookie("err", "error", time()+10);
			header('Location: manage-category.php');
		}
		break;
	case 'update':
		$count = $prop->getName('COUNT(c_id)', SUB_CATEGORY, " 1=1 AND c_name=".$_POST['category_id']." AND sc_name='".$_POST['scat_name']."' AND status=0 AND c_id!=".$_REQUEST['id']);
		if($count==0){
			$t_cond = array("c_id" => $_REQUEST['id']);
			$input = array(
				  'c_name'	=>$_POST['category_id'],
				  'sc_name'	=>$_POST['scat_name'],
				);
			if($prop->update(SUB_CATEGORY, $input, $t_cond))
			{
				setcookie("status", "Success", time()+10);
				setcookie("title", "Subcategory Updated Successfully", time()+10);
				setcookie("err", "success", time()+10);
				header('Location: manage-category.php');
			}else{
				setcookie("status", "Error", time()+10);
				setcookie("title", "Subcategory Updated Error", time()+10);
				setcookie("err", "error", time()+10);
				header('Location: manage-category.php?id='.$_REQUEST['id']);
			}
		}else{
			setcookie("status", "Error", time()+10);
			setcookie("title", "Category Already Exits", time()+10);
			setcookie("err", "error", time()+10);
			header('Location: manage-category.php?id='.$_REQUEST['id']);
		}
		break;
}
$formAction = 'add';
if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
	$formAction = 'update&&id='.$_REQUEST['id'];
	$curr_val = $prop->get_Disp('SELECT * FROM `'.SUB_CATEGORY.'` WHERE status!=2 AND c_id='.$_REQUEST['id']);
	if(empty($curr_val)){
		setcookie("status", "Error", time()+10);
		setcookie("title", "Error", time()+10);
		setcookie("err", "error", time()+10);
		header('Location: manage-category.php');
		exit;
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
    <title>Manage Be Safe Category</title>
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
	<link rel="stylesheet" href="css/style-accordian.css">
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
.span1{width:60%;}
.span2{width:20%; text-align:center}
.cd-accordion__label{background:#fff !important; color: #003963;}
.cd-accordion__label:hover{background:#8bbde61a !important}
li a{color:#414141;}
.cd-accordion{    margin-top: 10px;
    margin-bottom: 0px !important;
    border: 1px dotted #eaeff3;
    border-radius: 4px;
    box-shadow: none;
    overflow: hidden;}
    .span2 a {
        border-radius: 100px;
    width: 25px;
    color: #0d558a;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 500;
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
                        <h4 class="page-title">Manage Be safe List </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Manage Be safe List </li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">List of Be safe Pages</h3>
							<div class="row" style="BACKGROUND: #00568a !important;font-weight:bold;color: white;padding: 15px;">
                            	<div class="col-md-8">Category Name</div>
                                <div class="col-md-2">Departments Assigned</div>
                                <div class="col-md-2">Employees Assigned</div>
                            </div>
                            <ul class="cd-accordion cd-accordion--animated margin-top-lg margin-bottom-lg">
                                <li class="cd-accordion__item cd-accordion__item--has-children">
                                  <input class="cd-accordion__input" type="checkbox" name ="group-1" id="group-1">
                                  <label class="cd-accordion__label cd-accordion__label--icon-folder" for="group-1"><span class="span1">Main Category 1</span><span class="span2"><a href="add-training-design.php">10</a></span><span class="span2"><a href="add-training-design.php">10</a></span></label>
                            
                                  <ul class="cd-accordion__sub cd-accordion__sub--l1">
                                    <li class="cd-accordion__item cd-accordion__item--has-children">
                                      <input class="cd-accordion__input" type="checkbox" name ="sub-group-1" id="sub-group-1">
                                      <label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-1"><span class="span1">Sub Category 1</span><span class="span2"><a href="add-training-design.php">3</a></span><span class="span2"><a href="add-training-design.php">3</a></span></label>
                            
                                      <ul class="cd-accordion__sub cd-accordion__sub--l2">
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 1</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 2</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 3</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                      </ul>
                                    </li>
                                  </ul>
                                  
                                  <ul class="cd-accordion__sub cd-accordion__sub--l1">
                                    <li class="cd-accordion__item cd-accordion__item--has-children">
                                      <input class="cd-accordion__input" type="checkbox" name ="sub-group-2" id="sub-group-2">
                                      <label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-2"><span class="span1">Sub Category 2</span><span class="span2"><a href="add-training-design.php">7</a></span><span class="span2">7</span></label>
                            
                                      <ul class="cd-accordion__sub cd-accordion__sub--l2">
                                         <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 1</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 2</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 3</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                      </ul>
                                    </li>
                                  </ul>
                                  
                                  
                                </li>
                            
                               
                              </ul>
                              
                            <ul class="cd-accordion cd-accordion--animated margin-top-lg margin-bottom-lg">
                                <li class="cd-accordion__item cd-accordion__item--has-children">
                                  <input class="cd-accordion__input" type="checkbox" name ="group-2" id="group-2">
                                  <label class="cd-accordion__label cd-accordion__label--icon-folder" for="group-2"><span class="span1">Main Category 2</span><span class="span2">10</span><span class="span2">10</span></label>
                            
                                  <ul class="cd-accordion__sub cd-accordion__sub--l1">
                                    <li class="cd-accordion__item cd-accordion__item--has-children">
                                      <input class="cd-accordion__input" type="checkbox" name ="sub-group-21" id="sub-group-21">
                                      <label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-21"><span class="span1">Sub Category 1</span><span class="span2">3</span><span class="span2">3</span></label>
                            
                                      <ul class="cd-accordion__sub cd-accordion__sub--l2">
                                         <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 1</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 2</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 3</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                      </ul>
                                    </li>
                                  </ul>
                                  
                                  <ul class="cd-accordion__sub cd-accordion__sub--l1">
                                    <li class="cd-accordion__item cd-accordion__item--has-children">
                                      <input class="cd-accordion__input" type="checkbox" name ="sub-group-22" id="sub-group-22">
                                      <label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-22"><span class="span1">Sub Category 2</span><span class="span2">7</span><span class="span2">7</span></label>
                            
                                      <ul class="cd-accordion__sub cd-accordion__sub--l2">
                                         <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 1</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 2</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                        <li class="cd-accordion__item"><a class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1">Page 3</span><span class="span2">1</span><span class="span2">1</span></a></li>
                                      </ul>
                                    </li>
                                  </ul>
                                  
                                  
                                </li>
                            
                               
                              </ul>      
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
	<!-- Footable -->
    <script src="plugins/bower_components/footable/js/footable.all.min.js"></script>
    <!--Acordian 3 level init-->
    <script src="js/main.js"></script>
    <script src="js/util.js"></script>
    <script>
    $(function() {
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
	?>
    });
	$(document).on('click', '.main-status', function() {
		var element = $(this);
		var id = element.attr("data-id");
		var status = element.attr("data-status");
		var ms = (status==0?'Active':'Inactive');
		swal({
			title: ms,
			text: "Are you sure?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Change it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax-status.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=cat-status',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg,response.err);
						if(response.result){
							location.reload();
						}
					}
				});
			}
			else
			{

				swal("Cancelled", "", "error");
			}
		});
	});
	$(document).on('click', '.sub-status', function() {
		var element = $(this);
		var id = element.attr("data-id");
		var status = element.attr("data-status");
		var ms = (status==0?'Active':'Inactive');
		swal({
			title: ms,
			text: "Are you sure?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Change it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax-status.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=catsub-status',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg,response.err);
						if(response.result){
							location.reload();
						}
					}
				});
			}
			else
			{
				swal("Cancelled", "", "error");
			}
		});
	});
	/*Delete Cat*/
	$(document).on('click', '.deleteCat', function() {
		var element = $(this);
		var id = element.attr("data-id");
		var status = element.attr("data-status");
		var ms = (status==0?'Active':'Delete');
		swal({
			title: ms,
			text: "Are you sure, you want to delete it?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Delete it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if(isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax-status.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=catsub-status-delete',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg,response.err);						
						if(response.result){
							location.reload();
						}
					}
				});
			}
			else
			{
				swal("Cancelled", "", "error");
			}
		});
	});
	/*Delete Cat END*/
	/*Delete SubCat*/
	$(document).on('click', '.deleteone_subcat span', function() {
		var element = $(this);
		var id = element.attr("data-id");
		var status = element.attr("data-status");
		var ms = (status==0?'Active':'Delete');
		swal({
			title: ms,
			text: "Are you sure, you want to delete it?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Delete it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if(isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax-status.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=catsub-status-subdelete',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg,response.err);						
						if(response.result){
							location.reload();
						}
					}
				});
			}
			else
			{
				swal("Cancelled", "", "error");
			}
		});
	});
	/*Delete SubCat END*/
	/*NoCategory Cat*/
	$(document).on('click', '.NoCategory', function() {
		var element = $(this);
		var id = element.attr("data-id");
		var status = element.attr("data-status");
		var ms = 'SubCategory Exist';
		swal({
			title: ms,
			text: "That's why you can't delete it",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Go Back!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				 swal('Status','You are back!!!','success');
			}
			else
			{
				swal("Cancelled", "", "error");
			}
		});
	});
	/*NoCategory END*/
	
	$("#submitAjaxBtn").click(function(e){
		var name = $('#mainCategory').val();
		var id = $('#mainCatId').val();
		if(name!='' && name!='undifined'){
			$('.mainCategory').html('');
			$('.mainCategory').hide();
			$.ajax({
				type: "POST",
				url: "ajax.php",
				cache:false,
				data: 'name='+name+'&id='+id+'&meth=Action-Category',
				dataType:'json',
				success: function(response)
				{
					swal(response.status, response.msg, response.error);
					if(response.result){
						location.reload();
					}
				}
			});
		}else{
			$('.mainCategory').html('Please enter category name');
			$('.mainCategory').show();
			$('#mainCategory').focus();
		}
	});
	$('.edit-cat').click(function(e){
		let id = $(this).attr('data-id');
		let name = $('#cat-name-'+id).html();
		$('#mainCategory').val(name);
		$('#mainCatId').val(id);
		$('#submitAjaxBtn').html('Update');
		$('#myModalLabel').html('Edit Category');
		$('.mainCategory').html('');
		$('.mainCategory').hide();
	});
	$('.add-cat').click(function(e){
		$('#mainCategory').val('');
		$('#mainCatId').val('');
		$('#submitAjaxBtn').html('Add');
		$('#myModalLabel').html('Add Category');
		$('.mainCategory').html('');
		$('.mainCategory').hide();
	});
	</script>
</body>

</html>