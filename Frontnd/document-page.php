<?php

require_once('config.php');
require_once('readPdfDoc/class.filetotext.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$catfetdoc =  "SELECT * FROM docs WHERE doc_id =".base64_decode($_REQUEST['ids'])." AND doc_status=0";
//$catfetdoc =  "SELECT * FROM docs WHERE doc_id =".$_REQUEST['ids']." AND doc_status=0";
$rowdoc=$prop->getAll_Disp($catfetdoc);

?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title><?php echo $rowdoc[0]['doc_name'] ?></title>
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
    <style type="text/css" media="print">
	BODY {display:none;visibility:hidden;}
	</style>
<style>
body{-moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;}
ol {
    padding: 0;
    color: #333;
    font-weight: 600;
}
span.twitter-typeahead {
    display: block !important;
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
                <?php 
				/*$perm_form = 1;
				if($nav_main===1)
					$perm_form = 0;
				if(in_array($rowdoc[0]['doc_cat'],explode(',',$nav_category)))
					$perm_form = 0;
				if(in_array($rowdoc[0]['doc_scat'],explode(',',$nav_sub_category)))
					$perm_form = 0;
				if(in_array($rowdoc[0]['doc_cat'],explode(',',$rej_category)))
					$perm_form = 1;
				if(in_array($rowdoc[0]['doc_scat'],explode(',',$rej_sub_category)))
					$perm_form = 1;
				if($perm_form===1)
				{
					header('Location:'.LIVE_SITE); exit;
				}*/
				?>
                <?php 
				$perm_form = 1;
				if(in_array($page_id,explode(',',$nav_pages)))
					$perm_form = 0;
				if($perm_form===1)
				{
					header('Location:'.LIVE_SITE); exit;
				}
				
				?>
                <div class="clearfix"></div>
               <div class="row m-t-15">
                    <div class="col-md-9">
                        <div class="white-box">
                            <div class="row">
                              <div class=" row title-hd">

                              <div class="col-md-2"></div>
                              <div class="col-md-8"><h3 class="accident"><?php echo $rowdoc[0]['doc_name'] ?> </h3> </div>
                              <div class="col-md-2"></div>


                              </div>
								<div class="white-box document-sec" id='pdf_content'>
									<div class="print-opt top-print"><ul><a href="pdf/dynamic_pdf.php?id=<?php echo base64_decode($_REQUEST['ids']);?>&type=D&method=doc"><li class="Dsc-li li-decor lab-head-u-normal"><img alt="PDF Download" title="PDF Download" src="img/pdf1.png"></li></a><a href="pdf/dynamic_pdf.php?id=<?php echo base64_decode($_REQUEST['ids']);?>&type=I&method=doc" target='_blank'><li class="Dsc-li li-decor lab-head-u-normal"><img alt="Print  Document" title="Print Document" src="img/printer.png"></li></a></ul></div>
<?php if($rowdoc[0]['doc_content']!= ''){echo $rowdoc[0]['doc_content'];}else{
$docObj = new Filetotext("images/docs/".$rowdoc[0]['doc_file']);
//$docObj = new Filetotext("test.pdf");
$return = $docObj->convertToText();
//echo "<a href='images/docs/".$rowdoc[0]['doc_file']."'>Test</a><br>";
echo  $return;
} ?>
	<div class="print-opt bottom-print"><ul><a href="pdf/dynamic_pdf.php?id=<?php echo base64_decode($_REQUEST['ids']);?>&type=D&method=doc"><li class="Dsc-li li-decor lab-head-u-normal"><img alt="PDF Download" title="PDF Download" src="img/pdf1.png"></li></a><a href="pdf/dynamic_pdf.php?id=<?php echo base64_decode($_REQUEST['ids']);?>&type=I&method=doc" target='_blank'><li class="Dsc-li li-decor lab-head-u-normal"><img alt="Print  Document" title="Print Document" src="img/printer.png"></li></a></ul></div>
		</div>

                                </div>
                            </div>
                        </div>
				<?php include("doc_sidebar.php"); ?>
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
	 <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/0.11.1/typeahead.bundle.min.js"></script>



    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/0.11.1/typeahead.jquery.min.js"></script>

 <script type="text/javascript" src="js/typeheadsearch.js"></script>
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
//Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
	 $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

});</script>
    <!-- accordian script ends-->
</body>

</html>
