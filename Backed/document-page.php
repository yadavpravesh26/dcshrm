<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "docs";

$catfetdoc =  "SELECT * FROM docs WHERE doc_id =".$_REQUEST['ids']." AND doc_status!=2";
//$catfetdoc =  "SELECT * FROM docs WHERE doc_id =".$_REQUEST['ids']." AND doc_status=0";
$rowdoc=$prop->getAll_Disp($catfetdoc);
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
	<title><?php echo $rowdoc[0]['doc_name'] ?></title>
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
	<link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	 <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	<!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	   <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
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
h1 {
    line-height: 48px;
    font-size: 22px;
    font-weight: 600;
}
ol {
    padding: 0;
    color: #333;
    font-weight: 600;
}

		.icheck-list li {
    padding-bottom: 5px;
    display: inline;
    margin-right: 10px;
}
		.icheck-list {padding-right: 0;}
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
						<h4 class="page-title">Manage Documents</h4> </div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a>
							</li>
							<li class="active">Manage Documents</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-md-12">
			
						   <div class="white-box">
                            <h3 class="box-title"><?php echo $rowdoc[0]['doc_name'] ?></h3>


<?php echo $rowdoc[0]['doc_content'] ?>


</div>









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

													 <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
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
																//Bootstrap-TouchSpin
																$( ".vertical-spin" ).TouchSpin( {
																	verticalbuttons: true,
																	verticalupclass: 'ti-plus',
																	verticaldownclass: 'ti-minus'
																} );
																var vspinTrue = $( ".vertical-spin" ).TouchSpin( {
																	verticalbuttons: true
																} );
																if ( vspinTrue ) {
																	$( '.vertical-spin' ).prev( '.bootstrap-touchspin-prefix' ).remove();
																}
																$( "input[name='tch1']" ).TouchSpin( {
																	min: 0,
																	max: 100,
																	step: 0.1,
																	decimals: 2,
																	boostat: 5,
																	maxboostedstep: 10,
																	postfix: '%'
																} );
																$( "input[name='tch2']" ).TouchSpin( {
																	min: -1000000000,
																	max: 1000000000,
																	stepinterval: 50,
																	maxboostedstep: 10000000,
																	prefix: '$'
																} );
																$( "input[name='tch3']" ).TouchSpin();
																$( "input[name='tch3_22']" ).TouchSpin( {
																	initval: 40
																} );
																$( "input[name='tch5']" ).TouchSpin( {
																	prefix: "pre",
																	postfix: "post"
																} );
																// For multiselect
																$( '#pre-selected-options' ).multiSelect();
																$( '#optgroup' ).multiSelect( {
																	selectableOptgroup: true
																} );
																$( '#public-methods' ).multiSelect();
																$( '#select-all' ).click( function () {
																	$( '#public-methods' ).multiSelect( 'select_all' );
																	return false;
																} );
																$( '#deselect-all' ).click( function () {
																	$( '#public-methods' ).multiSelect( 'deselect_all' );
																	return false;
																} );
																$( '#refresh' ).on( 'click', function () {
																	$( '#public-methods' ).multiSelect( 'refresh' );
																	return false;
																} );
																$( '#add-option' ).on( 'click', function () {
																	$( '#public-methods' ).multiSelect( 'addOption', {
																		value: 42,
																		text: 'test 42',
																		index: 0
																	} );
																	return false;
																} );
															} );
														</script>
														<!-- Footable -->



													     <!-- Sweet-Alert  -->
													    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>

														<!-- Date Picker Plugin JavaScript -->
													    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
														 <!-- Date range Plugin JavaScript -->
													    <script src="plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
													    <script src="plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>



													</html>
