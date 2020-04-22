<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = SUBCATEGORY;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'add':
	$insdata   = array(
            'category_id'           =>$_POST['category_id'],       
            'subcate_name'           =>$_POST['subcatname']
			);		
		$result = $prop->add($table_name, $insdata);
        if ($result) {
			 setcookie("status", "Success", time()+10);
			 setcookie("title", "Sub category Created Successfully", time()+10);
			 setcookie("err", "success", time()+10);
			 header('Location: manage-subcategories.php');
		 }
	    else{
			 setcookie("status", "Error", time()+10);
             setcookie("title", "Sub category Creation Error", time()+10);
             setcookie("err", "error", time()+10);
			 header('Location: manage-subcategories.php');
		 }
		 break;
	 case 'update':
		
		$t_cond = array("sub_id" => $_REQUEST['id']);
		$value = array(
		"category_id" => $_POST['category_id'],
		"subcate_name" => $_POST['subcatname']		
		);
		if($prop->update($table_name, $value, $t_cond))
		 {
			setcookie("status", "Success", time()+10);
			setcookie("title", "Sub category Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			 header('Location: manage-subcategories.php');
		 }

	 break;
	 case 'modify':
		 $curr_val = $prop->get('*',$table_name, array("sub_id"=>$_REQUEST['id']));
		// print_r($curr_val); exit;
		 break;
	 case 'dele':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Sub category Deleted Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-subcategories.php');

	 break;
	  case 'sts':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Sub category Status Changed Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-subcategories.php');

	 break;
		// echo $curr_val; exit;
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
    <title>DCSHRM Super Admin</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	 <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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
                        <h4 class="page-title">Add Sub Category</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Add Sub Category</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Add Sub Category</h3> 
                            <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>
                            <form data-toggle="validator" method="post" action="manage-subcategories.php?method=<?php echo $foraction; ?>" >
                                       <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Select Category</label>
                       <?php  
					  $catsql = "SELECT `category_id`,`category_name`, `category_status` FROM  ".CATEGORY." WHERE `category_status` NOT IN(1,2) order by category_name ASC";
        $catfet=$prop->getAll_Disp($catsql); 
		echo  '<select name="category_id" id="category_filid" class="selectpicker" data-style="form-control" required>
				<option value="">Select Category</option>';
		for($i=0; $i<count($catfet); $i++)
					                    {  
		echo  '<option value="'.$catfet[$i]['category_id'].'" '.($catfet[$i]['category_id'] == $curr_val['category_id'] ? "selected":"").' >'.$catfet[$i]['category_name'].'</option>';
		}
		echo  '</select>'; ?>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Enter Sub Category</label>
                                            
                                            <div class="input-group">
                                               
                                                <input type="text" class="form-control" id="exampleInputuname" name="subcatname"  placeholder="Sub Category Name" value="<?php echo $curr_val['subcate_name']; ?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                          
                                      
                                        
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12"><button type="submit" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button><button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10">Submit</button></div>
                                        
                                        </div>
                                        
                                    </div>
							</form>
                            
                            
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Manage Sub Categories</h3> 
                            <div class="table-responsive dash-table">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sub Category Name</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
							 $catsql = "SELECT  s.`sub_id`,s.`subcate_name`,s.`subcate_status`,c.`category_name` from ".SUBCATEGORY." s LEFT JOIN ".CATEGORY." c ON c.category_id=s.category_id WHERE s.`subcate_status`!='1' order by s.`sub_id` Desc";
							$catfet=$prop->getAll_Disp($catsql); 
							for($i=0; $i<count($catfet); $i++)
					                    {  
									?>
                                        <tr>
										 <td><?php echo $catfet[$i]['subcate_name'];?> </td>
                                            <td><?php echo $catfet[$i]['category_name'];?> </td>
                                            <td><a href="manage-subcategories.php?id=<?php echo $catfet[$i]['sub_id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> <a class="deleteone" id="<?php echo $catfet[$i]['sub_id'];?>" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></td>
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
            <footer class="footer text-center"> <?php include 'footer.php';?> </footer>
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
	 <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- data table -->
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script>
	$(function() {
		$(document).on('click', '.deleteone', function() {
var element = $(this);
var del_id = element.attr("id");
var card_name = "Sub category";
			swal({   

				title: card_name,   

				text: "Are you sure you want to delete this Sub category?",   

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
							data: 'ids='+del_id+'&meth=subcatdelete',  
							success: function(response)  
							{   
							  window.location.href = "manage-subcategories.php?method=dele";
							}   
						});              
				 } 
				 else 
				 {     

					swal("Cancelled", "", "error");   

				} 

            });
     });

});
    $(document).ready(function() {
		<?php if($_COOKIE[err] !='')
			{
				
				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");'; 
				setcookie("status", $_COOKIE[status], time()-100);
				setcookie("title", $_COOKIE[title], time()-100);
				setcookie("err", $_COOKIE[err], time()-100);
			}
			?>
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
