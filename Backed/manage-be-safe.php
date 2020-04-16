<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = "cat_sub";
$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
if($session['b_type'] != 2 && !isset($session['bid']) && $session['bid']=='')
{
	header('location:dashboard.php');
	exit;
}
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
    <title>Manage Be Safe Category</title>
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
	<link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
    
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
                        <h4 class="page-title">Manage Be safe List </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li class="active">Manage Be safe List </li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">List of Be safe Pages</h3>
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-md-3">
                                <input type="text" name="" placeholder="Search Keyword" class="form-control">
                                </div>    
                                <div class="col-md-3">
                                <select class="form-control select2" id="select_dep" >
                                    <option>Filter by Department</option>
                                    <?php
									$count = count($listDepart);
									for($i=0; $i<$count; $i++){ 
										echo '<option value="'.$listDepart[$i]['dept_id'].'">'.$listDepart[$i]['dep_name'].'</option>';
									}
									?>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <select class="form-control select2" id="select_emp" >
                                    <option>Filter by Employee</option>
                                    <?php
									$count = count($listEmps);
									for($i=0; $i<$count; $i++){ 
										echo '<option value="'.$listEmps[$i]['id'].'">'.$listEmps[$i]['name'].'</option>';
									}
									?>
                                </select>
                                </div>
                                <div class="col-md-3">
                                	<button type="button" class="btn btn-success waves-effect waves-light pull-right m-r-10">
                                	 <i class="ti-plus"></i> Assign to Department
                                	</button>
                              </div>
                                <div class="clearfix"></div>
                                </div>
                                
							<div class="row" style="BACKGROUND: #00568a !important;font-weight:bold;color: white;padding: 15px;">
                            	<div class="col-md-8">Category Name</div>
                                <div class="col-md-2">Departments Assigned</div>
                                <div class="col-md-2">Employees Assigned</div>
                            </div>
                            <div id="filter_data_val">
                              
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
     <!-- myModalDepartment content -->
      <div id="myModalDepartment" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Assign Department</h4> </div>

                    	<form method="post" id="ajaxHandForm">
                            <div class="modal-body">
                                <input type="hidden" name="meth" id="meth" value="ajaxsaveHand">
                                <label for="document_name">Choose Department</label>
                                <div class="form-group">
                                	<select name="popup_depart" id="popup_depart" class="form-control select2" style="width:100%">
                                    	<option value="">Select Department</option>
                                        <?php
										$count = count($listDepart);
										for($i=0; $i<$count; $i++){ 
											echo '<option value="'.$listDepart[$i]['dept_id'].'">'.$listDepart[$i]['dep_name'].'</option>';
										}
										?>
                                    </select>
                                </div>
                               
                            </div>
    
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Assign</button>
                            </div>
						</form>
                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>
     <!-- /.modal -->
     <!-- myModalEMP content -->
      <div id="myModalEMP" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Assign Employee</h4> </div>

                    	<form method="post" id="ajaxHandForm">
                            <div class="modal-body">
                                <input type="hidden" name="meth" id="meth" value="ajaxsaveHand">
                                <label for="document_name">Choose Employee</label>
                                <div class="form-group">
                                	<select name="popup_emp" id="popup_emp" class="form-control select2" style="width:100%">
                                    	<option value="">Select Employee</option>
                                        <?php
                                        $count = count($listEmps);
                                        for($i=0; $i<$count; $i++){ 
                                            echo '<option value="'.$listEmps[$i]['id'].'">'.$listEmps[$i]['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                               
                            </div>
    
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Assign</button>
                            </div>
						</form>
                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>
     <!-- /.modal -->
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

        <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
        <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
        <!--Acordian 3 level init-->
		<script src="js/main.js"></script>
        <script src="js/util.js"></script>
    <script>
    $(function() {
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
	
    });
	jQuery(document).ready(function() {
		call_filter_data();
		setTimeout(function() { 
			$('.checkbox input[type="checkbox"]').click(function(e){
				var classname = $(this).attr('class');
				var prev_classname = $(this).parent().attr('id');
				console.log(classname+prev_classname);
				if($(this).prop("checked") == true)
				{
					$( "ul." + prev_classname + " li .checkbox input[type='checkbox']").each(function( index ) {
					  $( this ).prop('checked', true);
					});
				}
				else
				{
					$( "ul." + prev_classname + " .checkbox input[type='checkbox']").each(function( index ) {
					  $( this ).prop('checked', false);
					});
				}
			});
		}, 3000);
		
		//$("#empselect").select2();
		$("#select_dep").select2();
		$("#select_emp").select2();
		$("#popup_depart").select2();
		$("#popup_emp").select2();
	});
	
	function call_filter_data()
	{
		$.ajax({
			url: "be_safe_list.php",
			type: 'POST',
			data: 'catIDs=<?php echo $nav_cat['c'];?>&subCateIDs=<?php echo $nav_cat['s'];?>&pageIDs=<?php echo $nav_cat['p'];?>',
			dataType:'html',
			success: function (datahtml) {
				$('#filter_data_val').html(datahtml);				
			}
		})
	}
	</script>
</body>

</html>
