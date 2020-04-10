<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = CERTIFICATE_DETAILS;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'add':
	 $dir = "uploads/certificate/";
	 if(!is_dir($dir)){
		 mkdir($dir,0755,true);
	 }
	 $imagetype = explode('.',basename($_FILES['image']['name']));
	 if(!empty($imagetype)){
		 $imagename = time().".".end($imagetype);
		 move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename);


	 }else{
		 $imagename = "";
	 }
	$insdata   = array(
    'c_title'		=>$_POST['ctitle'],
    'c_subtitle'	=>$_POST['cstitle'],
    'dept_id'		=>$_POST['dept_id'],
    'employee_ids'	=>implode(",",$_POST['emp_id']),
    'c_content'		=>$_POST['c_content'],
	'logo_image'	=>$imagename,
    'c_auth'		=>$_POST['days'],
    'c_logo_type'	=>$_POST['logo_type']
	);
		$result = $prop->addID($table_name, $insdata);
        if ($result) {
          for($i=0;$i<count($_POST['sign_name']);$i++)
          {
          $insdatanew   = array(
            'ca_name'         =>$_POST['sign_name'][$i],
            'ca_desig'         =>$_POST['sign_desig'][$i],
            'ca_date'         =>date('Y-m-d',strtotime($_POST['sign_date'][$i])),
            'c_id'         =>$result,
        			);
              $prop->add(CERTIFICATE_AUTH, $insdatanew);
            }
			 setcookie("status", "Success", time()+10);
			 setcookie("title", "Certificate Created Successfully", time()+10);
			 setcookie("err", "success", time()+10);
			 header('Location: manage-certificate-details.php');
		 }
	    else{
			 setcookie("status", "Error", time()+10);
             setcookie("title", "Certificate Creation Error", time()+10);
             setcookie("err", "error", time()+10);
			 header('Location: manage-certificate-details.php');
		 }
		 break;
	 case 'update':
	 $dir = "uploads/certificate/";
	 	$iname = $_REQUEST['oldimg'];
	 	if($iname =='')
	 	{
	 		$iname1 = time();
	 	}else{
	 		$ext = explode(".",$iname);
	 		$iname1 = $ext[0];
	 		//echo $iname1;

	 	}
	 	if(!is_dir($dir)){
	 		mkdir($dir,0777,true);
	 	}

	 	$chkimg = basename($_FILES['image']['name']);
	 	if($chkimg != ''){
	 		$extn = explode(".",$chkimg);
	 		$imagename = $iname1.".".end($extn);
	 		move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename);

	 		}
	 		else{
	 			$imagename = $iname;
	 		}
		$t_cond = array("c_id" => $_REQUEST['id']);
		$value   = array(
		'c_title'		=>$_POST['ctitle'],
		'c_subtitle'	=>$_POST['cstitle'],
		'dept_id'		=>$_POST['dept_id'],
	    'employee_ids'	=>implode(",",$_POST['emp_id']),
		'c_content'		=>$_POST['c_content'],
		'logo_image'	=>$imagename,
		'c_auth'		=>$_POST['days'],
		'c_logo_type'	=>$_POST['logo_type']
		);
		if($prop->update($table_name, $value, $t_cond))
		 {
       for($i=0;$i<count($_POST['sign_name']);$i++)
       {
           if($_REQUEST['ca_id'][$i]!="")
           {
           $t_condne = array("ca_id" => $_REQUEST['ca_id'][$i]);
         $insdatanew   = array(
           'ca_name'         =>$_POST['sign_name'][$i],
           'ca_desig'         =>$_POST['sign_desig'][$i],
           'ca_date'         =>date('Y-m-d',strtotime($_POST['sign_date'][$i])),
           'c_id'         =>$_POST['reqid']
             );
             $prop->update(CERTIFICATE_AUTH, $insdatanew,$t_condne);
           }
           else {
             $insdatanew   = array(
               'ca_name'         =>$_POST['sign_name'][$i],
               'ca_desig'         =>$_POST['sign_desig'][$i],
               'ca_date'         =>date('Y-m-d',strtotime($_POST['sign_date'][$i])),
               'c_id'         =>$_POST['reqid']
               );
                 $prop->add(CERTIFICATE_AUTH, $insdatanew);
           }
         }
			setcookie("status", "Success", time()+10);
			setcookie("title", "Certificate Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			 header('Location: manage-certificate-details.php');
		 }

	 break;
	 case 'modify':
		 $curr_val = $prop->get('*',$table_name, array("c_id"=>$_REQUEST['id']));
		// print_r($curr_val); exit;
    $selauth =  $prop->getAll_Disp("SELECT  `ca_id`, `ca_name`, `ca_desig`, `ca_date` FROM ".CERTIFICATE_AUTH." WHERE c_id=".$_REQUEST['id']."");
		 break;
	 case 'dele':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Certificate Deleted Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-certificate-details.php');

	 break;
	  case 'sts':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Certificate Status Changed Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-certificate-details.php');

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
    <title>DCSHRM Certificate</title>
    <!-- Bootstrap Core CSS -->
     <!--<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
     <!--alerts CSS -->
    <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Date picker plugins css -->
    <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- summernotes CSS -->
    <link href="plugins/bower_components/summernote/dist/summernote.css" rel="stylesheet" />


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
<style>

.fileinput.input-group {
    display: block;
}
.form-group {
    margin-bottom: 15px;

}
	.b_btn {
    margin: 10px;
}
	#appen .form-group
	 {
    margin-top: 10px;
    margin-bottom: 10px;
}
	.m_sp{margin-bottom: 10px;}
	#days {
    float: right;
}
	.l_sp{margin: 30px 0px;}
	.s_b {
    position: relative;
}
#days {
    float: right;
    position: absolute;
    top: -45px;
    left: 263px;
    border-radius: 3px;
    padding: 5px;
    box-shadow: 1px 1px 11px #4c566740;
    /*width: 65px;*/
}
	.b_style img {
    width: 150px;
}
	.l_sp1{margin-top: 15px; float: left;}
	.a_rt{float: right;}
	.a_rt li label {
    padding-right: 8px; margin-right: -7px;}

	@media only screen and (max-width: 600px)
	{
		.form-group {
			margin-bottom: 0px;
		}
		.l_sp {
    margin: 10px 0px;
}
		.l_sp1{margin-top: 0px !important;}
	}


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
                        <h4 class="page-title"><?php
          		if(isset($_REQUEST['id']))
          		{
          	 ?> Edit <?php } else { ?> Add New <?php } ?> Certificate </h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Add Certificate</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>
                  <form data-toggle="validator" method="post" action="certificate-page.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                        <h3 class="box-title">Choose Design</h3>
                        <div class="col-sm-12 col-md-12 b_style">
							<div class="form-group">
								<div class="form-group">
									<div class="clearfix"></div>
									<label class="control-label l_sp1">Choose Template</label>
									   <ul class="list-inline icheck-list p-0 a_rt">
											<li>
												<div class="radio radio-success">
													<input type="radio" name="logo_type" id="radio4" <?php if($curr_val['c_logo_type']==1) { echo 'checked'; } ?> required value="1">
													<label for="radio4"><img src="img/pdf1.png"  alt="logo-image"></label>
												</div>
											</li>
											<li>
												<div class="radio radio-success">
													<input type="radio" name="logo_type" id="radio5" <?php if($curr_val['c_logo_type']==2) { echo 'checked'; } ?> required value="2">
													<label for="radio5"><img src="img/pdf2.png" alt="logo-image"></label>
												</div>
											</li>
										   <li>
												<div class="radio radio-success">
													<input type="radio" name="logo_type" <?php if($curr_val['c_logo_type']==3) { echo 'checked'; } ?> id="radio6" required value="3">
													<label for="radio6"><img src="img/pdf3.png" alt="logo-image"></label>
												</div>
											</li>

												<li>
												<div class="radio radio-success">
													<input type="radio" name="logo_type" id="radio7" <?php if($curr_val['c_logo_type']==4) { echo 'checked'; } ?> required value="4">
													<label for="radio7"><img src="img/pdf4.png" alt="logo-image"></label>
												</div>
											</li>
