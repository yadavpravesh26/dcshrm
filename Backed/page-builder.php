<?php

require_once('../config.php');

require_once(DOC_CONFIG.'inc/pdoconfig.php');

require_once(DOC_CONFIG.'inc/pdoFunctions.php');

require_once('inc/img_resize.php');

$cdb = new DB();

$db = $cdb->getDb();

$prop = new PDOFUNCTION($db);

$table_name = "pages";

if(bckPermission($session['b_type'])){

	header('location:dashboard.php');

	exit;

}
$update_id = '';
$method = '';

if(isset($_POST['btnDataSubmit']) and $_REQUEST['method']=='add')
{
	$update_id = $_POST['draft_id'];
	$method = 'update';
}
else if($_REQUEST['method']!='' and isset($_POST['btnDataSubmit']))
{
	$method = 'update';
}

switch($method)
{

	 case 'update':

		$dir = "uploads/catdetails/";

			$iname = $_REQUEST['oldimg'];

			if($iname =='')

			{

				$iname1 = time();

			}else{

				$ext = explode(".",$iname);

				$iname1 = $ext[0];

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


		if($update_id=='')
		$t_cond = array("p_id" => $_REQUEST['id']);
		else
		$t_cond = array("p_id" => $update_id);
		



		if($_POST['training']!="")

			{

			$training  = implode(",",$_POST['training']);

			}

			else {

				$training  = "emp";

			}

			if($_POST['quiz']!="")

			{

			$quiz  = implode(",",$_POST['quiz']);

			}

			else {

				$quiz  = "emp";

			}

			if($_POST['images']!="")

			{

			$images = implode(",",$_POST['images']);

			}

			else {

				$images  = "emp";

			}

			if($_POST['videos']!="")

			{

			$videos = implode(",",$_POST['videos']);

			}

			else {

				$videos  = "emp";

			}

			if($_POST['handout']!="")

			{

			$handout = implode(",",$_POST['handout']);

			}

			else {

				$handout  = "emp";

			}



		$value   = array(

			'title'         =>$_POST['title'],

			'meta_title'         =>$_POST['mtitle'],

			'meta_desc'         =>$_POST['mdesctt'],

			'ban_title'     =>$_POST['btitle'] ,

			'ban_sub_title'       =>$_POST['bsubtitle'],

			'ban_image'         =>$imagename,

			'ban_alt_title'         =>$_POST['balttitle'],

			'descript'         =>$_POST['desc'],

			'trainings'		=>$training,

			'quiz'			=>$quiz,

			'images'		=>$images,

			'videos'		=> $videos,

			'handout'		=>$handout,

			'category' => $_POST['cat1'],
			
			'page_status' => 0

			);



		if($prop->update($table_name, $value, $t_cond))

		 {

			setcookie("status", "Success", time()+10);

			if($update_id=='')
			setcookie("title", "BeSafe Program Updated Successfully", time()+10);
			else
			setcookie("title", "BeSafe Program Created Successfully", time()+10);
			

			setcookie("err", "success", time()+10);

			header('Location: manage-new-page.php');

		 }else{

			setcookie("status", "Error", time()+10);

            if($update_id=='')
			setcookie("title", "Besafe Program Updated Error", time()+10);
			else
			setcookie("title", "Besafe Program Created Error", time()+10);
			

            setcookie("err", "error", time()+10);

			header('Location: page-builder.php?method=modify&id='.$_REQUEST['id']);

		}



	 break;

}

$titleTag = 'Add';

if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){

	$titleTag = 'Edit';

	$curr_val = $prop->get('*',$table_name, array("p_id"=>$_REQUEST['id']));

	if(empty($curr_val)){

		header('Location: manage-new-page.php');

		exit;

	}

}

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

        <title>Page Builder</title>

        <!-- Bootstrap Core CSS -->

        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">

        <!-- Footable CSS -->

        <link href="plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">

        <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

        <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

        <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />

        <link href="plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />

        <link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />

        <link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />

		<!--alerts CSS -->

		<link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

        <!-- Menu CSS -->

        <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">

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

        <style>

            .add.pull-right {

                cursor: pointer;

            }

            

            .file-box td {

                height: 73px !important;

                vertical-align: middle;

                text-overflow: ellipsis;

                /* white-space: nowrap; */

            }

            

            span.input-group-addon.btn.btn-default.btn-file {

                width: 100px;

                margin: -3px -2px;

                padding: 10px 0;

            }

            

            .navigation ul li:first-child:before {

                top: 0;

            }

            

            .navigation ul li {

                position: relative;

                list-style: none;

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

            

            .navigation ul li:after,

            .navigation ul li:before {

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

            

            .navigation ul li:after,

            .navigation ul li:before {

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

            

            .footable-row-detail-name {

                display: table-cell;

                font-weight: 500;

                padding-right: 3px;

                padding-bottom: 5px;

                /* display: none; */

            }

            

            .footable-row-detail-inner {

                width: 100%;

            }

            

            .wid100 {

                width: 100%

            }

            

            .file-box {

                border: 1px dashed #c0dbfc;

                padding: 10px 10px 0;

                border-radius: 6px;

            }

            

            h3.m-t-0.m-b-10 {

                background: #429aec;

                overflow: hidden;

                padding: 7px 23px 7px 15px;

                margin-bottom: -10px !important;

                color: #fff;

            }

            

            .white-box h3.box-title {

                background: #2196f3 !important;

                height: 40px;

                margin-top: 0px !important;

                margin-right: 0px !important;

                margin-bottom: 15px !important;

                margin-left: 0px !important;

                padding: 0 15px !important;

                align-items: center;

                display: flex;

                color: #ffffff;

                /* width: 109%; */

            }

            

            th {

                color: #355981 !important;

            }

            

            thead {

                background: #ffffff !important;

                color: #ffffff;

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

                                    <h4 class="page-title">Page Builder</h4> </div>

                                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                                    <ol class="breadcrumb">

                                        <li><a href="dashboard.php">Dashboard</a></li>

                                        <li class="active">Page Builder</li>

                                    </ol>

                                </div>

                                <!-- /.col-lg-12 -->

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="white-box">

                                        <h3 class="box-title">	

										<?php echo $titleTag; ?> Category Page</h3>



											<?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');?>



                                            <form data-toggle="validator" method="post" action="page-builder.php?method=<?php echo $foraction; ?>" enctype="multipart/form-data" id='cateForm'>

                                                <div class="row">

                                                    <div class="form-group col-md-4">

                                                        <label for="exampleInputuname">Select Category</label>
														<input type="hidden" name="meth" value="auto-save-draft" />
                                                        <input type="hidden" name="draft_id" id="draft_id" value="<?=$curr_val['p_id'];?>" />
                                                        <?php 
															if(!isset($curr_val['page_status']))
															$page_status = 1;
															else
															$page_status = $curr_val['page_status'];
														?>
                                                        <input type="hidden" name="page_status" value="<?php echo $page_status;?>" />
                                                        <select class="form-control select2" id="select-maincategory" name="maincat1">
                                                            <option value=''>Select Category</option>
                                                            <?php
															$first_cat='';
															$mod_cat_id = '';
                                                            $catfets =  "SELECT * FROM cats WHERE status=0";
															$rowcat=$prop->getAll_Disp($catfets);
															if(isset($curr_val[category]) and $curr_val[category] != '')
															{
																$sql =  "SELECT * FROM cat_sub WHERE status=0 AND c_id=$curr_val[category]";
																//echo $sql;
																$mod_cat = $prop->getAll_Disp($sql);
																$mod_cat_id = $mod_cat[0][c_name];
																//echo $mod_cat_id;
															}
															for($i=0; $i<count($rowcat); $i++)
															{
																if($i==0)
																$first_cat = $rowcat[$i]['c_id'];
															?>
																<option value="<?php echo $rowcat[$i]['c_id']; ?>"
                                                                <?php 
																	if($mod_cat_id != '' and $mod_cat_id == $rowcat[$i]['c_id'])
																	{
																		echo "selected";
																	}
																?>>
                                                                	<?php echo $rowcat[$i]['c_name']; ?>
                                                                </option>
															<?php }
															?>
                                                        </select>

                                                        <div class="help-block with-errors"></div>

                                                    </div>
                                                    <div class="form-group col-md-4">

                                                        <label for="exampleInputuname">Select Sub Category</label>
														<div id="get_selectet_subcat">
                                                        <select class="form-control select2 select_sub_cat" id="select-category" name="cat1">
                                                            <option value=''>Select Sub Category</option>
                                                            <?php
															if($mod_cat_id != '')
															$first_cat = $mod_cat_id;
                                                            $catfetsub =  "SELECT * FROM cat_sub WHERE c_name='". $first_cat ."' AND status=0";												$rowcatub=$prop->getAll_Disp($catfetsub);

															for($di=0; $di<count($rowcatub); $di++)
															 {
			
															?>
			
																					<option value="<?php echo $rowcatub[$di]['c_id']; ?>" <?php if ($rowcatub[$di][ 'c_id']==$curr_val[category]) { echo "selected"; } ?>>
			
																						<?php echo $rowcatub[$di]['sc_name']; ?>
			
																					</option>
			
																					<?php } ?>
                                                        </select>
														</div>
                                                        

                                                        <div class="help-block with-errors"></div>

                                                    </div>
                                                    <div class="clearfix"></div>

                                                    <div class="form-group col-md-4">

                                                        <label for="exampleInputuname">Page Title</label>



                                                        <div class="input-group">



                                                            <input type="text" class="form-control" id="exampleInputuname" placeholder="Page Title" name="title" value="<?=$curr_val['title'];?>" required>

                                                        </div>

                                                        <div class="help-block with-errors"></div>

                                                    </div>

                                                    <div class="form-group col-md-6">

                                                        <label for="exampleInputuname">Meta Title</label>



                                                        <div class="input-group">



                                                            <input type="text" class="form-control" name="mtitle" value="<?=$curr_val['meta_title'];?>" id="exampleInputuname" placeholder="Meta Title" required>

                                                        </div>

                                                        <div class="help-block with-errors"></div>

                                                    </div>

                                                    <div class="form-group col-md-6">

                                                        <label for="exampleInputuname">Meta Description</label>



                                                        <div class="input-group">

                                                            <textarea class="form-control" name="mdesctt" placeholder="Meta Description" rows="2">

                                                                <?=$curr_val['meta_desc'];?>

                                                            </textarea>



                                                        </div>

                                                        <div class="help-block with-errors"></div>

                                                    </div>

                                                    <!-- Banner Section -->

                                                    <section class="wid100">

                                                        <h3 class="box-title col-sm-12" style="margin: 0 0 15px !important; margin-top: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px;">Banner Image</h3>

                                                        <div class="clearfix"></div>

                                                        <div class="form-group col-md-4">

                                                            <label for="exampleInputuname">Banner Title</label>



                                                            <div class="input-group">



                                                                <input type="text" class="form-control" name="btitle" value="<?=$curr_val['ban_title'];?>" id="exampleInputuname" placeholder="Banner Title" required>

                                                            </div>

                                                            <div class="help-block with-errors"></div>

                                                        </div>

                                                        <?php /*?><div class="form-group col-md-6">

                                                            <label for="exampleInputuname">Banner Subtitle</label>



                                                            <div class="input-group">



                                                                <input type="text" class="form-control" name="bsubtitle" value="<?=$curr_val['ban_sub_title'];?>" id="exampleInputuname" placeholder="Banner Subtitle" required>

                                                            </div>

                                                            <div class="help-block with-errors"></div>

                                                        </div><?php */?>

                                                        <div class="form-group col-md-4">

                                                            <label for="exampleInputuname">Banner Image Alt Title</label>



                                                            <div class="input-group">



                                                                <input type="text" class="form-control" name="balttitle" value="<?=$curr_val['ban_alt_title'];?>" id="exampleInputuname" placeholder="Banner Image Alt Title" required>

                                                            </div>

                                                            <div class="help-block with-errors"></div>

                                                        </div>
                                                        
                                                        <div class="form-group col-md-4">

                                                            <label>Image upload</label>

                                                            <div>

                                                                <?php

													if(isset($_REQUEST['id']))

												  {

												 ?>

                                                                    <input type="hidden" name="oldimg" value="<?=$curr_val['ban_image'];?>">

                                                                    
                                                                    <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="image">
																	<img src="uploads/catdetails/<?=$curr_val['ban_image'];?>" height="100%" width="50%">

                                                                    <br/>


                                                                    <?php } else { ?>

                                                                        <!--<div class="fileinput fileinput-new input-group" data-provides="fileinput">

                                                                            <div class="form-control" data-trigger="fileinput">

                                                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>

                                                                                <span class="fileinput-filename"></span>

                                                                            </div>

                                                                            <span class="input-group-addon btn btn-default btn-file" style="width: 100px;margin-top: 0;height: 32px !important;display: inline-block;float: right; margin:0 !important">

													 <span class="fileinput-new">Select file</span>

                                                                            <span class="fileinput-exists">Change</span>

                                                                            <input type="file" name="image" required>

                                                                            </span>

                                                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" style="  float: right; height:32px; ">Remove</a>

                                                                        </div>-->
																		<input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="image" required>
                                                                        <div class="help-block with-errors"></div>

                                                                        <?php }  ?>



                                                            </div>

                                                        </div>

                                                        

                                                    </section>

                                                    <!-- Banner Section ends -->

                                                    <!-- Page Content starts -->

                                                    <section class="wid100">

                                                        <h3 class="box-title col-sm-12" style="margin: 0 0 15px !important; margin-top: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px;">Page Content</h3>

                                                        <div class="clearfix"></div>



                                                        <div class="col-sm-12">



                                                            <form method="post">

                                                                <textarea id="mymce" name="desc">

                                                                    <?=$curr_val['descript'];?>

                                                                </textarea>

                                                            </form>



                                                        </div>



                                                    </section>

                                                    <!-- Page Content ends -->



                                                    <!-- Content linking starts -->

                                                    <section class="wid100 m-t-30">

                                                        <h3 class="box-title col-sm-12" style="margin: 0 0 15px !important; margin-top: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px;">Files</h3>

                                                        <div class="clearfix"></div>


                                                        <div class="col-sm-6 col-md-6 m-b-30">

                                                            <div class="file-box">

                                                                <h3 class="m-t-0 m-b-10" style="background: #348253;"><div class="title pull-left">Handouts</div><div class="add pull-right" data-toggle="modal" data-target="#myModalHand" ><img data-toggle="tooltip" data-original-title="Add Handouts"  src="img/add-file-button.png"></div></h3>

                                                                <div class="clearfix m-b-10"></div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Title</th>



                                                                                <th class="text-nowrap" style=" width: 70px; ">Action</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="addmorehand">

                                                                            <?php

																		if(isset($_REQUEST[id]))

																		{

																			if($curr_val['handout']!="emp")

																			{

																	$exp =	explode(",",$curr_val['handout']);

																	$loocount =  count($exp);

																		// Perform queries



																	for($i=0; $i<$loocount; $i++)

																		 {

																			$row=$prop->get_Disp("SELECT doc_name FROM handouts WHERE doc_type=1 AND doc_status=0 AND doc_id=".$exp[$i]."");
																			if($row[doc_name] != '')
																			{

																	?>

                                                                                <tr id="row-hand<?php echo $exp[$i];?>">

                                                                                    <input type="hidden" name="handout[]" value="<?php echo $exp[$i];?>">

                                                                                    <td>

                                                                                        <?php echo $row[doc_name];?>

                                                                                    </td>

                                                                                    <td class="text-nowrap text-center">

                                                                                        <a href="javascript:void(0);" rel="row-hand<?php echo $exp[$i];?>" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>

                                                                                    </td>

                                                                                </tr>

                                                                                <?php } }  }  } ?>

                                                                        </tbody>

                                                                    </table>

                                                                </div>



                                                            </div>



                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-md-6 m-b-30">

                                                            <div class="file-box">

                                                                <h3 class="m-t-0 m-b-10"><div class="title pull-left">Training</div><div class="add pull-right" data-toggle="modal" data-target="#myModalTraining" ><img data-toggle="tooltip" data-original-title="Add Training"  src="img/add-file-button.png"></div></h3>

                                                                <div class="clearfix m-b-10"></div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Title</th>



                                                                                <th class="text-nowrap" style=" width: 70px; ">Action</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="addmoretraining">



																	<?php

																	if(isset($_REQUEST[id]))

																	{

																		if($curr_val['trainings']!="emp")

																		{

																			$exp =	explode(",",$curr_val['trainings']);

																			$loocount =  count($exp);

																			for($i=0; $i<$loocount; $i++)

																			{

																				$row=$prop->get_Disp("SELECT doc_name FROM docs WHERE doc_type=2 AND doc_status=0 AND doc_id=".$exp[$i]."");

																				if(!empty($row)){

																		?>

																		<tr id="row-train<?php echo $exp[$i];?>">

																			<input type="hidden" name="training[]" value="<?php echo $exp[$i];?>">

																			<td>

																				<?php echo $row[doc_name];?>

																			</td>

																			<td class="text-nowrap text-center">

																				<a href="javascript:void(0);" rel="row-train<?php echo $exp[$i];?>" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>

																			</td>

																		</tr>

																		<?php 

																				}

																			}  

																		}  

																	} ?>

                                                                        </tbody>

                                                                    </table>

                                                                </div>



                                                            </div>



                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-md-6 m-b-30">

                                                            <div class="file-box">

                                                                <h3 class="m-t-0 m-b-10" style="background:#ec42ac;"><div class="title pull-left">Quiz</div><div class="add pull-right" data-toggle="modal" data-target="#myModalQuiz"><img data-toggle="tooltip" data-original-title="Add Quiz" src="img/add-file-button.png"></div></h3>

                                                                <div class="clearfix m-b-10"></div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Title</th>



                                                                                <th class="text-nowrap" style=" width: 70px; ">Action</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="addmorequiz">

                                                                        <?php

																		if(isset($_REQUEST[id]))

																		{

																			if($curr_val['quiz']!="emp")

																			{

																		$exp =	explode(",",$curr_val['quiz']);

																		$loocount =  count($exp);

																		

																		for($i=0; $i<$loocount; $i++)

																		{

																			$row=$prop->get_Disp("SELECT d_template_name FROM dynamic_form WHERE form_type=0 AND d_detele_status=0 AND d_form_id=".$exp[$i]."");
																			if($row['d_template_name'] != '')
																			{

																		?>

																					<tr id="row-quiz<?php echo $exp[$i];?>">

																						<input type="hidden" name="quiz[]" value="<?php echo $exp[$i];?>">

																						<td>

																							<?php echo $row['d_template_name'];?>

																						</td>

																						<td class="text-nowrap text-center">

																							<a href="javascript:void(0);" rel="row-quiz<?php echo $exp[$i];?>" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>

																						</td>

																					</tr>

																					<?php } }  } } ?>

                                                                        </tbody>

                                                                    </table>

                                                                </div>



                                                            </div>



                                                        </div>



                                                        <?php /*?><div class="col-sm-6 col-md-6 m-b-30">

                                                            <div class="file-box">

                                                                <h3 class="m-t-0 m-b-10" style="background: #688a86;"><div class="title pull-left">Images</div><div class="add pull-right" data-toggle="modal" data-target="#myModalImages"><img  data-toggle="tooltip" data-original-title="Add Images"  src="img/add-file-button.png"></div></h3>

                                                                <div class="clearfix m-b-10"></div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Title</th>



                                                                                <th class="text-nowrap" style=" width: 70px; ">Action</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="addmoreimages">

                                                                        <?php

																			if(isset($_REQUEST[id]))


																			{

																				if($curr_val['images']!="emp")

																				{

																					$exp =	explode(",",$curr_val['images']);

																					$loocount =  count($exp);

																					for($i=0; $i<$loocount; $i++)

																					{

																						$row=$prop->get_Disp("SELECT doc_name FROM docs WHERE doc_type=4 AND doc_status=0 AND doc_id=".$exp[$i]."");

																		

																				?>

																				<tr id="row-img<?php echo $exp[$i];?>">

																					<input type="hidden" name="images[]" value="<?php echo $exp[$i];?>">

																					<td>

																						<?php echo $row[doc_name];?>

																					</td>

																					<td class="text-nowrap text-center">

																						<a href="javascript:void(0);" rel="row-img<?php echo $exp[$i];?>" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>

																					</td>

																				</tr>

																				<?php 

																					}  

																				}  

																			} ?>

                                                                        </tbody>

                                                                    </table>

                                                                </div>



                                                            </div>



                                                        </div><?php */?>

                                                        <div class="col-sm-6 col-md-6 m-b-30">

                                                            <div class="file-box">

                                                                <h3 class="m-t-0 m-b-10" style="background: #345982;"><div class="title pull-left">Videos </div><div class="add pull-right" data-toggle="modal" data-target="#myModalVideos" ><img data-toggle="tooltip" data-original-title="Add Videos"  src="img/add-file-button.png"></div></h3>

                                                                <div class="clearfix m-b-10"></div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Title</th>



                                                                                <th class="text-nowrap" style=" width: 70px; ">Action</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="addmorevideos">

                                                                            <?php

																		if(isset($_REQUEST[id]))

																		{

																			if($curr_val['videos']!="emp")

																			{

																	$exp =	explode(",",$curr_val['videos']);

																	$loocount =  count($exp);

																	

																	for($i=0; $i<$loocount; $i++)

																	{

																			$row=$prop->get_Disp("SELECT doc_name FROM docs WHERE doc_type=3 AND doc_status=0 AND doc_id=".$exp[$i]."");
																			if($row[doc_name] != '')
																			{

																	?>

                                                                                <tr id="row-vid<?php echo $exp[$i];?>">

                                                                                    <input type="hidden" name="videos[]" value="<?php echo $exp[$i];?>">

                                                                                    <td>

                                                                                        <?php echo $row[doc_name];?>

                                                                                    </td>

                                                                                    <td class="text-nowrap text-center">

                                                                                        <a href="javascript:void(0);" rel="row-vid<?php echo $exp[$i];?>" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>

                                                                                    </td>

                                                                                </tr>

                                                                                <?php } }  }  } ?>

                                                                        </tbody>

                                                                    </table>

                                                                </div>



                                                            </div>



                                                        </div>

														



                                                        



                                                    </section>

                                                    <!-- Content linking ends -->



                                                    <div class="clearfix"></div>

                                                    <div class="col-sm-12">

                                                        <a href="manage-new-page.php" class="btn btn-inverse waves-effect waves-light pull-right" style="padding-top:7px;">Cancel</a>

                                                        <button type="submit" class="btn btn-success waves-effect waves-light pull-right m-r-10" name="btnDataSubmit">

                                                            <?php

				if(isset($_REQUEST['id']) and $curr_val['page_status'] != 1)

				{

			 ?> Update

                                                                <?php } else { ?> Add

                                                                    <?php } ?>

                                                        </button>

                                                    </div>



                                                </div>



                                    </div>

                                    </form>



                                </div>

                            </div>



                        </div>

                        <!-- /.container-fluid -->

                        <?php include "footer.php" ?>

                    </div>
					<div id="alert_draft" style="position:fixed; right:10px; top:10px;z-index:999999"></div>
                    <!-- /#page-wrapper -->



        </div>

        <!-- sample modal content -->

        <div id="myModalHand" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add Handouts</h4> </div>

                    	<form method="post" id="ajaxHandForm">
                            <div class="modal-body">
                                <?php
									$videocategory_id = '';
									$subcategory_id = '';
									if(isset($curr_val[category]))
									{
										$catfetsub =  "SELECT * FROM cat_sub WHERE c_id='". $curr_val[category]."' AND status=0";
										$rowcatub=$prop->getAll_Disp($catfetsub);
										$rowcatub=$prop->getAll_Disp($catfetsub);
										for($di=0; $di<count($rowcatub); $di++)
										{
											$videocategory_id = $rowcatub[$di]['c_name'];
											$subcategory_id = $curr_val[category];
										}
									}	
								?>
								<input type="hidden" name="catId" id="catId" class="CatId" value="<?php echo $videocategory_id?>">
								<input type="hidden" name="subCatID" id="subCatID" class="SubCatId" value="<?php echo $subcategory_id?>">
                                <input type="hidden" name="meth" id="meth" value="ajaxsaveHand">
                                <label for="document_name">Choose a existing Handout</label>
                                <div class="form-group">
                                	<select name="exist_handout" id="exist_handout" class="form-control select2" style="width:100%">
                                    	<option value="">Seletct Hand Out</option>
                                        <?php
                                        $sql_hand_out = 'select * from handouts where `doc_status`!=2';
										$row_hand_out = $prop->getAll_Disp($sql_hand_out);
										for($di=0; $di<count($row_hand_out); $di++)
										{?>
										<option value="<?php echo $row_hand_out[$di][doc_id]; ?>"><?php echo $row_hand_out[$di][doc_name];?></option>
										<?php }
										?>
                                    </select>
                                </div>
                                <p style="text-align:center; margin-top:15px;">OR</p>
                                <label for="document_name">Handout Title</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="document_name" id="document_name" placeholder="Title">
                                </div>
                                <div class="help-block with-errors"></div>      
                                <label for="exampleInputuname">Upload Document</label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" id="doc_file">
                                </div>
                            </div>
    
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Add</button>
                            </div>
						</form>
                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->



        <!-- sample modal form content -->

        <div id="myModalQuiz" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add Quiz</h4> 

					</div>

                        <?php /*?><select class="select2 select2-multiple select-quiz" id="addquiz" multiple="multiple" data-placeholder="Choose">

                        <?php

						if($curr_val['category']!='' && $curr_val['category']>0){

							$catfetdoc =  "SELECT d_form_id,d_template_name FROM dynamic_form WHERE form_type=0 AND d_detele_status=0 AND scat_id=".$curr_val['category'];

							$rowdoc=$prop->getAll_Disp($catfetdoc);

							for($i=0; $i<count($rowdoc); $i++)

							{

								echo '<option value="'.$rowdoc[$i][d_form_id].'">'.$rowdoc[$i][d_template_name].'</option>';

							}

						}

						?>

                        </select><?php */?>
                        <form method="post" id="ajaxQuizForm">
                            <div class="modal-body">
                                <?php
									$videocategory_id = '';
									$subcategory_id = '';
									if(isset($curr_val[category]))
									{
										$catfetsub =  "SELECT * FROM cat_sub WHERE c_id='". $curr_val[category]."' AND status=0";
										$rowcatub=$prop->getAll_Disp($catfetsub);
										$rowcatub=$prop->getAll_Disp($catfetsub);
										for($di=0; $di<count($rowcatub); $di++)
										{
											$videocategory_id = $rowcatub[$di]['c_name'];
											$subcategory_id = $curr_val[category];
										}
									}	
								?>
								<input type="hidden" name="catId" class="CatId" value="<?php echo $videocategory_id?>">
								<input type="hidden" name="subCatID" class="SubCatId" value="<?php echo $subcategory_id?>">
                                <input type="hidden" name="meth" id="meth" value="ajaxsaveQuiz">
                                
                                <label for="document_name">Quiz Title</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="quiz_name" id="quiz_name" placeholder="Title" required>
                                </div>
                                <div class="help-block with-errors"></div>      
                                <label for="exampleInputuname">Quiz URL</label>
                                <div class="form-group">
                                    <input type="url" class="form-control" name="quiz_url" id="quiz_url" required>
                                </div>
                            </div>
    
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Add</button>
                            </div>
						</form>
				</div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->

        

        <!-- sample modal Trainings content -->

        <div id="myModalTraining" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add Training	</h4> </div>
						<form method="post" id="ajaxTrainingForm">
                  		  
                         	<div class="modal-body" id="select-training">
                                <input type="hidden" name="meth" id="meth" value="ajaxsaveTraining">
                                <label for="document_name">Choose a existing Training</label>
                                <div class="form-group">
                                	<select name="exist_training" id="exist_training" class="form-control select2" style="width:100%">
                                    	<option value="">Seletct Training</option>
                                        <?php
                                        $sql_training = 'select * from docs where `doc_status`!=2 and doc_type=2';
										$row_training = $prop->getAll_Disp($sql_training);
										for($di=0; $di<count($row_training); $di++)
										{?>
										<option value="<?php echo $row_training[$di][doc_id]; ?>"><?php echo $row_training[$di][doc_name];?></option>
										<?php }
										?>
                                    </select>
                                </div>
                                <!--<p style="text-align:center; margin-top:15px;">OR</p>
                                <label for="document_name">Training Title</label>
                                <div class="form-group">
                                <input type="text" class="form-control" name="training_name" id="training_name" placeholder="Title">
                                </div>
                                <div class="help-block with-errors"></div>      
                                <label for="exampleInputuname">Upload Document</label>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" id="training_file">
                                </div>-->
                            </div>
				
                 		 	<div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Add</button>
                            </div>
                    	</form>

                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->



        <!-- sample modal content -->

        <div id="myModalVideos" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add Videos</h4> </div>

                   <?php /*?> <div id="select-videos" class="modal-body">
                        <select class="select2 select2-multiple select-videos" id="addvideos" multiple="multiple" data-placeholder="Choose">

                            <?php

							if($curr_val['category']!='' && $curr_val['category']>0){

								$catfetdoc =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=3 AND doc_status=0 AND doc_scat=".$curr_val['category'];

								$rowdoc=$prop->getAll_Disp($catfetdoc);

								for($i=0; $i<count($rowdoc); $i++)

								{

									echo '<option value="'.$rowdoc[$i][doc_id].'">'.$rowdoc[$i][doc_name].'</option>';

								}

							}

							?>


                        </select>

                    </div>
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-info waves-effect" id="saveVideo">Add</button>
					</div><?php */?>
                   <div class="modal-body">
                   		<?php
							$videocategory_id = '';
							$subcategory_id = '';
							if(isset($curr_val[category]))
							{
                        		$catfetsub =  "SELECT * FROM cat_sub WHERE c_id='". $curr_val[category]."' AND status=0";
								$rowcatub=$prop->getAll_Disp($catfetsub);
								$rowcatub=$prop->getAll_Disp($catfetsub);
								for($di=0; $di<count($rowcatub); $di++)
								{
									$videocategory_id = $rowcatub[$di]['c_name'];
									$subcategory_id = $curr_val[category];
								}
							}	
						?>
                        <input type="hidden" id="videocategory_id" value="<?php echo $videocategory_id?>">
                        <input type="hidden" id="subcategory_id" value="<?php echo $subcategory_id?>">
                        <label for="exampleInputuname">Video Title</label>
                        <div class="form-group">
                        <input type="text" class="form-control" name="document_name" id="video_title" placeholder="Title" required>
                        </div>
    
                        <div class="help-block with-errors"></div>
    
                        <label for="exampleInputuname1">Video Link</label>
    
                        <div class="form-group">
    
                            <input type="text" class="form-control" value="<?php echo $curr_val['doc_file'];?>" name="video" id="video_url" placeholder="Ex: https://www.youtube.com/watch?v=00f0A1ppnRo" required>
    
                        </div>
    
                        <div class="help-block with-errors"></div>
					</div>
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-info waves-effect" id="ajaxsaveVideo">Add</button>
                    </div>

                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->

        

        <!-- sample Add New Video modal content -->

        

        <!-- /.modal -->

		

		<!-- sample modal content -->

        <div id="myModalImages" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add Images</h4> </div>

					<div id="select-images" class="modal-body">

                        <select class="select2 select2-multiple select-images" id="addimages" multiple="multiple" data-placeholder="Choose">

                            <?php

							if($curr_val['category']!='' && $curr_val['category']>0){

								$catfetdoc =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=4 AND doc_status=0 AND doc_scat=".$curr_val['category'];

								$rowdoc=$prop->getAll_Disp($catfetdoc);

								for($i=0; $i<count($rowdoc); $i++)

								{

									echo '<option value="'.$rowdoc[$i][doc_id].'">'.$rowdoc[$i][doc_name].'</option>';

								}

							}

							?>

                        </select>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-info waves-effect" id="saveImage">Add</button>

                    </div>

                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->



		<!-- Add Category .modal -->

			<div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

							<h4 class="modal-title" id="myModalLabel">Add Category</h4> </div>

						<div class="modal-body">

							<div class="form-group col-md-12">

								<label for="exampleInputuname">Category</label>

								<div class="form-group">

									<input type="hidden" id="mainCatId" value=""/>

									<input type="text" class="form-control" id="mainCategory" placeholder="Category" required="">

								</div>

								<div style="color:#e70000" class="help-block with-errors mainCategory"></div>

							</div>

						</div>

						<div class="modal-footer">

							<button type="button" class="btn btn-info waves-effect" id="submitAjaxBtn">Add</button>

						</div>

					</div>

					<!-- /.modal-content -->

				</div>

				<!-- /.modal-dialog -->

			</div>

		<!-- /.modal -->

        

        <!-- Add SubCategory .modal -->

			<div id="mySubCatModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

							<h4 class="modal-title" id="myModalLabel">Add Sub Category</h4> </div>

						<div class="modal-body">

							<div class="form-group col-md-12">

								<label for="exampleInputuname">Choose Parent Category</label>

                                <div style="margin-bottom:10px;" id="RefonlyCat">

                                <select name="category_id" id="category_id" class="selectpicker " data-style="form-control" required>

                                <option value="">Select Category</option>

                                <?php

										$catfet=$prop->getAll_Disp("SELECT * FROM `".MAIN_CATEGORY."` WHERE `status`=0 order by c_name ASC");

										//echo  '<option value="">Select Category</option>';

										for($i=0; $i<count($catfet); $i++)

															  {

										echo  '<option value="'.$catfet[$i]['c_id'].'" '.($catfet[$i]['c_id'] == $curr_val['c_name'] ? "selected":"").' >'.$catfet[$i]['c_name'].'</option>';

										}

										

										?>

                                        </select>

                                </div>

								<label for="exampleInputuname">Sub Category Name</label>

                                <div class="form-group">

                                	<input type="text" class="form-control" id="scat_name"  name="scat_name"  placeholder="Sub Category Name" value="" required>

								</div>

								<div style="color:#e70000" class="help-block with-errors mainsubCategory"></div>

							</div>

						</div>

						<div class="modal-footer">

							<button type="button" class="btn btn-info waves-effect" id="submitAjaxBtnSubCat">Add</button>

						</div>

					</div>

					<!-- /.modal-content -->

				</div>

				<!-- /.modal-dialog -->

			</div>

		<!-- /.modal -->

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

        <script>
			var last_draft_id = '';
            jQuery(document).ready(function() {

                // Switchery

                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                $('.js-switch').each(function() {

                    new Switchery($(this)[0], $(this).data());

                });

                // For select 2
				$(".select2").select2();
				$('.selectpicker').selectpicker();
				$("#select-maincategory").select2({
					  tags: true
				});
				$("#select-category").select2({
					  tags: true
				});
				
				setInterval(ajaxCall, 15000);
			});
			
			 var ajaxCall = function(){
			 	$("form#cateForm").ajaxSubmit(function(e) {
					var formdata = $('#cateForm').serializeArray();
					$.ajax({
							url: "ajax-functions.php",
							type: 'POST',
							data:formdata,
							dataType:'json',
							success: function (response) {
								$('#draft_id').val(response.LastID);								
								console.log($('#draft_id').val());
								<?php
								if(isset($curr_val['page_status']) and $curr_val['page_status'] == 0)
								{
								?>
								$('#alert_draft').html('<div class="alert alert-success"><strong>Auto Save!</strong> Program auto saved.</div>');
								<?php
								}
								else
								{?>
								$('#alert_draft').html('<div class="alert alert-success"><strong>Draft!</strong> Program saved in draft.</div>');
								<?php
								}
								?>
								setTimeout(function() { $('#alert_draft').html(''); }, 3000);
								
							}
						})		
					
				})
			}
			
        </script>
		<script src="js/jqueryForm.js"></script> 
        <!-- Footable -->

        <script src="plugins/bower_components/footable/js/footable.all.min.js"></script>

        <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>



        <script src="js/jasny-bootstrap.js"></script>

        <!--FooTable init-->

        <script src="js/footable-init.js"></script>

        <!-- wysuhtml5 Plugin JavaScript -->

        <script src="plugins/bower_components/tinymce/tinymce.min.js"></script>

        <script>

            $(document).ready(function() {

				$('[data-toggle="tooltip"]').tooltip();

                $(document).delegate('.removeField', 'click', function() {

                    var fieldValue = $(this).attr('rel');

                    if (fieldValue == undefined || fieldValue == '')

                        return false;

                    else {

                        $('#' + fieldValue).remove();
						
						if(fieldValue.indexOf('row-train') != -1){
							training_count = 0;
							$('#mymce').html('');
							$(tinymce.get('mymce').getBody()).html('');
						}
						

                    }

                });

				/*Add Category Start*/

				$("#submitAjaxBtn").click(function(e){

					var name = $('#mainCategory').val();

					var id = $('#mainCatId').val();

					if(name!='' && name!='undifined'){

						$('.mainCategory').html('');

						$('.mainCategory').hide();

						$.ajax({

							type: "POST",

							url: "ajax.php",

							cache:false,

							data: 'name='+name+'&id='+id+'&meth=Action-Category',

							dataType:'json',

							success: function(response)


							{

								swal(response.status, response.msg, response.error);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);

								if(response.result){

									

									$.ajax({

											type: "POST",

											url: "ajax-cat.php",

											cache:false,

											data: 'meth=RefonlyCat',

											success: function(response)

											{

												//alert(response);

												$('#RefonlyCat').html(response); 

												$('.close').click();

											}

										});

									//location.reload();

								}

							}

						});

					}else{

						$('.mainCategory').html('Please enter category name');

						$('.mainCategory').show();

						$('#mainCategory').focus();

					}

				});

				/*Add Category END*/

				

				/*Add Sub Category Start*/

				$("#submitAjaxBtnSubCat").click(function(e){

					var name = $('#scat_name').val();

					var id = $( "#category_id option:selected" ).val();

					

					if(id == '' && id == 'undifined'){

						$('.mainsubCategory').html('Please select category name');

						$('.mainsubCategory').show();

						$('#category_id').focus();

					}else if(name!='' && name!='undifined'){

						$('.mainsubCategory').html('');

						$('.mainsubCategory').hide();

						$.ajax({

							type: "POST",

							url: "ajax.php",

							cache:false,

							data: 'scat_name='+name+'&category_id='+id+'&meth=Action-SubCategory',

							dataType:'json',

							success: function(response)

							{

								swal(response.status, response.msg, response.error);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);

								if(response.result){

									$.ajax({

										type: "POST",

										url: "ajax-cat.php",

										cache:false,

										data: 'meth=RefCat',

										success: function(response)

										{

											$('#select-category').html(response);

											$('.close').click();

										}

									});

								}

							}

						});

					}else{

						$('.mainsubCategory').html('Please enter Subcategory name');

						$('.mainsubCategory').show();

						$('#category_id').focus();

					}

				});

				/*Add Sub Category END*/

                /*ajaxTrainingForm start*/
				<?php 
					if(isset( $curr_val['trainings']) and $curr_val['trainings']!= "emp" )
					{
					?>
					var training_count = 1;
					<?php
					
					}
					else
					{
				?>
				var training_count = 0;
				<?php
					}
				?>
				$("form#ajaxTrainingForm").submit(function(e) {
					e.preventDefault();    
					var formData = new FormData(this);
					var training_id = $('#exist_training option:selected').val();
					var training_title = $('#exist_training option:selected').text();
					
					if(training_id != '' && training_count == 0)
					{
							$.ajax({
								url: "ajax-functions.php",
								type: 'POST',
								data: 'training_id='+training_id+'&meth=get-training-data',
								dataType:'json',
								success: function (response) {
									//swal(response.data);
									$('#mymce').html(response.data);
									$(tinymce.get('mymce').getBody()).html(response.data);
								}
							})		
							
							$('#exist_training option[value=""]').attr('selected','selected');
							var newRowContent = '<tr id="row-train' + training_id + '">'
												+'<input type="hidden" name="training[]" value="' + training_id + '">'
												+'<td>' + training_title + '</td>'
												+'<td class="text-nowrap text-center">'
												+'<a href="javascript:void(0);" rel="row-train' + training_id + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'
												+'</td>'
											+'</tr>';
									
									$(newRowContent).appendTo($("#addmoretraining"));
									$("#myModalTraining").modal('toggle');	
									training_count = 1;
					}
					else
					{
						swal('Already one training added');
						setTimeout(function() {
							$(".confirm").trigger('click');
						}, 3000);
					}
					
				});
				/*ajaxTrainingForm END*/
				var HandOutArray = new Array();
				var HandOutArrayIndex=0;
				$('#addmorehand').find('td').each (function() {
				  console.log($(this).html());
				  HandOutArray[HandOutArrayIndex] = $.trim($(this).text());
				  HandOutArrayIndex++;
				});  
				$("form#ajaxHandForm").submit(function(e) {
					e.preventDefault();    
					var formData = new FormData(this);
					var handout_id = $('#exist_handout option:selected').val();
					var handout_title = $('#exist_handout option:selected').text();
					
					if(handout_id == '')
					{
						var cat_id = $('#catId').val();
						var subcat_id = $('#subCatID').val();
						/*if(cat_id == '' || subcategory_id == '')
						{
							swal('Please select Category');
							return false;
						}*/
						;
						if($('#document_name').val() == '')
						{
							swal('Please select Hand Out Title');							
							setTimeout(function() {
								$(".confirm").trigger('click');
							}, 3000);
							return false;
						}
						else
						{
							var doc_title = $('#document_name').val();
							if(jQuery.inArray(doc_title, HandOutArray) !== -1)
							{
								swal('Handout title alrady exist');							
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
								return false;
							}
						}
						if($('#doc_file').val() == '')
						{
							swal('Please select Hand Out Title');
							setTimeout(function() {
								$(".confirm").trigger('click');
							}, 3000);
							return false;
						}
						
						$.ajax({
							url: "ajax-functions.php",
							type: 'POST',
							data: formData,
							dataType:'json',
							success: function (response) {
								if(response.err)
								{
									swal(response.msg);
									setTimeout(function() {
										$(".confirm").trigger('click');
									}, 3000);
								}
								else
								{
									
									$('#document_name').val('');
									$('#doc_file').val('');
									
									var newRowContent = '<tr id="row-hand' + response.lastId + '">'
												+'<input type="hidden" name="handout[]" value="' + response.lastId + '">'
												+'<td>' + response.handTitle + '</td>'
												+'<td class="text-nowrap text-center">'
												+'<a href="javascript:void(0);" rel="row-hand' + response.lastId + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'
												+'</td>'
											+'</tr>';
									
									$(newRowContent).appendTo($("#addmorehand"));
									$("#myModalHand").modal('toggle');
									$("#exist_handout option:first").attr('selected', 'selected');
									$('#exist_handout').select2();
									$('#ajaxHandForm #document_name').attr("readonly", false); 
									$('#ajaxHandForm #doc_file').prop('disabled', false); 	
									HandOutArray[HandOutArrayIndex] = response.handTitle;
									HandOutArrayIndex++;
								}
							},
							cache: false,
							contentType: false,
							processData: false
						});
					}
					else
					{
							
							if(jQuery.inArray(handout_title, HandOutArray) !== -1)
							{
								swal('Handout alrady added');							
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
								return false;
							}
							$('#exist_handout option[value=""]').attr('selected','selected');
							var newRowContent = '<tr id="row-hand' + handout_id + '">'
												+'<input type="hidden" name="handout[]" value="' + handout_id + '">'
												+'<td>' + handout_title + '</td>'
												+'<td class="text-nowrap text-center">'
												+'<a href="javascript:void(0);" rel="row-hand' + handout_id + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'
												+'</td>'
											+'</tr>';
									
									$(newRowContent).appendTo($("#addmorehand"));
									$("#myModalHand").modal('toggle');
									$("#exist_handout option:first").attr('selected', 'selected');
									$('#exist_handout').select2();
									$('#ajaxHandForm #document_name').attr("readonly", false); 
									$('#ajaxHandForm #doc_file').prop('disabled', false); 
									HandOutArray[HandOutArrayIndex] = handout_title;
									HandOutArrayIndex++;	
					}
				});
				
				
				/*Quizzes*/
				var QuizArray = new Array();
				var QuizArrayIndex=0;
				$('#addmorequiz').find('td').each (function() {
				  console.log($(this).html());
				  QuizArray[QuizArrayIndex] = $.trim($(this).text());
				  QuizArrayIndex++;
				});  
				
				$("form#ajaxQuizForm").submit(function(e) {
					e.preventDefault();    
					var formData = new FormData(this);
					
					var cat_id = $('#catId').val();
					var subcat_id = $('#subCatID').val();
					if(cat_id == '' || subcategory_id == '')
					{
						swal('Please select Category');
						setTimeout(function() {
							$(".confirm").trigger('click');
						}, 3000);
						return false;
					}
					
					var quiz_name = $('#quiz_name').val();
					if(jQuery.inArray(quiz_name, QuizArray) !== -1)
					{
						swal('Quiz title alrady exist');							
						setTimeout(function() {
							$(".confirm").trigger('click');
						}, 3000);
						return false;
					}
					
					$.ajax({
						url: "ajax-functions.php",
						type: 'POST',
						data: formData,
						dataType:'json',
						success: function (response) {
							if(response.err)
							{
								swal(response.msg);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
							}
							else
							{
								$('#quiz_name').val('');
								$('#quiz_url').val('');
								var newRowContent = '<tr id="row-quiz' + response.lastId + '">'
											+'<input type="hidden" name="quiz[]" value="' + response.lastId + '">'
											+'<td>' + response.quizTitle + '</td>'
											+'<td class="text-nowrap text-center">'
											+'<a href="javascript:void(0);" rel="row-quiz' + response.lastId + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'
											+'</td>'
										+'</tr>';
								
								$(newRowContent).appendTo($("#addmorequiz"));
								$("#myModalQuiz").modal('toggle');	
								QuizArray[QuizArrayIndex] = response.quizTitle;
				  				QuizArrayIndex++;
							}
						},
						cache: false,
						contentType: false,
						processData: false
					});
				});
				/*Quizzes End*/

                $("#saveHand").click(function() {

                    var x = $('#addhandout').val();

                    for (i = 0; i < x.length; i++) {

                        if ($('#row-hand' + x[i]).is(':visible')) {

                            continue;

                        } else {

                            var newRowContent = '<tr id="row-hand' + x[i] + '">'

										+'<input type="hidden" name="handout[]" value="' + x[i] + '">'

										+'<td>' + $('#select-handout option[value=' + x[i] + ']').text() + '</td>'

										+'<td class="text-nowrap text-center">'

										+'<a href="javascript:void(0);" rel="row-hand' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'

										+'</td>'

									+'</tr>';

                            $(newRowContent).appendTo($("#addmorehand"));

                        }

                    }

                    $("#myModalHand").modal('toggle');

                });

				

				$("#saveQuiz").click(function() {

                    var x = $('#addquiz').val();

                    for (i = 0; i < x.length; i++) {

                        if ($('#row-quiz' + x[i]).is(':visible')) {

                            continue;

                        } else {

                            var newRowContent = '<tr id="row-quiz' + x[i] + '">'

										+'<input type="hidden" name="quiz[]" value="' + x[i] + '">'

										+'<td>' + $('#select-quiz option[value=' + x[i] + ']').text() + '</td>'

										+'<td class="text-nowrap text-center">'

										+'<a href="javascript:void(0);" rel="row-quiz' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'

										+'</td>'

									+'</tr>';

                            $(newRowContent).appendTo($("#addmorequiz"));

                        }

                    }

                    $("#myModalQuiz").modal('toggle');

                });

				

				$("#saveTrain").click(function() {

                    var x = $('#addtraining').val();

                    for (i = 0; i < x.length; i++) {

                        if ($('#row-train' + x[i]).is(':visible')) {

                            continue;

                        } else {

                            var newRowContent = '<tr id="rowguide' + x[i] + '" ><input type="hidden" name="guide[]" value="' + x[i] + '" ><td>' + $('#guidefield option[value=' + x[i] + ']').text() + '</td><td class="text-nowrap text-center"><a href="javascript:void(0);" rel="' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeFieldguide"><img src="img/close-button.png"></a></td></tr>';

							var newRowContent = '<tr id="row-train' + x[i] + '">'

										+'<input type="hidden" name="training[]" value="' + x[i] + '">'

										+'<td>' + $('#select-training option[value=' + x[i] + ']').text() + '</td>'

										+'<td class="text-nowrap text-center">'

										+'<a href="javascript:void(0);" rel="row-train' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'

										+'</td>'

									+'</tr>';

                            $(newRowContent).appendTo($("#addmoretraining"));

                        }

                    }

                    $("#myModalTraining").modal('toggle');

                });

				

				$("#saveVideo").click(function() {

                    var x = $('#addvideos').val();

                    for (i = 0; i < x.length; i++) {

                        if ($('#row-vid' + x[i]).is(':visible')) {

                            continue;

                        } else {
							
							
							var newRowContent = '<tr id="row-vid' + x[i] + '">'

										+'<input type="hidden" name="videos[]" value="' + x[i] + '">'

										+'<td>' + $('#select-videos option[value=' + x[i] + ']').text() + '</td>'

										+'<td class="text-nowrap text-center">'

										+'<a href="javascript:void(0);" rel="row-vid' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'

										+'</td>'

									+'</tr>';

                            $(newRowContent).appendTo($("#addmorevideos"));

                        }

                    }

                    $("#myModalVideos").modal('toggle');

                });

				

				$("#saveImage").click(function() {

                    var x = $('#addimages').val();

                    for (i = 0; i < x.length; i++) {

                        if ($('#row-img' + x[i]).is(':visible')) {

                            continue;

                        } else {

                            var newRowContent = '<tr id="row-img' + x[i] + '">'

										+'<input type="hidden" name="images[]" value="' + x[i] + '">'

										+'<td>' + $('#select-images option[value=' + x[i] + ']').text() + '</td>'

										+'<td class="text-nowrap text-center">'

										+'<a href="javascript:void(0);" rel="row-img' + x[i] + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'

										+'</td>'

									+'</tr>';

                            $(newRowContent).appendTo($("#addmoreimages"));

                        }

                    }

                    $("#myModalImages").modal('toggle');

                });



             

                if ($("#mymce").length > 0) {

                    tinymce.init({

                        selector: "textarea#mymce",

                        theme: "modern",

                        height: 300,
						
						

                        plugins: [

                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"

                        ],

                        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
						toolbar2: "print preview media | forecolor backcolor emoticons",
						image_advtab: true,
						file_picker_callback: function(callback, value, meta) {
						  if (meta.filetype == 'image') {
							$('#upload').trigger('click');
							$('#upload').on('change', function() {
							  var file = this.files[0];
							  var reader = new FileReader();
							  reader.onload = function(e) {
								callback(e.target.result, {
								  alt: ''
								});
							  };
							  reader.readAsDataURL(file);
							});
						  }
						},

                    });

                }

            });



            function ResetFormVal() {

                $("#cateForm")[0].reset();

            }
			 var VideoArray = new Array();
			 var VideoArrayIndex=0;
			 $('#addmorevideos').find('td').each (function() {
			   console.log($(this).html());
			   VideoArray[VideoArrayIndex] = $.trim($(this).text());
			   VideoArrayIndex++;
			 }); 
			 $("#ajaxsaveVideo").click(function(e) {
			 	
				var cat_id = $('#videocategory_id').val();
				var subcat_id = $('#subcategory_id').val();
				var video_title = $('#video_title').val();
				var video_url = $('#video_url').val();
				var patern = /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
				if(cat_id == '' || subcategory_id == '')
				{
					swal('Please select Category');
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
					return false;
				}
				
				if(video_title == '')
				{
					swal('Please Enter Video Title');
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
					return false;
				}
				else
				{
					var video_title = $('#video_title').val();
					if(jQuery.inArray(video_title, VideoArray) !== -1)
					{
						swal('Video title alrady exist');							
						setTimeout(function() {
							$(".confirm").trigger('click');
						}, 3000);
						return false;
					}
				}
				
				if(video_url == '')
				{
					swal('Please Enter Video URL');
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
					return false;
				}
				else if(!patern.test(video_url)){
					swal('Please Enter Valid URL');
					setTimeout(function() {
						$(".confirm").trigger('click');
					}, 3000);
					return false;
				}
				
				
				$.ajax({
                        type: "POST",
                        url: "ajax-functions.php",
                        cache: false,
                        data: 'cat_id=' + cat_id + '&subcat_id=' + subcat_id + '&video_title=' + video_title + '&video_url=' + video_url + '&meth=ajaxsaveVideo',
						dataType:'json',
                        success: function(response) {
							
							if(response.err)
							{
								swal(response.msg);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
							}
							else
							{
								$('#video_title').val('');
								$('#video_url').val('');
								var newRowContent = '<tr id="row-vid' + response.lastId + '">'
											+'<input type="hidden" name="videos[]" value="' + response.lastId + '">'
											+'<td>' + response.videoTitle + '</td>'
											+'<td class="text-nowrap text-center">'
											+'<a href="javascript:void(0);" rel="row-vid' + response.lastId + '" data-toggle="tooltip" data-original-title="Remove" class="removeField"><img src="img/close-button.png"></a>'
											+'</td>'
										+'</tr>';
								
								$(newRowContent).appendTo($("#addmorevideos"));
								$("#myModalVideos").modal('toggle');
								VideoArray[VideoArrayIndex] = response.videoTitle;
				  				VideoArrayIndex++;
							}
						}
				})		
			 	
			 })
			/*Main select-maincategory*/
			$("#select-maincategory").change(function() {
			
				var id = $(this).val();
				//console.log($.isNumeric(id));
				if($.isNumeric(id))
				{
					if (id != '' && id > 0) {
						 $.ajax({
	
							type: "POST",
	
							url: "ajax.php",
	
							cache: false,
	
							data: 'id=' + id + '&meth=get-subCategory',
	
							dataType: 'json',
	
							success: function(response) {
								if (response.status) {
									if (response.status) {
										$('#select-category').html(response.subcate);
									}
								}
							}	
							
						})
						
					}
				}
				else
				{
					
					var name = id;
					var id = '';
					$.ajax({

							type: "POST",

							url: "ajax.php",

							cache:false,

							data: 'name='+name+'&id='+id+'&meth=Action-Category',

							dataType:'json',

							success: function(response)
							{
								swal(response.status, response.msg, response.error);
								addedId = response.newId;
								$('#select-maincategory option:selected').val(addedId);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
								
								
							}
					})		
					$('#select-category').html('<option value="">Select Sub Category</option>');
				}
			})
			
			/*END*/
            $("#exist_handout").change(function(e) {
				 var handout_id = $(this).val();
				 if(handout_id != '')
				 {
				 	$('#ajaxHandForm #document_name').attr("readonly", true); 
					$('#ajaxHandForm #doc_file').prop('disabled', true);
					console.log('true');
				 }
				 else
				 {
				 	$('#ajaxHandForm #document_name').attr("readonly", false); 
					$('#ajaxHandForm #doc_file').prop('disabled', false); 
					console.log('false');
				 }
			})
		    $("#select-category").change(function(e) {

                var id = $(this).val();
				if($.isNumeric(id))
				{
					callmycode(id)
					
				}
				else{
					
					category_id = $('#select-maincategory option:selected').val();
					name = id;
					$.ajax({

							type: "POST",
							url: "ajax.php",
							cache:false,
							data: 'scat_name='+name+'&category_id='+category_id+'&meth=Action-SubCategory',
							dataType:'json',
							success: function(response)
							{
								swal(response.status, response.msg, response.error);
								setTimeout(function() {
									$(".confirm").trigger('click');
								}, 3000);
								addedId = response.newId;
								$('#select-category option:selected').val(addedId);
								//console.log(addedId);
								callmycode(addedId)
								console.log($('#select-category option:selected').val());
								
							}
					})		
				}
            });

			 

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
function callmycode(id){
if (id != '' && id > 0) {
	console.log(id);
	$.ajax({

		type: "POST",

		url: "ajax.php",

		cache: false,

		data: 'id=' + id + '&meth=Page-Category',

		dataType: 'json',

		success: function(response) {

			if (response.status) {

				$('#videocategory_id').val(response.videocategory_id);
				
				$('#subcategory_id').val(response.subcatnewvideo);
				
				$('.CatId').val(response.videocategory_id);
				
				$('.SubCatId').val(response.subcatnewvideo);

				//$('#select-handout').html(response.handout);

				$('#select-quiz').html(response.quiz);

				//$('#select-training').html(response.trainings);

				$('#select-videos').html(response.video);

				$('#select-images').html(response.image);

				

				$( ".select-quiz" ).select2();
				
				$( ".select-handout" ).select2();
				$( ".select-training" ).select2();

				$( ".select-videos" ).select2();

				$( ".select-images" ).select2();
				
				$( "#exist_training" ).select2();
				$( "#exist_handout" ).select2();
				
				//alert(response.subcatnewvideo);
				if($('#sub_cat_id_bck').val() != response.subcatnewvideo)
				{
					//$('#addmorequiz_bck').html($('#addmorequiz').html());
					//$('#addmorevideos_bck').html($('#addmorevideos').html());
					//$('#addmoreimages_bck').html($('#addmoreimages').html());
					//$('#addmoretraining_bck').html($('#addmoretraining').html());									
					
					
					//$('#addmorehand').html('');								
					//$('#addmorequiz').html('');									
					//$('#addmoretraining').html('');									
					//$('#addmorevideos').html('');
					$('#addmoreimages').html('');
				}
				else
				{
					//alert(response.subcatnewvideo);
					//$('#addmorequiz').html($('#addmorequiz_bck').html());
					//$('#addmorevideos').html($('#addmorevideos_bck').html());
					$('#addmoreimages').html($('#addmoreimages_bck').html());
					//$('#addmoretraining').html($('#addmoretraining_bck').html());
				}
				
				
				

				/*

				$('.select-handout').html(response.handout).trigger("change");

				$('.select-quiz').html(response.quiz).trigger("change");

				$('.select-trainings-log').html(response.trainings).trigger("change");

				$('.select-b-safe').html(response.safe).trigger("change");

				$( ".select2" ).select2();

				//$(".select2").trigger("change");

				*/
				//$( "#addtraining" ).select2();

			}

		}

	});

}
}
        </script>

        <!--Style Switcher -->

        <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <div style="display:none" id="store_bck">
            <div id="addmorequiz_bck"></div>
            <div id="addmorevideos_bck"></div>
            <div id="addmoreimages_bck"></div>
            <input type="hidden" id="sub_cat_id_bck" value="<?php if(isset($curr_val[category])){echo $curr_val[category];}?>">
        </div>

    </body>
    </html>