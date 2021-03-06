<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
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
    <title>DCSHRM | SAVED FORMS</title>
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
    <script src="http://www.w3schools.com/lib/w3data.js"></script>
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
        <div id="page-wrapper">
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
            <div class="row m-t-15">
                    <div class="col-md-12">
                        <div class="white-box p-0 ovr-flo">

                            <h3 class="box-title m-b-0 emp-own h-head-u">Filter Form</h3>

                            <div class="col-sm-12">
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
                        <div class="white-box p-0">

                            <h3 class="box-title m-b-0 emp-own h-head-u">Saved Forms</h3>
							<div class="col-md-12">
								<div class="table-responsive dash-table">
              <table class="table table-bordered" id="myTable">
                <thead>
                  <tr>
                    <th class="text-center">Form Name</th>
                    <th class="text-center">Date</th>
                    <th class=" text-center" style="width:180px">Action</th>
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
	function deleteform(rowID){
var element = $(this);
var del_id = rowID;
var card_name = "Form";
			swal({

				title: card_name,

				text: "Are you sure you want to delete this Form?",

				type: "warning",

				showCancelButton: true,

				confirmButtonColor: "#DD6B55",

				confirmButtonText: "Yes, delete it!",

				cancelButtonText: "Cancel",

				closeOnConfirm: false,

				closeOnCancel: false

			}, function(isConfirm){

				if (isConfirm) {
				 $.ajax({
							type: "POST",
							url: "ajax.php",
							cache:false,
							data: 'ids='+del_id+'&meth=Formdelete',
							success: function(response)
							{
							  swal('Form Deleted Successfully','Success');
							  window.location.reload();
							  return false;
							}
						});
				 }
				 else
				 {

					swal("Cancelled", "", "error");

				}

            });
	}
</script>
    <!-- accordian script ends-->
</body>

</html>