<div class="help-block with-errors"></div>
												</ul>
										</div>

							</div>

							<div class="clearfix"></div>
							<div class="form-group " style="overflow:hidden;">
								<label class="control-label col-md-3">Upload logo</label>
								<div class="col-md-9">
									<div>
										<?php
				if(isset($_REQUEST['id']))
				{
			 ?>
			 <input type="hidden" name="oldimg" value="<?=$curr_val['logo_image'];?>">
				<img style="max-width:200px; margin:0 auto;" src="uploads/certificate/<?=$curr_val['logo_image'];?>" height="100"> <br/>
                <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"  name="image">
			 <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
														 <div class="form-control" data-trigger="fileinput">
																 <i class="glyphicon glyphicon-file fileinput-exists"></i>
																 <span class="fileinput-filename"></span>
														 </div>
														 <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;display: inline-block;float: right; margin:0 !important">
				 <span class="fileinput-new">Select file</span>
														 <span class="fileinput-exists">Change</span>
														 <input type="file" accept="image/x-png,image/gif,image/jpeg" name="image">
														 </span>
														 <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" style=" height:32px; float: right; ">Remove</a>
			 </div><?php */?>

			 <?php } else { ?>
												 <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"  name="image" required>
                                                 <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
														 <div class="form-control" data-trigger="fileinput">
																 <i class="glyphicon glyphicon-file fileinput-exists"></i>
																 <span class="fileinput-filename"></span>
														 </div>
														 <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;display: inline-block;float: right; margin:0 !important">
				 										 <span class="fileinput-new">Select file</span>
														 <span class="fileinput-exists">Change</span>
														 <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" required>
														 </span>
														 <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" style="float: right;height: 32px !important;width: 100px;">Remove</a>
			 </div><?php */?>
				<div class="help-block with-errors"></div>
			 <?php }  ?>

									</div>
								</div>

							</div>
							<div class="clearfix"></div>
							<div class="form-group m-15">
								<label class="control-label col-md-3">Title</label>
								<div class="col-md-9">
								  <input type="text" placeholder="Title" name="ctitle" value="<?php echo $curr_val['c_title']; ?>" required class="form-control">
                  <div class="help-block with-errors"></div>
								</div>

							</div>

                       		<div class="form-group">
								<label class="control-label col-md-3">Sub Title</label>
								<div class="col-md-9">
								  <input type="text" placeholder="Sub Title" value="<?php echo $curr_val['c_subtitle']; ?>" name="cstitle" required class="form-control">
                  <div class="help-block with-errors"></div>
								</div>
							</div>
                       		<div class="form-group">
								<label class="control-label col-md-3">Department</label>
								<div class="col-md-9">
									<select class="form-control select2" name="dept_id" id="dept_id" required>
                      <option value="">Select</option>
              <?php
  				 $catsql = "SELECT  dept_id,`dep_name` from ".DEPARTMENT." WHERE `dep_status`!='1' order by `dept_id` Desc";
  				$catfet=$prop->getAll_Disp($catsql);
  				for($i=0; $i<count($catfet); $i++)
  		                    { ?>
                <option value="<?php echo $catfet[$i]['dept_id']; ?>" <?php if($catfet[$i]['dept_id']==$curr_val['dept_id']) { echo "selected"; }?>><?php echo $catfet[$i]['dep_name']; ?></option>
              <?php } ?>
                  </select>
                  <div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="form-group" id="response_emp">
								<?php
								if($_REQUEST['id'])
								{ ?>
									<label class="control-label col-md-3">Employees</label>
									<div class="col-md-9">
									  <select class="form-control select2 select2-multiple" multiple="multiple" name="emp_id[]" required>
									<?php
									$catsql = "SELECT id,name,department_id from ".USERS." WHERE `department_id`=".$curr_val['dept_id']." AND  `status`!=2 order by `name` ASC";
									$catfet=$prop->getAll_Disp($catsql);
									for($i=0; $i<count($catfet); $i++)
									          {
															$myString = $curr_val['employee_ids'];
														  $myArray = explode(',', $myString);
															?>
									<option value="<?php echo $catfet[$i]['id']; ?>" <?php echo (in_array($catfet[$i]['id'], $myArray)?'selected':''); ?>><?php echo $catfet[$i]['name']; ?></option>
									<?php } ?>
									  </select>
									  <div class="help-block with-errors"></div>
									</div>
									<?php
								}
								?>
							</div>


                       		<div class="form-group">
								<label class="control-label col-md-3">Certificate Content</label>
								<div class="col-md-9">
								  <!--<textarea class="form-control" rows="4" id="input7" required></textarea>-->
								  <textarea class="summernote" required name="c_content"><?php echo $curr_val['c_content']; ?></textarea>
								</div>
							</div>
