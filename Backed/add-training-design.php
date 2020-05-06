<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

$curr_val = $prop->get('*',PAGES, array("p_id"=>$_REQUEST['programID'],'page_status'=>0));
$page_id = $curr_val['p_id'];
$subCatID = $curr_val['category'];
$CatVal = $prop->get('c_name','cat_sub', array("c_id"=>$subCatID ,'status'=>0));
$CatID = $CatVal['c_name'];

if(empty($curr_val)){
	header('location: manage-be-safe.php');
	exit;
}

if(isset($_REQUEST['company_id']))
$companyID = $_REQUEST['company_id'];
else
$companyID = $session['bid'];

if(isset($_POST['btnEmpAssign']))
{
	if(isset($_POST['FlowType']))
	$assignType = $_POST['FlowType'];
	
	$assign_count = 0;
	$unassign_count = 0;
	foreach ($_POST['empNames'] as $empID)
	{
		if($assignType == 1) //assign code
		{
			$input = array(
				'emp_id'	=>$empID,
				'catID'	=>$CatID,
				'subCatID'	=>$subCatID,
				'programID'	=>$page_id,
				'status'	=>0
			);
			$exits = $prop->getName('count(id)', 'assign_emp', "emp_id=".$empID." AND catID=".$CatID." AND subCatID=".$subCatID." AND programID=".$page_id);
			if($exits === 0){
				$result = $prop->add('assign_emp', $input);
				if ($result) {
					$assign_count++;
				}
			}
			else
			{
				$unassignEmpID = $prop->getName('id', 'assign_emp', "status=2 AND emp_id=".$empID." AND catID=".$CatID." AND subCatID=".$subCatID." AND programID=".$page_id);
				if($unassignEmpID != 0)
				{
					$t_cond = array("id" => $unassignEmpID);
					$result = $prop->update('assign_emp', $input, $t_cond);
					if ($result) {
						$assign_count++;
					}
					
				}
			}
			
		}
		else //unassign code
		{
			$input = array(
				'emp_id'	=>$empID,
				'catID'	=>$CatID,
				'subCatID'	=>$subCatID,
				'programID'	=>$page_id,
				'status'	=>2
			);
			$exits = $prop->getName('count(id)', 'assign_emp', "emp_id=".$empID." AND catID=".$CatID." AND subCatID=".$subCatID." AND programID=".$page_id);
			if($exits === 0){
				$result = $prop->add('assign_emp', $input);
				if ($result) {
					$unassign_count++;
				}
			}
			else
			{
				$unassignEmpID = $prop->getName('id', 'assign_emp', "status=0 AND emp_id=".$empID." AND catID=".$CatID." AND subCatID=".$subCatID." AND programID=".$page_id);
				if($unassignEmpID != 0)
				{
					$t_cond = array("id" => $unassignEmpID);
					$result = $prop->update('assign_emp', $input, $t_cond);
					if ($result) {
						$unassign_count++;
					}
					
				}
			}
		}
	}
	if($assign_count != 0)
	{
		setcookie('status', 'Success', time()+10);
		setcookie('title', 'Employee Assigned Successfully', time()+10);
		setcookie('err', 'success', time()+10);
		header('Location: add-training-design.php?programID='.$page_id.'&company_id='.$companyID);
	}
	else if($assign_count == 0 and $unassign_count == 0)
	{
		setcookie('status', 'Error', time()+10);
		setcookie('title', 'Employee already Assigned', time()+10);
		setcookie('err', 'error', time()+10);
		header('Location: add-training-design.php?programID='.$page_id.'&company_id='.$companyID);
	}
	else if($unassign_count != 0)
	{
		setcookie('status', 'Success', time()+10);
		setcookie('title', 'Employee Unassigned Successfully', time()+10);
		setcookie('err', 'success', time()+10);
		header('Location: add-training-design.php?programID='.$page_id.'&company_id='.$companyID);
	}
	else
	{
		setcookie('status', 'Error', time()+10);
		setcookie('title', 'Employee already Unassigned'.$assignType, time()+10);
		setcookie('err', 'error', time()+10);
		header('Location: add-training-design.php?programID='.$page_id.'&company_id='.$companyID);
	}
}



