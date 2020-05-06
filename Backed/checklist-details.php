<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
if(bckPermissionCompany($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
function processURL($url)
{
$ch = curl_init();
curl_setopt_array($ch, array(
CURLOPT_URL => $url,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_SSL_VERIFYPEER => false,
CURLOPT_SSL_VERIFYHOST => 2
));

$result = curl_exec($ch);
//var_dump($result);
curl_close($ch);
return $result;
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
    <title>Employees</title>
    <!-- Bootstrap Core CSS -->
     <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	   <!-- Footable CSS -->
    <link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
	   <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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
	a.ic-re i {
    font-size: 15px;
    margin-right: 5px;
}

a.ic-re {
    color: #163f5d;
    display: flex;
    align-items: center;
}
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
                        <h4 class="page-title">Checklist</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Checklist List</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>



 		 <div class="row">
                    <div class="col-md-12">
                        <div class="white-box" style="overflow:hidden;">

                            <h3 class="box-title m-b-0">List of Checklist</h3>

                            <div class="table-responsive dash-table">
                                 <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    	$apiLink = 'https://pr.survey360pro.com/admin/api/dcshrm-api.php';
										$fetch_con = "dcshrm-".$session['bid']."-checklist-";
										$url = "$apiLink?user_details=".$fetch_con."&method=call_for_gues_id";
										$result = processURL($url);
										$all_survey = json_decode($result, true);
										$total_survey = count($all_survey["output"]);
										$output_survey = $all_survey["output"];
										//print_r($output_survey);
										//echo $result ;
										for($i= 0; $i<$total_survey; $i++)
										{
											$gues_id = $output_survey[$i]['gues_id'];
											$add_date = $output_survey[$i]['add_date'];
											$gues_others = $output_survey[$i]['others'];
											$gues_others = explode('-',$gues_others);
											$company_id= $gues_others[1];
											$emp_id = $gues_others[3];
											$url = "$apiLink?gues_id=".$gues_id."&method=call_for_gues_details";
											$result_gues = processURL($url);
											$all_gues = json_decode($result_gues, true);
											$output_gues = $all_gues["output"];
											
											/*EMP Details*/
											$sql = "SELECT e.id,e.name,e.email,e.contact_no,d.dep_name FROM ".USERS." e INNER JOIN ".DEPARTMENT_NEW." d ON d.dept_id = e.department_id WHERE e.status!=2 AND e.u_type=4 AND e.id=".$emp_id;		
											
											$row=$prop->getAll_Disp($sql);
											
									?>
                                    	<tr>
                                        	<td><?php echo $add_date;?></td>
                                        	<td><?php echo $output_gues[0]['g_name']." ".$output_gues[0]['last_name'];?></td>
                                            <td><?php echo $row[0]['email'];?></td>
                                            <td><?php echo $row[0]['contact_no'];?></td>                                            
                                            <td><a class="ic-re" href="view_checklist_details.php?emp_id=<?php echo $emp_id;?>&gues_id=<?php echo $gues_id;?>"><i class="icon-chart"></i>View Report</a></td>
                                        </tr> 
                                        <?php } ?>   	
                                    </tbody>
                                </table>
                            </div>






                    </div>
                </div>

            </div>

<!--end-->
        </div>
        <footer class="footer text-center"> <?php include 'footer.php';?> </footer>
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
    <script src="js/validator.js"></script>
    <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
	   <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
    
    
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
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->

    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>

    $(document).ready(function() {
        var table = $('#myTable').DataTable();
		table.order( [ 0, 'desc' ], [ 2, 'asc' ] ).draw();
    });
    </script>

</body>

</html>