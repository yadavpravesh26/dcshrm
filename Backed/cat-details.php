<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = CAT_DETAILS;

$method = $_REQUEST['method']!=''?$_REQUEST['method']:'';
switch($method)
{
	 case 'add':

	 $dir = "uploads/catdetails/";
			$thumb = $dir."thumb/";
			$fthumb = $dir."fthumb/";
			$regular = $dir."regular/";
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
			$formname = $_POST[formname];
			$formlink = $_POST[formlink];
			$arr = array();
			for ($index = 0; $index < count($formname); $index++) {
			    $arr[$index] = $formname[$index]."~".$formlink[$index];
			}
			$result = implode(">", $arr);
			$docname = $_POST[docname];
			$doclink = $_POST[doclink];
			$arrs = array();
			for ($indexq = 0; $indexq < count($docname); $indexq++) {
			    $arrs[$indexq] = $docname[$indexq]."~".$doclink[$indexq];
			}
			$docresult = implode(">", $arrs);
	$insdata   = array(
            'checkpoint'    =>implode(',',$_POST[checkpoint]),
            'video'         =>implode(',',$_POST[video]),
						'form_link'         =>$result,
					/*	'form_name'         =>implode(',',$_POST[formname]),
						'doc_name'         =>implode(',',$_POST[docname]),*/
						'doc_link'         =>$docresult,
            'doc_image'     =>$imagename ,
            'heading'       =>$_POST['heading'],
            'title'         =>$_POST['title'],
            'cat1'         =>$_POST['catname'],
            'cat2'         =>$_POST['sub_cat_id'],
            'cat3'         =>$_POST['sub_cat_ids'],
            'checklist_link' =>$_POST['checklist_link'],
            'training'       =>$_POST['training'],
            'descript'           =>$_POST['desc']
			);


		$result = $prop->add($table_name, $insdata);
		unlink($dir.$imagename);
        if ($result) {
			 setcookie("status", "Success", time()+10);
			 setcookie("title", "Categort detail Created Successfully", time()+10);
			 setcookie("err", "success", time()+10);
			 header('Location: manage-catdetails.php');
		 }
	    else{
			 setcookie("status", "Error", time()+10);
             setcookie("title", "Categort detail Creation Error", time()+10);
             setcookie("err", "error", time()+10);
			 header('Location: manage-catdetails.php');
		 }
		 break;
	 case 'update':
		$dir = "uploads/catdetails/";
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
			$formname = $_POST[formname];
			$formlink = $_POST[formlink];
			$arr = array();
			for ($index = 0; $index < count($formname); $index++) {
					$arr[$index] = $formname[$index]."~".$formlink[$index];
			}
			$result = implode(">", $arr);
			$docname = $_POST[docname];
			$doclink = $_POST[doclink];
			$arrs = array();
			for ($indexq = 0; $indexq < count($docname); $indexq++) {
					$arrs[$indexq] = $docname[$indexq]."~".$doclink[$indexq];
			}
			$docresult = implode(">", $arrs);
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
		$t_cond = array("c_id" => $_REQUEST['id']);
		$value   = array(
           'checkpoint'    =>implode(',',$_POST[checkpoint]),
            'video'         =>implode(',',$_POST[video]),
						'form_link'         =>$result,
					/*	'form_name'         =>implode(',',$_POST[formname]),
						'doc_name'         =>implode(',',$_POST[docname]),*/
						'doc_link'         =>$docresult,
            'doc_image'     =>$imagename ,
            'heading'       =>$_POST['heading'],
            'title'         =>$_POST['title'],
			      'cat1'         =>$_POST['catname'],
            'cat2'         =>$_POST['sub_cat_id'],
            'cat3'         =>$_POST['sub_cat_ids'],
            'checklist_link' =>$_POST['checklist_link'],
            'training'       =>$_POST['training'],
            'descript'           =>$_POST['desc']
			);
		if($prop->update($table_name, $value, $t_cond))
		 {
			setcookie("status", "Success", time()+10);
			setcookie("title", "Category Updated Successfully", time()+10);
			setcookie("err", "success", time()+10);
			 header('Location: manage-catdetails.php');
		 }

	 break;
	 case 'modify':
		 $curr_val = $prop->get('*',$table_name, array("c_id"=>$_REQUEST['id']));
		// print_r($curr_val); exit;
		 break;
	 case 'dele':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Categort detail Deleted Successfully", time()+10);
		 setcookie("err", "success", time()+10);
		 header('Location: manage-catdetails.php');

	 break;
	  case 'sts':
		 setcookie("status", "Success", time()+10);
		 setcookie("title", "Categort detail Status Changed Successfully", time()+10);
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
		    <link rel="stylesheet" href="plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />
			  <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <!-- Animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
	    <link href="css/custom.css" rel="stylesheet">
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
	.select2-container-multi .select2-choices {
    border: none;
    margin-top: -8px;
    min-height: 29px !important;
    background: none;
}
	.caret
	{
		display:none;
	}
	div#p_scents p img {
position: absolute;
right: -6px;
top: -8px;
}
div#p_scents p {
float: left;
margin-right: 0px;
position: relative;
}

