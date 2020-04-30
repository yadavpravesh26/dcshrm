<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(bckPermission($session['b_type'])){
	header('location:dashboard.php');
	exit;
}
$table_name = "cat_sub";


if(isset($_POST['assignEmp']))
{
	
	$BeSafePorgram = $_POST['BeSafePorgram'];
	$checkDepart = $_POST['checkDepart'];
	$insert_count = 0;
	$WhichType = '';
	$msg = '';
	foreach($_POST['BeSafePorgram'] as $item) {
       $item = explode('-',$item);
	   if($checkDepart)
	   {
	   	    /*Assign Departments code Start*/
		   $WhichType = 'Departments';
	   	   foreach($_POST['departmentDpn'] as $departmentDpn)
		   {
		   		$depID = $departmentDpn;
			   $input = array(
					'depart_id'	=>$depID,
					'catID'	=>$item[0],
					'subCatID'	=>$item[1],
					'programID'	=>$item[2],
					'status'	=>0
				);
			   $exits = $prop->getName('count(id)', 'assign_depart', "depart_id=".$depID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
			   
			   if($exits === 0){
					$result = $prop->add('assign_depart', $input);
					if ($result) {
						$insert_count++;
					}
			   }
			   else
			   {
					$unassignDepID = $prop->getName('id', 'assign_depart', "status=2 AND depart_id=".$depID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
					if($unassignDepID != 0)
					{
						$t_cond = array("id" => $unassignDepID);
						$result = $prop->update('assign_depart', $input, $t_cond);
						if ($result) {
							$insert_count++;
						}
						
					}
			   }
		   }
		   /*Assign Departments code end*/
	   }
	   else
	   {
		   /*Assign Employee code Start*/
		   $WhichType = 'Employees';
		   foreach($_POST['employeeDpn'] as $employeeDpn)
		   {
			   $empID = $employeeDpn;
			   $input = array(
					'emp_id'	=>$empID,
					'catID'	=>$item[0],
					'subCatID'	=>$item[1],
					'programID'	=>$item[2],
					'status'	=>0
				);
			   $exits = $prop->getName('count(id)', 'assign_emp', "emp_id=".$empID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
			   
			   if($exits === 0){
					$result = $prop->add('assign_emp', $input);
					if ($result) {
						$insert_count++;
					}
			   }
			   else
			   {
					$unassignEmpID = $prop->getName('id', 'assign_emp', "status=2 AND emp_id=".$empID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
					if($unassignEmpID != 0)
					{
						$t_cond = array("id" => $unassignEmpID);
						$result = $prop->update('assign_emp', $input, $t_cond);
						if ($result) {
							$insert_count++;
						}
						
					}
			   }
		   }
		   /*Assign Employee code END*/
		}	   
	   
    }
	
	if($insert_count != 0)
	{
		$status = 'Success';
		$title = $WhichType.' Assigned Successfully';
		$err = 'success';
	}
	else
	{
		$status = 'Error';
		$title = $WhichType.' already Assigned';
		$err = 'error';
	}
}

/*Unassign Employee code Start*/
if(isset($_POST['unassignEmp']))
{
	$BeSafePorgram = $_POST['BeSafePorgram'];
	$checkDepart = $_POST['checkDepart'];
	$insert_count = 0;
	$WhichType = '';
	$msg = '';
	foreach($_POST['BeSafePorgram'] as $item) {
       $item = explode('-',$item);
	   if($checkDepart)
	   {
	   	    /*Unassign Departments code Start*/
		   $WhichType = 'Departments';
	   	   foreach($_POST['departmentDpn'] as $departmentDpn)
		   {
		   		$depID = $departmentDpn;
			   $input = array(
					'depart_id'	=>$depID,
					'catID'	=>$item[0],
					'subCatID'	=>$item[1],
					'programID'	=>$item[2],
					'status'	=>2
				);
			   $exits = $prop->getName('count(id)', 'assign_depart', "depart_id=".$depID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
			   
			   if($exits === 0){
					$result = $prop->add('assign_depart', $input);
					if ($result) {
						$insert_count++;
					}
			   }
			   else
			   {
					$assignDepID = $prop->getName('id', 'assign_depart', "status=0 AND depart_id=".$depID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
					if($assignDepID != 0)
					{
						$t_cond = array("id" => $assignDepID);
						$result = $prop->update('assign_depart', $input, $t_cond);
						if ($result) {
							$insert_count++;
						}
						
					}
			   }
		   }
		   /*Unassign Departments code end*/
	   }
	   else
	   {
		   /*Unassign Employee code Start*/
		   $WhichType = 'Employees';
		   foreach($_POST['employeeDpn'] as $employeeDpn)
		   {
			   $empID = $employeeDpn;
			   $input = array(
					'emp_id'	=>$empID,
					'catID'	=>$item[0],
					'subCatID'	=>$item[1],
					'programID'	=>$item[2],
					'status'	=>2
				);
			   $exits = $prop->getName('count(id)', 'assign_emp', "emp_id=".$empID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
			   
			   if($exits === 0){
					$result = $prop->add('assign_emp', $input);
					if ($result) {
						$insert_count++;
					}
			   }
			   else
			   {
					$assignEmpID = $prop->getName('id', 'assign_emp', "status=0 AND emp_id=".$empID." AND catID=".$item[0]." AND subCatID=".$item[1]." AND programID=".$item[2]);
					if($assignEmpID != 0)
					{
						$t_cond = array("id" => $assignEmpID);
						$result = $prop->update('assign_emp', $input, $t_cond);
						if ($result) {
							$insert_count++;
						}
						
					}
			   }
		   }
		   /*Unassign Employee code END*/
		}	   
	   
    }
	
	if($insert_count != 0)
	{
		$status = 'Success';
		$title = $WhichType.' Unssigned Successfully';
		$err = 'success';
	}
	else
	{
		$status = 'Error';
		$title = $WhichType.' already Unssigned';
		$err = 'error';
	}
}
/*Unassign Employee code END*/

$permission = $prop->get('permission',USERS, array("id"=>$session['bid']));
$nav_cat = json_decode($permission['permission'], TRUE);
$nav_category = $nav_cat['c'];
$nav_sub_category = $nav_cat['s'];
$nav_pages = $nav_cat['p'];
$cat_count = count($nav_cat['c']);

$where_dep = ' where dep_status != 2 and company_id='.$session['bid'];
$listDepart = $prop->getAll('*',DEPARTMENT_NEW, $where_dep, '', 0, 0);

$where_emp = ' where status != 2 and u_type = 4 and u_id='.$session['bid'];
$listEmps = $prop->getAll('*',USERS, $where_emp, '', 0, 0);

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
    <title>Manage Assign</title>
     <!-- Bootstrap Core CSS -->
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	<!-- Footable CSS -->
	<link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
	<link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css"/>
	<link href="plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet"/>
	<link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet"/>
	
    
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />-->
	
    <!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<!-- Animation CSS -->
	<link href="css/animate.css" rel="stylesheet">
	<!-- Custom CSS -->
    <link rel="stylesheet" href="css/style-accordian.css">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/custom-style.css" rel="stylesheet">
	<!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	<!-- color CSS you can use different color css from css/colors folder -->
	<!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
	<link href="css/colors/default-dark.css" id="theme" rel="stylesheet">
    <link href="css/jquery.bonsai.css" rel="stylesheet" type="text/css">
    
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
.span1{width:60%;}
.span1 a{color: #003963;
    font-weight: 500;}
.span2{width:20%; text-align:center}
.cd-accordion__label{background:#fff !important; color: #003963;}
.cd-accordion__label:hover{background:#8bbde61a !important}
li a{color:#414141;}
.cd-accordion{    margin-top: 10px;
    margin-bottom: 0px !important;
    border: 1px dotted #eaeff3;
    border-radius: 4px;
    box-shadow: none;
    overflow: hidden;}
    .span2 a {
        border-radius: 100px;
    width: 25px;
    color: #0d558a;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 500;
}
.cd-accordion__item:last-child .cd-accordion__label{padding-left:0px;}
.main_cate_checkbox, .sub_cate_checkbox,.porgram_checkbox{margin-left:10px;margin-top:13px; margin-bottom:0px; float:left}
.sub_cate_checkbox{padding-left:20px;}
.sub_cate_checkbox{padding-left:30px;}
.porgram_checkbox{padding-left:50px;}
input.form-control, .select2{border-radius:5px;}
button.btn.btn-success,.modal-footer button.btn{color:#FFFFFF;}
.multiselect-container.dropdown-menu .checkbox input[type=checkbox]{opacity:1}
.multiselect.dropdown-toggle.btn.btn-default{background: none;box-shadow: none;width: 100%;height: 35px !important;font-weight: 300;}
.multiselect-native-select .btn-group,.open > .dropdown-menu{width:100%}
.select2{width:100% !important;}
.addDepartment,.addEmp{display:none !important;}
.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus{background-color: transparent;
    color: #333;}
</style>
	<link href="plugins/bower_components/multiSelectCheckbox/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
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
                        <h4 class="page-title">Manage Assign </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Manage Assign</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">List of Be safe Pages</h3>
                            <form method="post" enctype="multipart/form-data" id="formBeSafe">
                            	<input type="hidden" name="checkDepart" id="checkDepart" >
                                <input type="hidden" name="empID" id="empID" >
                                <div class="row" style="margin-bottom:20px;">
                                    <div class="col-md-3">
                                    <select class="form-control select2" id="companyDpn" name="companyDpn" required>
                                        <option value="">Select Company</option>
                                        <?php
										if(isset($_POST['assignEmp']) or isset($_POST['unassignEmp']))
										$compID = $_POST['companyDpn'];
										else
										$compID = '';
										
										$sqlcomp = "SELECT  * from ".USERS." WHERE `u_type`= 2 and status != 2";
										$rowComp=$prop->getAll_Disp($sqlcomp);
										for($i=0; $i<count($rowComp); $i++){
											if($compID == $rowComp[$i]['id'])
											$sel='selected';
											else
											$sel='';
											echo '<option value="'.$rowComp[$i]['id'].'" '.$sel.'>'.$rowComp[$i]['c_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    </div>    
                                    <div class="col-md-3">
                                    <select class="form-control select2" id="departmentDpn" name="departmentDpn[]" required>
                                        <option value="">Select Departments</option>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                    	<select class="form-control select2" id="employeeDpn" name="employeeDpn[]" required>
                                            <option value="">Select Employees</option>
                                        </select>
                                          
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" id="unassignDepart" name="unassignEmp" class="btn btn-success waves-effect waves-light pull-right m-r-10"> Unassign</button>&nbsp;&nbsp;&nbsp;<button type="submit" id="assignDepart" name="assignEmp" class="btn btn-success waves-effect waves-light pull-right m-r-10"> Assign</button>
                                  </div>
                                    <div class="clearfix"></div>
                                    </div>                                
                                <div class="row" style="BACKGROUND: #00568a !important;font-weight:bold;color: white;padding: 15px;">
                                    <div class="col-md-8">Category Name</div>
                                    <div class="col-md-2">Departments Assigned</div>
                                    <div class="col-md-2">Employees Assigned</div>
                                </div>
                                <div id="filter_data_val">
                                  <p style="border: 1px solid #ccc;padding: 10px;text-align: center;">No record found</p>
                                </div>   
                            </form>
                        </div>
                    </div>
                </div>

            </div>
			
            <!-- /.container-fluid -->
			
            <?php include "footer.php" ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
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

        <script src="js/jasny-bootstrap.js"></script>

        <!--Style Switcher -->

        <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

        <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

		<!-- Sweet-Alert  -->

		<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>

        <!-- Custom Theme JavaScript -->

        <script src="js/custom.min.js"></script>

        <script src="js/validator.js"></script>

        <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>

        <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

        <script src="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

        <script src="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

        
        <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
        <!--Acordian 3 level init-->
		<script src="js/main.js"></script>
        <script src="js/util.js"></script>
        
        <script type="text/javascript" src="plugins/bower_components/multiSelectCheckbox/bootstrap-multiselect.js"></script>
    <script>
    $(function() {
    <?php 
		if(isset($insert_count))
		{
			echo 'swal("'.$status.'", "'.$title.'", "'.$err.'");';
				?>
				setTimeout(function() {
					$(".confirm").trigger('click');
				  }, 3000);
				<?php
		}
	?>
	
    });
	jQuery(document).ready(function() {
		
		$('#assignDepart').attr("disabled", true);
		$('#unassignDepart').attr("disabled", true);
		$("#companyDpn").select2();
		$("#departmentDpn").select2();
		$("#employeeDpn").select2();
		<?php
		if(isset($_POST['assignEmp']) or isset($_POST['unassignEmp']))
		{
			$compID = $_POST['companyDpn'];
			?>
			call_filter_data('','','',<?php echo $compID;?>);
			<?php
		}
		?>
		
		$('#companyDpn').change(function(e){
			var companyID = $(this).children("option:selected").val();
			$('#departmentDpn').removeAttr('multiple');
			$("#departmentDpn").multiselect('destroy');
			$('#departmentDpn').html('<option value="">No Department found</option>');
			$("#departmentDpn").select2();
			
			$('#employeeDpn').removeAttr('multiple');
			$("#employeeDpn").multiselect('destroy');
			$('#employeeDpn').html('<option value="">No Employees found</option>');
			$("#employeeDpn").select2();
			
			call_filter_data('','','',companyID);
		});
		$('#departmentDpn').change(function(e){
			if($('#departmentDpn').val() != null)
			{
				var depIds = $('#departmentDpn').val();
				if($('#departmentDpn option').length === depIds.length )
				{
					$('#departmentDpn').next().addClass('SelDep');
					$('.SelDep ul .multiselect-all.active a label').html('<input type="checkbox" value="depMultiselect-all" checked> Deselect All');
				}
				else
				{
					$('.SelDep ul .multiselect-all a label').html('<input type="checkbox" value="depMultiselect-all"> Select All');	
					$('#departmentDpn').next().removeClass('SelDep');	
				}
				getEmpList(depIds);
				
			}
			else
			{
				$('#employeeDpn').removeAttr('multiple');
				$("#employeeDpn").multiselect('destroy');
				$('#employeeDpn').html('<option value="">No Employees found</option>');
				$("#employeeDpn").select2();
				$('.SelDep ul .multiselect-all a label').html('<input type="checkbox" value="depMultiselect-all"> Select All');	
				$('#departmentDpn').next().removeClass('SelDep');
			}
		});
		$('#employeeDpn').change(function(e){
			var empIds = $('#employeeDpn').val();
			$('#checkDepart').val(0);
			if(empIds != null)
				{
				if($('#employeeDpn option').length === empIds.length )
				{
					$('#checkDepart').val(1);
					$('#employeeDpn').next().addClass('SelEMP');
					$('.SelEMP ul .multiselect-all.active a label').html('<input type="checkbox" value="empMultiselect-all" checked> Deselect All');
					
				}
				else
				{
					$('.SelEMP ul .multiselect-all a label').html('<input type="checkbox" value="empMultiselect-all"> Select All');	
					$('#employeeDpn').next().removeClass('SelEMP');	
				}
			}
			else
			{
					$('.SelEMP ul .multiselect-all a label').html('<input type="checkbox" value="empMultiselect-all"> Select All');	
					$('#employeeDpn').next().removeClass('SelEMP');
			}	
		});
		
	});
	
	function call_filter_data(keyword,departID,empID,company_id)
	{
		$.ajax({
			url: "be_safe_list.php",
			type: 'POST',
			data: 'company_id='+ company_id,
			dataType:'html',
			success: function (datahtml) {
				$('#filter_data_val').html(datahtml);
				$.ajax({
					url: "getDepartList.php",
					type: 'POST',
					data: 'company_id='+ company_id,
					dataType:'html',
					success: function (dataDepart) {
						$("#departmentDpn").select2('destroy');
						$('#departmentDpn').attr('multiple','multiple');
						$('#departmentDpn').html(dataDepart);
						$('#departmentDpn').multiselect({
						  	numberDisplayed: 1,
							includeSelectAllOption: true,
							selectAllValue: 'depMultiselect-all',
						});			
					}
				})				
			}
		})
	}
	
	function getEmpList(depIds)
	{
		$.ajax({
			url: "getEmpList.php",
			type: 'POST',
			data: 'depIds='+ depIds,
			dataType:'html',
			success: function (dataEmps) {
				if(dataEmps != '')
				{
					if($('#employeeDpn option').text() == 'Select Employees' || $('#employeeDpn option').text() == 'No Employees found')
					$("#employeeDpn").select2('destroy');
					
					$('#employeeDpn').removeAttr('multiple');
					$("#employeeDpn").multiselect('destroy');
					
					$('#employeeDpn').attr('multiple','multiple');
					$('#employeeDpn').html(dataEmps);
					$('#employeeDpn').multiselect({
						numberDisplayed: 1,
						includeSelectAllOption: true,
						selectAllValue: 'empMultiselect-all',
					});	
				}
				else
				{
					$('#employeeDpn').removeAttr('multiple');
					$("#employeeDpn").multiselect('destroy');
					$('#employeeDpn').html('<option value="">No Employees found</option>');
					$("#employeeDpn").select2();
				}			
			}
		})	
	}
	</script>
</body>

</html>
