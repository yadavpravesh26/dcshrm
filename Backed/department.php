<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';

switch($method)
{
	case 'add':
		$msg = 'Enter Department Name';
		if($_POST['form1Name']!=''){
			$msg = 'Department already exits';
			$exits = $prop->getName('count(dept_id)', DEPARTMENT_NEW, " dep_name='".$_POST['form1Name']."' and company_id = '".$session['bid']."'");
			if($exits===0){
				$msg = 'Department Created Failed';
				
				$input  = array(
					'dep_name'		=>$_POST['form1Name'],
					'company_id'		=>$session['bid'],
					'created_id'	=>$session['bid'],
					'created_date'	=>DB_DATE,
				);
				$result = $prop->add(DEPARTMENT_NEW, $input);
				if ($result) {
					setcookie('status', 'Success', time()+10);
					setcookie('title', 'Department Created Successfully', time()+10);
					setcookie('err', 'success', time()+10);
					header('Location: manage-departments.php');
					break;
				}
			}
		}
		$change_url = (isset($_REQUEST['id'])?'department.php?id='.$_REQUEST['id']:'department.php');
		setcookie('status', 'Error', time()+10);
		setcookie('title', $msg, time()+10);
		setcookie('err', 'error', time()+10);
		header('Location:'.$change_url);
	break;
	case 'update':
		$msg = 'Enter Department Name';
		if($_POST['form1Name']!=''){
			$msg = 'Industry already exits';
			$exits = $prop->getName('count(dept_id)', DEPARTMENT, " dep_name='".$_POST['form1Name']."' AND dep_status != 2");
			if($exits===0){
				$msg = 'Department Updated Failed';
				$t_cond = array('dept_id'=>$_REQUEST['id']);
				$input  = array(
					'dep_name'		=>$_POST['form1Name'],
					'company_id'		=>$session['bid'],
					'updated_id'	=>$session['bid'],
					'updated_date'	=>DB_DATE,
				);
				if($prop->update(DEPARTMENT_NEW, $input, $t_cond))
				{
					//$get_all_emp = 'select id from '.USERS.' where department_id='.$_REQUEST['id'];
					//$all_emp_val = $prop->get_Disp($get_all_emp);
					/*$DP_cond = array('depart_id'=>$_REQUEST['id']);
					$update_AssignDep  = array(
					'depart_id'		=>$_POST['form1Name'],
					);
					$prop->update('assign_depart', $update_AssignDep, $DP_cond);
					*/
					setcookie('status', 'Success', time()+10);
					setcookie('title', 'Department Updated Successfully', time()+10);
					setcookie('err', 'success', time()+10);
					header('Location: manage-departments.php');
					break;
				}
			}
		}
		$change_url = (isset($_REQUEST['id'])?'department.php?id='.$_REQUEST['id']:'department.php');
		setcookie('status', 'Error', time()+10);
		setcookie('title', $msg, time()+10);
		setcookie('err', 'error', time()+10);
		header('Location:'.$change_url);
	break;
}
if(isset($_REQUEST['id'])){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',DEPARTMENT_NEW, array('dept_id'=>$_REQUEST['id'],'dep_status'=>0));
}
$listCategory = $prop->getAll('c_id as id,c_name as name',MAIN_CATEGORY, ' WHERE status=0', '', 0, 0);
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
    <title>Department</title>
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
						<h4 class="page-title">Add New Department</h4>
					</div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a></li>
							<li class="active">Department</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12">
						<?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');
						?>

                           <form data-toggle="validator" method="post" action="department.php?method=<?php echo $foraction; ?>">
							<div class="white-box" style=" border-radius: 10px; ">
								<div class="row">								
									<div class="col-sm-6">										<label class="form-label box-title">Department Name</label>
										<div class="form-group">
											<input type="text" name="form1Name" required value="<?php echo $curr_val['dep_name'];?>" id="form1Name" class="form-control">
                                            <input type="hidden" name="company_id" value="<?php echo $session['bid'];?>" id="company_id">
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
										    <label class="form-label box-title" style="display:block;">&nbsp;</label>
											<button type="submit" name="submit" class="btn btn-success btn-cons"><i class="icon-ok"></i> Submit</button>
										</div>
									</div>
								</div>
								
								
							</div>
						</form>
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

	$(document).on('click','.category,.category-all',function(){

		let id = $(this).attr('data-id');
		if(id==='all'){
			$('.category').not(this).prop('checked', this.checked);
		}else{
			$('.category-'+id).not(this).prop('checked', this.checked);
		}
		if(!this.checked){
			let cls = $(this).attr('data-class');
			console.log(cls);
			$('#'+cls).prop('checked', this.checked);
		}
	});
    </script>

</body>

</html>
