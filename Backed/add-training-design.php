<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

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
	<!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<!-- Animation CSS -->
	<link href="css/animate.css" rel="stylesheet">
	<!-- Custom CSS -->
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
                            <a class="nav-link active" href="#TrainingDetails" role="tab" data-toggle="tab">Training Details</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#DepartmentAssigned" role="tab" data-toggle="tab">Department Assigned</a>
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
                                    <h3 class="box-title"> Be Safe Pages Details</h3>
                                	<div class="row">
                                        <div class="col-md-3 mb-5">
                                        <div class="main-category">
                                            <div class="checkbox checkbox-success">
                                                <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                            </div>
                                        </div>
                                        <div class="sub-catergory p-l-20">
                                            <div class="checkbox checkbox-success">
                                                <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                            </div>
                                        </div>
                                        <div class="sub-catergory pl-5">
                                            <div class="checkbox checkbox-success">
                                                <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-5">
                                            <div class="main-category">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory p-l-20">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Sub Catergory</b></label>
                                                </div>
                                            </div>
                                            <div class="sub-catergory pl-5">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                                    <label class="category-label" for="checkbox-0"><b>Program Name</b></label>
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
                                <h3 class="box-title">Department Assigned</h3>
                            	<div class="row">
                                 	<div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-0"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-1" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-1"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-2" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-2"><b>Department1(2)</b></label>
                            </div>
                        </div>
                               	    <div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-10" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-10"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-20" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-20"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-0" data-class="checkbox-all" data-id="30" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-30"><b>Department1(2)</b></label>
                            </div>
                        </div>
                                	<div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-120" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-120"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-220" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-220"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-33" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-33"><b>Department1(2)</b></label>
                            </div>
                        </div>
                        		</div>
                            </div>
                        </div>        
                       
                	</div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="EmployeesAssigned">
                    	
                		<div class="col-md-12">
                            <div class="white-box">
                                <h3 class="box-title">Employees Assigned</h3>
                                <div class="row" style="margin-bottom:40px;">
                                	<div class="col-md-7">
                                    <select class="form-control select2" id="empselect" >
                                    <option>Employee Name</option>
                                    <option>EMP2</option>
                                    <option>EMP3</option>
                                    <option>EMP4</option>
                                    <option>EMP5</option>
                                    <option>EMP6</option>
                                </select></div>
                                <div class="col-md-1">
                                	<div class="radio radio-success">
                                        <input id="assign-120"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="assign">
                                        <label class="category-label" for="assign-120"><b>Assign</b></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<div class="radio radio-success">
                                        <input id="unassign-120"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="unassign">
                                        <label class="category-label" for="unassign-120"><b>UnAssign</b></label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<button type="button" id="add_new_company" class="btn btn-success waves-effect waves-light pull-left m-r-10">
                     Add
                    </button>
                                </div>
                                </div>
                                
                                <div class="row" style="margin-bottom:20px;">
                                	<div class="col-md-1" style="padding-top:7px;">
                                    Filter By
                                    </div>
                                <div class="col-md-3">
                                <select class="form-control select2" id="empselect" >
                                    <option>Select Department</option>
                                    <option>Department1</option>
                                    <option>Department2</option>
                                    <option>Department3</option>
                                    <option>Department4</option>
                                    <option>Department4</option>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <select class="form-control select2" id="empselect" >
                                    <option>Select Type</option>
                                    <option>Assign</option>
                                    <option>Unassign</option>
                                </select>
                                </div>
                                <div class="clearfix"></div>
                                </div>
                           		<div class="row">
                                 <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Employee Assigned</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center" width="250px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
										<tr>
                                        	<td>EMP1</td>
                                            <td>Dep1</td>
                                            <td>
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="assign1"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="assign">
                                                <label class="category-label" for="assign1"><b>Assign</b></label>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="unassign1"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="unassign">
                                                <label class="category-label" for="unassign1"><b>UnAssign</b></label>
                                            </div>
                                            </div>
                                            </div>

                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>EMP1</td>
                                            <td>Dep1</td>
                                            <td>
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="assign2"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="assign">
                                                <label class="category-label" for="assign2"><b>Assign</b></label>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="unassign2"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="unassign">
                                                <label class="category-label" for="unassign2"><b>UnAssign</b></label>
                                            </div>
                                            </div>
                                            </div>

                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>EMP1</td>
                                            <td>Dep1</td>
                                            <td>
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="assign3"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="assign">
                                                <label class="category-label" for="assign3"><b>Assign</b></label>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="radio radio-success">
                                                <input id="unassign3"  data-id="0" class="category" name="type[]" value="2" type="radio"  value="unassign">
                                                <label class="category-label" for="unassign3"><b>UnAssign</b></label>
                                            </div>
                                            </div>
                                            </div>

                                            </td>
                                        </tr> 
										
										
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
    
    
	<script>
	$(".select2").select2();
	$('#add_new_company').click(function() {
	  console.log('okkkk');
	  if ($('input[name="category[]"]').is(':checked')) 
	  {
	  	return true;
	  }
	  else
	  {
	  	swal('Please select Permission');
		setTimeout(function() {
			$(".confirm").trigger('click');
		}, 3000);
		return false;
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
			setcookie('status', $_COOKIE['status'], time()-10);
			setcookie('title', $_COOKIE['title'], time()-10);
			setcookie('err', $_COOKIE['err'], time()-10);
		}
	?>
	$(document).ready(function () { //newly added
		$("select[name='industry_type']").change(function(){
			$("#industry_text").val($(this).find(":selected").text());
		});
		
		<?php //if(!(isset($_REQUEST['id']) && $_REQUEST['id']>0)){ ?>
        $('#inputemail').keyup(function () {
			//alert($(this).val());
            var inputemail = $(this).val(); // assuming this is a input text field
			
				$.ajax({
						type: "POST",
						url: "ajax.php",
						cache:false,
						data: 'emailid='+inputemail+'&meth=companyemailexist',
						dataType: 'json',
						success: function(data)
						{
							if(data.status) {
								console.log(data.status+"ppp");
								$("#inputemail").css("border", "1px solid #CC2424");
								$(".alexist").html("Email ID already exist");
								$(".alexist").css("color", "#CC2424");
								$("#inputemail").focus();
								 $(':input[type="submit"]').prop('disabled', true);
								return false;
							}
							else {
								console.log(data.status);
								$("#inputemail").css("border", "1px solid #E4E7EA");
								$(".alexist").html("");
								 $(':input[type="submit"]').prop('disabled', false);
							}
						}
					});
					
					
					$(document).ready(function() {
		 $('#myTable').DataTable( {
			"bFilter": true,
			"bInfo" : true,
			"paging":   true,
			"ordering": false,
			"info":     false,
			"lengthMenu": [ [50, 10, 150, 50000], [50, 100, 150, "All"] ],
			"displayLength": 50,
			"processing": true,
			"serverSide": true
			
		});
                
        });
		<?php //} ?>
		$("#inputPassword4, #inputPasswordConfirm4").keydown(function(e){
		 if (e.keyCode == 32) { 
		var ID=$(this).attr('rel');
		 $("#"+ID).fadeIn(1000).fadeOut(1000);
       return false; 
     }
	});	
    });
	function ResetFormVal(){
		$("#formadvertiser")[0].reset();
	}
	</script>
<script src="js/jquery.qubit.js"></script>
<script src="js/jquery.json-list.js"></script>
<script src="js/jquery.bonsai.js"></script>
<script>
$('.auto-checkboxes').bonsai({
  expandAll: true,
  checkboxes: true, // depends on jquery.qubit plugin
  createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
});
</script>
<script>
$(document).ready(function () {
	$( 'input[type="checkbox"]' ).click(function() {
		setInterval(function(){ 
			$( 'input[type="checkbox"]' ).each(function( index ) {
				console.log($(this).val());
				if ($(this).prop("indeterminate")) {
					$(this).prop("indeterminate", false);
					$(this).prop("checked", true);
					console.log( index + ": " + $( this ).val() );
				}
			});
		}, 3000);
	  	
	  
	});
	
})
</script>
</body>

</html>