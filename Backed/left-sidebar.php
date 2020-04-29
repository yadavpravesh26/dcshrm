<?php $current_page = $_SERVER['REQUEST_URI'];
	  $current_page = explode('/',$current_page);
	  $current_page = $current_page[2];
	 // echo $current_page;
	  $active_css = 'class="nav nav-second-level collapse in" aria-expanded="true"';
?>
<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="hide sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> 
					<span class="input-group-btn">
						<button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
					</span> 
				</div>
                <!-- /input-group -->
            </li>
			<li> 
				<a href="dashboard.php" class="waves-effect"><i class="icon-pie-chart"></i> <span class="hide-menu">Dashboard </span></a> 
			</li>
			<?php if($session['b_type']===0){ ?>
			<li> <a href="#" class="waves-effect"><i class="ti-write"></i> <span class="hide-menu">Manage Be Safe Page<span class="fa arrow"></span> </span></a>
                <ul <?php if($current_page == 'page-builder.php' or $current_page == 'manage-new-page.php'){echo $active_css;} else{ echo 'class="nav nav-second-level" ';}?>>
                	<?php if($session['b_type']===0){ ?>
                    <li> <a href="page-builder.php">Add New Page</a> </li>
                     <?php } ?>
                    <li> <a href="manage-new-page.php">Manage Be Safe Pages</a> </li>
                </ul>
            </li>
           
           <?php } ?>
          	<li class=""> <a href="#" class="waves-effect"><i class="ti-medall-alt"></i> <span class="hide-menu">Settings<span class="fa arrow"></span> </span></a>
                <ul <?php if($current_page != 'page-builder.php' and $current_page != 'manage-new-page.php' and $current_page != 'dashboard.php'){echo $active_css;} else{ echo 'class="nav nav-second-level"';}?>>
                    <?php if($session['b_type']===0){ ?>
                    <li> 
				<a href="manage-category.php" class="waves-effect"><i class="ti-settings"></i> <span class="hide-menu">Manage Category </span></a> 
			</li>
                   
                    <li> <a href="#" class="waves-effect"><i class="ti-receipt"></i> Manage Programs <span class="fa arrow"></span> </a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="action-hand-outs.php">Add New Programs</a> </li>
                    <li> <a href="manage-hand-outs.php">Manage Programs</a> </li>
                    </ul>
                    </li>
                   
                    <li> <a href="#" class="waves-effect"><i class="ti-bookmark-alt"></i> Manage Trainings <span class="fa arrow"></span> </span></a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="action-training.php">Add New Training </a> </li>
                    <li> <a href="manage-training.php">Manage Training</a> </li>
                    </ul>
                    </li>
                    
                     <li> <a href="manage-assign.php" class="waves-effect"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="hide-menu">Manage Assign </span></a></li>
                    
                    <li> <a href="#" class="waves-effect"><i class="fa fa-tasks" aria-hidden="true"></i> Manage Jobs <span class="fa arrow"></span> </a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="add-jobs.php">Add New job</a> </li>
                    <li> <a href="manage-jobs.php">Manage Jobs</a> </li>
                    </ul>
                    </li>
                    
                   
                    <?php /*?><li> <a href="#" class="waves-effect"><i class="ti-ruler-pencil"></i> Manage Quiz <span class="fa arrow"></span> </span></a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="cms/form-editor.php">Add New Quiz </a> </li>
                    <li> <a href="manage-new-forms.php">Manage Quiz</a> </li>
                    </ul>
                    </li><?php */?>
                    
                    <?php /*?><li><a href="#" class="waves-effect"><i class="ti-video-clapper"></i> Manage Videos<span class="fa arrow"></span> </span> </a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="action-video.php">Add New Video </a> </li>
                    <li> <a href="manage-video.php">Manage Videos</a> </li>
                    </ul>
                    </li><?php */?>
                    
                    <?php /*?><li> <a href="#" class="waves-effect"><i class="ti-image"></i> Manage Images<span class="fa arrow"></span> </span> </a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="action-image.php">Add New Image </a> </li>
                    <li> <a href="manage-image.php">Manage Images</a> </li>
                    </ul>
                    </li><?php */?>
                    
                    <li> <a href="#" class="waves-effect"><i class="ti-bag"></i> Manage Companies<span class="fa arrow"></span> </span> </a>
                    <ul class="nav nav-second-level">
                    <li> <a href="add-company.php">Add New Company</a> </li>
                    <li> <a href="manage-company.php">Manage Companies</a> </li>
                </ul>
                </li>
                <li> <a href="manage-industries.php" class="waves-effect"><i class="ti-settings"></i> Manage Industries </span></a> 
                    </li>
                
                	<li> <a href="#" class="waves-effect"><i class="ti-medall-alt"></i> Add New Certificate <span class="fa arrow"></span> </span></a> 
                    <ul class="nav nav-second-level">
                    <li> <a href="certificate-page.php">Add New Certificate</a> </li>
                    <li> <a href="manage-certificate-details.php">Manage Certificates</a> </li>
                    </ul>
                    </li>
                    
                     <?php } ?>
                    
                    <?php if($session['b_type'] === 2){ ?>
                    <li class=""> <a href="#" class="waves-effect"><i class="ti-user"></i> <span class="hide-menu">Employees<span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="add-employee.php">Add New Employee</a> </li>
                            <li> <a href="add-bulk-employee.php">Employee Bulk Import</a> </li>
                            <li> <a href="employee-details.php">Manage Employees </a> </li>
                        </ul>
                    </li>
                    <li class=""> <a href="manage-be-safe.php" class="waves-effect"><i class="ti-image"></i> <span class="hide-menu">Manage Be Safe Programs </span></a>
                    <!--     <ul class="nav nav-second-level">
                            <li> <a href="manage-be-safe.php">Manage Be Safe Programs</a> </li>
                            <li> <a href="add-training-design.php">Assigned Be Safe Programs</a> </li>
                        </ul>  -->
                    </li>
                    
                    <li class=""> <a href="manage-departments.php" class="waves-effect"><i class="ti-settings"></i> <span class="hide-menu">Manage Departments </span></a>
                    </li>
                    <li> <a href="survey-details.php" class="waves-effect"><i class="ti-user"></i> <span class="hide-menu">Quiz Report </span></a> </li>
                    <li class=""> <a href="#" class="waves-effect"><i class="ti-medall-alt"></i> <span class="hide-menu">Manage Certificates<span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="certificate-page.php">Add New Certificate</a> </li>
                            <li> <a href="manage-certificate-details.php">Manage Certificates</a> </li>
                        </ul>
                    </li>
                    
                    
                     <?php } ?>
                </ul>
            </li>
            
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->