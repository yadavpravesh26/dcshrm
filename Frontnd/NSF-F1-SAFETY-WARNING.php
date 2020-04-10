<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('bitly.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$emp_id = $_SESSION['US']['user_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>EMPLOYEE SAFETY WARNING FORM</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EMPLOYEE SAFETY WARNING FORM">
    <meta name="description" content="EMPLOYEE SAFETY WARNING FORM">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <link href="css/colors/green-dark.css" id="theme" rel="stylesheet">    
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="http://www.w3schools.com/lib/w3data.js"></script>
    <style type="text/css" media="print">
	BODY {display:none;visibility:hidden;}
	</style>
	<style>
	body{-moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;}
    .footer{    background: #f9f9f9;}
    #page-wrapper {background:#fff !important;}
    .container-fluid {
    padding-right: 0px !important;
    padding-left: 0px !important;
}
		.img-banner{background: url('http://dcshrm.com/sadmin/uploads/catdetails/1577943341.jpg') no-repeat center center; background-size: cover; height: 300px; width:100%;}

.col-md-10.text-box h4 {
    font-size: 17px;
    font-weight: 600;
    text-transform: uppercase;
}

		#home_info {
    background-color: #ffffff;
    padding-top: 40px;
    /*padding-bottom: 60px;*/
    position: relative;
}
#home_info .bg-color {
    background-color: rgba(27, 150, 142, 0.21);
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    transform: skewY(-10deg) scaleY(0.7);
    transform-origin: center center;
}
.center {
    text-align: center;
}
.pricing-box {
    text-align: center;
    margin-top: 0px;
    margin-bottom: 20px;
    padding-left: 0px;
    padding-right: 0px;
}
/*.t_sp
{
    margin-top: 30px;
}*/
.pricing-box .pricing-content {
    border: 1px solid #e0e0e8;
    background-color: #fcfcfd;
    -webkit-box-shadow: 0 9px 18px rgba(0, 0, 0, 0.08);
    box-shadow: 0 9px 18px rgba(0, 0, 0, 0.08);
    border-radius: 10px;
    position: relative;
    padding: 27px 27px 27px 27px;
}
.pricing-content {
    min-height: 200px;
}
.pricing-box.pricing-color1 .pricing-content .pricing-title {
    color: #324545;
    text-align: start;
}
.pricing-box .pricing-content .pricing-title {
    font-size: 17px;
    font-weight: 600;
    text-transform: uppercase;
}
.pricing-box .pricing-content .pricing-details {
    text-align: left;
}
.pricing-box .pricing-content .pricing-details ul {
    padding: 0;
    margin: 0;
    list-style: none;
    margin-top: 20px;
    margin-bottom: 20px;
}
.pricing-box .pricing-content .pricing-details ul li {
    font-size: 14px;
    color: #777493;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;
    position: relative;
    transition: all 0.3s ease 0s;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
}
.pricing-box.pricing-color1 .pricing-content .pricing-details ul li:before {
    background-color: #2FD1CE;
    -webkit-box-shadow: 0 3px 8px rgba(117, 109, 231, 0.5);
    box-shadow: 0 3px 8px rgba(117, 109, 231, 0.5);
}
.pricing-box .pricing-content .pricing-details ul li:before {
    position: absolute;
    content: "";
    width: 10px;
    height: 10px;
    border-radius: 10px;
    left: 0;
    top: 50%;
    margin-top: -5px;
    background-color: #ffffff;
    -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

		#home_info{background: #fff;
    margin: 0;
    padding-right: 0;
    padding-left: 0;
    width: 100%;}
		.pricing-details .click-btn li button {
    width: 100%;
    border: none;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 3px 8px rgb(192, 192, 192); transition: all linear .3s;
}
		.pricing-details .click-btn li button:hover {opacity:.7;}
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

.scroll-me {
    overflow-y: auto;
    height: 596 px;
    float: left;
}
ul#vid-list li {
display: inline;
width: 25% !important;
float: left;
padding: 15px;
}
ul#vid-list {
width: 100% !important;
overflow: hidden;
padding: 0;
}
.scroll-me {
width: 100% !important;
clear: both;
}
.col-centered {
    margin: 0 auto;
    display: block;
    float: none;
}
.pricing-details button {
    text-align: left;
}
.p-l
{
    padding-left: 0px;
}
.p-r
{
    padding-left: 0px;
}
/*.b_sp
{
    margin-bottom: 30px;
}*/