<input type="hidden" name="reqid" value="<?php echo $_REQUEST['id']; ?>">
              <label>&nbsp;</label>
							<div class="col-sm-12 col-md-12 col-xs-12 p-0">
								<h3 class="box-title">Authority Blocks</h3>
								<div class="col-md-12 p-0">
								  <div class="s_b">
									<div class="col-md-3"><select id="days" class="form-control col-sm-3 select2" name="days">
										<option value="0">- Select -</option>
										<option value="1" <?php if(count($selauth)==1) { echo "selected"; } ?>>1</option>
										<option value="2" <?php if(count($selauth)==2) { echo "selected"; } ?>>2</option>
										<option value="3" <?php if(count($selauth)==3) { echo "selected"; } ?>>3</option>
										<option value="4" <?php if(count($selauth)==4) { echo "selected"; } ?>>4</option>
									</select>
									</div>
    <div id="editdeta">
      <?php

        for($i=0;$i<count($selauth);$i++)
        {
      ?>
      <input type="hidden" value="<?php echo $selauth[$i]['ca_id']?>" name="ca_id[]">
      <label class="control-label col-md-12 l_sp">Authority <?php echo $i+1; ?></label>
      <div class="form-group">
        <label class="control-label col-md-3">Name</label>
        <div class="col-md-9 m_sp">
          <input placeholder="Name" name="sign_name[]" value="<?php echo $selauth[$i]['ca_name']?>" class="form-control" type="text">
        </div>
        <label></label>
        <div class="form-group">
          <label class="control-label col-md-3">Designation</label>
          <div class="col-md-9 m_sp">
            <input placeholder="Designation" class="form-control" name="sign_desig[]" value="<?php echo $selauth[$i]['ca_desig']?>" type="text">
          </div>
          <label></label>
          <div class="form-group">
            <label class="control-label col-md-3">Date</label>
            <div class="col-md-9 m_sp">
              <div class="input-group">
                <input class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="sign_date[]" type="text" value="<?php echo date('m/d/Y',strtotime($selauth[$i]['ca_date']));?>">
                <span class="input-group-addon"><i class="icon-calender"></i>
                </span>
              </div>
            </div>
            <label></label>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
									<div id="appen"></div>
								</div>
								</div>
							</div>
              <label>&nbsp;</label>
<div class="clearfix"></div>
                       	<div class="col-sm-12">
							<button type="submit" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button><button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10">Add</button>
						</div>
                        </div>

						<div class="clearfix"></div>
						</div>
					</div>




                    </div>
                  </form>
                </div>
                <!-- /.row ends-->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; MACA Supply </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
  <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
     <!-- Sweet-Alert  -->
    <script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script>

		//Warning Message
    $('#sa-warning').click(function(){
        swal({
            title: "Are you sure?",
            text: "You want to delete this Form!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function(){
            swal("Deleted!", "Form has been deleted.", "success");
        });
    });</script>
    <!-- Custom Theme JavaScript -->
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>


    <script src="js/jasny-bootstrap.js"></script>

    <!--Style Switcher -->
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
   <script>// For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
			</script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/validator.js"></script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

     <script>

    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({

        todayHighlight: true
    });


    </script>
    <!-- end - This is for export functionality only -->
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

        });
    });

    </script>
    <script>
