<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(bckPermissionCompany($session['b_type']) || !isset($_REQUEST['emp_id']) || !isset($_REQUEST['gues_id']) ){
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
.star_width{width: 20px !important;
    height: 20px !important;
    font-size: 18px !important;}
.star_width:before {
    content: "\e60a";
    position: absolute !important;
    margin-top: -10px !important;
    margin-left: -8px !important;
}
.bodystate h3 {
    font-weight: 400;
    color: #55606c;
}

table.display.nowrap.dataTable.no-footer i {
    background: none;
    color: #0d558a;
    background: transparent;
    width: auto;
    height: auto;
    box-shadow: none;
    padding: 0;
    border-radius: 0;
    vertical-align: middle;
    margin-top: 18px;
}
td.text-left {
    text-transform: capitalize;
    color: #3e3e3e;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    padding-left: 20px !important;
}
table.display.nowrap.dataTable.no-footer th i {
    margin-top: 0;
    font-size: 14px;
    margin-right: 1px;
    color: #fff;
}
td.sorting_1.text-left {
    white-space: initial !important;
}
.qa {
    box-shadow: 1px 3px 7px #cccccc59;
    border-radius: 4px 4px 4px;
}
.qa .qq {
    background: #f2f7fb;
    padding: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
    margin-bottom:0;
}
p.aa i.ti-star.danger {
    font-size: 24px;
    margin-right: 5px;
    color: #163f5d;
}
p.qq i {
    margin-right: 5px;
    font-size: 16px;
}
p.aa {
    padding: 10px 30px;
    font-weight: 400;
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
                        <h4 class="page-title">View Checklist Details </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active">View Checklist Details</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            <div class="row">
				<div class="col-md-12 col-sm-12">
				  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-user bg-success bg3"></i>
					  <div class="bodystate">
						<h3>Employee Details</h3>
                        <?php
                        	$emp_id = $_REQUEST['emp_id'];
							$gues_id = $_REQUEST['gues_id'];
							$sql = "SELECT e.id,e.name,e.email,e.contact_no,d.dep_name FROM ".USERS." e INNER JOIN ".DEPARTMENT_NEW." d ON d.dept_id = e.department_id WHERE e.status!=2 AND e.u_type=4 AND e.id=".$emp_id;
							
							
							$row=$prop->getAll_Disp($sql);
							?>
						<table class="display nowrap dataTable no-footer" cellspacing="0" width="100%" style="width: 100%; margin-top:30px;">
						    <thead>
						        <tr>
						            <th>Name</th>
						            <th>Email</th>
						            <th>Phone</th>
						            <th>Department</th>
						            
						        </tr>
						    </thead>
                            <tbody>
                                <tr role="row" class="odd" style=" font-weight: 500; color: #333; text-align:left;">
                                    <td class="sorting_1"><?php echo ucfirst($row[0]['name']);?></td>
                                    <td><?php echo $row[0]['email'];?></td>
                                    <td><?php echo $row[0]['contact_no'];?></td>
                                    <td><?php echo $row[0]['dep_name'];?></td>
                                </tr>
                            </tbody>
                        </table>
					  </div>
					</div>  
				  </div>
                  <div class="white-box rd-10">
					<div class="r-icon-stats">
					  <i class="ti-thought danger bg1"></i>
					  <div class="bodystate">
						<h3>Checklist Details</h3>
                        </div>
					  
					</div>
                    <?php 
					$gues_id = $_REQUEST['gues_id'];
							$apiLink = 'https://pr.survey360pro.com/admin/api/dcshrm-api.php';
							$url = "$apiLink?gues_id=".$gues_id."&method=questions_ans_details";
							$result = processURL($url);
							$all_questions_ans = json_decode($result, true);
							$total_questions_ans = count($all_questions_ans["output"]);
							$output_questions_ans = $all_questions_ans["output"];
							
					for($i= 0; $i<$total_questions_ans; $i++)
					{
						$ans = $output_questions_ans[$i]['ans'];
						if($ans != '')
						{
						?>  
					  <div class="qa">
					      <p class="qq"><i class=" icon-question"></i> <?php echo $output_questions_ans[$i]['ques'];?></p>
					      <p class="aa"> 
                          <?php 
						   
							if(strpos($ans, '_') !== false){
								$count_star = str_replace("_","",$ans);
								for($j = 1; $j<=5;$j++)
								{
									if($j <= intval($count_star))
									echo '<i class="ti-star danger" style="color: #FFC371;"></i>';
									else
									echo '<i class="ti-star danger "></i>';
								} 
							}
							else
							echo $ans;
							?>
                          </p>
                      </div>    
					<?php
					}
                    }
					?>      
					  
					  
					  
				  </div>
				</div>
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