ul.unstyled.centered li {
    list-style: none;
}
.styled-checkbox + label:before{border:1px solid #4f5366;}
.styled-checkbox {
  position: absolute;
  opacity: 0;
}
.styled-checkbox + label {
  position: relative;
  cursor: pointer;
  padding: 0;
}
.styled-checkbox + label:before {
  content: '';
  margin-right: 10px;
  display: inline-block;
  vertical-align: text-top;
  width: 20px;
  height: 20px;
  background: white;
}
.styled-checkbox:hover + label:before {
  background: #f35429;
}
.styled-checkbox:focus + label:before {
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
}
.styled-checkbox:checked + label:before {
  background: #f35429;
}
.styled-checkbox:disabled + label {
  color: #b8b8b8;
  cursor: auto;
}
.styled-checkbox:disabled + label:before {
  box-shadow: none;
  background: #ddd;
}
.styled-checkbox:checked + label:after {
  content: '';
  position: absolute;
  left: 5px;
  top: 9px;
  background: white;
  width: 2px;
  height: 2px;
  box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
}
ul.unstyled.centered {
    margin-top: 40px;
    text-align: center;
}
.next-sm{    border: 1px solid #4f5366;
    border-radius: 4px;
    background: #4f5366;
    font-weight: 400;
    margin-left: 10px;
    font-size: 13px;
    padding: 5px 15px;
    /* float: left; */
    display: block;
    margin: 8px auto;
    color: #fff;
    box-shadow: 1px 1px 6px #333333a6;}
.toggle-handle.btn.btn-default{background:#FFFFFF;}
/*Scroll*/
/* width */
::-webkit-scrollbar {
  width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
.nav-tabs .nav-link{
    border: 1px solid #ddd;
}


.tab_inner ul.handout-sst li a{display:block; width:100%; padding:15px 8px; color:#636363; font-size:14px;}
.tab_inner a i{font-size:24px; margin-right:10px;}
.tab_inner .title:hover,.active_training .title,.active_training .iconn i{color:#44a42a !important;}
.tab_inner .iconn i{font-size:24px;}
.tab_inner ul.handout-sst li a:hover{color:#44a42a}
.tab_inner ul.handout-sst li a:hover i{color:#44a42a}
.nav-tabs > li > a{background: #f7f8fa;border: 1px solid #f1f1f1;}
.nav-tabs > li.active > a{color: #44a42a !important;background: #fff;}
.text-box{border-top-left-radius: 0px;border: 1px solid #f1f1f1;
    border-top: 0;}
.nav-tabs .nav-link {
    border: 1px solid #f1f1f1 !important;font-weight: 500;
}
.nav-tabs .active .nav-link,.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    border-bottom: 1px solid #ffff !important;border-top: 3px solid #44a42a !important;color: #44a42a !important;font-weight: 500;
}
.nav-tabs {
    border-bottom: 1px solid #f1f1f1 !important;
}
.RETRAINED_COL{    padding: 30px 25px 0px;}
</style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
       <?php include 'header.php';?>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
       <?php include 'navbar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
            	<div class="row">
                    <div class="col-md-12">
                        <div class="">
							<div class="row">

								<div class="img-banner"><div class="banner-txt">EMPLOYEE SAFETY WARNING FORM</div></div>

                           </div>
                            </div>
                        </div>
                    </div>
               <div class="clearfix"></div>
			</div>
            <div class="row">
                <div id="home_info" class="container" style="background: #fff;">
                    <div class="bg-color"></div>
                    <div class="container">
                    	<div class="row center b_sp">
                        	<div class="col-md-12 text-box" >
                            	<form>
                                  <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">EMPLOYEE NAME:</label>
                                    <input type="text" class="form-control" id="empname" placeholder="EMPLOYEE NAME">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">POSITION:</label>
                                    <input type="text" class="form-control" id="empname" placeholder="POSITION">
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">SUPERVISOR:</label>
                                    <input type="text" class="form-control" id="empname" placeholder="SUPERVISOR">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">DEPARTMENT:</label>
                                    <input type="text" class="form-control" id="empname" placeholder="DEPARTMENT">
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">DATE OF WARNING:</label>
                                    <input type="date" class="form-control" id="empname" placeholder="DATE OF WARNING">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">VIOLATION DATE:</label>
                                    <input type="date" class="form-control" id="empname" placeholder="VIOLATION DATE">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">VIOLATION TIME:</label>
                                    <input type="date" class="form-control" id="empname" placeholder="VIOLATION TIME">
                                  </div>
                                  
                                  <div class="clearfix"></div>
                                  
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">SUPERVISOR’S STATEMENT:</label>
                                    <textarea class="form-control" style="min-height:200px"></textarea>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">TYPE OF WARNING:</label>
                                  </div>                                  
                                  <div class="form-group col-md-2">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">&nbsp;VERBAL</label>
                                  </div> 
                                  <div class="form-group col-md-2"> 
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;WRITTEN</label>
                                  </div> 
                                  <div class="form-group col-md-2">  
                                    <input type="checkbox" class="form-check-input" id="exampleCheck3">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;SERIOUS</label>
                                  </div> 
                                  <div class="form-group col-md-2">  
                                    <input type="checkbox" class="form-check-input" id="exampleCheck4">
                                    <label class="form-check-label" for="exampleCheck4">&nbsp;OTHER</label>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">EMPLOYEE’S STATEMENT:</label>
                                  </div>                                  
                                  <div class="form-group col-md-4">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">&nbsp;I AGREE WITH THE SUPERVISOR’S STATEMENT</label>
                                  </div> 
                                  <div class="form-group col-md-4"> 
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;I DISAGREE WITH THE SUPERVISOR
’S STATEMENT</label>
                                  </div> 
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-12">
                                    <h3>PREVIOUS WARNINGS:</h3>
                                  </div> 
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">DESCRIPTION OF 1st:</label>
                                    <textarea class="form-control" style="min-height:200px"></textarea>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">DATE</label>
                                    <input type="date" class="form-control" id="empname" placeholder="DATE">
                                 </div>
                                  <div class="form-group col-md-4 RETRAINED_COL">
                                    <label for="exampleInputEmail1">RETRAINED</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;YES</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;NO</label>
                                 </div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">EMPLOYEE SIGNATURE:</label>
                                    <input type="file" class="form-control" id="empname">
                                 </div>   
                                  <div class="clearfix"></div>
                                  
                                  <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">DESCRIPTION OF 2nd:</label>
                                    <textarea class="form-control" style="min-height:200px"></textarea>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">EMPLOYEE SIGNATURE:</label>
                                    <input type="file" class="form-control" id="empname">
                                 </div> 
                                 <div class="form-group col-md-4 RETRAINED_COL">
                                    <label for="exampleInputEmail1">RETRAINED</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;YES</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;NO</label>
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">DATE</label>
                                    <input type="date" class="form-control" id="empname" placeholder="DATE">
                                 </div>  
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">DESCRIPTION OF 2nd:</label>
                                    <textarea class="form-control" style="min-height:200px"></textarea>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">EMPLOYEE SIGNATURE:</label>
                                    <input type="file" class="form-control" id="empname">
                                 </div> 
                                 <div class="form-group col-md-4 RETRAINED_COL">
                                    <label for="exampleInputEmail1">RETRAINED</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;YES</label>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck3">&nbsp;NO</label>
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1">SAFETY COORDINATOR</label>
                                    <input type="text" class="form-control" id="empname" placeholder="SAFETY COORDINATOR">
                                 </div>  
                                  <div class="clearfix"></div>
                                  <hr>
                                  <div class="form-group col-md-6">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">&nbsp;I HAVE READ AND UNDERSTAND THIS WARNING</label>
                                  </div> 
                                  <div class="col-md-6" style="text-align:right;">
                                  	<button type="submit" class="btn btn-primary">Submit</button>
                                  </div>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <!-- /.container-fluid --><?php include 'footer.php';?>

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
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- accordian script -->
   


<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>
.back-to-top {
    position: fixed;
    bottom: 25px;
    right: 25px;
    display: none;
}
html {
  scroll-behavior: smooth;
}
</style>
    <!-- grid script ends -->
    <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><img src="<?php echo TEMP_PATH;?>/img/back_top.png"></a>
</body>

</html>
