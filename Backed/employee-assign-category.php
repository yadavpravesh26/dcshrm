<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php'); 
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(isset($_POST['meth']) && $_POST['meth']=='Employee-Access')
{
	$id = $_POST['id'];
	$category = $_POST["category"];
	$subcategory = $_POST['subcategory'];
	$value = array('c'=>$category,'s'=>$subcategory);
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("id" => $id);
		$values = array("permission" => json_encode($value),'updated_id'=>$session['bid'],'updated_date'=>DB_DATE,'updated_ip'=>IP);
		$s = $prop->update(USERS, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if(isset($_REQUEST['id'])){
	$titleTag = 'Edit';
	$curr_val = $prop->get('id,department_id,permission,u_id,status',USERS, array('id'=>$_REQUEST['id']));
	if($curr_val['status']===2){
		header('Location: employee-details.php');
		exit;
	}
	if($curr_val['u_id']!=$session['bid'] && $session['b_type']!=0){
		header('Location: employee-details.php');
		exit;
	}
	$per_reject = json_decode($curr_val['permission'],TRUE);
	$per = $prop->getName('permission', DEPARTMENT, ' dep_status!=2 AND dept_id='.$curr_val['department_id']);
	$per = json_decode($per,TRUE);
}else{
	header('Location: employee-details.php');
		exit;
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
    <title>Employee Assign Category</title>
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
						<h4 class="page-title">Employee Assign Category</h4>
					</div>
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="dashboard.php">Dashboard</a></li>
							<li class="active">Employee Assign Category</li>
						</ol>
					</div>
					<!-- /.col-lg-12 -->
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12">
						<?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');
						?>

                           <form data-toggle="validator" method="post" action="employee-assign-category.php?method=<?php echo $foraction; ?>">
							<div class="white-box">
								<div class="row b-b">								<?php 								
								if($curr_val['u_id']!=$session['bid'] && $session['b_type']==0){
									$listComp = $prop->getAll('id,c_name',USERS, ' WHERE status!=2 AND u_type=2 ', '', 0, 0);																	?>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="form-label box-title">Company</label>
											<div class="form-group">
												<select class="form-control" name="company" required>
													<option value="">Select</option>	
													<?php foreach($listComp as $co){	
													echo '<option value="'.$co['id'].'" '.($curr_val['u_id']==$co['id']?'selected':'').'>'.$co['c_name'].'</option>';
													} ?>
												</select>
											</div>
										</div>
									</div><?php }else{ echo '<input type="hidden" name="company" value="'.$curr_val['u_id'].'">'; }	?>
								</div>
								<?php 
								$permission = array();
								if(isset($per)){
									$permission['m'] = @$per['m'];
									$permission['c'] = @$per['c'];
									$permission['s'] = @$per['s'];
									$mchecked_opt = (isset($permission['m']) && $permission['m']===1?'checked':'');
								}
								?>
								<div class="row b-b">
									<div class="col-sm-2">
										<h4 class="m-b-0 box-title m-t-10">Category</h4>
									</div>
									<div class="col-sm-9">
										<!--<div class="checkbox checkbox-success">
											<input id="checkbox-all" data-id="all" class="category-all" name="cat" value="all" type="checkbox" <?php echo $mchecked_opt; ?>>
											<label for="checkbox-all"> All </label>
										</div>-->
									</div>
								</div>
								<div class="row m-t-10">
								<?php  
								
								$nav_main = $permission['m'];
								$nav_category = $permission['c'];
								$nav_sub_category = $permission['s'];
								if(isset($nav_main) && $nav_main===1){
									$listCategory = $prop->getAll('c_id as id,c_name as name',MAIN_CATEGORY, ' WHERE status=0', '', 0, 0);
									$count = count($listCategory);
									for($i=0;$i<$count;$i++){
										$checked_opt = 'checked';
										if (in_array($listCategory[$i]['id'], explode(',',$permission['c']))){
											
											if(in_array($listCategory[$i]['id'],explode(',',$per_reject['c'])))
												$checked_opt = '';
											if($per_reject['m']==1)
												$checked_opt = '';
									?>
									<div class="col-md-4">
										<div class="main-category">
											<div class="checkbox checkbox-success">
												<input id="checkbox-<?php echo $i; ?>" data-parent="0" data-class="checkbox-all" data-id="<?php echo $listCategory[$i]['id']; ?>" class="category" name="category[]" value="<?php echo $listCategory[$i]['id']; ?>" type="checkbox" <?php echo $checked_opt; ?>>
												<label class="category-label" for="checkbox-<?php echo $i; ?>"><b><?php echo $listCategory[$i]['name']; ?></b></label>
											</div>
										</div>
										<?php  
										$listSub = $prop->getAll('c_id as id,c_name as mid, sc_name as name',SUB_CATEGORY, ' WHERE status=0 AND c_name='.$listCategory[$i]['id'], '', 0, 0);
										$subcount = count($listSub);
										for($j=0;$j<$subcount;$j++){
											$checked_opt = 'checked';
											if (in_array($listSub[$j]['id'], explode(',',$per_reject['s'])))
												$checked_opt = '';
											if($per_reject['m']==1)
												$checked_opt = '';
										?>
										<div class="sub-catergory p-l-20">
											<div class="checkbox checkbox-success">
												<input id="checkbox-<?php echo $i.$j; ?>" data-parent="<?php echo $listCategory[$i]['id']; ?>" data-class="checkbox-<?php echo $i; ?>" data-id="<?php echo $listCategory[$i]['id'].$listSub[$j]['id']; ?>" class="category category-<?php echo $listCategory[$i]['id']; ?>" name="SubCategory[<?php echo $listCategory[$i]['id']; ?>][]" value="<?php echo $listSub[$j]['id']; ?>" type="checkbox" <?php echo $checked_opt; ?>>
												<label class="category-label category-label-<?php echo $i.$j; ?>" for="checkbox-<?php echo $i.$j; ?>"><?php echo $listSub[$j]['name']; ?></label>
											</div>
										</div>
										<?php 
										} 
										?>
									</div>
									<?php   
										}
									}
									
								}else{
									if(isset($nav_category) && $nav_category!=''){
										$listCategory = $prop->getAll('c_id as id,c_name as name',MAIN_CATEGORY, ' WHERE status=0 AND c_id IN ('.$nav_category.')', '', 0, 0);
										$count = count($listCategory);
										for($i=0;$i<$count;$i++){
											$checked_opt = 'checked';
											if (in_array($listCategory[$i]['id'], explode(',',$permission['c']))){
												
												if(in_array($listCategory[$i]['id'],explode(',',$per_reject['c'])))
													$checked_opt = '';
										?>
										<div class="col-md-4">
											<div class="main-category">
												<div class="checkbox checkbox-success">
													<input id="ccheckbox-<?php echo $i; ?>" data-parent="0" data-class="checkbox-all" data-id="<?php echo $listCategory[$i]['id']; ?>" class="category" name="category[]" value="<?php echo $listCategory[$i]['id']; ?>" type="checkbox" <?php echo $checked_opt; ?>>
													<label class="category-label" for="ccheckbox-<?php echo $i; ?>"><b><?php echo $listCategory[$i]['name']; ?></b></label>
												</div>
											</div>
											<?php  
											$listSub = $prop->getAll('c_id as id,c_name as mid, sc_name as name',SUB_CATEGORY, ' WHERE status=0 AND c_name='.$listCategory[$i]['id'], '', 0, 0);
											$subcount = count($listSub);
											for($j=0;$j<$subcount;$j++){
												$checked_opt = 'checked';
												if (in_array($listSub[$j]['id'], explode(',',$per_reject['s'])))
													$checked_opt = '';
											?>
											<div class="sub-catergory p-l-20">
												<div class="checkbox checkbox-success">
													<input id="ccheckbox-<?php echo $i.$j; ?>" data-parent="<?php echo $listCategory[$i]['id']; ?>" data-class="checkbox-<?php echo $i; ?>" data-id="<?php echo $listCategory[$i]['id'].$listSub[$j]['id']; ?>" class="category category-<?php echo $listCategory[$i]['id']; ?>" name="SubCategory[<?php echo $listCategory[$i]['id']; ?>][]" value="<?php echo $listSub[$j]['id']; ?>" type="checkbox" <?php echo $checked_opt; ?>>
													<label class="category-label category-label-<?php echo $i.$j; ?>" for="ccheckbox-<?php echo $i.$j; ?>"><?php echo $listSub[$j]['name']; ?></label>
												</div>
											</div>
											<?php 
											} 
											?>
										</div>
										<?php   
											}
										}
									}	
									if(isset($nav_sub_category) && $nav_sub_category!=''){
										$nav_get_cat = $prop->getName('GROUP_CONCAT(c_name)', SUB_CATEGORY, ' 1=1 AND c_id IN ('.$nav_sub_category.')');
										$sqlm = 'SELECT c_id,c_name as name from `'.MAIN_CATEGORY.'` WHERE status=0 AND c_id IN ('.$nav_get_cat.')';
										$listCategory=$prop->getAll_Disp($sqlm);
										$count = count($listCategory);
										for($i=0;$i<$count;$i++){

										?>
										<div class="col-md-4">
											<div class="main-category">
												<div class="">
													<label class="category-label" for="scheckbox-<?php echo $i; ?>"><b><?php echo $listCategory[$i]['name']; ?></b></label>
												</div>
											</div>
											<?php  
											$sqls = "SELECT c_id as id,c_name as c_id, sc_name as name  from `".SUB_CATEGORY."` WHERE status=0 AND c_name='".$listCategory[$i]['c_id']."' AND c_id IN (".$nav_sub_category.")";
											$listSub = $prop->getAll_Disp($sqls);
											$subcount = count($listSub);
											for($j=0;$j<$subcount;$j++){
												$checked_opt = 'checked';
												if (in_array($listSub[$j]['id'], explode(',',$per_reject['s'])))
													$checked_opt = '';
											?>
											<div class="sub-catergory p-l-20">
												<div class="checkbox checkbox-success">
													<input id="scheckbox-<?php echo $i.$j; ?>" data-parent="<?php echo $listCategory[$i]['c_id']; ?>" data-class="checkbox-<?php echo $i; ?>" data-id="<?php echo $listCategory[$i]['c_id'].$listSub[$j]['id']; ?>" class="category category-<?php echo $listCategory[$i]['c_id']; ?>" name="SubCategory[<?php echo $listCategory[$i]['c_id']; ?>][]" value="<?php echo $listSub[$j]['id']; ?>" type="checkbox" <?php echo $checked_opt; ?>>
													<label class="category-label category-label-<?php echo $i.$j; ?>" for="scheckbox-<?php echo $i.$j; ?>"><?php echo $listSub[$j]['name']; ?></label>
												</div>
											</div>
											<?php 
											} 
											?>
										</div>
										<?php   
											
										}
									}
								}
									 
								?>
								</div>
								<div class="row b-b">
									<div class="col-sm-5">
										<div class="form-group">
											<button type="button" name="submit" id="saveBtn" class="btn btn-success btn-cons"><i class="icon-ok"></i> Submit</button>
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
	$(document).on('click','#saveBtn',function(){
		var category = [];
		var subcategory = [];
        $("input:checkbox:not(:checked)").each(function () {
			let name = $(this).attr('name');
			let val = $(this).val();
			let parent = $(this).attr('data-parent');
			if($(this).attr('data-class')==='checkbox-all')
				category.push(val);
			else
				subcategory.push(val);
        });
		//var subcategory = JSON.stringify(subcategory);
		console.log(category);
		console.log(subcategory);
		$.ajax({
			type: "POST",
			url: "employee-assign-category.php",
			cache:false,
			data: 'category='+category+'&subcategory='+subcategory+'&meth=Employee-Access&id=<?php echo $_REQUEST['id']; ?>',
			dataType:'json',
			success: function(response)
			{
				swal(response.status, response.msg,response.err);
				if(response.result){
					window.location.href = "employee-details.php";
					return false;
				}
			}
		});
    });
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
		/* if(!this.checked){
			let cls = $(this).attr('data-class');
			$('#'+cls).prop('checked', this.checked);
		} */
	});
    </script>

</body>

</html>