$where_dep = ' where dep_status != 2 and company_id='.$companyID;
$listDepart = $prop->getAll('*',DEPARTMENT_NEW, $where_dep, '', 0, 0);

$departmentIDs='';
for($i=0; $i < count($listDepart); $i++){ 

	if($i < count($listDepart)-1)
	$departmentIDs .= $listDepart[$i]['dept_id'].',';
	else
	$departmentIDs .= $listDepart[$i]['dept_id'];
}

$where_emp = ' where status != 2 and u_type = 4 AND department_id IN ('.$departmentIDs.') and u_id='.$companyID;
$listEmps = $prop->getAll('*',USERS, $where_emp, ' ORDER BY name ASC ', 0, 0);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/DCSHRM_logo-g.png">
    <title>Manage Category</title>
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

		.footable-row-detail-name {
    display: table-cell;
    font-weight: 500;
    padding-right: 3px;
    padding-bottom: 5px;
    /* display: none; */
}
		.footable-row-detail-inner {width:100%;}
	</style>
<style>
#myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

#myUL .caret {
display:block;
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

#myUL .caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

#myUL .caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0e5589;
    border-color: #0e5589 #0e5589 #0e5589;
}
.nav-tabs {
    border: 1px solid #ecf0f4;
}
ol.auto-checkboxes.bonsai label {
    margin-left: 7px;
}
.nav-tabs>li>a {
    border-radius: 0;
    color: #2b2b2b;
    font-weight: 600;
}
.select2{width:100% !important;border-radius:5px;}
ul.handout-sst {
    list-style: disc;
    padding: 0;
}
span.title i {
    color: #333;
    margin-right: 10px;
}
span.iconn {
    float: right;
    color: #0d558a;
}
span.title {
    font-weight: 400;
    color: #333;
}
ul.handout-sst a img {
    margin-right: 5px;
}
ul.handout-sst li {
    padding: 10px 5px;
}

