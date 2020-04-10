<?php
if($_SESSION['U']['id']=='') {
	 header('Location: '.ADMIN_SITE);
}

?>
<link href="css/colors/gray.css" id="theme" rel="stylesheet">
<link href="css/style-owns.css" id="theme" rel="stylesheet">
<!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <!-- Logo -->
                <div class="top-left-part" style="    height: 60px;">
                    <a class="logo" href="<?php echo ADMIN_SITE; ?>">
                        <span class="hidden-xs"><img src="img/DCSHRM_logo.png" style="margin-top: 10px;" alt="home" /></span>
					</a>
                </div>
                <!-- /Logo -->
                <!-- This is for mobile view search and menu icon -->
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                   <!-- <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>-->

                </ul>
                <!-- This is the message dropdown -->
                <ul class="nav navbar-top-links navbar-right pull-right">


                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="img/user-icon.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?=$_SESSION['U']['email']?></b> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="change-password.php"><i class="ti-user"></i> Change Password</a></li>
                            <li role="separator" class="divider"></li>
							<?php if(isset($_SESSION['U']['permission']) && $_SESSION['U']['permission']==1 && isset($_SESSION['backup'])){ ?>
							<li><a href="access-permission.php?status=close"><i class="ti-arrow-left"></i> Back</a></li>
                            <li role="separator" class="divider"></li>
							<?php } ?>
                            <li><a href="index.php?method=logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- .Megamenu -->


                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