div#p_scentsv p img {
position: absolute;
right: -6px;
top: -8px;
}
div#p_scentsv p {
float: left;
margin-right: 0px;
position: relative;
}
div#p_scents p label {
width: 100%;
}
div#p_scentsv p label {
width: 100%;
}
.container-fluid .form-group {
margin-bottom: 0;
}
.cat-row button {
        position: absolute;
        right: 7px;
        top: 0;
        padding: 0 16px;
        font-size: 20px;
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
                        <h4 class="page-title">Add Categories</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Add Categories</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Select Categories</h3>
                             <?php $foraction = ($_REQUEST['method']=='' || $_REQUEST['method']=='add')?'add':'update&id='.$_REQUEST['id'].'';?>

                            <form data-toggle="validator" method="post" action="cat-details.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" >
                                       <div class="row">
									     <div class="form-group col-md-4">

										  <?php /*
					  $catsql = "SELECT `category_id`,`category_name`, `category_status` FROM  ".CATEGORY_DOC." WHERE `category_status` NOT IN(1,2) order by category_name ASC";
        $catfet=$prop->getAll_Disp($catsql);
		echo  '<select name="cat1" id="category_filid" class="selectpicker" data-style="form-control" required>
				<option value="">Select Category</option>';
		for($i=0; $i<count($catfet); $i++)
					                    {
		echo  '<option value="'.$catfet[$i]['category_id'].'" '.($catfet[$i]['category_id'] == $curr_val['cat1'] ? "selected":"").' >'.$catfet[$i]['category_name'].'</option>';
		}
		echo  '</select>'; */?>
		 <input type="text" class="form-control placeSelect" id="category_filid" name="catname" value="<?php echo $curr_val['cat1']; ?>" placeholder="Category"/><div class="cat-row"><button type="button" id="catbut"  class="btn btn-success">
    +
</button></div>
		<div class="help-block with-errors"></div>
																																	</div>


<div id="subcat" class="form-group col-md-4" <?php if($curr_val['cat2']=="") { ?> style="display:none;"  <?php } ?>>
	<input type="text" class="form-control placeSelect1" id="sub_cat_id" value="<?php echo $curr_val['cat2']; ?>" name="sub_cat_id" placeholder="Category"/><div class="cat-row"><button type="button" id="scatbut" class="btn btn-success">+</button><button type="button" style="display: block;right: 50px;background: #383b49;border: 1px solid #393c4a;" id="catbutminus" class="btn btn-success">-</button></div>

											 </div>
											 <div class="form-group col-md-4">

											 <div id="subcatdet" <?php if($curr_val['cat3']=="") { ?> style="display:none;"  <?php } ?>>
											 <input type="text" value="<?php echo $curr_val['cat3']; ?>" class="form-control placeSelect2" id="sub_cat_ids" name="sub_cat_ids" placeholder="Category"/>
											 <div class="cat-row">
											 <button type="button" style="display: block;background: #383b49;border: 1px solid #393c4a;" id="scatbutminus" class="btn btn-success">-</button>
											 </div>
											 </div>
											 </div>

										  <div class="clearfix"></div>

                                          <h3 class="box-title" style=" display: block; width: 100%;">Add Banner Section</h3>

                                         <div class="col-md-6">

							<div class="form-group">

                                    <label>Banner Image</label>
                                    <div >
									                <?php
											if(isset($_REQUEST['id']))
										  {
										 ?>
										 <input type="hidden" name="oldimg" value="<?=$curr_val['doc_image'];?>">

                                     <img src="uploads/catdetails/regular/<?=$curr_val['doc_image'];?>" height="100"> <br/>
                                     <input type="file" class="form-control" name="image">
										  <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div><?php */?>

										  <?php } else { ?>
                                          <input type="file" class="form-control" name="image" required>
                                      	  <?php /*?><div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;">
                        <span class="fileinput-new">Select file</span>
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


								<div class="form-group col-md-6" >

								 <label>Main Title</label>
                                                    <div class="input-group">
                                                        <input type="text" required class="form-control" value="<?=$curr_val['heading'];?>" name="heading" placeholder="Heading">
                                                       <div class="help-block with-errors"></div>
                                                    </div>

                                                </div>
												 <h3 class="box-title" style=" display: block; width: 100%;">Add Description</h3>
												<div class="form-group col-md-12">

												 <label >Title</label>
                                                    <div class="input-group">
                                                        <input type="text" required class="form-control" name="title" placeholder="Title" value="<?=$curr_val['title'];?>">
                                                         <div class="help-block with-errors"></div>
                                                    </div>

                                                </div>
											<div class="form-group col-md-12 m-t-10">
										  <label class="col-sm-12">Description</label>
										  <div class="form-group">
                                                    <div class="input-group">
                                           <textarea class="textarea_editor form-control" required style="height:200px;" name="desc" id="desc" rows="15" placeholder="Enter text ..."><?=$curr_val['descript'];?></textarea>
										   </div>
										   <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
<div class="clearfix"></div>
					<h3 class="box-title" style=" display: block; width: 100%;">Add New Forms</h3>
					<div class="form-group col-md-12" >
					<div id="p_scentsvform">
					<?php
					if(isset($_REQUEST['id']))
					{
					$checkarrary = $curr_val['form_link'];
					$point_arrayy = explode(">", $checkarrary);
					$resulty = count($point_arrayy);
					for($i=0;$i<$resulty;$i++)
					{
						$ar = explode("~",$point_arrayy[$i]);

					?>
					<p class="col-sm-6 col-xs-12">
					<label for="p_scntsforms"><input type="text" class="form-control" size="20" name="formname[]" value="<?php echo $ar[0]; ?>" placeholder="Form Name" /> </label>
					<label for="p_scntsforms"><input type="text" class="form-control" size="20" name="formlink[]" value="<?php echo $ar[1]; ?>" placeholder="Form Link" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScntvform"><img src="img/delete.png" class="delicon"></a> <?php } ?>
					</p>

					<?php
					}
					}
					else
					{
					?>
					<p class="col-sm-6 col-xs-12">
					<label for="p_scntsforms"><input type="text" class="form-control" id="p_scnt" size="20" name="formname[]" value="" placeholder="Form Name" /></label>
					<label for="p_scntsforms"><input type="text" class="form-control" id="p_scnt" size="20" name="formlink[]" value="" placeholder="Form Link" /></label>
					</p>
					<?php } ?>
					</div>
					<div class="col-md-12 m-b-10"> <button type="button" id="addScntvform" class="btn btntheme2 pull-right" style="width: 125px;">Add Forms</button></div>
									 <div class="help-block with-errors"></div>
							 </div>

							 <div class="clearfix "></div>

							<h3 class="box-title" style=" display: block; width: 100%;">Add New Document</h3>
																	<div class="form-group col-md-12" >


							<div id="p_scentsvdoc">
								 <?php
							 if(isset($_REQUEST['id']))
							 {
								 $checkarrary = $curr_val['doc_link'];
								 $point_arrayy = explode(">", $checkarrary);
								 $resulty = count($point_arrayy);
								 for($i=0;$i<$resulty;$i++)
								 {
									 $ar = explode("~",$point_arrayy[$i]);
							 ?>
							 <p class="col-sm-6 col-xs-12">
									<label for="p_scntsdoc"><input type="text" class="form-control" size="20" name="docname[]" value="<?php echo $ar[0]; ?>" placeholder="Document Name" /> </label>
									 <label for="p_scntsdoc"><input type="text" class="form-control" size="20" name="doclink[]" value="<?php echo $ar[1]; ?>" placeholder="Document Link" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScntvdoc"><img src="img/delete.png" class="delicon"></a> <?php } ?>
								 </p>

							 <?php
								 }
							 }
							 else
							 {
							?>
								 <p class="col-sm-6 col-xs-12">
									 <label for="p_scntsdoc"><input type="text" class="form-control" id="p_scnt" size="20" name="docname[]" value="" placeholder="Document Name" /></label>
										<label for="p_scntsdoc"><input type="text" class="form-control" id="p_scnt" size="20" name="doclink[]" value="" placeholder="Document Link" /></label>
								 </p>
							 <?php } ?>
								 </div>
									<div class="col-md-12 m-b-10"> <button type="button" id="addScntvdoc" class="btn btntheme2 pull-right" style="width: 125px;">Add Document</button></div>
																		 <div class="help-block with-errors"></div>
																 </div>
                             <h3 class="box-title" style=" display: block; width: 100%;"> Add Checklist Links</h3>
														 <div class="form-group col-md-12" >


				<div id="p_scentsvlist">
					 <?php
				 if(isset($_REQUEST['id']))
				 {
					 $checkarrary = $curr_val['checklist_link'];
					 $point_arrayy = explode(">", $checkarrary);
					 $resulty = count($point_arrayy);
					 for($i=0;$i<$resulty;$i++)
					 {
						 $ar = explode("~",$point_arrayy[$i]);
				 ?>
				 <p class="col-sm-6 col-xs-12">
						<label for="p_scntslist"><input type="text" class="form-control" size="20" name="docname[]" value="<?php echo $ar[0]; ?>" placeholder="Document Name" /> </label>
						 <label for="p_scntslist"><input type="text" class="form-control" size="20" name="doclink[]" value="<?php echo $ar[1]; ?>" placeholder="Document Link" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScntvlist"><img src="img/delete.png" class="delicon"></a> <?php } ?>
					 </p>

				 <?php
					 }
				 }
				 else
				 {
				?>
					 <p class="col-sm-6 col-xs-12">
						 <label for="p_scntslist"><input type="text" class="form-control" id="p_scnt" size="20" name="checkname[]" value="" placeholder="Checklist Name" /></label>
							<label for="p_scntslist"><input type="text" class="form-control" id="p_scnt" size="20" name="checklink[]" value="" placeholder="Checklist Link" /></label>
					 </p>
				 <?php } ?>
					 </div>
						<div class="col-md-12 m-b-10"> <button type="button" id="addScntvlist" class="btn btntheme2 pull-right" style="width: 125px;">Add Checklist</button></div>
															 <div class="help-block with-errors"></div>
													 </div>
													 <h3 class="box-title" style=" display: block; width: 100%;"> Add Training Links</h3>
													 <div class="form-group col-md-12" >


			<div id="p_scentsvtrain">
				 <?php
			 if(isset($_REQUEST['id']))
			 {
				 $checkarrary = $curr_val['checklist_link'];
				 $point_arrayy = explode(">", $checkarrary);
				 $resulty = count($point_arrayy);
				 for($i=0;$i<$resulty;$i++)
				 {
					 $ar = explode("~",$point_arrayy[$i]);
			 ?>
			 <p class="col-sm-6 col-xs-12">
					<label for="p_scntstrain"><input type="text" class="form-control" size="20" name="trainname[]" value="<?php echo $ar[0]; ?>" placeholder="Training Name" /> </label>
					 <label for="p_scntstrain"><input type="text" class="form-control" size="20" name="trainlink[]" value="<?php echo $ar[1]; ?>" placeholder="Training Link" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScntvlist"><img src="img/delete.png" class="delicon"></a> <?php } ?>
				 </p>

			 <?php
				 }
			 }
			 else
			 {
			?>
				 <p class="col-sm-6 col-xs-12">
					 <label for="p_scntstrain"><input type="text" class="form-control" id="p_scnt" size="20" name="checkname[]" value="" placeholder="Training Name" /></label>
						<label for="p_scntstrain"><input type="text" class="form-control" id="p_scnt" size="20" name="checklink[]" value="" placeholder="Training Link" /></label>
				 </p>
			 <?php } ?>
				 </div>
					<div class="col-md-12 m-b-10"> <button type="button" id="addScntvtrain" class="btn btntheme2 pull-right" style="width: 125px;">Add Checklist</button></div>
														 <div class="help-block with-errors"></div>
												 </div>
										   <h3 class="box-title" style=" display: block; width: 100%;">Add New Checkpoint</h3>
                                      <div class="form-group col-md-12" >


										 <div id="p_scents">
										 <?php
											if(isset($_REQUEST['id']))
											{
												$checkarrar = $curr_val['checkpoint'];
												$point_array = explode(",", $checkarrar);
												$result = count($point_array);
												for($i=0;$i<$result;$i++)
												{
											?>
											<p class="col-sm-6 col-xs-12">
													<label for="p_scnts"><input type="text" class="form-control" size="20" name="checkpoint[]" value="<?php echo $point_array[$i]; ?>" placeholder="Checkpoint" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScnt"><img src="img/delete.png" class="delicon"></a> <?php } ?>
												</p>

											<?php
												}
											}
											else
											{
										 ?>
												<p class="col-sm-6 col-xs-12">
													<label for="p_scnts"><input type="text" class="form-control" id="p_scnt" size="20" name="checkpoint[]" value="" placeholder="Checkpoint" /></label>
												</p>
											<?php } ?>
												</div>
												<div class="col-md-12 m-b-10"><button type="button" id="addScnt" class="btn btntheme2 pull-right" style="width: 125px;">Add Checkpoint</button></div>
                                            <div class="help-block with-errors"></div>
                                        </div>
										 <h3 class="box-title" style=" display: block; width: 100%;">Add New Video</h3>
                                         <div class="form-group col-md-12" >


										 <div id="p_scentsv">
												<?php
											if(isset($_REQUEST['id']))
											{
												$checkarrary = $curr_val['video'];
												$point_arrayy = explode(",", $checkarrary);
												$resulty = count($point_arrayy);
												for($i=0;$i<$resulty;$i++)
												{
											?>
											<p class="col-sm-6 col-xs-12">
													<label for="p_scnts"><input type="text" class="form-control" size="20" name="video[]" value="<?php echo $point_arrayy[$i]; ?>" placeholder="Video" /> </label><?php if($i!=0) { ?><a href="javascript:void(0);" id="remScntv"><img src="img/delete.png" class="delicon"></a> <?php } ?>
												</p>

											<?php
												}
											}
											else
											{
										 ?>
												<p class="col-sm-6 col-xs-12">
													<label for="p_scnts"><input type="text" class="form-control" id="p_scnt" size="20" name="video[]" value="" placeholder="Video" /></label>
												</p>
											<?php } ?>
												</div>
												 <div class="col-md-12 m-b-10"> <button type="button" id="addScntv" class="btn btntheme2 pull-right" style="width: 125px;">Add Video</button></div>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="clearfix "></div>


                                        <div class="col-sm-12 m-t-30"><button type="button" class="btn btn-inverse waves-effect waves-light pull-right">Cancel</button><button type="submit" class="btn btn-info waves-effect waves-light pull-right m-r-10">Add</button></div>

                                        </div>

                                    </div>
							</form>


                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->
    <?php include "footer.php" ?>
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
	 <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
		<script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>
		<script>
			CKEDITOR.replace( 'desc', {
				height: 250
			} );
		</script>

<script type="text/javascript">
$('#del').hide();
var c=1;
$('#add').click(function () {
	$('#del').show();
    var table = $(this).closest('table');
    if (table.find('input:text').length < 10) {
        c = c+1;
		table.append('<tr> <td ><div class="row m-0"><div><div class="form-group"><div class="input-group"><input type="text" class="form-control" name="checkpoint[]" placeholder="New Checkpoint"></div></div></div></div> </td></tr>');
    }
});
$('#del').click(function () {
    var table = $(this).closest('table');
    if (table.find('input:text').length > 1) {
		c = c-1;
        table.find('input:text').last().closest('tr').remove();
    }
	if(table.find('input:text').length == 1) {
		$('#del').hide();
	}
});
</script>
<script type="text/javascript">
$('#dels').hide();
var d=1;
$('#adds').click(function () {
	$('#dels').show();
    var table = $(this).closest('table');
    if (table.find('input:text').length < 10) {
        d = d+1;
		table.append('<tr> <td ><div class="row m-0"><div><div class="form-group"><div class="input-group"><input type="text" class="form-control" name="video[]" placeholder="New Video"></div></div></div></div> </td></tr>');
    }
});
$('#dels').click(function () {
    var table = $(this).closest('table');
    if (table.find('input:text').length > 1) {
		d = d-1;
        table.find('input:text').last().closest('tr').remove();
    }
	if(table.find('input:text').length == 1) {
		$('#dels').hide();
	}
});
</script>
<script type="text/javascript">
<?php
if(!isset($_REQUEST[id]))
{
?>
$("#catbutminus").hide();
$("#subcat").hide();
$("#subcatdet").hide();
<?php  } ?>
 $(document).on('click', '#catbut', function() {
       // var cat = $("#category_filid option:selected").val();
		//if(cat==1)
		//{
			$("#catbutminus").show();
			$("#subcat").show();
		//}
		//else{
		//	$("#subcat").hide();
		//	$("#subcatdet").hide();
		//}
    });
	 $(document).on('click', '#catbutminus', function() {
		 $("#subcat").hide();
		 $("#catbutminus").hide();
		 $("#subcatdet").hide();
		 });
		 $(document).on('click', '#scatbut', function() {
		 $("#subcatdet").show();
		 //$("#catbutminus").hide();
		 });
		 $(document).on('click', '#scatbutminus', function() {
		 $("#subcatdet").hide();
		 //$("#catbutminus").hide();
		 });
	$(document).on('change', '#subfilid', function() {

        var cat = $("#subfilid option:selected").val();
		if(cat==1)
		{
			$("#subcatdet").show();
		}
		else{
			$("#subcatdet").hide();
		}
    });
	</script>
  <script>
    $(document).ready(function() {
      //  $('.textarea_editor').wysihtml5();
		var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
       // $('#addScnt').live('click', function() {
			$("#addScnt").click(function() {
                $('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="checkpoint[]" placeholder="Checkpoint" /></label> <a href="javascript:void(0);" id="remScnt"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDiv);
                i++;
                return false;
        });
       // $("#remScnt").click(function() {
			$(document).on("click", "#remScnt", function() {
			//alert('dfdf');
        //$('#remScnt').live('click', function() {

                        $(this).parents('p').remove();
                        i--;

                return false;
        });



		var scntDivv = $('#p_scentsv');
        var i = $('#p_scentsv p').size() + 1;
       // $('#addScnt').live('click', function() {
			$("#addScntv").click(function() {
                $('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="video[]" value="" placeholder="Video" /></label> <a href="javascript:void(0);" id="remScntv"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDivv);
                i++;
                return false;
        });
       // $("#remScnt").click(function() {
			$(document).on("click", "#remScntv", function() {
			//alert('dfdf');
        //$('#remScnt').live('click', function() {

                        $(this).parents('p').remove();
                        i--;

                return false;
        });



		var scntDivvs = $('#p_scentsvform');
        var is = $('#p_scentsvform p').size() + 1;
       // $('#addScnt').live('click', function() {
			$("#addScntvform").click(function() {
                $('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="formname[]" value="" placeholder="Form Name" /></label><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="formlink[]" value="" placeholder="Form Link" /></label> <a href="javascript:void(0);" id="remScntvform"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDivvs);
                is++;
                return false;
        });
       // $("#remScnt").click(function() {
			$(document).on("click", "#remScntvform", function() {
			//alert('dfdf');
        //$('#remScnt').live('click', function() {

                        $(this).parents('p').remove();
                        is--;

                return false;
        });
//Start document
				var scntDivvsm = $('#p_scentsvdoc');
						var ism = $('#p_scentsvdoc p').size() + 1;
					 // $('#addScnt').live('click', function() {
					$("#addScntvdoc").click(function() {
										$('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="docname[]" value="" placeholder="Document Name" /></label><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="doclink[]" value="" placeholder="Document link" /></label> <a href="javascript:void(0);" id="remScntvdoc"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDivvsm);
										ism++;
										return false;
						});
					 // $("#remScnt").click(function() {
					$(document).on("click", "#remScntvdoc", function() {
					//alert('dfdf');
						//$('#remScnt').live('click', function() {

														$(this).parents('p').remove();
														ism--;

										return false;
						});

						//End
						//Start list
										var scntDivvsmd = $('#p_scentsvlist');
												var ismd = $('#p_scentsvlist p').size() + 1;
											 // $('#addScnt').live('click', function() {
											$("#addScntvlist").click(function() {
																$('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="checkname[]" value="" placeholder="Checklist Name" /></label><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="checklink[]" value="" placeholder="Checklist link" /></label> <a href="javascript:void(0);" id="remScntvlist"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDivvsmd);
																ismd++;
																return false;
												});
											 // $("#remScnt").click(function() {
											$(document).on("click", "#remScntvlist", function() {
											//alert('dfdf');
												//$('#remScnt').live('click', function() {

																				$(this).parents('p').remove();
																				ismd--;

																return false;
												});

												//End

												//Start list
																var scntDivvsml = $('#p_scentsvtrain');
																		var ismdn = $('#p_scentsvtrain p').size() + 1;
																	 // $('#addScnt').live('click', function() {
																	$("#addScntvtrain").click(function() {
																						$('<p class="col-sm-6 col-xs-12"><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="trainname[]" value="" placeholder="Training Name" /></label><label for="p_scnts"><input type="text" id="p_scnt" class="form-control" size="20" name="trainlink[]" value="" placeholder="Training link" /></label> <a href="javascript:void(0);" id="remScntvtrain"><img src="img/delete.png" class="delicon"></a></p>').appendTo(scntDivvsml);
																						ismdn++;
																						return false;
																		});
																	 // $("#remScnt").click(function() {
																	$(document).on("click", "#remScntvtrain", function() {
																	//alert('dfdf');
																		//$('#remScnt').live('click', function() {

																										$(this).parents('p').remove();
																										ismdn--;

																						return false;
																		});

																		//End
  });

$('.placeSelect').select2({
    tags: true,
	 selectOnClose: true,
    tokenSeparators: [','],
    createSearchChoice: function (term) {
        return {
            id: $.trim(term),
            text: $.trim(term)+ ' (new)'
        };
    },

    ajax: {
        url: 'ajax.php',
        dataType: 'json',
        data: function(term, page) {
            return {
                q: term,
				meth:"queryjs"
            };
        },

        results: function(data, page) {
            return {
                results: data
            };
        }
    },

    // Take default tags from the input value
    initSelection: function (element, callback) {
        var data = [];

        function splitVal(string, separator) {
            var val, i, l;
            if (string === null || string.length < 1) return [];
            val = string.split(separator);
            for (i = 0, l = val.length; i < l; i = i + 1) val[i] = $.trim(val[i]);
            return val;
        }

        $(splitVal(element.val(), ",")).each(function () {
            data.push({
                id: this,
                text: this
            });
        });

        callback(data);
    },

    // Some nice improvements:

    // max tags is 3
    maximumSelectionSize: 1,

    // override message for max tags
    formatSelectionTooBig: function (limit) {
        return "category limit is only  " + limit;
    }
});
//$('.placeSelect').on("change", function(e){
	$(document).on('change', '.placeSelect', function(e) {
    if (e.added) {
        if (/ \(new\)$/.test(e.added.text)) {
           // A new tag was added
           // Prompt the user
           var response = confirm("Do you want to add the new Category "+e.added.id+"?");

           if (response == true) {
              // User clicked OK
             // console.log("Sending the tag to the server");
              $.ajax({
                   type: "POST",
                   url: 'ajax.php',
                   data: {id: e.added.id, meth: "addnewpro"},
                   success: function () {
                     // alert("error");
                   }
               });
           } else {
                // User clicked Cancel
               // console.log("Removing the tag");
                var selectedTags = $(".placeSelect").select2("val");
                var index = selectedTags.indexOf(e.added.id);
                selectedTags.splice(index,1);
                if (selectedTags.length == 0) {
                    $(".placeSelect").select2("val","");
                } else {
                    $(".placeSelect").select2("val",selectedTags);
                }
           }
        }
    }
});
/* second */
$('.placeSelect1').select2({
    tags: true,
	 selectOnClose: true,
    tokenSeparators: [','],
    createSearchChoice: function (term) {
        return {
            id: $.trim(term),
            text: $.trim(term)+ ' (new)'
        };
    },

    ajax: {
        url: 'ajax.php',
        dataType: 'json',
        data: function(term, page) {
            return {
                q: term,
				meth:"queryjs1"
            };
        },

        results: function(data, page) {
            return {
                results: data
            };
        }
    },

    // Take default tags from the input value
    initSelection: function (element, callback) {
        var data = [];

        function splitVal(string, separator) {
            var val, i, l;
            if (string === null || string.length < 1) return [];
            val = string.split(separator);
            for (i = 0, l = val.length; i < l; i = i + 1) val[i] = $.trim(val[i]);
            return val;
        }

        $(splitVal(element.val(), ",")).each(function () {
            data.push({
                id: this,
                text: this
            });
        });

        callback(data);
    },

    // Some nice improvements:

    // max tags is 3
    maximumSelectionSize: 1,

    // override message for max tags
    formatSelectionTooBig: function (limit) {
        return "only  " + limit;
    }
});
//$('.placeSelect').on("change", function(e){
	$(document).on('change', '.placeSelect1', function(e) {
    if (e.added) {
        if (/ \(new\)$/.test(e.added.text)) {
           // A new tag was added
           // Prompt the user
           var response = confirm("Do you want to add the new Subcategory "+e.added.id+"?");

           if (response == true) {
              // User clicked OK
             // console.log("Sending the tag to the server");
              $.ajax({
                   type: "POST",
                   url: 'ajax.php',
                   data: {id: e.added.id, meth: "addnewprosub"},
                   success: function () {
                     // alert("error");
                   }
               });
           } else {
                // User clicked Cancel
               // console.log("Removing the tag");
                var selectedTags = $(".placeSelect1").select2("val");
                var index = selectedTags.indexOf(e.added.id);
                selectedTags.splice(index,1);
                if (selectedTags.length == 0) {
                    $(".placeSelect1").select2("val","");
                } else {
                    $(".placeSelect1").select2("val",selectedTags);
                }
           }
        }
    }
});
/* end second */
/* second */
$('.placeSelect2').select2({
    tags: true,
	 selectOnClose: true,
    tokenSeparators: [','],
    createSearchChoice: function (term) {
        return {
            id: $.trim(term),
            text: $.trim(term)+ ' (new)'
        };
    },

    ajax: {
        url: 'ajax.php',
        dataType: 'json',
        data: function(term, page) {
            return {
                q: term,
				meth:"queryjs2"
            };
        },

        results: function(data, page) {
            return {
                results: data
            };
        }
    },

    // Take default tags from the input value
    initSelection: function (element, callback) {
        var data = [];

        function splitVal(string, separator) {
            var val, i, l;
            if (string === null || string.length < 1) return [];
            val = string.split(separator);
            for (i = 0, l = val.length; i < l; i = i + 1) val[i] = $.trim(val[i]);
            return val;
        }

        $(splitVal(element.val(), ",")).each(function () {
            data.push({
                id: this,
                text: this
            });
        });

        callback(data);
    },

    // Some nice improvements:

    // max tags is 3
    maximumSelectionSize: 1,

    // override message for max tags
    formatSelectionTooBig: function (limit) {
        return "only  " + limit;
    }
});
//$('.placeSelect').on("change", function(e){
	$(document).on('change', '.placeSelect2', function(e) {
    if (e.added) {
        if (/ \(new\)$/.test(e.added.text)) {
           // A new tag was added
           // Prompt the user
           var response = confirm("Do you want to add the third Subcategory "+e.added.id+"?");

           if (response == true) {
              // User clicked OK
             // console.log("Sending the tag to the server");
              $.ajax({
                   type: "POST",
                   url: 'ajax.php',
                   data: {id: e.added.id, meth: "addnewprosub"},
                   success: function () {
                     // alert("error");
                   }
               });
           } else {
                // User clicked Cancel
               // console.log("Removing the tag");
                var selectedTags = $(".placeSelect2").select2("val");
                var index = selectedTags.indexOf(e.added.id);
                selectedTags.splice(index,1);
                if (selectedTags.length == 0) {
                    $(".placeSelect2").select2("val","");
                } else {
                    $(".placeSelect2").select2("val",selectedTags);
                }
           }
        }
    }
});
    </script>

</body>

</html>
