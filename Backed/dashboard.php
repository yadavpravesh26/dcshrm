<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

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
    <title>Dashboard</title>
    <!-- Bootstrap Core CSS -->
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- data table css -->
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- data table css ends-->
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
<style type="text/css">
    .form-group {
    margin-bottom: 15px;
}
.panel-group .panel .panel-heading a[data-toggle=collapse] {
    display: block;
}
.modal-body {
    background: #f5f5f5;
}
.white{
    background: #fff;
}
</style>
</head>

<body>
    <!-- Preloader -->
    <!-- <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div> -->
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
                        <h4 class="page-title">Dashboard </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            <div class="row">
			<?php 
			if($session['b_type']===0){ 
				$totalActUser = $prop->counts('id',USERS, array('status'=>0,'u_type'=>2));
				$totalInActUser = $prop->counts('id',USERS, array('status'=>1,'u_type'=>2));
				$totalUser = $totalActUser + $totalInActUser;
				$expiryUser = $prop->getName('COUNT(id)', USERS, " 1=1 AND status!=2 AND end_date<'".date('Y-m-d')."'");
			?>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-danger bg1"></i>
					  <div class="bodystate">
						<h4><?php echo $totalUser; ?></h4>
						<a href="manage-company.php"><span class="text-muted d-txt">Total Company</span></a>
					  </div>
					</div>  
				  </div>
				</div>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-info bg2"></i>
					  <div class="bodystate">
						<h4><?php echo $totalActUser; ?></h4>
						<a href="manage-company.php?s=active"><span class="text-muted d-txt">Active Company</span></a>
					  </div>
					</div>  
				  </div>
				</div>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-success bg3"></i>
					  <div class="bodystate">
						<h4><?php echo $totalInActUser; ?></h4>
						<a href="manage-company.php?s=inactive"><span class="text-muted d-txt">Inactive Company</span></a>
					  </div>
					</div>  
				  </div>
				</div>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-inverse bg4"></i>
					  <div class="bodystate">
						<h4><?php echo $expiryUser; ?></h4>
						<a href="manage-company.php?e=expiry"><span class="text-muted d-txt">Expiry Company</span></a>
					  </div>
					</div>  
				  </div>
				</div>
			<?php } 
			if($session['b_type']===2){ 
			$totalActUser = $prop->counts('id',USERS, array('status'=>0,'u_type'=>4,'u_id'=>$session['bid']));
			$totalInActUser = $prop->counts('id',USERS, array('status'=>1,'u_type'=>4,'u_id'=>$session['bid']));
			$totalUser = $totalActUser + $totalInActUser;
			?>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-danger bg1"></i>
					  <div class="bodystate">
						<h4><?php echo $totalUser; ?></h4>
						<a href="employee-details.php"><span class="text-muted">Total Users</span></a>
					  </div>
					</div>  
				  </div>
				</div>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-info bg2"></i>
					  <div class="bodystate">
						<h4><?php echo $totalActUser; ?></h4>
						<a href="employee-details.php?s=active"><span class="text-muted">Active Users</span></a>
					  </div>
					</div>  
				  </div>
				</div>
				<div class="col-md-3 col-sm-6">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-success bg3"></i>
					  <div class="bodystate">
						<h4><?php echo $totalInActUser; ?></h4>
						<a href="employee-details.php?s=inactive"><span class="text-muted">Inactive Users</span></a>
					  </div>
					</div>  
				  </div>
				</div>
			<?php } ?>
			</div>
            

             </div>
            <!-- /.container-fluid -->
            <?php include "footer.php" ?>
       
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
    <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- data table -->
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });


    </script>

</body>

</html>
