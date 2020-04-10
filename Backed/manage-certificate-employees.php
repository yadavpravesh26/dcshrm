<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(isset($_REQUEST['ids']))
{
   $table_name = CERTIFICATE_DETAILS;
  $curr_val = $prop->get('*',$table_name, array("c_id"=>$_REQUEST['ids']));
  $coun = explode(",",$curr_val['employee_ids']);
    for($i=0;$i<count($coun);$i++)
    {
      $totalData =$prop->getName('count(ec_id) AS tot',EMPLOYEE_CERTIFICATES,' 1=1 AND c_id='.$curr_val['c_id'].' AND e_id='.$coun[$i].'');
      if($totalData==0)
      {
      	$insdata   = array(
                  'c_id'           =>$curr_val['c_id'],
                  'c_date'           =>date('Y-m-d'),
                  'e_id'           =>$coun[$i]
      			);
      		$result = $prop->add(EMPLOYEE_CERTIFICATES, $insdata);
        }
    }
}
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'dele':
   setcookie("status", "Success", time()+10);
   setcookie("title", "Certificate Deleted Successfully", time()+10);
   setcookie("err", "success", time()+10);
   header('Location: manage-certificate-employees.php?ids='.$_REQUEST['id']);

 break;
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
    <title>Department Category</title>
    <!-- Bootstrap Core CSS -->
     <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	   <!-- Footable CSS -->

	   <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">

    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
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

		.footable-row-detail-name {
    display: table-cell;
    font-weight: 500;
    padding-right: 3px;
    padding-bottom: 5px;
    /* display: none; */
}
		.footable-row-detail-inner {width:100%;}
        .new-ad{margin-top:25px;}

.dcs-bot .btn {
height: 32px !important;
}

.dcs-bot .input-group-addon {
padding: 8px 95px 8px 26px;
font-size: 14px;
}
.navbar-header {
    background: #4F5467 !important;
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
                        <h4 class="page-title">Employee Certificates</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Employee Certificate Details</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

  <div class="row">
                    <div class="col-md-12">
                        <div class="white-box" style="overflow:hidden;">

                            <h3 class="box-title m-b-0">Manage Employee Certificates </h3>

                            <div class="table-responsive">
                                  <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Certificate Title</th>
                                            <th>Date</th>
                                            <th>Department</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>

            </div>

<!--end-->
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
 <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>

    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
	<!-- Footable -->


    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>

    <!-- end - This is for export functionality only -->
    <script>
    $(function() {
      <?php if($_COOKIE[err] !='')
  			{

  				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';
  				setcookie("status", $_COOKIE[status], time()-100);
  				setcookie("title", $_COOKIE[title], time()-100);
  				setcookie("err", $_COOKIE[err], time()-100);
  			}
  			?>


    });

    $(document).ready(function() {

       var ClientTable = $('#example23').DataTable({
           'processing': true,
           'serverSide': true,

           "ajax":{
              url : "ajax-employee-certificate.php", // json datasource
              type: "post",  // method  , by default get
              "data": function ( data ) {
                  data.cert_id = <?php echo $_REQUEST['ids']; ?>;
               },
              error: function(){  // error handling
                $(".example23-error").html("");
                $("#example23").append('<tbody class="employee-grid-error"><tr><th colspan="3">No Net Volume found in the server</th></tr></tbody>');
                $("#example23_processing").css("display","none");
              }
            }
       });
});
$(document).on('click', '.deleteone', function() {
var element = $(this);
var del_id = element.attr("id");
var card_name = "Employee";
  swal({

    title: card_name,

    text: "Are you sure you want to delete this Employee?",

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
          data: 'ids='+del_id+'&meth=certdelete',
          success: function(response)
          {
          //  swal("Success","Delete Success","success");
            //ClientTable.ajax.reload();
            window.location.href = "manage-certificate-employees.php?method=dele&id="+<?php echo $_REQUEST['ids']; ?>;
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

</body>

</html>
