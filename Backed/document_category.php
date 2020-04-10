<?php

require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');

$cdb = new DB();

$db = $cdb->getDb();

$prop = new PDOFUNCTION($db);

$table_name = CATEGORY_DOC;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';

switch($method)

{

	 case 'add':

	$insdata   = array(

            'category_name'           =>$_POST['form1Name']

			);		

		$result = $prop->add($table_name, $insdata);

        if ($result) {

			 setcookie("status", "Success", time()+10);

			 setcookie("title", "Category Created Successfully", time()+10);

			 setcookie("err", "success", time()+10);

			 header('Location: document_category.php');

		 }

	    else{

			 setcookie("status", "Error", time()+10);

             setcookie("title", "Category Creation Error", time()+10);

             setcookie("err", "error", time()+10);

			 header('Location: document_category.php');

		 }

		 break;

	 case 'update':

		

		$t_cond = array("category_id" => $_REQUEST['id']);

		$value = array(

		"category_name" => $_POST['form1Name']

		);

		if($prop->update($table_name, $value, $t_cond))

		 {

			setcookie("status", "Success", time()+10);

			setcookie("title", "Category Updated Successfully", time()+10);

			setcookie("err", "success", time()+10);

			 header('Location: document_category.php');

		 }



	 break;

	 case 'modify':

		 $curr_val = $prop->get('*',$table_name, array("category_id"=>$_REQUEST['id']));

		// print_r($curr_val); exit;

		 break;

	 case 'dele':

		 setcookie("status", "Success", time()+10);

		 setcookie("title", "Category Deleted Successfully", time()+10);

		 setcookie("err", "success", time()+10);

		 header('Location: document_category.php');



	 break;

	  case 'sts':

		 setcookie("status", "Success", time()+10);

		 setcookie("title", "Category Status Changed Successfully", time()+10);

		 setcookie("err", "success", time()+10);

		 header('Location: document_category.php');



	 break;

		// echo $curr_val; exit;

}



?><!DOCTYPE html>



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

    <title> DCSHRM</title>

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

	    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />

    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" /

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

                        <h4 class="page-title">Manage Categories </h4> </div>

                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 

                        <ol class="breadcrumb">

                            <li><a href="dashboard.php">Dashboard</a></li>

                            <li class="active">Manage Categories</li>

                        </ol>

                    </div>

                    <!-- /.col-lg-12 -->

                </div>

				 <div class="row">

                    <div class="col-md-12">

                        <div class="white-box">

                     <h3 class="box-title">Add Categories</h3> 

				   <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>

                  <form data-toggle="validator" method="post" action="document_category.php?method=<?php echo $foraction; ?>"  >

                    

                    <div class="form-group">

                      <label class="form-label">Category Name</label>

                      <span class="help"></span>

                      <div class="input-with-icon  right">

                        <i class=""></i>

                        <input type="text" name="form1Name" required value="<?php echo $curr_val['category_name'];?>" id="form1Name" class="form-control">

                      </div>

					  <div class="help-block with-errors"></div>

                    </div> 

                    <div class="form-group">

                      <div class="pull-right">

                        <button type="submit" name="add" class="btn btn-success btn-cons"><i class="icon-ok"></i> Add</button> 

                      </div>

                    </div>

                    <div class="clearfix"></div>

                  </form>

                </div>

              </div>

              </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="white-box">

                            <h3 class="box-title">Manage Categories</h3> 

                             <div class="table-responsive dash-table">

                                <table id="myTable" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Category Name</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

							 $catsql = "SELECT  category_id,`category_name`,category_status from ".CATEGORY_DOC." WHERE `category_status`!='1' order by `category_id` Desc";

							$catfet=$prop->getAll_Disp($catsql); 

							for($i=0; $i<count($catfet); $i++)

					                    {  

									?>

                                        <tr>

                                            <td><?php echo $catfet[$i]['category_name'];?> </td>

                                            <td><a href="document_category.php?id=<?php echo $catfet[$i]['category_id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> <a class="deleteone" id="<?php echo $catfet[$i]['category_id'];?>" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></td>

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

	<?php if($_COOKIE[err] !='')

			{

				

				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");'; 

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

	

	//Warning Message

   /* $('#sa-delete').click(function(){

        swal({   

            title: "Are you sure?",   

            text: "You want to delete!",   

            type: "warning",   

            showCancelButton: true,   

            confirmButtonColor: "#DD6B55",   

            confirmButtonText: "Yes, delete it!",   

            closeOnConfirm: false 

        }, function(){   

            swal("Deleted!", "successfully deleted.", "success"); 

        });

    });*/



	$(function() {

		$(document).on('click', '.deleteone', function() {

var element = $(this);

var del_id = element.attr("id");

var card_name = "Category";

			swal({   



				title: card_name,   



				text: "Are you sure you want to delete this Category?",   



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

							data: 'ids='+del_id+'&meth=catdocdelete',  

							success: function(response)  

							{   

							  window.location.href = "document_category.php?method=dele";

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

	</script>

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



	

    </script>

</body>



</html>