ul.handout-sst {
    list-style: none;
    padding: 0;
}
.img-banner {
    background: url(<?php echo '../uploads/catdetails/'.$curr_val[ban_image]; ?>) no-repeat center center;
    background-size: cover;
    height: 300px;
    width: 100%;
    margin-bottom:30px;
}
.banner-txt {
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.4);
    color: #fff;
    text-align: CENTER;
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    font-weight: 600;
    text-transform: uppercase;
}
.tab-content {
    margin-top: 10px;
}
.dataTables_wrapper{width:100%}
button.btn.btn-success, button.btn {
    color: #FFFFFF;
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
                	<div class="col-md-12">
                    	<ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" href="#TrainingDetails" role="tab" data-toggle="tab">Be Safe Details</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#DepartmentAssigned" role="tab" data-toggle="tab">Departments Assigned</a>
                          </li>
                           <li class="nav-item">
                            <a class="nav-link" href="#EmployeesAssigned" role="tab" data-toggle="tab">Employees Assigned</a>
                          </li>
                        </ul>
                    </div>
                    
                </div>
                <?php $foraction = (isset($_REQUEST['id'])?'update&id='.$_REQUEST['id']:'add');?>

                <div class="tab-content">               
                	<div role="tabpanel" class="tab-pane fade in active" id="TrainingDetails">
                		<div class="row">
                        	<div class="col-md-12">
                                <div class="white-box">
                                    <h3 class="box-title"> BE SAFE PROGRAM DETAILS</h3>
                                    <div class="img-banner"><div class="banner-txt"><?php echo $curr_val[title] ?></div></div>
                                	<div class="row">
                                	    <div id="home_info" class="" style="background: #fff;width:100%">
                                            <div class="bg-color"></div>
                                            <div class="container" style="width:100% !important">
                                                <div class="row center b_sp">
                                                    <div class="col-md-12" style="padding-left: 0px;">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                          <li class="nav-item" aria-expanded="false">
                                                            <a class="nav-link active" href="#Content_tab" role="tab" data-toggle="tab" aria-expanded="true">Be Safe</a>
                                                          </li>
                                                          <li class="nav-item">
                                                            <a class="nav-link" href="#Handout_tab" role="tab" data-toggle="tab" aria-expanded="false">Handout</a>
                                                          </li>
                                                          <!--<li class="nav-item">
                                                            <a class="nav-link" href="#Trainings_tab" role="tab" data-toggle="tab">Trainings</a>
                                                          </li>-->
                                                           <li class="nav-item">
                                                            <a class="nav-link" href="#Quiz_tab" role="tab" data-toggle="tab" aria-expanded="false">Quiz</a>
                                                          </li>
                                                          <li class="nav-item">
                                                            <a class="nav-link" href="#Videos_tab" role="tab" data-toggle="tab" aria-expanded="false">Videos</a>
                                                          </li>
                                                          <li class="nav-item">
                                                            <a class="nav-link" href="#Checklist_tab" role="tab" data-toggle="tab" aria-expanded="false">Checklist</a>
                                                          </li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-box col-md-12" id="runtime_descript">
                                                        <div class="tab-content">
                                                         <div role="tabpanel" class="tab-pane fade active show" id="Content_tab" aria-expanded="true">
                                                            <p><strong><?php echo $curr_val[ban_title] ?></strong></p>
                                    <?php 
                                                            echo $curr_val[descript];					
                                                            ?>
                                                         </div>
                                                         <div role="tabpanel" class="tab-pane fade" id="Handout_tab" aria-expanded="false">
                                                                <?php
                                                                if($curr_val['handout']!="emp" && $curr_val['handout']!=""){
                                                                //echo $curr_val['handout'];
                                                                ?>
                                                                <div class="tab_inner">
                                                                <ul Class="handout-sst">
                                                                <?php
                                                                $catfetdoc =  "SELECT * FROM handouts WHERE doc_type=1 AND doc_id IN(".$curr_val['handout'].") AND doc_status=0";
                                                                $rowdoc=$prop->getAll_Disp($catfetdoc);
                                                                for($i=0; $i<count($rowdoc); $i++){
                                                                    $old_name = "../images/docs/".$rowdoc[$i]['doc_file'] ;
                                                                    $extension = end(explode('.',strtolower($old_name)));
                                                                    $new_name = "../images/docs/".$rowdoc[$i][doc_name].".".$extension ;
                                                                    rename( $old_name, $new_name);
                                                                ?>
                                                                    <li>
                                                                    <?php 
                                                                        if($extension == 'pdf')
                                                                        $class = 'fa fa-file-pdf-o';
                                                                        else if($extension == 'doc' || $extension == 'docx')
                                                                        $class = 'fa fa-file-word-o';
                                                                    ?>
                                                                   <a href="<?php echo $new_name; ?>"> <span class="title"><i class="<?php echo $class;?>"></i><?php echo $rowdoc[$i][doc_name]; ?></span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li>
                                                                <?php } ?>    
                                                                </ul>
                                                                </div>
                                                                <?php } ?>
                                                             </div>
                                                         <div role="tabpanel" class="tab-pane fade" id="Quiz_tab" aria-expanded="false">
                                                                 <?php if($curr_val['quiz']!="emp" && $curr_val['quiz']!=""){?>
                                                                 <div class="tab_inner">
                                                                    <ul Class="handout-sst">
                                                                     <?php
                                                                    $catfetdoc =  "SELECT * FROM dynamic_form WHERE form_type=0 AND d_form_id IN(".$curr_val['quiz'].") AND d_detele_status=0";
                                                                    $rowdoc=$prop->getAll_Disp($catfetdoc);
                                                                    $CompanyId = $prop->get('u_id,name,email,contact_no', USERS, array('id'=>$companyID));
                                                                    $user_name = $CompanyId['name'];
                                                                    $email = $CompanyId['email'];
                                                                    $contact_no = $CompanyId['contact_no'];
                                                                    $user_name = explode(' ',$user_name);
                                                                    $fname = $user_name[0];
                                                                    $lname = $user_name[1];
                                                                    
                                                                    for($i=0; $i<count($rowdoc); $i++)
                                                                     {
                                                                     
                                                                     ?>
                                                                        <li><a href="<?php echo  $quiz_url; ?>" target="_blank" title="Click To Attend Quiz"><i class="fa fa-question-circle "></i><span class="title"><?php echo $rowdoc[$i][d_template_name]; ?></span><span class="iconn"><i class="fa fa-arrow-circle-right"></i></span></a></li>
                                                                        <?php }?>
                                                                    </ul>
                                                                    </div>
                                                             <?php } ?>
                                                          </div>
                                                         <div role="tabpanel" class="tab-pane fade" id="Videos_tab" aria-expanded="false">
                                                         <?php
                                                            if($curr_val['videos']!="emp" && $curr_val['videos']!="") { 
                                                                /* $catfetdoc =  "SELECT * FROM docs WHERE doc_type=3 AND doc_id IN(".$curr_val['videos'].") AND doc_status=0"; */
                                                                $str_videos = $prop->getName('GROUP_CONCAT(doc_file)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=3 AND doc_id IN('.$curr_val['videos'].')');
                                                                
                                                                $str_videos_names = $prop->getName('GROUP_CONCAT(doc_name)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=3 AND doc_id IN('.$curr_val['videos'].')');
                                                                $arr_videos = explode(",", $str_videos);
                                                                $arr_videos_names = explode(",", $str_videos_names);
                                                                $result = count($arr_videos);
                                                                $ex = explode("v=",$arr_videos[0]);
                                                                $ex = explode("&",$ex[1]);
                                                            ?>
                                                                <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm-8 col-md-8">
                                                                        <iframe id="vid_frame" src="https://www.youtube.com/embed/<?php echo $ex[0]; ?>" frameborder="0" width="100%" height="500" frameborder="0" allowfullscreen></iframe>
                                                                    </div>
                                                                    <div class="col-sm-4 col-md-4" style=" background: #cccccc1a; box-shadow: 1px 2px 11px #cccccc5c; ">
                                                                        <div class="row">
                                                                        <div class="scroll-me">
                                                                            <div id="vid-list">
                                                                            <?php 
                                                                                for($i=0;$i<$result;$i++)
                                                                                {
                                                                                    $ex = explode("v=",$arr_videos[$i]);
                                                                                    $ex = explode("&",$ex[1]);
                                                                            ?>
                                                                            
                                                                                <div class="video-sec">
                                                                                    <div class="col-sm-4 col-md-4 pt1">
                                                                                        <a  class="dash" href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://www.youtube.com/embed/<?php echo $ex[0]; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
                                                                                          <span class="vid-thumb">
                                                                                        <img class="you" width="100%" height="auto" src="http://img.youtube.com/vi/<?=$ex[0]?>/hqdefault.jpg" /></span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-6 pt2"> 
                                                                                        <a  class="dash" href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://www.youtube.com/embed/<?php echo $ex[0]; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'"><label><?php echo $arr_videos_names[$i];?></label></a>
                                                                                    </div>
                                                                                </div>
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                            </div>
                                                                        </div>		
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                                                 </div>
                                                                                 
                                                         <div role="tabpanel" class="tab-pane fade" id="Checklist_tab" aria-expanded="false">
                                                                 <?php if($curr_val['images']!="emp" && $curr_val['images']!=""){?>
                                                                 <div class="tab_inner">
                                                                    <ul Class="handout-sst">
                                                                     <?php
                                                                    $catfetdoc =  "SELECT * FROM docs WHERE doc_type=4 AND doc_id IN(".$curr_val['images'].") AND doc_status=0";
                                                                    $rowdoc=$prop->getAll_Disp($catfetdoc);
                                                                    for($i=0; $i<count($rowdoc); $i++)
                                                                     {
                                                                     
                                                                     ?>
                                                                        <li><a href="<?php echo  $rowdoc[$i][doc_file]; ?>" target="_blank" title="Click To Attend Quiz"><i class="fa fa-list" aria-hidden="true"></i> <span class="title"><?php echo $rowdoc[$i][doc_name]; ?></span><span class="iconn"><i class="fa fa-arrow-circle-right"></i></span></a></li>
                                                                        <?php }?>
                                                                    </ul>
                                                                    </div>
                                                             <?php } ?>
                                                          </div>                        
                                                        </div>   
                                                    </div>
                                                    
                                                    
                                                </div>
                                                           
                                            </div>                                        
                                    	</div>                                	    
                                	</div>
                                </div>
                            </div>        
                           
                         </div>  
                	</div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="DepartmentAssigned">
                		<div class="col-md-12">
                            <div class="white-box">
                                <h3 class="box-title" style="padding-right: 0px;">
                                	<div class="row" style="width:100%">
                                	<div class="col-md-9">
                                    Departments Assigned
                                    </div>
                                    <div class="col-md-3" style="padding-right: 0px;">
                                    	<div class="input-group md-form form-sm form-2 pl-0">
                                      <input class="form-control my-0 py-1 lime-border" type="text" placeholder="Search" aria-label="Search" id="searchKeyword">
                                      <div class="input-group-append" style="background: gray;width: 36px;padding: 2px 10px;margin-right: -5px;">
                                        <span class="input-group-text lime lighten-2" id="basic-text1"><i class="ti-search text-grey"
                                            aria-hidden="true"></i></span>
                                      </div>
                                    </div>
                                    </div>
                                     <div class="clearfix"></div>
								
                                </div>
                                </h3>
                                 
                               
                                <div class="row" id="departAssignTab">
                               		
                                </div>
                            </div>
                        </div>        
                       
                	</div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="EmployeesAssigned">
                    	
                		<div class="col-md-12">
                            <div class="white-box">
                                <h3 class="box-title">Employees Assigned</h3>
                                <form method="post" name="empAssignForm">
                                <div class="row" style="margin-bottom:40px;">
                                	<div class="col-md-7">
                                    <select class="form-control select2" id="empselect" name="empNames[]" multiple required>
                                    <!--<option>Select Name</option>-->
                                    <?php
									$count = count($listEmps);
									for($i=0; $i<$count; $i++){ 
										echo '<option value="'.$listEmps[$i]['id'].'">'.$listEmps[$i]['name'].'</option>';
									}
									?>
                                </select></div>
                                    <div class="col-md-1">
                                        <div class="radio radio-success">
                                            <input id="assign-120" name="FlowType" type="radio"  value="1" required>
                                            <label class="category-label" for="assign-120"><b>Assign</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio radio-success">
                                            <input id="unassign-120" name="FlowType" type="radio" value="2"  >
                                            <label class="category-label" for="unassign-120"><b>UnAssign</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" name="btnEmpAssign" id="add_new_company" class="btn btn-success waves-effect waves-light pull-left m-r-10">
                                         Submit
                                        </button>
                                    </div>
                                </div>
                                </form>
                                <div class="row" style="margin-bottom:20px;">
                                	<div class="col-md-1" style="padding-top:7px;">
                                    Filter By
                                    </div>
                                <div class="col-md-3">
                                <input type="text" name="empKeyword" placeholder="Search by Employee Name" class="form-control" id="empKeyword" onKeyUp="filter_data()">
                                </div>    
                                <div class="col-md-3">
                                <select class="form-control select2" id="empFilterByDep" onChange="filter_data()" >
                                    <option value="">Select Department</option>
                                    <?php
									$count = count($listDepart);
									for($i=0; $i<$count; $i++){ 
										echo '<option value="'.$listDepart[$i]['dept_id'].'">'.$listDepart[$i]['dep_name'].'</option>';
									}
									?>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <select class="form-control select2" id="empFilterByType" onChange="filter_data()">
                                    <option value="">Select Type</option>
                                    <option value="0">Assign</option>
                                    <option value="2">Unassign</option>
                                </select>
                                </div>
                                <div class="col-md-2">
                                	<!--<button type="button" id="add_new_company" class="btn btn-success waves-effect waves-light pull-left m-r-10">
                                     Search
                                    </button>-->
                              </div>
                                <div class="clearfix"></div>
                                </div>
                           		<div class="row">
                                 <table id="myTable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Employee Assigned</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Employee Email </th>
                                            <th class="text-center" width="250px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                        		</div>
                    		 </div>
                        </div>        
                       
                	</div>               
                 
                </div>
                <div class="clearfix"></div>
                
            </div>
            <!-- /.container-fluid -->
              <?php include "footer.php" ?>

        </div>
        <!-- /#page-wrapper -->
    </div>
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
    	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>-->

    
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
			setcookie('status', $_COOKIE['status'], time()-10);
			setcookie('title', $_COOKIE['title'], time()-10);
			setcookie('err', $_COOKIE['err'], time()-10);
		}
	?>
	$(document).ready(function () { //newly added
		AssignPart('');
		$("#empselect").select2();
		$("#empFilterByDep").select2();
		$("#empFilterByType").select2();
		 $('#myTable1').DataTable( {
			"bFilter": false,
			"bInfo" : true,
			"paging":   true,
			"ordering": false,
			"info":     false,
			"lengthMenu": [ [50, 10, 150, 50000], [50, 100, 150, "All"] ],
			"processing": true,
			"serverSide": false,
			"displayLength": 50,
			"ajax":{
				url :"assignEmpTab.php", 
				type: "post",  
				"data": function ( data ) {
					data.empKeyword = $("#empKeyword").val();
					data.empFilterByDep = $("#empFilterByDep option:selected").val();
					data.empFilterByType = $("#empFilterByType option:selected").val();
					data.programID = <?php echo $page_id;?>;
					data.companyID = <?php echo $companyID;?>;
				},
				complete: function() {
					console.log('complete');
					$('[data-toggle="tooltip"]').tooltip();
				},
				error: function(){ 
					$(".form-grid-error").html("");
					$("#form-grid").append('<tbody class="form-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#form-grid_processing").css("display","none");
				}
			}
		});
		
		$('#searchKeyword').keyup(function(e){
			var keyword = $(this).val();
			AssignPart(keyword);
		});
		
		
	});
	/*Delete Code start*/
	$(document).on('click', '.deleteone', function() {
		var element = $(this);
		var id = element.attr("id");
		var status = 2;
		var ms = 'DELETE';
		swal({
			title: ms,
			text: "Are you sure?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Delete it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type: "POST",
					url: "ajax-status.php",
					cache:false,
					data: 'id='+id+'&status='+status+'&meth=AssignEmpDelete',
					dataType:'json',
					success: function(response)
					{
						swal(response.status, response.msg,response.err);
						setTimeout(function() {
							$(".confirm").trigger('click');
						}, 3000);
						if(response.result){
							location.reload();
						}
					}
				});
			}
			else
			{
				swal("Cancelled", "", "error");
				setTimeout(function() {
					$(".confirm").trigger('click');
				}, 3000);
			}
		});
		});
		/*Delete Code END*/
	function filter_data()
	{
		$('#myTable1').DataTable().ajax.reload();
	}
	function AssignPart(keyword)
	{
		$.ajax({
			url: "assignDepartTab.php",
			type: 'POST',
			data: 'keyword='+ keyword+'&programID=<?php echo $_REQUEST['programID']; ?>&companyID=<?php echo $companyID;?>',
			dataType:'html',
			success: function (datahtml) {
				$('#departAssignTab').html(datahtml);				
			}
		})
	}
	function assignDepart(that,catID,subCatID,deprtID)
	{
		if($(that).prop("checked") == true)
		type = 'assign';
		else
		type = 'unassign';
		 console.log(type);
		$.ajax({
			type: "POST",
			url: "ajax-status.php",
			cache:false,
			data: 'catID='+catID+'&subCatID='+subCatID+'&deprtID='+deprtID+'&programID=<?php echo $_REQUEST['programID'];?>&meth=assignDepart&type='+type,
			dataType:'json',
			success: function(response)
			{
				swal(response.status, response.msg,response.err);
				setTimeout(function() {
				  $(".confirm").trigger('click');
			 	}, 3000);
			}
		});
	}
	
	function assignEmp(type,empID)
	{
		$.ajax({
			type: "POST",
			url: "ajax-status.php",
			cache:false,
			data: 'catID=<?php echo $CatID; ?>&subCatID=<?php echo $subCatID ?>&empID='+empID+'&programID=<?php echo $_REQUEST['programID'];?>&meth=assignEmp&type='+type,
			dataType:'json',
			success: function(response)
			{
				swal(response.status, response.msg,response.err);
				setTimeout(function() {
				  $(".confirm").trigger('click');
			 	}, 3000);
			}
		});
	}
	</script>
</body>

</html>