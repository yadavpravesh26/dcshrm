<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = DEPARTMENT;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	case 'add':
		$msg = 'Enter Industry Name';
		if($_POST['form1Name']!=''){
			$msg = 'Industry Created Failed';
			$input  = array(
				'dep_name'		=>$_POST['form1Name'],
				'permission'	=>'no',
				//'u_id'			=>$_POST['company'],
				'created_id'	=>$session['bid'],
				'created_date'	=>DB_DATE,
			);
			$result = $prop->add(DEPARTMENT, $input);
			if ($result) {
				setcookie('status', 'Success', time()+10);
				setcookie('title', 'Industry Created Successfully', time()+10);
				setcookie('err', 'success', time()+10);
				header('Location: manage-industries.php');
				break;
			}
		}
	break;
	case 'update':
		$msg = 'Enter Industry Name';
		if($_POST['form1Name']!=''){
			$msg = 'Industry Updated Failed';
			$t_cond = array('dept_id'=>$_REQUEST['id']);
			$input  = array(
				'dep_name'		=>$_POST['form1Name'],
				'permission'	=>'no',										
				//'u_id'			=>$_POST['company'],
				'updated_id'	=>$session['bid'],
				'updated_date'	=>DB_DATE,
			);
			if($prop->update(DEPARTMENT, $input, $t_cond))
			{
				setcookie('status', 'Success', time()+10);
				setcookie('title', 'Industry Updated Successfully', time()+10);
				setcookie('err', 'success', time()+10);
				header('Location: manage-industries.php');
				break;
			}
		}	
	break;	
}	
if(isset($_REQUEST['id'])){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',DEPARTMENT, array('dept_id'=>$_REQUEST['id'],'dep_status'=>0));
	if($curr_val['dep_status']===2){
		header('Location: manage-industries.php');
		exit;
	}
	if($curr_val['u_id']!=$session['bid'] && $session['b_type']!=0){
		header('Location: manage-industries.php');
		exit;
	}
}			
?><!DOCTYPE html>

<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
    <title> Manage Industries</title>
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
  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
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
                        <h4 class="page-title">Manage Industries </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Manage Industries</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
                <div class="row">
                 <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Manage Industries</h3>
                            <div>
                            	 <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>
                                  <form data-toggle="validator" method="post" action="manage-industries.php?method=<?php echo $foraction; ?>"  >
                
                                    <div class="form-group col-md-6">
                                    <label class="form-label">Industry Name</label>
                                      <span class="help"></span>
                                      <div class="input-with-icon  right">
                                        <i class=""></i>
                                        <input type="text" name="form1Name" required value="<?php echo $curr_val['dep_name'];?>" id="form1Name" class="form-control">
                                      </div>
                                      <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <div class="pull-left" style="margin-top: 25px;">
                                        <button type="submit" name="add" class="btn btn-success btn-cons"><i class="icon-ok"></i> <?php if($_REQUEST['method'] == 'modify'){echo 'Update';} else{echo 'Add';}?></button>
                                      </div>
                                    </div>
                                    <div class="clearfix"></div>
                                  </form>
                            </div>
                             <div class="table-responsive dash-table">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Industry Name</th>
                                            <th width="100px" class="text-center" data-toggle="true" data-breakpoints="all">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										$where = ' ';
										$catsql = "SELECT  dept_id,`dep_name`,dep_status from ".DEPARTMENT." WHERE `dep_status`!=2 $where order by `dept_id` DESC";
										if($session['b_type']===0){
											$catsql = "SELECT * from ".DEPARTMENT." WHERE dep_status!=2 order by dept_id DESC";
										}
										$catfet=$prop->getAll_Disp($catsql);
										for($i=0; $i<count($catfet); $i++)
					                    {
									?>
                                        <tr>
                                            <td><?php echo $catfet[$i]['dep_name'];?> </td>
                                            <td width="200">
												<a data-toggle="tooltip" data-placement="top" title="Edit" href="manage-industries.php?id=<?php echo $catfet[$i]['dept_id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> 
												<a data-toggle="tooltip" data-placement="top" title="<?php echo ($catfet[$i]['dep_status']==0?'Publish':'Unpublish'); ?>" href="javascript:void(0)"><span data-id="<?php echo $catfet[$i]['dept_id'];?>" data-status="<?php echo ($catfet[$i]['dep_status']==0?1:0);?>" class="depart-status label i-lable label-<?php echo ($catfet[$i]['dep_status']==0?'success':'warning'); ?>"><i class="i-font17 ti-<?php echo ($catfet[$i]['dep_status']==0?'unlock':'lock'); ?>"></i></span></a> 
												<a class="deleteone" id="<?php echo $catfet[$i]['dept_id'];?>" href="javascript:void(0);"><span id="sa-delete" data-id="<?php echo $catfet[$i]['dept_id'];?>" data-status="<?php echo ($catfet[$i]['dep_status']==0?2:0);?>" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a>
											</td>
                                        </tr>
									<?php } ?>

                                    </tbody>
                                </table>
                            </div>




                            </div>


                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
            <?php include "footer.php" ?>
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
	  <script src="js/validator.js"></script>
    <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
	   <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
	<script>
	<?php 	if($_COOKIE[err] !='')
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
	// For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
		</script>
    <script>
	$(document).on('click', '.depart-status', function() {
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
						data: 'id='+id+'&status='+status+'&meth=industry-status',
						dataType:'json',
						success: function(response)
						{
							swal(response.status, response.msg,response.err);
							setTimeout(function() {
								$(".confirm").trigger('click');
							}, 3000);
							if(response.result){
								location.reload();
							}
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
		
		$(document).on('click', '.deleteone span', function() {
			var element = $(this);
			var id = element.attr("data-id");
			var status = element.attr("data-status");
			var ms = (status==0?'Active':'Delete');
			swal({
				title: ms,
				text: "Are you sure, you want to delete it??",
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
						data: 'id='+id+'&status='+status+'&meth=industry-status-delete',
						dataType:'json',
						success: function(response)
						{
							swal(response.status, response.msg,response.err);
							if(response.result){
								location.reload();
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
	</script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- data table -->
  <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script>

    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
</body>

</html>
