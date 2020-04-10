<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
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
	<title>Manage Form Reports</title>
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
        <!-- Top Navigation -->
       <?php include 'header.php';?>
        <!-- End Top Navigation -->
		 <?php include 'left-sidebar.php';?>
        <!-- Left navbar-header -->
       <?php include 'navbar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Saved Forms</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a></li>
							<li class="active">Forms</li>
						</ol>
                    </div>

                </div>
                <div class="clearfix"></div>
            <div class="row m-t-15">
                    <div class="col-md-12">
                        <div class="white-box" style="overflow:hidden;">

                            <h3 class="box-title m-b-0 emp-own h-head-u">Filter Form</h3>

                           
                                <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="exampleInputuname" class="lab-head-u">Form Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-u" id="formname" placeholder="Form Name">
                                            </div>
                                        </div>

								</div>

                                <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="exampleInputuname" class="lab-head-u">Date</label>
                                            <div class="example">

                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-u mydatepicker" id="datec" placeholder="mm/dd/yyyy">
                                            <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                    </div>
                                        </div>


                                </div>

                                <div class="col-md-3">

                                        <div class="form-group">
                                           <label for="exampleInputuname" class="lab-head-u">&nbsp;</label>
                                          <button class="btn btn-block btn-success" id="search">Search</button>
                                        </div>

                                </div>
                            </div>
							<div class="clearfix"></div>
                            </div>
                        </div>
            
				<div class="clearfix"></div>

                  <div class="row m-t-15">
                    <div class="col-md-12">
                        <div class="white-box ">

                            <h3 class="box-title m-b-0 emp-own h-head-u">Saved Forms</h3>
							<div class="col-md-12">
								<div class="table-responsive dash-table">
              <table class="table table-bordered" id="myTable">
                <thead>
                  <tr>
						<th width="50%" class="text-center">Form Name</th>
						<th width="20%" class="text-center">Name</th>
						<th width="10%" class="text-center">Date</th>
						<th width="20%" class="wid-150px text-center">Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
							</div>

							<div class="clearfix"></div>
                        </div>
                    </div>
            </div>

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
	<!-- Date Picker Plugin JavaScript -->
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>

	<!--end -->
    <script>

	 $(document).ready(function() {
		<?php if($_COOKIE[err] !='')
			{

				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';
				setcookie("status", $_COOKIE[status], time()-10);
				setcookie("title", $_COOKIE[title], time()-10);
				setcookie("err", $_COOKIE[err], time()-10);
			}
			?>
        var dataTable = $('#myTable').DataTable( {
			"columnDefs": [ {
            "targets": [0], // column or columns numbers
            "orderable": false,  // set orderable for selected columns
          }],
		  "bFilter": false,
		  "bInfo" : true,
		  "lengthChange":true,
            "processing": true,
            "serverSide": true,

            "ajax":{
                url :"from-report-data.php", // json datasource
                type: "post",  // method  , by default get
				 "data": function ( data ) {
                data.formname = $('#formname').val();
                data.datec = $('#datec').val();

            },
				complete: function() {
					$('[data-toggle="tooltip"]').tooltip();
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
	
	$(document).on('click', '.reassignQuiz', function() {
		var element = $(this);
		var id = element.attr('data-id');
		var status = element.attr('data-ass');
		var msg = (status==1?'Reassign Quiz':'Cancel Reassign Quiz');
		swal({
			title: 'Quiz',
			text: msg,
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Are you sure?",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=QuizAss',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg, response.err);
						location.reload();
					}
				});
			}
			else
			{
				swal("Cancelled", "", "error");
			}
		});
	});
</script>
    <!-- accordian script ends-->
</body>

</html>
