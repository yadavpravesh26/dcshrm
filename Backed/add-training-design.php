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
    
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />-->
	
    <!-- Menu CSS -->
	<link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
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
    background: url(http://dcshrm.com/sadmin/uploads/catdetails/1586402717.JPG) no-repeat center center;
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
/*.multiselect.dropdown-toggle.btn.btn-default{background:transparent}
.multiselect-container{width:100%}*/
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
                                    <div class="img-banner"><div class="banner-txt">ASBESTOS AWARENESS</div></div>
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
                    </ul>
                </div>
				<div class="text-box col-md-12" id="runtime_descript">
                	<div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade active show" id="Content_tab" aria-expanded="true">
						<p><strong>Asbestos Awareness</strong></p>
<p>We do not have asbestos exposures in our normal business, but this does not mean that we will not encounter it as we visit job sites. If you suspect exposure to asbestos due to demolition or another source, report it immediately to a supervisor.</p>
<p>&nbsp;</p>
<p><strong>What are the Hazards? </strong></p>
<p>Asbestos fibers are difficult to see with just the naked eye and breathing asbestos can cause a buildup of asbestosis in the lungs causing scaring and reduced function. Exposure to asbestos can lead to multiple abnormalities such as; lung cancer, mesothelioma, and death. People most commonly exposed to asbestos tend to work in the construction industry, ship repair, or any job that includes renovations or demolitions.</p>
<p>&nbsp;</p>
<p><strong>How to Avoid the Hazards </strong></p>
<ul>
<li>There are OSHA standards set to protect employees from asbestos in all industries.</li>
<li>Companies and organizations are required by law to provide personal exposure assessment of the risk and hazards associated with exposure to asbestos with that specific job duty.</li>
<li>There are laws set to determine the highest possible airborne levels of asbestos that someone could be required to work in. These are called Permissible Exposure Limit (PEL). Although there are no safe levels of exposure to asbestos, there are levels that lead to more serious harm.</li>
<li>Where exposure exists, employers are required to protect workers by declaring regulated areas, controlling job duties in those areas, provide relevant protective equipment and implementing engineering controls to limit airborne levels as much as possible.</li>
</ul>
<p>&nbsp;</p>
<p><strong>Key Things to Remember When Working with Asbestos </strong></p>
<p>* Always wear protective mask and other equipment</p>
<p>* Wash clothes immediately when finished working</p>
<p>* Shower or rinse at the job site</p>
<p>* Always be aware!</p>
<p>&nbsp;</p>                                                <!--<div id="loadMore" style="">
                          <a style="cursor:pointer">Load More</a>
                        </div>-->
                                                              </div>

                     <div role="tabpanel" class="tab-pane fade" id="Handout_tab" aria-expanded="false">
                     							<div class="tab_inner">
						<ul class="handout-sst">
													<li>
                                                       <a href="images/docs/ASBESTO AWARENESS PROGRAM.docx"> <span class="title"><i class="fa fa-file-word-o"></i>ASBESTO AWARENESS PROGRAM</span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li>
                                                       <li>
                                                       <a href="images/docs/ASBESTO AWARENESS PROGRAM.docx"> <span class="title"><i class="fa fa-file-word-o"></i>COVID AWARENESS PROGRAM</span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li>
						    
						</ul>
						</div>
						                     </div>
                                          <div role="tabpanel" class="tab-pane fade" id="Quiz_tab" aria-expanded="false">
                     	    			   		 <div class="tab_inner">
                            <ul class="handout-sst">
                                                             <li><a href="" target="_blank" title="Click To Attend Quiz"><img src="img/notepad.png"><span class="title">ASBESTOS AWARENESS</span><span class="iconn"><i class="fa fa-arrow-circle-right"></i></span></a></li>
                                                             <li><a href="" target="_blank" title="Click To Attend Quiz"><img src="img/notepad.png"><span class="title">Training Quiz</span><span class="iconn"><i class="fa fa-arrow-circle-right"></i></span></a></li>
                                                            </ul>
                            </div>
    			                          </div>
                     <div role="tabpanel" class="tab-pane fade" id="Videos_tab" aria-expanded="false">
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
                                      <input class="form-control my-0 py-1 lime-border" type="text" placeholder="Search" aria-label="Search">
                                      <div class="input-group-append" style="background: gray;width: 36px;padding: 2px 10px;margin-right: -5px;">
                                        <span class="input-group-text lime lighten-2" id="basic-text1"><i class="ti-search text-grey"
                                            aria-hidden="true"></i></span>
                                      </div>
                                    </div>
                                    </div>
                                     <div class="clearfix"></div>
								
                                </div>
                                </h3>
                                 
                               
                               <div class="row">
                                 	<div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-0" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-0"><b>Air Force(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-1" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-1"><b>Bankruptcy Courts Forms(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-2" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-2"><b>Coast Guard Forms(2)</b></label>
                            </div>
                        </div>
                               	    <div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-10" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-10"><b>National Mediation Board Forms(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-20" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-20"><b>Department1(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-0" data-class="checkbox-all" data-id="30" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-30"><b>Defense Health Agency Forms(2)</b></label>
                            </div>
                        </div>
                                	<div class="col-md-4">
                            <div class="checkbox checkbox-success">
                                <input id="depart-120" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-120"><b>Denali Commission Forms(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-220" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox" checked>
                                <label class="category-label" for="depart-220"><b>Parole Commission Forms(2)</b></label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="depart-33" data-class="checkbox-all" data-id="0" class="category" name="category[]" value="2" type="checkbox">
                                <label class="category-label" for="depart-33"><b>Tax Court Forms(2)</b></label>
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
                                    <select class="form-control select2" id="empselect" multiple >
                                    <!--<option>Select Name</option>-->
                                    <option>AARON</option>
                                    <option>BRENDAN</option>
                                    <option>CHARLEY</option>
                                    <option>DAVID</option>
                                    <option>ELIAS</option>
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
                                <input type="text" name="" placeholder="Search by Employee Name" class="form-control">
                                </div>    
                                <div class="col-md-3">
                                <select class="form-control select2" id="select_dep" >
                                    <option>Select Department</option>
                                    <option>Air Force</option>
                                    <option>AmeriCorps</option>
                                    <option>Bankruptcy Courts Forms</option>
                                    <option>Coast Guard Forms</option>
                                    <option>National Mediation Board Forms</option>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <select class="form-control select2" id="select_type" >
                                    <option>Select Type</option>
                                    <option>Assign</option>
                                    <option>Unassign</option>
                                </select>
                                </div>
                                <div class="col-md-2">
                                	<button type="button" id="add_new_company" class="btn btn-success waves-effect waves-light pull-left m-r-10">
                                     Search
                                    </button>
                              </div>
                                <div class="clearfix"></div>
                                </div>
                           		<div class="row">
                                 <table id="myTable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Employee Assigned</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center" width="250px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
										<tr>
                                        	<td>ALBERT</td>
                                            <td>Air Force</td>
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
                                        	<td>CAMERON</td>
                                            <td>AmeriCorps</td>
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
                                        	<td>BRETT</td>
                                            <td>Bankruptcy Courts Forms</td>
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
	
		$("#empselect").select2();
		$("#select_dep").select2();
		$("#select_type").select2();
		$("#empselect").MultiSelect({
		  nonSelectedText: 'Select Employee Name'
		 });*/
		 
		 $('#myTable1').DataTable( {
			"bFilter": false,
			"bInfo" : true,
			"paging":   true,
			"ordering": false,
			"info":     false,
			"lengthMenu": [ [50, 10, 150, 50000], [50, 100, 150, "All"] ],
			"processing": true,
			"serverSide": false,
			"displayLength": 50
		} );
		
	});
	</script>
</body>

</html>