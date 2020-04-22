<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = DOCUMENT;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'add':
	 $dir = "uploads/docimages/";
			$thumb = $dir."thumb/";
			$fthumb = $dir."fthumb/";
			$regular = $dir."regular/";
			$filepath = "uploads/documentword/";
			if(!is_dir($dir) || !is_dir($thumb) || !is_dir($fthumb)){

				mkdir($dir,0755,true);
				mkdir($thumb,0755,true);
				mkdir($regular,0755,true);
				mkdir($fthumb,0755,true);
			}

			$imagetype = explode('.',basename($_FILES['image']['name']));
			if(!empty($imagetype)){
				$imagename = time().".".end($imagetype);
				if(move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename)){
					$resize = new ResizeImage($dir.$imagename.'');
					$resize->resizeTo(400, 350 ,'exact');
					$resize->saveImage($dir.'regular/'.$imagename.'');
				}

			}else{
				$imagename = "";
			}
			$ftype = explode('.',basename($_FILES['docfile']['name']));
			if(!empty($ftype)){
				$filename =  str_replace(" ","_",$_POST['document_name']).".".end($ftype);
				move_uploaded_file($_FILES['docfile']['tmp_name'],$filepath.$filename);
			}

			$catsqlS = "SELECT `doc_id`,`document_name` FROM  ".DOCUMENT." WHERE  `doc_status` NOT IN(1,2)";
