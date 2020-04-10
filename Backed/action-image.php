<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "docs";
if(bckPermission($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	case 'add':

		$insdata = array(
					'doc_cat'		=>$_POST['category_id'],
					'doc_scat'		=>$_POST['subcategory_id'],
					'doc_name'		=>$_POST['document_name'],
					'doc_type'		=>4
			);
		$result = 1;
		$msg = 'Image Creation Error';
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
			$result = 0;
			$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');
			
			$msg = 'File invalid format';
			$extension = end(explode('.',strtolower($_FILES['file']['name'])));
			if(in_array($extension, $allowedExtensions)){
				$doc_file = rand(10,100).time().'.'.$extension;
				if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/banner/'.$doc_file)) {
					$insdata['doc_file'] = $doc_file;
					$result = 1;
					if ($prop->add($table_name, $insdata)) {
						setcookie("status", "Success", time()+10);
						setcookie("title", "Image Created Successfully", time()+10);
						setcookie("err", "success", time()+10);
						header('Location: manage-image.php');
						break;
					}
				}else{
					$msg = 'File not upload';
				}
			}
		}
		setcookie("status", "Error", time()+10);
		setcookie("title", $msg, time()+10);
		setcookie("err", "error", time()+10);
		header('Location: action-image.php');
	break;
	case 'update':

		$t_cond = array("doc_id" => $_REQUEST['id']);
		$value = array(
					'doc_cat'		=>$_POST['category_id'],
					'doc_scat'		=>$_POST['subcategory_id'],
					'doc_name'		=>$_POST['document_name']
			);
		$result = 1;
		$msg = 'Image Updated Error';
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
			$result = 0;
			$allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');
			$msg = 'File invalid format';
			$extension = end(explode('.',strtolower($_FILES['file']['name'])));
			if(in_array($extension, $allowedExtensions)){
				$doc_file = rand(10,100).time().'.'.$extension;
				if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/banner/'.$doc_file)) {
					$value['doc_file'] = $doc_file;
					$result = 1;
				}else{
					$msg = 'File not upload';
				}
			}
		}
		
		if($result)
			$res = $prop->update($table_name, $value, $t_cond);
		if($res)
		{
			setcookie("status", "Success", time()+10);
			setcookie("title", "Image Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			header('Location: manage-image.php');
		}else{
			setcookie("status", "Error", time()+10);
            setcookie("title", $msg, time()+10);
            setcookie("err", "error", time()+10);
			header('Location: action-image.php?method=modify&id'.$_REQUEST['id']);
		}
	break;
}
$titleTag = 'Add';
if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',$table_name, array("doc_id"=>$_REQUEST['id'],'doc_type'=>4));
	if(empty($curr_val)){
		header('Location: manage-image.php');
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
	<title><?php echo $titleTag; ?> Image</title>
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
						<h4 class="page-title"><?php echo $titleTag; ?> Image</h4> </div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a>
							</li>
							<li class="active"><?php echo $titleTag; ?> Image</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="white-box">
							<h3 class="box-title"><?php echo $titleTag; ?> Image</h3>

							<?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');?>

							<form data-toggle="validator" method="post" action="action-image.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" id='categoryform'>
								<div class="row">
									<div class="form-group col-md-6">
										<label for="exampleInputuname">Category</label>
										<select class="selectpicker mainCategory" name="category_id" id="category_id" data-placeholder="Choose" required>
											<option value="">Select</option>
											<?php
											$catfets =  "SELECT * FROM cats WHERE status=0";
											$rowcat=$prop->getAll_Disp($catfets);
											for($i=0; $i<count($rowcat); $i++)
											{
											?>
											<option value="<?php echo $rowcat[$i]['c_id']; ?>" <?php echo $rowcat[$i]['c_id']==$curr_val['doc_cat']?'selected':''; ?>><?php echo $rowcat[$i]['c_name']; ?></option>
											<?php 
											} 
											?>
										</select>
										<div class="help-block with-errors"></div>
									</div>
									<div id="SubCatDiv" class="form-group col-md-6">
										<label for="exampleInputuname">Sub Category</label>
										<select class="selectpicker subCategory" name="subcategory_id" id="subcategory_id" data-placeholder="Choose" required>
											<option value="">Select</option>
											<?php
											if($curr_val['doc_scat']!='' && $curr_val['doc_cat']>0){
												$rowcatub=$prop->getAll_Disp("SELECT * FROM cat_sub WHERE c_name='". $curr_val['doc_cat']."' AND status=0");
												for($di=0; $di<count($rowcatub); $di++)
												{
													$myString = $curr_val['doc_cat'];
												?>
												<option value="<?php echo $rowcatub[$di]['c_id']; ?>" <?php echo $rowcatub[$di]['c_id']==$curr_val['doc_scat']?'selected':'';?>><?php echo $rowcatub[$di]['sc_name']; ?></option>
												<?php 
												} 
											}
											?>
										</select>
										<div class="help-block with-errors"></div>
									</div>

									<div class="clearfix"></div>
									<div class="form-group col-md-6">
										<label for="exampleInputuname">Image Title</label>

										<div class="input-group">

											<input type="text" class="form-control" name="document_name" value="<?php echo $curr_val['doc_name'];?>" id="exampleInputuname" placeholder="Title" required>
										</div>
										<div class="help-block with-errors"></div>
									</div>
									
									<div class="form-group col-md-6">
										<label for="exampleInputuname">Image</label>

										<div class="input-group">

											<input type="file" class="form-control" name="file" accept="image/x-png,image/gif,image/jpeg" id="exampleInputuname">
										</div>
										<div class="help-block with-errors"></div>
										<div class=""><?php echo ($curr_val['doc_file']!=''?'<img width="200px" src="../images/banner/'.$curr_val['doc_file'].'">':''); ?></div>
									</div>


									</section>
									<!-- Page Content ends -->




									<div class="clearfix"></div>
									<div class="col-sm-12">
										<a href="manage-image.php"><button type="button"  class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button></a>
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
			// Switchery
			var elems = Array.prototype.slice.call( document.querySelectorAll( '.js-switch' ) );
			$( '.js-switch' ).each( function () {
				new Switchery( $( this )[ 0 ], $( this ).data() );
			} );
			// For select 2
			$( ".select2" ).select2();
			$( '.selectpicker' ).selectpicker();
		} );

	</script>
	<!-- Footable -->
	<script src="plugins/bower_components/footable/js/footable.all.min.js"></script>
	<script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
	<!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
	<!--FooTable init-->
	<script src="js/footable-init.js"></script>

    <script>

	$('.mainCategory').change(function(e){
		let id = $(this).val();
		let dropdown = $('#SubCatDiv');
		let c = '<label for="exampleInputuname">Sub Category</label>'
				+'<select class="selectpicker subCategory" name="subcategory_id" id="subcategory_id" data-placeholder="Choose" required>'
				+'</select><div class="help-block with-errors"></div>';
		dropdown.html(c);
		let opt = '';
		let url = 'ajax-drop.php?method=category&id='+id;
		$.getJSON(url, function (data) {
			$('#subcategory_id').html('<option value="">Select</option>');
			$.each(data, function (key, entry) {
				$('#subcategory_id').append('<option value="'+entry.id+'">'+entry.name+'</option>');
			});
			$('#subcategory_id').selectpicker() ;
		});
		
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
	?>
    </script>
	<!--Style Switcher -->
	<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
