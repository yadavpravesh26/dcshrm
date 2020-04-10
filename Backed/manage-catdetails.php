<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = DOCUMENT;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'dele':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Deleted Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-catdetails.php');

	 break;
	  case 'sts':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Document Status Changed Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-catdetails.php');

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

	  <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  
   
     <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
		 <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	
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
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
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
                        <h4 class="page-title">Manage Categories details</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Manage Categories details</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                
				<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Manage Categories details</h3> 
                             <div class="table-responsive dash-table">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Page Name</th>
											  <th>Category Name</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
							 $catsql = "SELECT  s.`c_id`,s.`heading`,s.`status`,s.`cat1`,c.category_name from ".CAT_DETAILS." s LEFT JOIN ".CATEGORY_DOC." c ON c.category_id=s.cat1 WHERE s.status='0' AND s.`heading`!=''  order by s.`c_id` DESC";
							$catfet=$prop->getAll_Disp($catsql); 
							for($i=0; $i<count($catfet); $i++)
					                    {  
									?>
                                        <tr>
										 <td><?php echo $catfet[$i]['heading'];?> </td>
                                            <td><?php echo $catfet[$i]['category_name'];?> </td>
                                            <td><a href="cat-details.php?id=<?php echo $catfet[$i]['c_id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> <a class="deleteone" id="<?php echo $catfet[$i]['c_id'];?>" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></td>
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
            <footer class="footer text-center"> 2017 &copy; MACA Supply </footer>
        </div>
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
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/jasny-bootstrap.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
   
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/validator.js"></script>
    <!--Style Switcher -->
    <!-- data table -->
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
	 <script>
	$(function() {
		$(document).on('click', '.deleteone', function() {
var element = $(this);
var del_id = element.attr("id");
var card_name = "Category Details";
			swal({   

				title: card_name,   

				text: "Are you sure you want to delete this Details?",   

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
							data: 'ids='+del_id+'&meth=catdetaildelete',  
							success: function(response)  
							{   
							  window.location.href = "manage-catdetails.php?method=dele";
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
           
        });
    });
   
    </script>
</body>

</html>