$catfetS=$prop->getAll_Disp($catsqlS);
$totcount = count($catfetS)+1;
	$insdata   = array(
            'category_id'           =>$_POST['category_id'],
            'document_name'           =>$_POST['document_name'],
            'doc_image'           =>$imagename ,
            'doc_file'           =>$filename ,
            /*'doc_path'           =>$_POST['doc_path'],*/
            'doc_content'           =>$_POST['editor1'],
            'rowno'           =>$totcount
			);

		$result = $prop->add($table_name, $insdata);
		unlink($dir.$imagename);
        if ($result) {
			 setcookie("status", "Success", time()+10);
			 setcookie("title", "Document Created Successfully", time()+10);
			 setcookie("err", "success", time()+10);
			 header('Location: manage-documents.php');
		 }
	    else{
			 setcookie("status", "Error", time()+10);
             setcookie("title", "Document Creation Error", time()+10);
             setcookie("err", "error", time()+10);
			 header('Location: manage-documents.php');
		 }
		 break;
	 case 'update':
		$dir = "uploads/docimages/";
		$filepath = "uploads/documentword/";
			$iname = $_REQUEST['oldimg'];
			$ipath = $_REQUEST['olddoc'];
			if($iname =='')
			{
				$iname1 = time();
			}else{
				$ext = explode(".",$iname);
				$iname1 = $ext[0];
			}
			if($ipath =='')
			{
				$ipath1 = time();
			}else{
				$ext = explode(".",$ipath);
				$ipath1 = $ext[0];
			}
			if(!is_dir($dir)){
				mkdir($dir,0777,true);
			}

			$chkimg = basename($_FILES['image']['name']);
			if($chkimg != ''){
				$extn = explode(".",$chkimg);
				$imagename = $iname1.".".end($extn);
				move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename);
				    $resize = new ResizeImage($dir.$imagename.'');
					$resize->resizeTo(400, 350 ,'exact');
					$resize->saveImage($dir.'regular/'.$imagename.'');
				}
				else{
					$imagename = $iname;
				}

				$chkimg1 = basename($_FILES['docfile']['name']);
			if($chkimg1 != ''){
				$extn1 = explode(".",$chkimg1);
				$filename = str_replace(" ","_",$_POST['document_name']).".".end($extn1);
				move_uploaded_file($_FILES['docfile']['tmp_name'],$dir.$filename);

				}
				else{
					$filename = $ipath;
				}
		$t_cond = array("doc_id" => $_REQUEST['id']);
		$value   = array(
            'category_id'           =>$_POST['category_id'],
            'document_name'           =>$_POST['document_name'],
            'doc_image'           =>$imagename ,
			'doc_content'           =>$_POST['editor1'],
            'doc_file'           =>$filename
           /* 'doc_path'           =>$_POST['doc_path']*/

			);
		if($prop->update($table_name, $value, $t_cond))
		 {
			setcookie("status", "Success", time()+10);
			setcookie("title", "Document Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			 header('Location: manage-documents.php');
		 }

	 break;
	 case 'modify':
		 $curr_val = $prop->get('*',$table_name, array("doc_id"=>$_REQUEST['id']));
		// print_r($curr_val); exit;
		 break;
	 case 'dele':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Document Deleted Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-documents.php');

	 break;
	  case 'sts':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Document Status Changed Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-documents.php');

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
    <style>
        .do-lable {    background: #577ab7;
    padding: 2px 10px;
    border-radius: 16px;
    color: #fff;
    font-weight: 400;
    font-size: 12px;
}
.input-group-addon {
    padding: 9px 4px;
    font-size: 12px;
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
                        <h4 class="page-title">Manage Documents</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Manage Documents</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Manage Documents</h3>
                             <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>

                            <form data-toggle="validator" method="post" action="manage-documents.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" >
                                       <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputuname">Applicable Category</label>
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
                                            <label for="exampleInputuname">Document Name</label>

                                            <div class="input-group">

                                                <input type="text" class="form-control" id="exampleInputuname" name="document_name"  placeholder="Document Name" value="<?=$curr_val['document_name']?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                         <div class="col-md-6">

							<div class="form-group">
                                    <label class="col-sm-12">Document Image</label>
                                    <div class="col-sm-12">
									                <?php
											if(isset($_REQUEST['id']))
										  {
										 ?>
										 <input type="hidden" name="oldimg" value="<?=$curr_val['doc_image'];?>">
					
                                     <img src="uploads/docimages/regular/<?=$curr_val['doc_image'];?>" height="100"> <br/>
                                      <input type="file" name="image" class="form-control">
										  <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div><?php */?>

										  <?php } else { ?>
                                           <input type="file" name="image" class="form-control" required>
                                        <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" required>
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div><?php */?>
											 <div class="help-block with-errors"></div>
											<?php }  ?>

                                    </div>
                                </div>

                            </div>
                                        <?php /* <div class="form-group col-md-6">
                                            <label for="exampleInputuname">File Path</label>

                                            <div class="input-group">

                                                <input type="text" class="form-control" id="exampleInputuname" name="doc_path"  placeholder="URL" value="<?=$curr_val['doc_path']?>" required>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div><?php */?>
                                          <div class="col-md-6">

							<div class="form-group">
                                    <label class="col-sm-12">Document File</label>
                                    <div class="col-sm-12">
									                <?php
											if(isset($_REQUEST['id']))
										  {
										 ?>
										 <input type="hidden" name="olddoc" value="<?=$curr_val['doc_file'];?>">
					
                                     <a> <img src="img/microsoft-word-viewer-icon.png" height="100"> <a href="download_file.php?download_file=<?=$curr_val['doc_file'];?>"><span class="do-lable">Download File</span></a> <br/>
                                      <input type="file" name="docfile" class="form-control">
										  <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Upload new file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="docfile">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div><?php */?>

										  <?php } else { ?>
                                           <input type="file" name="docfile" class="form-control" required>
                                        <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="docfile" required>
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div><?php */?>
											 <div class="help-block with-errors"></div>
											<?php }  ?>

                                    </div>
                                </div>

                            </div>
                                     <div class="col-lg-12">
									 <textarea cols="80" id="editor1" name="editor1" rows="10" ><?=$curr_val['doc_content'];?>
	</textarea>
</div>

                                        <div class="clearfix"></div>
                                        <div class="col-sm-12"><button type="button" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button><button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10">Add</button></div>

                                        </div>

                                    </div>
							</form>


                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Manage Documents</h3>
                             <div class="table-responsive dash-table">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Document Name</th>
                                            <th>Category Name</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
							 $catsql = "SELECT  s.`doc_id`,s.`document_name`,s.`doc_status`,c.`category_name` from ".DOCUMENT." s LEFT JOIN ".CATEGORY." c ON c.category_id=s.category_id WHERE s.`doc_status`!='1' order by s.`document_name` Asc";
							$catfet=$prop->getAll_Disp($catsql);
							for($i=0; $i<count($catfet); $i++)
					                    {
									?>
                                        <tr>
										 <td><?php echo $catfet[$i]['document_name'];?> </td>
                                            <td><?php echo $catfet[$i]['category_name'];?> </td>
                                            <td><a href="manage-documents.php?id=<?php echo $catfet[$i]['doc_id'];?>&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a> <a class="deleteone" id="<?php echo $catfet[$i]['doc_id'];?>" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></td>
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
	<script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>
	<script>
		CKEDITOR.replace( 'editor1', {
			height: 250
		} );
	</script>
	 <script>
	$(function() {
		$(document).on('click', '.deleteone', function() {
var element = $(this);
var del_id = element.attr("id");
var card_name = "Document";
			swal({

				title: card_name,

				text: "Are you sure you want to delete this Document?",

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
							data: 'ids='+del_id+'&meth=docdelete',
							success: function(response)
							{
							  window.location.href = "manage-documents.php?method=dele";
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
