<?php
if($_SESSION['US']['user_id']=='') {
	 header("Location: index.html");
		}
	if($_SESSION['US']['sub_id']==1)
	{
		$arrform = '1,2,3,4,5,6,7,8,9,11,12,15,16,17,18,19,20,21,22,103';	
	}
	if($_SESSION['US']['sub_id']==2)
	{
		
		$arrform = '1,2,3,4,5,6,7,8,10,17,18';	
	}	
if($_SESSION['US']['sub_id']==3)
	{
		 $arrform = '1,2,3,4,5,6,7,8,9,11,12,15,16,17,18,19,20,21,22,103';	
	}	
	if($_SESSION['US']['sub_id']==4)
	{
		
		 $arrform = '1,2,3,4,5,6,7,8,9,11,12,15,16,17,18,19,20,21,22,103';		
	}	
	if($_SESSION['US']['sub_id']==5)
	{
		
		 $arrform = '1,2,3,4,5,6,7,8,9,11,12,15,16,17,18,19,20,21,103';	
	}	
	if($_SESSION['US']['sub_id']==6)
	{
		
		$arrform = '1,2,3,4,5,6,7,8,10,17,18';	
	}	
	if($_SESSION['US']['sub_id']==0)
	{
		
		$arrform = '1,2,3,4,5,6,7,8,9,11,12,13,18,103,104,105,106';	
	}
	
	//print_r($_SESSION);
?>
<style type="text/css">

		.typeahead {

		  background-color: #fff;

		}

		.typeahead:focus {

		  border: 2px solid #0097cf;

		}

		.tt-query {

		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);

		     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);

		          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);

		}

		.tt-hint {

		  color: #999

		}

		.tt-menu {
			

		  width: 550px;

		  margin: 12px 0;

		  padding: 8px 0;

		  background-color: #fff;

		  border: 1px solid #ccc;

		  border: 1px solid rgba(0, 0, 0, 0.2);

		  -webkit-border-radius: 8px;

		     -moz-border-radius: 8px;

		          border-radius: 8px;

		  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);

		     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);

		          box-shadow: 0 5px 10px rgba(0,0,0,.2);

		    left: 17px !important;

		    top: 75% !important;

		}

		.tt-suggestion {

		  padding: 3px 20px;

		  font-size: 18px;

		  line-height: 24px;

		}

		.tt-suggestion:hover {

		  cursor: pointer;

		  color: #fff;

		  background-color: #0097cf;

		}

		.tt-suggestion.tt-cursor {

		  color: #fff;

		  background-color: #0097cf;

		}

		.image-ajax .image {

		  width: 30px;

		  float: left;

		}

		.image-ajax .menu-text{

		    padding-bottom: 0px;

		    margin: 0px;

		}

		.image-ajax .price{

		    font-size: 12px;

		    margin: 0px;

		}

		.image-ajax .ajax-text{

		    padding-left: 60px;

		}

		.tt-suggestion.tt-cursor {

		  color: #fff;

		  background-color: #0097cf;

		}

		.tt-suggestion p {

		  margin: 5px;

		}

	</style>
<!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="index.php"><img src="img/logo.png" alt="home" /></a></div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs" name='searchdash' action='search-result.php'>
                            <input type="text" placeholder="Search..." class="form-control" id='search_val' name='search_val' value=<?php echo $_GET['search_val']; ?>>
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                   
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs">
						<?php echo ($_SESSION['US']['type']==2?$_SESSION[US]['company_name']:$_SESSION[US]['user_name']); ?></b>  <img src="img/man.png" alt="user-img" width="32" class="img-circle"> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <!--<li><a href="#"><i class="ti-user"></i>Help</a></li>-->
                          
                            <li><a href="settings-page.php"><i class="ti-settings m-r-5"></i>Setting</a></li>
                            
                            <li><a href="index.php?method=logout"><i class="fa fa-power-off m-r-5"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    
                 
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->