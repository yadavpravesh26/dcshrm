<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('bitly.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

$curr_val = $prop->get('*',PAGES, array("p_id"=>$_REQUEST['id'],'page_status'=>0));
$emp_id = $_SESSION['US']['user_id'];
$page_id = $curr_val['p_id'];

if(empty($curr_val)){
	header('location: '._404);
	exit;
}
$category_id = $prop->getName('c_name',SUB_CATEGORY, ' status=0 AND c_id='.$curr_val['category']);

if(isset($_POST['acknowledgeBtn']))
{
	$emp_id = $_SESSION['US']['user_id'];
	$page_id = $curr_val['p_id'];
	$input = array(
				'page_id'	=>$page_id,
				'emp_id'	=>$emp_id
				);
	$result = $prop->add('acknowledge', $input);
}
function ger_origenal_url($url)
{
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_HEADER,true); // Get header information
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,false);
    $header = curl_exec($ch);
    
    $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header)); // Parse information
        
    for($i=0;$i<count($fields);$i++)
    {
        if(strpos($fields[$i],'Location') !== false)
        {
            $url = str_replace("Location: ","",$fields[$i]);
        }
    }
    return $url;
}
function long_to_short_url($long_url)
{
	$client_id = '58989d0612817317372c79680be27f8ce8d46320';
	$client_secret = 'e866b2b37a4e2706edb2002ae31d89ee64a9a3e0';
	$user_access_token = '0dbfe11922a256a03e1d04ef93c40d6e9590329a';
	$user_login = 'yadavpravesh26';
	$user_api_key = '0dbfe11922a256a03e1d04ef93c40d6e9590329a';  
	
	
	$params = array();
	$params['access_token'] = $user_access_token;
	$params['longUrl'] = $long_url;
	$params['domain'] = 'bit.ly';
	$results = bitly_get('shorten', $params);
	
	return $results['data']['url'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $curr_val[ban_title] ?></title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $curr_val[meta_desc] ?>">
    <meta name="description" content="<?php echo $curr_val[meta_desc] ?>">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title><?php echo $curr_val[title] ?></title>
    <!-- Bootstrap Core CSS -->
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
		.img-banner{background: url('<?php echo ADMIN_SITE.'uploads/catdetails/'.$curr_val[ban_image] ?>') no-repeat center center; background-size: cover; height: 300px; width:100%;}

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
				<?php 
				$perm_form = 1;
				if($nav_main===1)
					$perm_form = 0;
				if(in_array($category_id,explode(',',$nav_category)))
					$perm_form = 0;
				if(in_array($curr_val['category'],explode(',',$nav_sub_category)))
					$perm_form = 0;
				if(in_array($category_id,explode(',',$rej_category)))
					$perm_form = 1;
				if(in_array($curr_val['category'],explode(',',$rej_sub_category)))
					$perm_form = 1;
				if($perm_form===1)
				{
					header('Location:'.LIVE_SITE); exit;
				}
				
				?>
				
               <div class="row">
                    <div class="col-md-12">
                        <div class="">
							<div class="row">

								<div class="img-banner" ><div class="banner-txt"><?php echo $curr_val[ban_title] ?></div></div>

                           </div>
                            </div>
                        </div>
                    </div>

				<div class="clearfix"></div>


<div class="row">
	<div id="home_info" class="container" style="background: #fff;">
		<div class="bg-color"></div>
		<div class="container">
			<div class="row center b_sp">
            	<div class="col-md-9" style="padding-left: 0px;">
                	<ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item active">
                        <a class="nav-link" href="#Content_tab" role="tab" data-toggle="tab">Besafe</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#Handout_tab" role="tab" data-toggle="tab">Programs</a>
                      </li>
                      <!--<li class="nav-item">
                        <a class="nav-link" href="#Trainings_tab" role="tab" data-toggle="tab">Trainings</a>
                      </li>-->
                       <li class="nav-item">
                        <a class="nav-link" href="#Quiz_tab" role="tab" data-toggle="tab">Quiz</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#Videos_tab" role="tab" data-toggle="tab">Videos</a>
                      </li>
                    </ul>
                </div>
				<div class="col-md-9 text-box" id="runtime_descript">
                	<div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade active show" id="Content_tab">
						<?php 
                        echo $curr_val[descript];					
                        ?>
                        <?php
                        if($curr_val['trainings']!="emp" && $curr_val['trainings']!="")
                        {
							$catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id IN(".$curr_val['trainings'].") AND doc_status=0 limit 1";
							 $rowdoc=$prop->getAll_Disp($catfetdoc);
							 for($i=0; $i<count($rowdoc); $i++)
							 {
							 	echo $rowdoc[$i][doc_content];
								
								$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
								$extension = end(explode('.',strtolower($old_name)));
								$new_name = "images/docs/".$rowdoc[$i][doc_name].".".$extension ;
								rename( $old_name, $new_name);
								
								if($extension == 'pdf')
								$class = 'fa fa-file-pdf-o';
								else if($extension == 'doc' || $extension == 'docx')
								$class = 'fa fa-file-word-o';
								?>
								<h2 style="margin-top: 30px;">Handouts</h2>
                                <div class="tab_inner">
                                    <ul class="handout-sst">
                                        <li>
                                           <a href="<?php echo $new_name;?>"> <span class="title"><i class="<?php echo $class;?>"></i><?php echo $rowdoc[$i][doc_name];?></span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li>
                                   </ul>
                                </div>
								<?php
							 }
						} ?>
                        <!--<div id="loadMore" style="">
                          <a style="cursor:pointer">Load More</a>
                        </div>-->
                        <?php
                        $emp_id = $_SESSION['US']['user_id'];
                        $page_id = $curr_val['p_id'];
                        $exits = $prop->getName('count(acknowledge_id)', 'acknowledge', "page_id='".$page_id."' and emp_id='".$emp_id."'");
                        if($exits===0){
                        ?>
                        <ul class="unstyled centered">
                          <li>
                          <form method="post">
                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1" required>
                            <label for="styled-checkbox-1">I hereby acknowledge that I have completed this course module.</label>
                            <button class="next-sm" type="submit" name="acknowledgeBtn">Submit</button>
                           </form> 
                          </li>
                      </ul>
                      <?php
                        }else{?>
                        <ul class="unstyled centered">
                          <li>
                            <label for="styled-checkbox-1">You have already completed this course!</label>
                            <button class="next-sm" type="submit" name="acknowledgeBtn" disabled>Already Acknowledged</button>
                           </li>
                      </ul>
                        <?php }?>
                       </div>

                     <div role="tabpanel" class="tab-pane fade" id="Handout_tab">
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
							$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
							$extension = end(explode('.',strtolower($old_name)));
							$new_name = "images/docs/".$rowdoc[$i][doc_name].".".$extension ;
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
                     <?php /*?><div role="tabpanel" class="tab-pane fade" id="Trainings_tab">
                     	<?php
                        if($curr_val['trainings']!="emp" && $curr_val['trainings']!="")
                        {
							$catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id IN(".$curr_val['trainings'].") AND doc_status=0 limit 1";
							 $rowdoc=$prop->getAll_Disp($catfetdoc);
							 for($i=0; $i<count($rowdoc); $i++)
							 {
							 	echo $rowdoc[$i][doc_content];
								
								$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
								$extension = end(explode('.',strtolower($old_name)));
								$new_name = "images/docs/".$rowdoc[$i][doc_name].".".$extension ;
								rename( $old_name, $new_name);
								
								if($extension == 'pdf')
								$class = 'fa fa-file-pdf-o';
								else if($extension == 'doc' || $extension == 'docx')
								$class = 'fa fa-file-word-o';
								?>
								<h1>Downloads</h1>
                                <div class="tab_inner">
                                    <ul class="handout-sst">
                                        <li>
                                           <a href="<?php echo $new_name;?>"> <span class="title"><i class="<?php echo $class;?>"></i><?php echo $rowdoc[$i][doc_name];?></span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li>
                                   </ul>
                                </div>
								<?php
							 }
						} ?>
                        
                     </div><?php */?>
                     <div role="tabpanel" class="tab-pane fade" id="Quiz_tab">
                     	<?php if($curr_val['quiz']!="emp" && $curr_val['quiz']!=""){?>
    			   		 <div class="tab_inner">
                            <ul Class="handout-sst">
                             <?php
                            $catfetdoc =  "SELECT * FROM dynamic_form WHERE form_type=0 AND d_form_id IN(".$curr_val['quiz'].") AND d_detele_status=0";
                            $rowdoc=$prop->getAll_Disp($catfetdoc);
                            $CompanyId = $prop->get('u_id,name,email,contact_no', USERS, array('id'=>$session['fid']));
                            $user_name = $CompanyId['name'];
                            $email = $CompanyId['email'];
                            $contact_no = $CompanyId['contact_no'];
                            $user_name = explode(' ',$user_name);
                            $fname = $user_name[0];
                            $lname = $user_name[1];
                            
                            for($i=0; $i<count($rowdoc); $i++)
                             {
                             $quiz_url = ger_origenal_url($rowdoc[$i][quiz_url]);
                             $quiz_url = str_replace("asia","dcshrm",$quiz_url);
                             $encript = base64_encode($CompanyId['u_id']."-".$session['fid']."-".$fname."-".$lname."-".$email."-".$contact_no);
                             
                             $quiz_url2 = $quiz_url."&data=".$encript;					 
                             $quiz_url = long_to_short_url($quiz_url2);
                             
                                            
                            ?>
                                <li><a href="<?php echo  $quiz_url; ?>" target="_blank" title="Click To Attend Quiz"><i class="fa fa-question-circle "></i><span class="title"><?php echo $rowdoc[$i][d_template_name]; ?></span><span class="iconn"><i class="fa fa-arrow-circle-right"></i></span></a></li>
                                <?php }?>
                            </ul>
                            </div>
    			     <?php } ?>
                     </div>
                     <div role="tabpanel" class="tab-pane fade" id="Videos_tab">
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
								<h1 class="vid-ttl">Video Gallery</h1>
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
                                                      <span class="vid-thumb"><img class="you" width="100%" height="auto" src="http://img.youtube.com/vi/<?=$ex[0]?>/hqdefault.jpg" /></span>
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
                    </div>   
    			</div>
    			<div class="col-sm-3" id="sidebarRight">
                	<?php
                    if($curr_val['handout']!="emp" && $curr_val['handout']!=""){
					?>
    			    <div class="sidebarr" id="Hand-Outs">
    			        <h3><img src="img/handout.png"> Hand Outs</h3>
    			    <ul Class="handout-sst">
                    <?php
                    $catfetdoc =  "SELECT * FROM docs WHERE doc_type=1 AND doc_id IN(".$curr_val['handout'].") AND doc_status=0";
					$rowdoc=$prop->getAll_Disp($catfetdoc);
                    for($i=0; $i<count($rowdoc); $i++){
						$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
						$extension = end(explode('.',strtolower($old_name)));
						$new_name = "images/docs/".$rowdoc[$i][doc_name].".".$extension ;
						rename( $old_name, $new_name);
					?>
    			        <li><span class="title"><a href="<?php echo $new_name; ?>"><?php echo $rowdoc[$i][doc_name]; ?></a></span><span class="iconn"><a href="<?php echo $new_name; ?>"><img src="img/arrow1.png"></a></span></li>
                    <?php } ?>    
    			    </ul>
    			    </div>
                    <?php } ?>
                    <?php if($curr_val['quiz']!="emp" && $curr_val['quiz']!=""){?>
    			    <div class="sidebarr" id="Quiz-sidebar">
    			     <h3><img src="img/help.png">Quiz</h3>
                     <ul Class="handout-sst">
                     <?php
					$catfetdoc =  "SELECT * FROM dynamic_form WHERE form_type=0 AND d_form_id IN(".$curr_val['quiz'].") AND d_detele_status=0";
					$rowdoc=$prop->getAll_Disp($catfetdoc);
					$CompanyId = $prop->get('u_id,name,email,contact_no', USERS, array('id'=>$session['fid']));
					$user_name = $CompanyId['name'];
					$email = $CompanyId['email'];
					$contact_no = $CompanyId['contact_no'];
					$user_name = explode(' ',$user_name);
					$fname = $user_name[0];
					$lname = $user_name[1];
					
					for($i=0; $i<count($rowdoc); $i++)
					 {
					 $quiz_url = ger_origenal_url($rowdoc[$i][quiz_url]);
					 $quiz_url = str_replace("asia","dcshrm",$quiz_url);
					 $encript = base64_encode($CompanyId['u_id']."-".$session['fid']."-".$fname."-".$lname."-".$email."-".$contact_no);
					 
					 $quiz_url2 = $quiz_url."&data=".$encript;					 
					 $quiz_url = long_to_short_url($quiz_url2);
					 
                     		        
					?>
    			        <li><span class="title"><a href="<?php echo  $quiz_url; ?>" target="_blank"><?php echo $rowdoc[$i][d_template_name]; ?></a></span><span class="iconn"><a href="<?php echo  $quiz_url; ?>" target="_blank"><img src="img/arrow1.png"></a></span></li>
                        <?php }?>
    			    </ul>
    			    </div>
    			     <?php } ?>
                     <div class="sidebarr" id="indexing">
                    	<h3><img src="img/help.png">Indexing </h3>
                        <ul class="handout-sst"></ul>
                    </div>
                    <div class="sidebarr" id="training_sidebar">
                    	<h3><img src="img/help.png">Trainings </h3>
                        <ul class="handout-sst">                   
                    <?php
                        if($curr_val['trainings']!="emp" && $curr_val['trainings']!="")
                        {
							$catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id IN(".$curr_val['trainings'].") AND doc_status=0";
							 $rowdoc=$prop->getAll_Disp($catfetdoc);
							 for($i=0; $i<count($rowdoc); $i++)
							 {?>
							 	<li id="training<?php echo $rowdoc[$i][doc_id];?>" class="<?php if($i==0){echo 'active_training';}?>"><span class="title"><a onClick="get_training_data(<?php echo $rowdoc[$i][doc_id];?>)"><?php echo $rowdoc[$i][doc_name]; ?></a></span><span class="iconn"><a onClick="get_training_data(<?php echo $rowdoc[$i][doc_id];?>)"><i class="fa fa-angle-right"></i></a></span></li>
							 <?php
							 }
						} ?>
                     	</ul> 
                      </div>  
    			</div>
                
			</div>
	        <?php /*?><div class="row center">
	            <div class="col-md-10 col-centered p-0 grid ">
                <?php
                  if($curr_val['handout']!="emp" && $curr_val['handout']!="")
                  {
                 ?>
                      <div class="col-sm-6 col-md-6 wid_th p-l item">
                        <div class="pricing-box pricing-color1">
                            <div class="pricing-content">
                                <div class="pricing-title">Hand Outs</div>
                                <div class="pricing-details">
                                    <ul class="click-btn">
                                      <?php
                                    $catfetdoc =  "SELECT * FROM docs WHERE doc_type=1 AND doc_id IN(".$curr_val['handout'].") AND doc_status=0";
                                    $rowdoc=$prop->getAll_Disp($catfetdoc);
                                    for($i=0; $i<count($rowdoc); $i++)
                                       {
									   	$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
										$extension = end(explode('.',strtolower($old_name)));
       									$new_name = "images/docs/".$rowdoc[$i][doc_name].".".$extension ;
										
									   	rename( $old_name, $new_name);
                                    ?>
                                        <li><a href="<?php echo $new_name; ?>"><button style=" background: #515068; "><?php echo $rowdoc[$i][doc_name]; ?></button></a></li>
                                      <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php } ?>
                      <?php
                        if($curr_val['trainings']!="emp" && $curr_val['trainings']!="")
                        {
                       ?>
                      <div class="col-sm-6 col-md-6 wid_th p-r item">
        	                <div class="pricing-box pricing-color1">
        	                    <div class="pricing-content">
        	                       
        	                        <div class="pricing-title">Training</div>
        	                        <div class="pricing-details">
        	                            <ul class="click-btn">
                                        <?php
                                      $catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id IN(".$curr_val['trainings'].") AND doc_status=0";
                                      $rowdoc=$prop->getAll_Disp($catfetdoc);
                                      for($i=0; $i<count($rowdoc); $i++)
                                         {
                                      ?>
                                       <li><a href="document-page.php?ids=<?php echo base64_encode($rowdoc[$i][doc_id]); ?>"><button style=" background: #128653;"><?php echo $rowdoc[$i][doc_name]; ?></button></a></li>

                                        <?php } ?>

        	                            </ul>
        	                        </div>
        	                    </div>
        	                </div>
                    	</div>
                    <?php } ?>
					<?php if($curr_val['quiz']!="emp" && $curr_val['quiz']!=""){?>
                      <div class="col-sm-6 col-md-6 wid_th p-r item">
        	                <div class="pricing-box pricing-color1">
        	                    <div class="pricing-content">
        	                        <div class="pricing-title">Quiz</div>
        	                        <div class="pricing-details">
        	                            <ul class="click-btn">
                                        <?php
                                        $catfetdoc =  "SELECT * FROM dynamic_form WHERE form_type=0 AND d_form_id IN(".$curr_val['quiz'].") AND d_detele_status=0";
                                        $rowdoc=$prop->getAll_Disp($catfetdoc);
                                        for($i=0; $i<count($rowdoc); $i++)
                                         {
                                        ?>
                                        <li><a href="<?php echo $rowdoc[$i][quiz_url]; ?>" target="_blank"><button style="background: #486a8a;"><?php echo $rowdoc[$i][d_template_name]; ?></button></a></li>

                                        <?php } ?>
        	                            </ul>
        	                        </div>
        	                    </div>
        	                </div>
                    	</div>
                    <?php } ?>
                </div>
	        </div><?php */?>
	       
		</div>
		
	</div>
</div>


<?php
if($curr_val['images']!="emp" && $curr_val['images']!="") { 
	/* $catfetdoc =  "SELECT * FROM docs WHERE doc_type=3 AND doc_id IN(".$curr_val['videos'].") AND doc_status=0"; */
	$str_img = $prop->getName('GROUP_CONCAT(doc_file)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=4 AND doc_id IN('.$curr_val['images'].')');
	$arr_img = explode(",", $str_img);
	$result = count($arr_img);
?>
	<div class="row m-t-15">
		<ul id="list-group">
		<?php 
			for($i=0;$i<$result;$i++)
			{
		?>
			<li class="list-group-item">
				<a href="images/banner/<?php echo $arr_img[$i]?>">
				  <img width="100%" height="auto" src="images/banner/<?php echo $arr_img[$i]?>">
				</a>
			</li>
		<?php 
			}
		?>
		</ul>		
	</div>
<?php } ?>
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
    <script>

	$(function(){
  $(".accordian h3").click(function(e){
    $($(e.target).find('.ti-plus').toggleClass('open'));
  $(".accordian ul ul").slideUp();
    if ($(this).next().is(":hidden")){
    $(this).next().slideDown();
    }
  });
 
 	/*Load more*/
	
	
	/*$("#runtime_descript h2").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript h3").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript h4").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript h5").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript h6").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript p").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	$("#runtime_descript ul").each(function( index ) {
	  $( this ).addClass("hide_load_more");
	});
	var hide_count = 0;
	var hide_loop = 1;
	var total_hide_load_more = $('.hide_load_more').length
	divid_hide_load_more = Math.ceil(total_hide_load_more/30);
	
	$("#runtime_descript .hide_load_more").each(function( index ) {
	  	if(hide_count >= 30){
			$( this ).css('display','none');
		}
		hide_count++;
	});
	
	$("#loadMore a").click(function(e){
		hide_loop++;
		var total_loop_time = parseInt(hide_loop*30);
		var show_count = 0;
		$("#runtime_descript .hide_load_more").each(function( index ) {
			show_count++;
			if(show_count <= total_loop_time){
				$( this ).css('display','block');
			}
			
		});
		//alert(show_count);
		if(hide_loop == divid_hide_load_more)
		$('#loadMore').hide();
		
		
	})*/
	/*Load more End*/
	
	//Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
	 $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
});</script>
    <!-- accordian script ends-->
    <!-- grid script -->
    <script>function resizeGridItem(item){
  grid = document.getElementsByClassName("grid")[0];
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
    item.style.gridRowEnd = "span "+rowSpan;
}

function resizeAllGridItems(){
  allItems = document.getElementsByClassName("item");
  for(x=0;x<allItems.length;x++){
    resizeGridItem(allItems[x]);
  }
}

function resizeInstance(instance){
	item = instance.elements[0];
  resizeGridItem(item);
}

window.onload = resizeAllGridItems();
window.addEventListener("resize", resizeAllGridItems);

allItems = document.getElementsByClassName("item");
for(x=0;x<allItems.length;x++){
  imagesLoaded( allItems[x], resizeInstance);
}

</script>

<!--Fixed_sidebar Start-->
<script>
    var length = $('#runtime_descript').height() - $('#sidebarRight').height() + $('#runtime_descript').offset().top;
	$(window).scroll(function () {
		var last_top = $('#runtime_descript').height()+20;
        var scroll = $(this).scrollTop();
        var height = $('#sidebarRight').height() + 'px';
		var pos_top = ( scroll - $('#runtime_descript').offset().top ) + $('#sidebarRight').height();
		var from_top = (scroll - $('#runtime_descript').offset().top + 50) + 'px';
		if(scroll <= 0) {
            $("#sidebarRight").css({
                'position': 'relative',
				'bottom': '0',
				'top': '0'
			});
			
        }
		else if(scroll >= length && scroll < last_top) {
			$("#sidebarRight").css({
                'position': 'absolute',
                'bottom': '0',
				'right': '0',
                'top': from_top
            });
			console.log(last_top);	
        }
		else {
		   $("#sidebarRight").css({
                'position': 'relative',
				'bottom': '0',
				'top': 'auto'


            });
        }
    });

</script>
<!--Fixed_sidebar END-->
<script>
$(document).ready(function(){
var all_h1_text = '';
var H1_count = 1;
$('#indexing ul').html('');
$("#Content_tab h1").each(function( index ) {
//alert('working');
  $( this ).attr('id',"H1_count"+ H1_count);
  $('#indexing ul').append("<li><span class='title'><a href='#H1_count"+H1_count+"'>"+$( this ).text()+"</a></span><span class='iconn'><a href='#H1_count"+H1_count+"'><img src='img/arrow1.png'></a></span></li>");
  H1_count++;
  console.log(all_h1_text);
});
	
	
	$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
/*sidebar code start*/	
$('#Hand-Outs').hide();
$('#Quiz-sidebar').hide();
$('#training_sidebar').hide();
$('#indexing').show();	

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href") // activated tab
  if(target == '#Content_tab')
  {
  	$('#Hand-Outs').hide();
	$('#Quiz-sidebar').hide();
	$('#training_sidebar').hide();
	$('#indexing').show();
	$('#runtime_descript').removeClass( "col-md-12" ).addClass( "col-md-9" );
  }
  else if(target == '#Videos_tab')
  {
  	$('#Hand-Outs').hide();
	$('#Quiz-sidebar').hide();
	$('#training_sidebar').hide();
	$('#indexing').hide();
	$('#runtime_descript').removeClass( "col-md-9" ).addClass( "col-md-12" );
  }
  else if(target == '#Handout_tab')
  {
  	$('#Hand-Outs').hide();
	$('#Quiz-sidebar').hide();
	$('#training_sidebar').hide();
	$('#indexing').hide();
	$('#runtime_descript').removeClass( "col-md-9" ).addClass( "col-md-12" );
  }
  else if(target == '#Trainings_tab')
  {
  	$('#Hand-Outs').hide();
	$('#Quiz-sidebar').hide();
	$('#training_sidebar').show();
	$('#indexing').hide();
	$('#runtime_descript').removeClass( "col-md-12" ).addClass( "col-md-9" );
  }
  else if(target == '#Quiz_tab')
  {
  	$('#Hand-Outs').hide();
	$('#Quiz-sidebar').hide();
	$('#training_sidebar').hide();
	$('#indexing').hide();
	$('#runtime_descript').removeClass( "col-md-9" ).addClass( "col-md-12" );
  }
  
  
});
		
/*sidebar code end*/
var get_screen_height = $(window).height();
get_screen_height = get_screen_height - 20;
$('#indexing').css({'max-height': get_screen_height,'overflow-y':'scroll','scroll-behavior': 'smooth'});
$('#Hand-Outs').css({'max-height': get_screen_height,'overflow-y':'scroll','scroll-behavior': 'smooth'});
$('#Quiz-sidebar').css({'max-height': get_screen_height,'overflow-y':'scroll','scroll-behavior': 'smooth'});
});

function get_training_data(id)
{
	$.ajax({
			type: "POST",
			url: "sadmin/ajax-status.php",
			cache:false,
			data: 'id='+id+'&meth=get-training-data',
			dataType:'json',
			success: function(response)
			{
				$('#Trainings_tab').html(response.msg);
				$('#training_sidebar li').removeClass('active_training');
				$('#training'+id).addClass('active_training');
				
			}
		});
}
</script>
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
