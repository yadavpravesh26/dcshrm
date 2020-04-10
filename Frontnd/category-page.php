<?php 
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title>DCSHRM</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
	<link href="css/style-own.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <link href="css/colors/green-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="http://www.w3schools.com/lib/w3data.js"></script>
	<style>
	.no-padding
	{
		padding-left:0px !important;
		padding-right:0px !important;
	}
	
.new {
    border-radius: 9px !important;
    border: 1px solid #f1f1f1 !important;
    box-shadow: 2px 4px 5px #e4e4e4;
    overflow: hidden;
}

.dc-full
{
    color: #8d9ea7 !important;
    font-size: 12px !important;
    text-align: right;
    padding: 0px 3px;
}

.dc-2
{
margin: 5px 0px !important;
}

.dc-3
{
    line-height: 20px;
    font-size: 16px;
    font-weight: 400;
}

.dc-4 {
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
        <!-- Top Navigation -->
       <?php include 'header.php';?>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
       <?php include 'navbar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!--<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Starter Page</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            
                        </ol>
                    </div>
                    
                </div>-->
                <div class="clearfix"></div>
               <div class="row m-t-15">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="row">
                             <div class=" row title-hd catpage">
                             <?php  
$catsqlnames1 = "SELECT cat1 from ".CAT_DETAILS." WHERE c_id='".base64_decode($_REQUEST[c_id])."'";
$catfetnames1=$prop->getAll_Disp($catsqlnames1);  
						
$catsqlnames2 = "SELECT cat2 from ".CAT_DETAILS." WHERE c_id='".base64_decode($_REQUEST[sc_id])."'";
$catfetnames2=$prop->getAll_Disp($catsqlnames2); 
     $catsql = "SELECT `cat2`,`heading`, `descript`,`doc_image` FROM  ".CAT_DETAILS." WHERE cat1='".$catfetnames1[0]['cat1']."' AND cat2='".$catfetnames2[0]['cat2']."' AND `status`=0";
        $catfet=$prop->getAll_Disp($catsql); 
		?>
                               <div class="col-md-12"><h3 class="accident"><?php echo  $catfetnames1[0]['cat1'] ?> > <?php echo $catfetnames2[0]['cat2'] ?> </h3> </div>
								
								</div>
								<div class="white-box wid-100">
					<?php  

     $catsql = "SELECT `c_id`,`cat2`,`heading`, `descript`,`doc_image` FROM  ".CAT_DETAILS." WHERE cat1='".$catfetnames1[0]['cat1']."' AND cat2='".$catfetnames2[0]['cat2']."' AND `status`=0";
        $catfet=$prop->getAll_Disp($catsql); 
		for($i=0; $i<count($catfet); $i++)
					                    {  
					?>
									  <div class="col-lg-3 col-md-6 no-padding new"> <img class="img-responsive" alt="user" src="img/new.png" style="position:absolute;width:75px;"> <img class="img-responsive" alt="user" src="../sadmin/uploads/catdetails/regular/<?php echo $catfet[$i]['doc_image'] ?>">
                        <div class="white-box ">
                            <div class="text-muted dc-full"><span class="m-r-10 dc-2">May 16</span> </div>
                            <h3 class="m-t-20 m-b-20 dc-3"><?php echo $catfet[$i]['heading'] ?></h3>
                           <p class="dc-4"><?php echo substr($catfet[$i]['descript'],0,80); ?></p>
						   <div class="clearfix"></div>
                            <a class="btn btn-success btn-rounded waves-effect waves-light m-t-20" href="category-detail.php?id=<?php echo $catfet[$i]['c_id'] ?>">Read more</a>
                        </div>
                    </div>
					  
					
					<?php } ?>
							</div>
                                
                                </div>
                            </div>
                        </div>

                    </div>
				<div class="clearfix"></div>
                <div class="row m-t-15">
                    
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
<!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- accordian script -->
    <script>
	$(function(){
  $(".accordian h3").click(function(e){
    $($(e.target).find('.ti-plus').toggleClass('open'));
  $(".accordian ul ul").slideUp();
    if ($(this).next().is(":hidden")){
    $(this).next().slideDown();
    }
  });
  

});</script>
    <!-- accordian script ends-->
</body>

</html>
