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
	case 'dele':
		setcookie("status", "Success", time()+10);
		setcookie("title", "Admin Deleted Successfully", time()+10);
		setcookie("err", "success", time()+10);
		header('Location: manage-accounts.php');
	break;
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
    <title>Manage Admin</title>
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
                        <h4 class="page-title">Manage Admin </h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="active">Manage Admin</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">List Of Admins</h3>

                            <div id="load_popup_modal_show_id" class="modal fade" tabindex="-1"></div>
                            <div class="table-responsive ">
								<?php 
								if($session['b_type']===0){
										$punchareafet=$prop->getAll_Disp('SELECT a.id,a.name,a.email,a.status,b.c_name FROM `'.USERS.'` a INNER JOIN `'.USERS.'` b ON a.u_id=b.id WHERE b.status!=2 AND a.status!=2 AND a.u_type=3 AND a.id!='.$session['bid']);
										$dis = 1;
									}else{
										$punchareafet=$prop->getAll_Disp('SELECT id,name,email,status FROM `'.USERS.'` WHERE `status`!=2 AND u_type=3 AND u_id='.$session['bid'].' AND id!='.$session['bid']);
										$dis = 0;
									}
								
								?>
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <?php if($dis) echo '<th>Company</th>'; ?>
                                            <th>Name</th>
											<th>Email</th>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
									for($i=0; $i<count($punchareafet); $i++)
					                {
									?>
                                        <tr>
                                            <?php if($dis) echo '<td>'.$punchareafet[$i]['c_name'].'</td>'; ?>
                                            <td><?php echo $punchareafet[$i]['name']; ?></td>
                                            <td><?php echo $punchareafet[$i]['email'];?></td>
                                            <td><a href="add-account.php?id=<?php echo $punchareafet[$i]['id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> <a class="deleteone" id="<?php echo $punchareafet[$i]['id'];?>" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></td>
                                        </tr>
									<?php  
									} 
									?>
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
    <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script>
	<?php 
			if($_COOKIE[err] !='')
			{

				echo 'swal("'.$_COOKIE[status].'", "'.$_COOKIE[title].'", "'.$_COOKIE[err].'");';
				setcookie("status", $_COOKIE[status], time()-10);
				setcookie("title", $_COOKIE[title], time()-10);
				setcookie("err", $_COOKIE[err], time()-10);
			}
			?>
	$(function() {
		$(document).on('click', '.deleteone', function() {
var element = $(this);
var del_id = element.attr("id");
var card_name = "Admin";
			swal({

				title: card_name,

				text: "Are you sure you want to delete this Admin?",

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
							data: 'ids='+del_id+'&meth=admindelete',
							success: function(response)
							{
							  window.location.href = "manage-accounts.php?method=dele";
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
    });


    </script>

</body>

</html>
