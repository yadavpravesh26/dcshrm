<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
/* if(isset($_POST['submit'])){
	if($_POST['department']!=''){
		$category = array();
		if(isset($_POST['cat'])){
			$category['m'] = 1;
		}else{
			if(isset($_POST['category'])){
				$cat = implode(' ', $_POST['category']);
				$category['c'] = $cat;
			}
			if(isset($_POST['SubCategory'])){
				$sub = array();
				foreach($_POST['SubCategory'] as $key => $value){
					if (!in_array($key, $_POST['category'])){
						foreach($value as $key2 => $value2){
							$sub[] = $value2;
						}
					}
				}
				$sub = implode(' ', $sub);
				$category['c'] = $sub;
			}
		}
	}
	
exit;
} */
switch($method)
{
	case 'add':
		$msg = 'Enter Department Name';
		if($_POST['form1Name']!=''){
			$msg = 'Department already exits';
			$exits = $prop->getName('count(dept_id)', DEPARTMENT, " u_id=".$session['bid']." AND dep_status=0 AND dep_name='".$_POST['form1Name']."'");
			if($exits===0){
				$msg = 'Department Created Failed';
				$category = array();
				if(isset($_POST['cat'])){
					$category['m'] = 1;
				}else{
					if(isset($_POST['category'])){
						$cat = implode(',', $_POST['category']);
						$category['c'] = $cat;
					}
					if(isset($_POST['SubCategory'])){
						$sub = array();
						foreach($_POST['SubCategory'] as $key => $value){
							if (!in_array($key, $_POST['category'])){
								foreach($value as $key2 => $value2){
									$sub[] = $value2;
								}
							}
						}
						$sub = implode(',', $sub);
						$category['s'] = $sub;
					}
				}
				$input  = array(
					'dep_name'		=>$_POST['form1Name'],
					'permission'	=>json_encode($category),
					'u_id'			=>$session['bid'],
					'created_id'	=>$session['bid'],
					'created_date'	=>DB_DATE,
				);
				$result = $prop->add(DEPARTMENT, $input);
				if ($result) {
					setcookie('status', 'Success', time()+10);
					setcookie('title', 'Department Created Successfully', time()+10);
					setcookie('err', 'success', time()+10);
					header('Location: manage-departments.php');
					break;
				}
			}
		}
		$change_url = (isset($_REQUEST['id'])?'category.php?id='.$_REQUEST['id']:'category.php');
		setcookie('status', 'Error', time()+10);
		setcookie('title', $msg, time()+10);
		setcookie('err', 'error', time()+10);
		header('Location:'.$change_url);
	break;
	case 'update':
		$msg = 'Enter Department Name';
		if($_POST['form1Name']!=''){
			$msg = 'Department already exits';
			$exits = $prop->getName('count(dept_id)', DEPARTMENT, " u_id=".$session['bid']." AND dep_status=0 AND dep_name='".$_POST['form1Name']."' AND dept_id!=".$_REQUEST['id']);
			if($exits===0){
				$msg = 'Department Updated Failed';
				$category = array();
				if(isset($_POST['cat'])){
					$category['m'] = 1;
				}else{
					if(isset($_POST['category'])){
						$cat = implode(',', $_POST['category']);
						$category['c'] = $cat;
					}
					if(isset($_POST['SubCategory'])){
						$sub = array();
						foreach($_POST['SubCategory'] as $key => $value){
							if (!in_array($key, $_POST['category'])){
								foreach($value as $key2 => $value2){
									$sub[] = $value2;
								}
							}
						}
						$sub = implode(',', $sub);
						$category['s'] = $sub;
					}
				}
				$t_cond = array('dept_id'=>$_REQUEST['id']);
				$input  = array(
					'dep_name'		=>$_POST['form1Name'],
					'permission'	=>json_encode($category),
					'updated_id'	=>$session['bid'],
					'updated_date'	=>DB_DATE,
				);
				if($prop->update(DEPARTMENT, $input, $t_cond))
				{
					setcookie('status', 'Success', time()+10);
					setcookie('title', 'Department Updated Successfully', time()+10);
					setcookie('err', 'success', time()+10);
					header('Location: manage-departments.php');
					break;
				}
			}
		}
		$change_url = (isset($_REQUEST['id'])?'category.php?id='.$_REQUEST['id']:'category.php');
		setcookie('status', 'Error', time()+10);
		setcookie('title', $msg, time()+10);
		setcookie('err', 'error', time()+10);
		header('Location:'.$change_url);
	break;
}
if(isset($_REQUEST['id'])){
	$titleTag = 'Edit';
	$curr_val = $prop->get('*',DEPARTMENT, array('dept_id'=>$_REQUEST['id'],'dep_status'=>0));
	if($curr_val['dep_status']===2){
		header('Location: manage-departments.php');
		exit;
	}
	if($curr_val['u_id']!=$session['bid'] && $session['b_type']!=0){
		header('Location: manage-departments.php');
		exit;
	}
}
$listCategory = $prop->getAll('c_id as id,c_name as name',MAIN_CATEGORY, ' WHERE status=0', '', 0, 0);
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
						<h4 class="page-title">Department</h4>
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

                           <form data-toggle="validator" method="post" action="category.php?method=<?php echo $foraction; ?>">
							<div class="white-box">
								<div class="row b-b">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="form-label box-title">Department Name</label>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<input type="text" name="form1Name" required value="<?php echo $curr_val['dep_name'];?>" id="form1Name" class="form-control">
										</div>
									</div>
								</div>
								<?php 
								$permission = array();
								if(isset($curr_val['permission']) && $curr_val['permission']!=''){
									$per = json_decode($curr_val['permission'], TRUE);
									$permission['m'] = @$per['m'];
									$permission['c'] = explode(",",@$per['c']);
									$permission['s'] = explode(",",@$per['s']);
									$mchecked_opt = (isset($permission['m']) && $permission['m']===1?'checked':'');
								}
								?>
								<div class="row b-b">
									<div class="col-sm-2">
										<h4 class="m-b-0 box-title m-t-10">Category</h4>
									</div>
									<div class="col-sm-9">
										<div class="checkbox checkbox-success">
											<input id="checkbox-all" data-id="all" class="category-all" name="cat" value="all" type="checkbox" <?php echo $mchecked_opt; ?>>
											<label for="checkbox-all"> All </label>
										</div>
									</div>
								</div>
								<div class="row m-t-10">
								<?php  
									$count = count($listCategory);
									for($i=0;$i<$count;$i++){
										$checked_opt = '';
										if (in_array($listCategory[$i]['id'], $permission['c']))
											$checked_opt = 'checked';
								?>
									<div class="col-md-4">
										<div class="main-category">
											<div class="checkbox checkbox-success">
												<input id="checkbox-<?php echo $i; ?>" data-class="checkbox-all" data-id="<?php echo $i; ?>" class="category" name="category[]" value="<?php echo $listCategory[$i]['id']; ?>" type="checkbox" <?php echo $mchecked_opt.' '.$checked_opt; ?>>
												<label class="category-label" for="checkbox-<?php echo $i; ?>"><b><?php echo $listCategory[$i]['name']; ?></b></label>
											</div>
										</div>
										<?php  
										$listSub = $prop->getAll('c_id as id,c_name as mid, sc_name as name',SUB_CATEGORY, ' WHERE status=0 AND c_name='.$listCategory[$i]['id'], '', 0, 0);
										$subcount = count($listSub);
										for($j=0;$j<$subcount;$j++){
											$schecked_opt = '';
											if (in_array($listSub[$j]['id'], $permission['s']))
											$schecked_opt = 'checked';
										?>
										<div class="sub-catergory p-l-20">
											<div class="checkbox checkbox-success">
												<input id="checkbox-<?php echo $i.$j; ?>" data-class="checkbox-<?php echo $i; ?>" data-id="<?php echo $i.$j; ?>" class="category category-<?php echo $i; ?>" name="SubCategory[<?php echo $listCategory[$i]['id']; ?>][]" value="<?php echo $listSub[$j]['id']; ?>" type="checkbox" <?php echo $mchecked_opt.' '.$schecked_opt.' '.$checked_opt; ?>>
												<label class="category-label category-label-<?php echo $i.$j; ?>" for="checkbox-<?php echo $i.$j; ?>"><?php echo $listSub[$j]['name']; ?></label>
											</div>
										</div>
										<?php 
										} 
										?>
									</div>
								<?php   
									} 
								?>
								</div>
								<div class="row b-b">
									<div class="col-sm-5">
										<div class="form-group">
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
