<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "pages";
if(bckPermission($session['b_type'])){
	header('location:dashboard.php');
	exit;
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
	<title>Manage New Pages</title>
	<!-- Bootstrap Core CSS -->
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	<!-- Footable CSS -->
	<link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css"/>
	<link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
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
						<h4 class="page-title">Manage Be Safe Programs</h4> </div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a>
							</li>
							<li class="active">Manage Be Safe Programs</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<div class="row">
					<div class="col-md-12">


						   <div class="white-box">
                            <h3 class="box-title">List Of Be Safe Programs</h3>
							   <div class="clearfix"></div>

							    <h2 class="box-title m-t-15">Filter By</h2>
							   <div class="form-group col-md-5">

									 <select class="form-control select2" id="category" name="category_id" data-placeholder="Choose" style="max-height: 34px;padding: 0px 10px;">
 										<option value="">Select</option>
 										<?php
 										// Perform queries
 									$catfets =  "SELECT * FROM `".MAIN_CATEGORY."` WHERE status=0 order by c_name ASC";
 									$rowcat=$prop->getAll_Disp($catfets);
 									for($i=0; $i<count($rowcat); $i++)
 										 {
 									?>
 										<optgroup label="<?php echo $rowcat[$i]['c_name']; ?>">
 											<?php
 											$catfetsub =  "SELECT * FROM `".SUB_CATEGORY."` WHERE c_name='". $rowcat[$i]['c_id']."' AND status=0 order by sc_name ASC";
 											$rowcatub=$prop->getAll_Disp($catfetsub);
 											for($di=0; $di<count($rowcatub); $di++)
 											 {
 												 $myString = $curr_val['doc_cat'];
 												 $myArray = explode(',', $myString);
 											?>
 											<option value="<?php echo $rowcatub[$di]['c_id']; ?>" <?php if (in_array($rowcatub[$di]['c_id'], $myArray)) { echo "selected"; } ?>><?php echo $rowcatub[$di]['sc_name']; ?></option>
 											<?php } ?>
 										</optgroup>
 										<?php } ?>


 									</select>
										<div class="help-block with-errors"></div>
									</div>
							   <div class="form-group col-md-5">
                                 <div class="clearfix"></div>
                                 <div class="input-group">
                                
                                        <input class="form-control" id="search" placeholder="Search Page Title" required="" type="text">
                                    </div>
									</div>
							   <div class="col-md-2 pull-right"><button type="button" id="searchbut" class="btn btn-block btn-info waves-effect waves-light pull-right m-r-10 ">Search</button></div>

							   <div class="clearfix"></div>
                                 <div class="table-responsive dash-table">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Program Title</th>
                                            <th class="text-center">Category Applicable</th>

                                            <th class="text-center" width="220px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>



                                    </tbody>
                                </table>
                            </div>



                            <form data-toggle="validator">
                                       <div class="row">


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
	<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
	<script>
	
	$(document).ready(function() {
		$('#myTable').DataTable( {
			"bFilter": false,
			"bInfo" : true,
			"paging":   true,
			"ordering": false,
			"info":     false,
			"lengthMenu": [ [50, 10, 150, 50000], [50, 100, 150, "All"] ],
			"processing": true,
			"serverSide": true,
			"displayLength": 50,
			"ajax":{
				url :"manage-page-data.php", 
				type: "post",  
				"data": function ( data ) {
					data.category = $("#category").val();
					data.search = $("#search").val();
				},
				complete: function() {
					$('[data-toggle="tooltip"]').tooltip();
				},
				error: function(){ 
					$(".form-grid-error").html("");
					$("#form-grid").append('<tbody class="form-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#form-grid_processing").css("display","none");
				}
			}
		} );

		$(document).on('click', '#searchbut', function() {
			$('#myTable').DataTable().ajax.reload();
		} );
		
		$(document).on('click', '.page-status', function() {
			var element = $(this);
			var id = element.attr("data-id");
			var status = element.attr("data-status");
			var ms = (status==0?'Publish':'Unpublish');
			swal({
				title: ms,
				text: "Are you sure?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, "+ms+" it!",
				cancelButtonText: "Cancel",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm){
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "ajax-status.php",
						cache:false,
						data: 'id='+id+'&status='+status+'&meth=page-status',
						dataType:'json',
						success: function(response)
						{
							swal(response.status, response.msg,response.err);
							if(response.result){
								$('#myTable').DataTable().ajax.reload();
							}
							setTimeout(function() {
								$(".confirm").trigger('click');
							}, 3000);
						}
					});
				}
				else
				{
					swal("Cancelled", "", "error");
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
				}
			});
		});
		/*Duplicate start*/
		$(document).on('click', '.page-copy', function() {
			var element = $(this);
			var id = element.attr("data-id");
			ms = 'Duplicate!';
			swal({
				title: ms,
				text: "Are you sure?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Duplicate it!",
				cancelButtonText: "Cancel",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm){
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "ajax-status.php",
						cache:false,
						data: 'id='+id+'&meth=page-copy',
						dataType:'json',
						success: function(response)
						{
							swal(response.status, response.msg,response.err);
							if(response.result){
								$('#myTable').DataTable().ajax.reload();
							}
							setTimeout(function() {
								$(".confirm").trigger('click');
							}, 3000);
						}
					});
				}
				else
				{
					swal("Cancelled", "", "error");
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
				}
			});
		});
		/*Duplicate END*/
		/*Delete code*/
		$(document).on('click', '.deleteone', function() {
			var element = $(this);
			var id = element.attr("id");
			var status = 2;
			var ms = 'Delete';
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
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "ajax-status.php",
						cache:false,
						data: 'id='+id+'&status='+status+'&meth=page-status-delete',
						dataType:'json',
						success: function(response)
						{
							swal(response.status, response.msg,response.err);
							if(response.result){
								$('#myTable').DataTable().ajax.reload();
							}
							setTimeout(function() {
								$(".confirm").trigger('click');
							  }, 3000);
						}
					});
				}
				else
				{
					swal("Cancelled", "", "error");
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
				}
			});
		});
		/*Delete code END*/
	} );
	<?php if($_COOKIE[err] !='')
	{

		echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';
		?>
				setTimeout(function() {
					$(".confirm").trigger('click');
				  }, 3000);
				<?php
		setcookie("status", $_COOKIE[status], time()-100);
		setcookie("title", $_COOKIE[title], time()-100);
		setcookie("err", $_COOKIE[err], time()-100);
	}
	?>
				
	</script>


</body>
</html>