$("#dept_id").change(function() {
	var dep_id = $(this).val();
	if(dep_id>0)
	{
	$.ajax({
			 type: "POST",
			 url: "emp-ajax.php",
			 cache:false,
			 data: 'dep_id='+dep_id,
				 success: function(response)
				 {
					 $("#response_emp").html(response);
					 $(".select2-multiple").select2();
					 //$('.select2-multiple').selectpicker();
				 }
		 });
	 }
	 else {
	 	$("#response_emp").html("");
	 }
});
		$("#days").change(function() {
var val = $(this).val();
$("#appen").html("");
 for (i = 0; i < val; i++) {
	 var sn = i+1;
$("#appen").append('  <input type="hidden" value="" name="ca_id[]"><label class="control-label col-md-12 l_sp">Authority '+sn+'</label><div class="form-group"><label class="control-label col-md-3">Name</label><div class="col-md-9 m_sp"><input type="text" placeholder="Name" name="sign_name[]" class="form-control"></div><label></label><div class="form-group"><label class="control-label col-md-3">Designation</label><div class="col-md-9 m_sp"><input type="text" placeholder="Designation" class="form-control" name="sign_desig[]"></div><label></label><div class="form-group"><label class="control-label col-md-3">Date</label><div class="col-md-9 m_sp"><div class="input-group"><input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" name="sign_date[]"><span class="input-group-addon"><i class="icon-calender"></i></span> </div></div><label></label><div class="clearfix"></div>');
	 $('.mydatepicker, #datepicker').datepicker();
 }
});

	</script>

   <script src="plugins/bower_components/summernote/dist/summernote.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('.summernote').summernote({

	toolbar: [
		['style', ['style']],
		['font', ['bold', 'italic', 'underline', 'clear']],
		['fontname', ['fontname']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['height', ['height']],
		['table', ['table']],
		['insert', ['link', 'picture', 'hr']],
		['view', ['fullscreen', 'codeview']],
		['help', ['help']]
],
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });
            $('.inline-editor').summernote({
                airMode: true
            });
        });
        window.edit = function () {
            $(".click2edit").summernote()
        }, window.save = function () {
            $(".click2edit").destroy()
        }
    </script>


</body>

</html>
