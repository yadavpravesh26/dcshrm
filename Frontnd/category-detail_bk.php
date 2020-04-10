<?php
require_once('config.php');
require_once(DOC_CONFIG . 'inc/pdoconfig.php');
require_once(DOC_CONFIG . 'inc/pdoFunctions.php');
$curr_val = $prop->get('*', PAGES, array("p_id" => $_REQUEST['id'], 'page_status' => 0));
if (empty($curr_val)) {
    header('location: ' . _404);
    exit;
}
$category_id = $prop->getName('c_name', SUB_CATEGORY, ' status=0 AND c_id=' . $curr_val['category']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="http://www.w3schools.com/lib/w3data.js"></script>
    <style type="text/css" media="print">
        BODY {
            display: none;
            visibility: hidden;
        }
    </style>
    <style>
        body {
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            user-select: none;
        }

        .footer {
            background: #f9f9f9;
        }

        #page-wrapper {
            background: #fff !important;
        }

        .container-fluid {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .img-banner {
            background: url('<?php echo ADMIN_SITE . 'uploads/catdetails/' . $curr_val[ban_image] ?>') no-repeat center center;
            background-size: cover;
            height: 300px;
            width: 100%;
        }

        .col-md-10.text-box h4 {
            font-size: 17px;
            font-weight: 600;
            text-transform: uppercase;
        }

        #home_info {
            background-color: #ffffff;
            padding-top: 40px;
            padding-bottom: 60px;
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

        #home_info {
            background: #fff;
            margin: 0;
            padding-right: 0;
            padding-left: 0;
            width: 100%;
        }

        .pricing-details .click-btn li button {
            width: 100%;
            border: none;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 3px 8px rgb(192, 192, 192);
            transition: all linear .3s;
        }

        .pricing-details .click-btn li button:hover {
            opacity: .7;
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

        .p-l {
            padding-left: 0px;
        }

        .p-r {
            padding-left: 0px;
        }

        .b_sp {
            margin-bottom: 30px;
        }
        .sidebar {
            width: 26.5rem;
            background: #FFF;
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
        <?php include 'header.php'; ?>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
        <?php include 'navbar.php'; ?>
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
                if ($nav_main === 1)
                    $perm_form = 0;
                if (in_array($category_id, explode(',', $nav_category)))
                    $perm_form = 0;
                if (in_array($curr_val['category'], explode(',', $nav_sub_category)))
                    $perm_form = 0;
                if (in_array($category_id, explode(',', $rej_category)))
                    $perm_form = 1;
                if (in_array($curr_val['category'], explode(',', $rej_sub_category)))
                    $perm_form = 1;
                if ($perm_form === 1) {
                    header('Location:' . LIVE_SITE);
                    exit;
                }

                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class="row">

                                <div class="img-banner">
                                    <div class="banner-txt"><?php echo $curr_val[ban_title] ?></div>
                                </div>

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
                                <div class="col-md-9 text-box" id="runtime_descript">
                                    <?php
                                    echo $curr_val[descript];
                                    ?>
                                    <div id="loadMore" style="">
                                        <a style="cursor:pointer">Load More</a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="sticky-wrapper" id="sticky-wrapper">
                                        <div class="sidebar-right sidebar-sticky sidebar-detached" id="sidebar">
                                            <div class="sidebar" id="jinglika_boosha" style="position: absolute;">
                                                <?php
                                                if ($curr_val['handout'] != "emp" && $curr_val['handout'] != "") {
                                                ?>
                                                    <div class="sidebarr">
                                                        <h3><img src="img/handout.png"> Hand Outs</h3>
                                                        <ul Class="handout-sst">
                                                            <?php
                                                            $catfetdoc =  "SELECT * FROM docs WHERE doc_type=1 AND doc_id IN(" . $curr_val['handout'] . ") AND doc_status=0";
                                                            $rowdoc = $prop->getAll_Disp($catfetdoc);
                                                            for ($i = 0; $i < count($rowdoc); $i++) {
                                                                $old_name = "images/docs/" . $rowdoc[$i]['doc_file'];
                                                                $extension = end(explode('.', strtolower($old_name)));
                                                                $new_name = "images/docs/" . $rowdoc[$i][doc_name] . "." . $extension;
                                                            ?>
                                                                <li><span class="title"><a href="<?php echo $new_name; ?>"><?php echo $rowdoc[$i][doc_name]; ?></a></span><span class="iconn"><img src="img/arrow1.png"></span></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>
                                                <div class="sidebarr">
                                                    <h3><img src="img/help.png">Quiz</h3>
                                                    <ul Class="handout-sst">
                                                        <li><span class="title"><a href="#">Civil Working Quiz</a></span><span class="iconn"><img src="img/arrow1.png"></span></li>
                                                        <li><span class="title"><a href="#">Internal Assesment Quiz</a></span><span class="iconn"><img src="img/arrow1.png"></span></li>
                                                        <li><span class="title"><a href="#">Know your Health Quiz</a></span><span class="iconn"><img src="img/arrow1.png"></span></li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row center" id="second_div">
                                <div class="col-md-10 col-centered p-0 grid ">
                                    <?php
                                    if ($curr_val['handout'] != "emp" && $curr_val['handout'] != "") {
                                    ?>
                                        <div class="col-sm-6 col-md-6 wid_th p-l item">
                                            <div class="pricing-box pricing-color1">
                                                <div class="pricing-content">
                                                    <div class="pricing-title">Hand Outs</div>
                                                    <div class="pricing-details">
                                                        <ul class="click-btn">
                                                            <?php
                                                            $catfetdoc =  "SELECT * FROM docs WHERE doc_type=1 AND doc_id IN(" . $curr_val['handout'] . ") AND doc_status=0";
                                                            $rowdoc = $prop->getAll_Disp($catfetdoc);
                                                            for ($i = 0; $i < count($rowdoc); $i++) {
                                                                $old_name = "images/docs/" . $rowdoc[$i]['doc_file'];
                                                                $extension = end(explode('.', strtolower($old_name)));
                                                                $new_name = "images/docs/" . $rowdoc[$i][doc_name] . "." . $extension;

                                                                rename($old_name, $new_name);
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
                                    if ($curr_val['trainings'] != "emp" && $curr_val['trainings'] != "") {
                                    ?>
                                        <div class="col-sm-6 col-md-6 wid_th p-r item">
                                            <div class="pricing-box pricing-color1">
                                                <div class="pricing-content">

                                                    <div class="pricing-title">Training</div>
                                                    <div class="pricing-details">
                                                        <ul class="click-btn">
                                                            <?php
                                                            $catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id IN(" . $curr_val['trainings'] . ") AND doc_status=0";
                                                            $rowdoc = $prop->getAll_Disp($catfetdoc);
                                                            for ($i = 0; $i < count($rowdoc); $i++) {
                                                            ?>
                                                                <li><a href="document-page.php?ids=<?php echo base64_encode($rowdoc[$i][doc_id]); ?>"><button style=" background: #128653;"><?php echo $rowdoc[$i][doc_name]; ?></button></a></li>

                                                            <?php } ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($curr_val['quiz'] != "emp" && $curr_val['quiz'] != "") {
                                    ?>
                                        <div class="col-sm-6 col-md-6 wid_th p-r item">
                                            <div class="pricing-box pricing-color1">
                                                <div class="pricing-content">
                                                    <div class="pricing-title">Quiz</div>
                                                    <div class="pricing-details">
                                                        <ul class="click-btn">
                                                            <?php
                                                            $catfetdoc =  "SELECT * FROM dynamic_form WHERE form_type=0 AND d_form_id IN(" . $curr_val['quiz'] . ") AND d_detele_status=0";
                                                            $rowdoc = $prop->getAll_Disp($catfetdoc);
                                                            for ($i = 0; $i < count($rowdoc); $i++) {
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
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($curr_val['videos'] != "emp" && $curr_val['videos'] != "") {
                    /* $catfetdoc =  "SELECT * FROM docs WHERE doc_type=3 AND doc_id IN(".$curr_val['videos'].") AND doc_status=0"; */
                    $str_videos = $prop->getName('GROUP_CONCAT(doc_file)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=3 AND doc_id IN(' . $curr_val['videos'] . ')');

                    $str_videos_names = $prop->getName('GROUP_CONCAT(doc_name)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=3 AND doc_id IN(' . $curr_val['videos'] . ')');
                    $arr_videos = explode(",", $str_videos);
                    $arr_videos_names = explode(",", $str_videos_names);
                    $result = count($arr_videos);
                    $ex = explode("v=", $arr_videos[0]);
                    $ex = explode("&", $ex[1]);
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
                                            for ($i = 0; $i < $result; $i++) {
                                                $ex = explode("v=", $arr_videos[$i]);
                                                $ex = explode("&", $ex[1]);
                                            ?>

                                                <div class="video-sec">
                                                    <div class="col-sm-4 col-md-4 pt1">
                                                        <a class="dash" href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://www.youtube.com/embed/<?php echo $ex[0]; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
                                                            <span class="vid-thumb"><img class="you" width="100%" height="auto" src="http://img.youtube.com/vi/<?= $ex[0] ?>/hqdefault.jpg" /></span>
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pt2">
                                                        <a class="dash" href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://www.youtube.com/embed/<?php echo $ex[0]; ?>?autoplay=1&rel=0&showinfo=0&autohide=1'"><label><?php echo $arr_videos_names[$i]; ?></label></a>
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

                <?php
                if ($curr_val['images'] != "emp" && $curr_val['images'] != "") {
                    /* $catfetdoc =  "SELECT * FROM docs WHERE doc_type=3 AND doc_id IN(".$curr_val['videos'].") AND doc_status=0"; */
                    $str_img = $prop->getName('GROUP_CONCAT(doc_file)', 'docs', ' 1=1 AND doc_status=0 AND doc_type=4 AND doc_id IN(' . $curr_val['images'] . ')');
                    $arr_img = explode(",", $str_img);
                    $result = count($arr_img);
                ?>
                    <div class="row m-t-15">
                        <ul id="list-group">
                            <?php
                            for ($i = 0; $i < $result; $i++) {
                            ?>
                                <li class="list-group-item">
                                    <a href="images/banner/<?php echo $arr_img[$i] ?>">
                                        <img width="100%" height="auto" src="images/banner/<?php echo $arr_img[$i] ?>">
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <!-- /.container-fluid --><?php include 'footer.php'; ?>

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
        $(function() {
            $(".accordian h3").click(function(e) {
                $($(e.target).find('.ti-plus').toggleClass('open'));
                $(".accordian ul ul").slideUp();
                if ($(this).next().is(":hidden")) {
                    $(this).next().slideDown();
                }
            });

            /*Load more*/
            $("#runtime_descript h1").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript h2").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript h3").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript h4").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript h5").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript h6").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript p").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            $("#runtime_descript ul").each(function(index) {
                $(this).addClass("hide_load_more");
            });
            var hide_count = 0;
            var hide_loop = 1;
            var total_hide_load_more = $('.hide_load_more').length
            divid_hide_load_more = Math.ceil(total_hide_load_more / 30);

            $("#runtime_descript .hide_load_more").each(function(index) {
                if (hide_count >= 30) {
                    $(this).css('display', 'none');
                }
                hide_count++;
            });

            $("#loadMore a").click(function(e) {
                hide_loop++;
                var total_loop_time = parseInt(hide_loop * 30);
                var show_count = 0;
                $("#runtime_descript .hide_load_more").each(function(index) {
                    show_count++;
                    if (show_count <= total_loop_time) {
                        $(this).css('display', 'block');
                    }

                }); 
                if (hide_loop == divid_hide_load_more)
                    $('#loadMore').hide();
            });

            var distance = $('#runtime_descript').offset().top+250;
            var distance1 = $('#second_div').offset().top-250;
            $window = $(window);

            $window.scroll(function() {
                if ( $window.scrollTop() >= distance ) {
                    $('#jinglika_boosha').css('position', 'fixed');
                } else {
                    $('#jinglika_boosha').css('position', 'absolute');
                }
                if ( $window.scrollTop() >= distance1 ) {
                    $('#jinglika_boosha').css('position', 'absolute');
                }
            });

        });   
        function resizeGridItem(item) {
            grid = document.getElementsByClassName("grid")[0];
            rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
            rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
            rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
            item.style.gridRowEnd = "span " + rowSpan;
        }

        function resizeAllGridItems() {
            allItems = document.getElementsByClassName("item");
            for (x = 0; x < allItems.length; x++) {
                resizeGridItem(allItems[x]);
            }
        }

        function resizeInstance(instance) {
            item = instance.elements[0];
            resizeGridItem(item);
        }

        window.onload = resizeAllGridItems();
        window.addEventListener("resize", resizeAllGridItems);

        allItems = document.getElementsByClassName("item");
        for (x = 0; x < allItems.length; x++) {
            imagesLoaded(allItems[x], resizeInstance);
        }
    </script>
    <!-- grid script ends -->
</body>

</html>