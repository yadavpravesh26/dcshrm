<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('bitly.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$table_name = 'jobs';
$table_name2 = 'job_applications';
$jobID = $_REQUEST['jobID']!=''?$_REQUEST['jobID']:'';
if($jobID == ''){
	header('location:careers.php');
	exit;
}
$curr_val = $prop->get('*',$table_name, array('id'=>$_REQUEST['jobID']));
if(empty($curr_val) || $curr_val['job_status']===2){
	header('Location: careers.php');
	exit;
}
if(isset($_POST['btnApply']))
{
	$msg = 'Enter Name';
	if($_POST['name']!=''){
		$msg = 'Job applying Failed';
		if(isset($_FILES['resume']['name']) && $_FILES['resume']['name']!=''){
			$result = 0;
			$allowedExtensions = array('doc', 'docx', 'pdf', 'docx');
			
			
			$extension = end(explode('.',strtolower($_FILES['resume']['name'])));
			$msg = 'File invalid format';
			if(in_array($extension, $allowedExtensions)){
				$doc_file = rand(10,100).time().'.'.$extension;
				if (move_uploaded_file($_FILES['resume']['tmp_name'], 'images/docs/'.$doc_file)) {
					$result = 1;
				}else{
					$msg = 'File not upload';
				}
			}
		}
		$input  = array(
			'name'		=>$_POST['name'],
			'email'		=>$_POST['email'],
			'city'		=>$_POST['city'],
			'country'		=>$_POST['country'],
			'phone'		=>$_POST['phone'],
			'resume'		=>$doc_file
		);
		if($result){
			$result = $prop->add($table_name2, $input);
			if ($result) {
				$msg = "Thanks for applying, Our team will response you soon";
			}
		}	
	}
}
?>
<!DOCTYPE html><html>
<head>        
<title><?php echo $curr_val['job_title']; ?></title>
<meta charset="utf-8">
<meta name="author" content="">
<meta name="robots" content="index follow">
<meta name="googlebot" content="index follow">
<meta name="keywords" content="">
<meta name="description" content="">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="https://edificecms.com/builder/elements/images/uploads/project201/dcshrm.png">  
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet" async>
<link rel="stylesheet" href="https://edificecms.com/builder/elements/images/uploads/project201/css/edifice-common-css.css?1582206961" type="text/css">
<link rel="stylesheet" href="https://edificecms.com/builder/elements/images/uploads/project201/css/edifice-index.css?1582206961" type="text/css">
<link rel="stylesheet" href="https://edificecms.com/builder/elements/js/vendor/bootstrap/css/bootstrap.min.css" async>
        <link rel="stylesheet" href="https://edificecms.com/builder/elements/fonts/font-awesome/css/font-awesome.min.css" async>
        <link rel="stylesheet" href="https://edificecms.com/builder/elements/css/page-publish.css" async>
        <link rel="stylesheet" href="https://edificecms.com/builder/elements/js/plugins/wow/css/animate.min.css" async>
        <link rel="stylesheet" href="https://edificecms.com/builder/elements/css/style.css" async>
        <link rel="stylesheet" href="https://edificecms.com/builder/elements/css/custom.css" async>

<style>
    .header-section{display:none; }
	.border-bottom{border-bottom:1px solid #f1f1f1; margin-bottom:25px;}
	#btn-black {
		font-weight: 400;
		font-size: 15px;
		padding-top: 8px;
		padding-right: 15px;
		padding-bottom: 8px;
		padding-left: 15px;
		color: #ffffff;
		background-color: #000 ;
		border: 2px solid #1e1818;
	}
	#btn-black:hover{background: #fff;
    border: 2px solid #1e1818;
    color: #1e1818;}
	
	label[for="fileuploader"] {
		font-weight: 400;
		font-size: 15px;
		padding-top: 8px;
		padding-right: 15px;
		padding-bottom: 8px;
		padding-left: 15px;
		color: #ffffff;
		background-color: #000 ;
		border: 2px solid #f1f1f1;
	}
	label[for="fileuploader"]{background: #fff;
    border: 2px solid #f1f1f1;
    color: #1e1818;}
	.big_sidebar{border-right: 1px solid #f1f1f1;
    margin-right: 20px;
    padding-right: 15px;}
</style>


</head>
<body data-spy="scroll" data-target=".header-menu-container" data-offset="61" style="font-family: 'Poppins', sans-serif !important;"><div class="droptrue" data-height="undefined">
<section class="edifice-section edi-bgimg edi-bg-img001 position-relative" data-block-type="section" data-section-id="001" data-section-type="hero-section" div-selector="parent-section" id="section-par-KRuKu">
   <!-- container -->
   <div class="container">
      <div class="row">
         <!--<div class="col-bg-container">
            <div class="video-bg1">
            <video autoplay muted loop class="myVideo">
            <source src="SampleVideo_1280x720_1mb(1).mp4" type="video/mp4">
            </video>
            </div>
            </div>-->
         <div class="col-xs-12 col-sm-4 col-md-3" id="column-9dZees8" data-lobipanel-child-inner-id="s2yfIHpA9x FjOzuVBBEz PvrTN">
             
         <div class="edifice-widget" data-block-type="widget" data-widget-type="icon-group" data-widget-id="020" id="widget-HdVBBxQ"><div class="edi-iconsgroup"><ul class="edi-icongroup-list"><li class="text-center" id="icon-HdVBBxQ"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-facebook"></i><span class=""></span></a></li><li class="text-center" id="icon-GEgS9lS"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-twitter"></i><span class=""></span></a></li><li class="text-center" id="icon-aXNMVfb"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-google-plus"></i><span class=""></span></a></li><li class="text-center" id="icon-4NAdrh2"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-youtube"></i><span class=""></span></a></li><li class="text-center" id="icon-hHBdVlK"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-linkedin"></i><span class=""></span></a></li></ul></div></div></div><div class="col-xs-12 col-sm-8 col-md-9" id="column-ykAuPyc" data-lobipanel-child-inner-id="8nSvOhDwIi Cg9z7AHKws aaUesjpyy7 8xZna">
             
         <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-K28fHHH"><p class="hdtitle"><i class="fa fa-phone"></i><span> Call Us:   +1 (801) 360-5036
</span></p></div><div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ZU04W"><p class="hdtitle"><i class="fa fa-envelope"></i><span>Info@dcshrm.com</span></p></div></div>
         
         <!-- /End row -->
      </div>
   </div>
   <!-- /End container -->
</section>
</div>
<div class="droptrue" data-height="undefined">
<!-- ICO Header
================================ -->
<section data-block-type="section" data-section-type="hero-section" data-section-id="001" class="edifice-section no-top-modal" div-selector="topheaderdrag-section" id="section-par-F5fiV">
    <!-- Fixed navbar -->
    <header>
        <nav class="navbar navbar-default navbar-sticky bootsnav">
         
            <div class="container">
                <div style="display:none;">
                    <li class="list-struct" id="1" data-menutype="t1~0"> <a class="list-link link" href="#">Home</a>								</li>
                    <li class="dropdown list-child-struct" id="3" data-menutype="t1~0"> <a href="#" class="dropdown-toggle list-link link" data-toggle="dropdown">Services</a>
                        <ul class="dropdown-menu"></ul>
                    </li>
                </div>
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"> <i class="fa fa-bars"></i>								</button>
                    <a id="brand" class="navbar-brand dev-logo-settings" href="index.html" target="">
                        <img src="https://edificecms.com/builder/elements/images/uploads/project201/1558678284.png" alt="Logo">								</a>							</div>
                <!-- End Header Navigation -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="up_main_menu nav navbar-nav navbar-right d-custom-submenu" data-in="fade" data-out="fade"><input type="hidden" name="menutyepe" id="menutyepe" value="0"><li class="list-struct" id="1616" data-menutype="t1~2"> <a class="list-link link" href="index.html">Home</a>
                    </li><li class="list-struct" id="1443" data-menutype="t1~2"> <a class="list-link link" href="about-us.html">About Us</a>
                    </li><li class="dropdown list-child-struct" id="9405" data-menutype="t1~2"> <a href="#" class="dropdown-toggle list-link link" data-toggle="dropdown">Browse by Category </a>
                        <ul class="dropdown-menu" id="9405"><li class="list-struct" id="6504" data-menutype="t1~2"> <a class="list-link link" href="#">Automotive</a>
                    </li><li class="list-struct" id="389" data-menutype="t1~2"> <a class="list-link link" href="#">Heavy Manufacturing</a>
                    </li><li class="list-struct" id="9105" data-menutype="t1~2"> <a class="list-link link" href="#">Light Manufacturing</a>
                    </li><li class="list-struct" id="4019" data-menutype="t1~2"> <a class="list-link link" href="#">Health Care</a>
                    </li><li class="list-struct" id="7944" data-menutype="t1~2"> <a class="list-link link" href="#">Office/Education</a>
                    </li><li class="list-struct" id="2925" data-menutype="t1~2"> <a class="list-link link" href="#">Distribution</a>
                    </li><li class="list-struct" id="3174" data-menutype="t1~2"> <a class="list-link link" href="#">Oil &amp; Gas</a>
                    </li><li class="list-struct" id="5249" data-menutype="t1~2"> <a class="list-link link" href="#">Electrical</a>
                    </li></ul>
                    </li><li class="list-struct" id="3585" data-menutype="t1~2"> <a class="list-link link" href="#">Blog</a>
                    </li><li class="list-struct" id="4622" data-menutype="t1~2"> <a class="list-link link" href="bsafe-program.html">B-Safe Program</a>
                    </li><li class="list-struct" id="3580" data-menutype="t1~2"> <a class="list-link link" href="#">Contact Us</a>
                    </li><li class="list-struct" id="6280" data-menutype="t1~2"> <a class="list-link link" target="_blank" href="https://dcshrm.com/login.php">Login</a>
                    </li><li class="list-struct" id="3124" data-menutype="t1~2"> <a class="list-link link" href="#section-par-jtnxs">Free consultation</a>
                    </li></ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
<div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- /.navbar -->
</section>
</div><div class="droptrue" data-height="">

</div>
<div class="droptrue" data-height="undefined">
<!-- Content 22
==================================================================== -->

<section class="edifice-section edi-bgimg position-relative white-section bgf1f1f1" data-block-type="section" data-section-id="001" data-section-type="hero-section" div-selector="parent-section" id="section-par-jkVuN">

<div id="content-section-22" class="content-section">
    <!-- Section Container -->
    <div class="section-container">


        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
            	<!-- col-md-9 -->
                <div class="col-md-9 col-sm-12 col-xs-12 lobipanel-parent-sortable border-line" data-lobipanel-child-inner-id="5Km8lvR5nb mw7pO">
                	 <!-- row -->
                 	<div class="row big_sidebar">
				        <!-- Title Block -->
                        <div class="col-md-12 col-sm-12 col-xs-12 no-top-modal title-block">
                            <!-- Title Block Container -->
                            <div class="title-block-container lobipanel-parent-sortable" data-lobipanel-child-inner-id="F4L4DABlZ3 8othh10Gnf eW3l6">

                                <!-- Title -->

                                <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" id="widget-GmpM4"><h1 class="hdtitle"><span><?php echo $curr_val['job_title'];?></span></h1>
                                </div>
								<div style="border-bottom:1px solid #f1f1f1"></div>

                            </div><!-- /End Title Block Container -->
                        </div>
                        <!-- /End Title Block -->
						<!-- Content Block -->
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	Position Title:
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	<?php echo $curr_val['job_title'];?>
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	Pay Range:
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	<?php echo $curr_val['pay_range'];?>
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	Job Location:
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	<?php echo $curr_val['job_city'];?>, <?php echo $curr_val['job_state'];?>
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	Duration:
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	<?php echo $curr_val['duration'];?>
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	Last Date Apply:
						</div>
                        <div class="col-md-6 col-sm-12 col-xs-6 no-top-modal content-block content-block-style-3">
                        	<?php echo $curr_val['last_date_apply'];?>
						</div>

                        <!-- Content Block -->
                        <div class="col-md-12 col-sm-12 col-xs-12 no-top-modal content-block content-block-style-3">
                            <!-- Content Block Container -->
                            <div class="content-block-container">

                                <div class="display-table">
                                    
                                    <div class="table-cell-vt">
                                        <div class="lobipanel-parent-sortable" data-lobipanel-child-inner-id="VQboCuM0EF Posubi3XnD Q5x1a">

                                            

                                            <div class="edifice-widget" data-block-type="widget" data-widget-type="text-block" data-widget-id="003" id="widget-f6NU4"><h1 class="hdtitle"><span></span></h1>
                                                
                                                <div class="d-edi-content-block">
                                                	<p class="para-content">
                                                    	<?php echo $curr_val["job_responsibilities"]; ?>
                                                    </p>
                                                </div>
                                               <div class="d-edi-content-block">
                                                    <p class="para-content">
                                                    	<?php echo $curr_val["job_requirements"];?>
                                                    </p>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>

                            </div><!-- /End Content Block Container -->
                        </div>
                        <!-- /End Content Block -->


                        <!-- Content Block -->
                        <div class="col-md-12 col-sm-12 col-xs-12 no-top-modal content-block content-block-style-3 job_end_border">
                            <!-- Content Block Container -->
                            <div class="content-block-container" id="apply-now">
                            <p style="text-align:center; font-weight:bold; margin-bottom:30px;">Please submit your resume in MS Word or PDF format</p>
								<form method="post" data-toggle="validator" enctype="multipart/form-data">
                                	<?php
                                    if(isset($msg))
									{
										echo "<p style='text-align:center'>".$msg."</p>";
									}
									?>
                                	<div class="sp-component col-md-6">
                                       <input class="form-control border-bottom" type="text" required name="name" id="name" placeholder="Enter your Name">
                                    </div>
                                    <div class="sp-component col-md-6">
                                       <input class="form-control border-bottom" type="email" required name="email" id="email" placeholder="Enter your Email">
                                    </div>
                                    <div class="sp-component col-md-6">
                                       <input class="form-control border-bottom" type="text" required name="city" id="name" placeholder="Enter your City">
                                    </div>
                                    <div class="sp-component col-md-6">
                                       <input class="form-control border-bottom" type="text" required name="country" id="country" placeholder="Enter your Country">
                                    </div>
                                    <div class="sp-component col-md-6">
                                       <input class="form-control border-bottom" type="text" required name="phone" id="phone" placeholder="Enter your Phone">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="control-label">Upload Resume</label>
                                          <input type="file" id="fileuploader" name="resume" required class="filestyle btn-fileUpload" data-buttonText="Select a File">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    
                                    <div class="btn-group right" id="btn-group-d25H4lk"><a class="btn btn-custom btn-square btn-standard" id="btn-black" href="careers.php"><span>Back</span></a></div>
                                    <div class="btn-group right" id="btn-group-d25H4lk"><button class="btn btn-custom btn-square btn-standard" name="btnApply" id="btn-ZmFzsur" type="submit"><span>Apply</span></button></div>
                                    	
                                    </div>
                                    
                                </form>
                            </div><!-- /End Content Block Container -->
                        </div>
                        <!-- /End Content Block -->
                        


                   
                
               </div>
                    <!-- /End row -->
				</div>
                <!-- /End col-md-9 -->
                 <!-- col-md-3 Sidebar-->
                <div class="col-md-3">
                	<div class="row small_sidebar">
                        <div class="btn-group right" style="width:100%" id="btn-group-d25H4lk"><a class="btn btn-custom btn-square btn-standard" id="btn-ZmFzsur" href="#apply-now" style="width:100%"><span>APPLY FOR THIS JOB</span></a></div>
                        <!-- Social-->
                        <div class="edifice-widget" data-block-type="widget" data-widget-type="icon-group" data-widget-id="020" id="widget-HdVBBxQ">
                    <div class="edi-iconsgroup" style="background:#CCCCCC;margin-top: 30px;"><ul class="edi-icongroup-list">
                    <li class="text-center" id="icon-HdVBBxQ" style="color:#FFFFFF">Share</li>
                    <li class="text-center" id="icon-HdVBBxQ"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-facebook"></i><span class=""></span></a></li><li class="text-center" id="icon-GEgS9lS"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-twitter"></i><span class=""></span></a></li><li class="text-center" id="icon-aXNMVfb"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-google-plus"></i><span class=""></span></a></li><li class="text-center" id="icon-4NAdrh2"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-youtube"></i><span class=""></span></a></li><li class="text-center" id="icon-hHBdVlK"><a class="bg-fanta color-white" href="javascript:void(0);"><i class="fa fa-linkedin"></i><span class=""></span></a></li></ul></div></div>
                    	<div style="margin-top:30px;margin-bottom:30px; border-top:1px solid #f1f1f1"></div>
                        <p style="text-align:center"><a href="#" style="color:#e40303; font-weight:bold">NOT THE RIGHT JOB?</a></p>
                        <p style="text-align:center"><a href="#" style="color:#e40303; font-weight:200">JOIN OUR TALENT NETWOK</a></p>
                    </div>
                    
                </div>
                <!-- /End col-md-3 Sidebar -->
                
            </div><!-- /End row -->
        </div><!-- /End container -->


    </div><!-- /End Section Container -->
</div>

</section>

<!-- /End Content 22 -->
</div>


 


<div class="droptrue" data-height="undefined">
<!-- Footer 4
==================================================================== -->
<footer id="footer-section-4" class="footer-section white-section section-xs-padding">
<!-- <section class="edifice-section section-par-sOh4x" data-block-type="section" data-section-id="001" data-section-type="hero-section" div-selector="parent-section" id="section-par-ClZV7">
<!-- Section Container -->
<!--       <div class="section-container">
<!-- container -->
<!--          <div class="container">
   <!-- row -->
<!--             <div class="row">
      <!-- Widget Block ( Link ) -->
<!--                <div class="col-md-3 col-sm-4 col-xs-12" id="column-bjcWzAy">
         <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-Qywwrl9"><h4 class="hdtitle"><span>Get In Touch</span></h4>
            
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-zffxa">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-globe"></i><span>1102 Saint Marys, Junction City, KS</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ICa0h">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-phone"></i><span>+123 455 755</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-kJ3HB">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-envelope"></i><span>contact@dcshrm.com</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-x9KJJ">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-link"></i><span> http://www.dcshrm.com</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ghhjq">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-compass"></i><span>9.00 am to 7.00 pm</span></a></h6>
         </div>
         <div class="edifice-widget widget-mbquq" data-block-type="widget" data-widget-type="icon-group" data-widget-id="020" style="position: relative; top: 0px; left: 0px; opacity: 1;" id="widget-ahfKl">
            <div class="edi-iconsgroup">
               <ul class="edi-icongroup-list">
                  <li class="text-center" id="icon-2RRWgk7">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-twitter"></i>
                     </a> 
                  </li>
                  <li class="text-center" id="icon-qBqjOk1">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-facebook"></i>
                     </a> 
                  </li>
                  <li class="text-center" id="icon-JkeQU4Y">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-google-plus"></i>
                     </a> 
                  </li>
                  <li class="text-center" id="icon-N8JYkA9">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-linkedin"></i>
                     </a> 
                  </li>
                  <li class="text-center" id="icon-4XD31NH">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-pinterest"></i>
                     </a> 
                  </li>
                  <li class="text-center" id="icon-4Inv5zW">
                     <a class="icon-circle color-white" href="#" target="_blank"> 
                     <i class="fa fa-dribbble"></i>
                     </a> 
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="col-sm-3 col-md-2 col-xs-4" id="column-FtE6OHK">
         <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-MuwsyZC"><h4 class="hdtitle"><span>Our Firm</span></h4>
            
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-XuqSwVZ">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>What We Do</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-vJ5QE">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Our Lawyer</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-OH8I3">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Our FAQ</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-tm4Jw">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Practice Area</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-1Im2O">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Popular Blog</span></a></h6>
         </div>
      </div>
      <div class="col-sm-3 col-md-2 col-xs-5" id="column-4aVojGL">
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-TDJv8M1"><h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>How We Help</span></a></h6>
            
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-CBVXsOW">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Our Success</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-V4xXNsw">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Fill a Form</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-Y1NwDGN">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Latest News</span></a></h6>
         </div>
         <div class="edifice-widget text-left widget-NFYdX" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-OV1X2ws">
            <h6 class="fw-normal mt-50 hdtitle"><a href="#" target=""><i class="fa fa-angle-right"></i><span>Resources</span></a></h6>
         </div>
      </div>
      <div class="empty-container col-md-4 col-sm-8 col-xs-12" id="column-ptRH9tS">
         <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-bR8EB9N"><h5 class="hdtitle"><span>Quick Contact</span></h5>
            
         </div>
         <div id="widget-fNJZTf0" class="edifice-widget" data-block-type="widget" data-widget-type="form-advance" data-widget-id="053" style="position: relative; top: 0px; left: 0px; opacity: 1;">
            <form class="edi-form edi-adv-vertical-form" action="#" method="post" enctype="multipart/form-data" data-border="bordered">
               <div class="col-md-12 col-sm-12 col-xs-12 p-0">
                  <input type="hidden" name="current_page" id="cur_pae_name" class="cur_pae_name" value=""><input type="hidden" name="sender_email" id="sender_email" class="sender_email" value="wasil@hexagonitsolutions.com"><input type="hidden" name="bcc_email" id="bcc_email" class="bcc_email" value=""><input type="hidden" name="pro_id" id="pro_id" class="pro_id" value="201"><input type="hidden" name="form_type" id="f_type" class="f_type" value="2"><input type="hidden" name="captcha_type" id="captcha_type" class="" value="none">
                  <div class="edi-form-container">
                     <div data-enable-settings="yes" class="col-sm-6 col-xs-12 col-md-6" id="column-CCI5296">
                        <div id="widget-fields-K46mOKI" class="edifice-widget" data-block-type="widget" data-widget-type="form-fields-input" data-widget-id="054" data-is-required="true" style="position: relative; top: 0px; left: 0px; opacity: 1;">
                           <div class="edi-adv-form-group">
                              <div class="edi-adv-form-label hide"><label>Name</label></div>
                              <div class="edi-adv-form-component">
                                 <div class="input-group"><input type="text" class="form-control" id="inpK46mOKI" name="Name" placeholder="Name"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div data-enable-settings="yes" class="col-sm-6 col-xs-12 col-md-6" id="column-375Zr77">
                        <div id="widget-fields-fNJZTf0" data-default="yes" class="edifice-widget" data-block-type="widget" data-widget-type="form-fields-input" data-widget-id="054" data-is-required="true" style="position: relative; top: 0px; left: 0px; opacity: 1;">
                           <div class="edi-adv-form-group">
                              <div class="edi-adv-form-label hide"><label>Email</label></div>
                              <div class="edi-adv-form-component">
                                 <div class="input-group"><input type="email" id="emailfNJZTf0" name="Email" class="form-control" placeholder="Email"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div data-enable-settings="yes" class="col-xs-12 col-md-12 col-sm-12" id="column-ohEipSQ">
                        <div id="widget-fields-XMdeAEh" class="edifice-widget" data-block-type="widget" data-widget-type="form-fields-textarea" data-widget-id="055">
                           <div class="edi-adv-form-group">
                              <div class="edi-adv-form-label hide"><label>LabelXMdeAEh</label></div>
                              <div class="edi-adv-form-component"><textarea class="form-control" rows="5" name="LabelXMdeAEh" id="txtXMdeAEh" placeholder="Message"></textarea></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12 p-0">
                  <div data-enable-settings="yes" class="col-sm-6 col-xs-12 col-md-11 hide" style="">
                     <div data-default="yes" id="widget-OKJ4Opl" class="edifice-widget" data-block-type="widget" data-widget-type="form-fields-captcha" data-widget-id="061" data-is-required="true" style="display: none;">
                        <div class="edi-adv-form-group">
                           <div class="edi-adv-form-label"><label>I'm not a robot</label></div>
                           <div class="edi-adv-form-component">
                              <div class="input-group"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div data-enable-settings="yes" class="col-sm-6 col-md-6 col-xs-12" id="column-w4G3iUo">
                     <div data-default="yes" class="edifice-widget" data-block-type="widget" data-widget-type="button-group" data-widget-id="011" id="widget-9B0qLDe">
                        <div class="btn-group" id="btn-group-9B0qLDe"><a data-btn-type="submit" class="btn btn-default btn-square" id="btn-9B0qLDe" href="javascript:void(0);"><span>SEND</span></a></div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- /End Widget Block ( Link ) -->
<!--               </div>
   <!-- /End row -->
   <div class="row"></div>
</footer></div>
<!-- /End container -->
<!--         </div>
<!-- /End Section Container -->
<!--      </section>-->

<!-- /End Footer 4 -->

<div class="droptrue" data-height="undefined">
<!-- Footer 4
==================================================================== -->
<footer id="footer-section-4" class="footer-section white-section section-xs-padding">
<section class="edifice-section section-par-YdhAI" data-block-type="section" data-section-id="001" data-section-type="hero-section" div-selector="parent-section" id="section-par-dn3S9">
<!-- Section Container -->
<div class="section-container">
<!-- container -->
<div class="container-fluid">
   <!-- row -->
   <div class="row">
      <!-- Widget Block ( Link ) --> 
      <div class="col-md-12 col-sm-12 col-xs-12 column-tZJhcwH lobipanel-parent-sortable border-line" data-lobipanel-child-inner-id="QQy3SAK3tH vgJPn60Wn7 Qd8nWeCiB8 DVJuzXyVtJ fouMtpFQPW eMKhN">
         <div class="edifice-widget position-relative" data-block-type="widget" data-widget-type="image" data-widget-id="004" id="widget-9qUEzPZ" style="position: relative; top: 0px; left: 0px; opacity: 1;"> <div class="edifice-addon-imgheader"></div><img class="img-responsive" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-url="index.html" data-target="_self" data-src="https://edificecms.com/builder/elements/images/uploads/project201/1558674388.png"></div><div class="edifice-widget" data-block-type="widget" data-widget-type="button-group" data-widget-id="011" id="widget-BX4ZZmT" style="position: relative; top: 0px; left: 0px; opacity: 1;"><div class="btn-group" id="btn-group-BX4ZZmT"><a class="btn btn-custom" id="btn-BX4ZZmT" href="#"><i class="fa  mr-5"></i><span>Terms and Condition</span></a><a class="btn btn-custom" id="btn-3LZQbJb" href="#"><i class="fa  mr-5"></i><span>Privacy Policy</span></a><a class="btn btn-custom" id="btn-dHUDtbh" href="#"><i class="fa  mr-5"></i><span>Legals</span></a></div></div><div class="edifice-widget" data-block-type="widget" data-widget-type="divider" data-widget-id="019" id="widget-VNn8kCL" style="position: relative; top: 0px; left: 0px; opacity: 1;"><div class="wid-divider divider-solid m-tb-50"></div></div><div class="edifice-widget text-center widget-qn3e9" data-block-type="widget" data-widget-type="text-block" data-widget-id="003" id="widget-vFFiN"><h1 class="hdtitle"><span></span></h1>
            
            <div class="d-edi-content-block"><p class="para-content"><span style="font-family: 'Source Sans Pro'; font-size: 16px; text-align: center;">© Copyright 2019 DCSHRM</span></p></div>
         </div>
      </div>
      <!-- /End Widget Block ( Link ) -->
   </div>
   <!-- /End row -->
   <div class="row"></div>
</div>
<!-- /End container -->
</div>
<!-- /End Section Container -->
</section>
</footer>
<!-- /End Footer 4 -->
</div>




<div class="droptrue" data-height="undefined">
<!-- Footer 4
==================================================================== -->

<!-- /End Footer 4 -->
</div>
<div class="droptrue" data-height="undefined">
<!-- Footer 4
==================================================================== -->

<!-- /End Footer 4 -->
</div>
<script type="text/javascript" src="https://edificecms.com/builder/elements/js/jquery.min.js"></script>
<script type="text/javascript" src="https://edificecms.com/builder/elements/js/vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://edificecms.com/builder/elements/js/jquery-ui.js"></script>	
<script async type="text/javascript" src="https://edificecms.com/builder/elements/js/vendor/modernizr-custom.js"></script>
<script type="text/javascript" src="https://edificecms.com/builder/elements/js/plugins/mobile/mobile.min.js"></script>
<script async type="text/javascript" src="https://edificecms.com/builder/elements/js/scripts.js"></script>
<script type="text/javascript" src="https://edificecms.com/builder/elements/js/page-publish.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min.js" integrity="sha256-b/0VIRZZWI4ziE8r1Zz0S9Q3otdXV3uCLab9Inhb6q4=" crossorigin="anonymous"></script>
    
    <script>		
        $(document).ready(function(){
            if($(".sharesocialicon").length)
            {
                var pro_id = 201;
                $.ajax({
                    url:'socialicon_curl.php',
                    type:'post',
                    dataType:'json',
                    data:{mode:'iconlist',pageurl:furl,pro_id:pro_id},
                    success:function(data)
                    {
                        $('.sharesocialicon').html(data['content']); 
                    } 
                });
            }
        });	
    </script>
    
    
    </body>
    </html>