<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$meth = (isset($_REQUEST['meth'])?$_REQUEST['meth']:'');
/* if(bckPermission($session['b_type'])){
	$output = array('status'=>'Error','msg'=>'Permission not available','err'=>'error');
	echo json_encode($output); exit;
} */
if($meth=='cat-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("c_id" => $id);
		$values = array("status" => $status);
		$s = $prop->update(MAIN_CATEGORY, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='catsub-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("c_id" => $id);
		$values = array("status" => $status);
		$s = $prop->update(SUB_CATEGORY, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='catsub-status-subdelete')
{
	$table_name = "pages";
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Deleted Failed','err'=>'error');
	$exits = $prop->getName('count(p_id)', $table_name, "page_status!=2 AND category=".$id);
	if($exits===0){
		if($id>0){
			$t_cond = array("c_id" => $id);
			$values = array("status" => $status);
			$s = $prop->update(SUB_CATEGORY, $values, $t_cond);
			if($s){
				$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
			}
		}
	}
	else
	{
		$output = array('status'=>'Error','msg'=>'Subcategory is assign to a page','err'=>'error');
	}	
	echo json_encode($output); exit;
}
if($meth=='catsub-status-delete')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Deleted Failed','err'=>'error');
	if($id>0){
		$t_cond = array("c_id" => $id);
		$values = array("status" => $status);
		$s = $prop->update(MAIN_CATEGORY, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='docs-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("doc_id" => $id);
		$values = array("doc_status" => $status);
		$s = $prop->update('docs', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='handouts-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("doc_id" => $id);
		$values = array("doc_status" => $status);
		$s = $prop->update('handouts', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='quiz-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("d_form_id" => $id);
		$values = array("d_form_status" => $status);
		$s = $prop->update(DYNAMIC_FORM, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='page-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("p_id" => $id);
		$values = array("page_status" => $status);
		$s = $prop->update(PAGES, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='page-copy')
{
	$id = $_POST["id"];
	$output = array('status'=>'Error','msg'=>'Copied Failed','err'=>'error');
	if($id>0){
		$sql = "INSERT INTO pages
			(title, meta_title, meta_desc, ban_title,ban_sub_title,ban_image,ban_alt_title,descript,docs,forms,trainings,guides,quiz,images,handout,videos,category,page_status)
		SELECT 
			 concat(title,'-copy'), meta_title, meta_desc, ban_title,ban_sub_title,ban_image,ban_alt_title,descript,docs,forms,trainings,guides,quiz,images,handout,videos,category,page_status
		FROM 
			pages
		WHERE 
			p_id =".$id;
		$last_id = $prop->Duplicate($sql);
		if($last_id != 0){
			$output = array('status'=>'Status','msg'=>'Copied Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='page-status-delete')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("p_id" => $id);
		$values = array("page_status" => $status);
		$s = $prop->update(PAGES, $values, $t_cond);
		if($s){
			$output = array('status'=>'Delete','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='depart-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("dept_id" => $id);
		$values = array("dep_status" => $status);
		$s = $prop->update(DEPARTMENT_NEW, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='depart-delete')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("dept_id" => $id);
		$values = array("dep_status" => $status);
		$s = $prop->update(DEPARTMENT_NEW, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='industry-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("dept_id" => $id);
		$values = array("dep_status" => $status);
		$s = $prop->update(DEPARTMENT, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='industry-status-delete')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Deleted Failed','err'=>'error');
	if($id>0){
		$t_cond = array("dept_id" => $id);
		$values = array("dep_status" => $status);
		$s = $prop->update(DEPARTMENT, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='handout-delete')
{
	$id = $_POST["id"];
	$status = '2';
	$output = array('status'=>'Error','msg'=>'Deleted Failed','err'=>'error');
	if($id>0){
		$t_cond = array("doc_id" => $id);
		$values = array("doc_status" => $status);
		$s = $prop->update('handouts', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='certificate-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("c_id" => $id);
		$values = array("c_status" => $status);
		$s = $prop->update(CERTIFICATE_DETAILS, $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}
if($meth=='docs-status')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("doc_id" => $id);
		$values = array("doc_status" => $status);
		$s = $prop->update('docs', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Updated Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='docs-delete')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("doc_id" => $id);
		$values = array("doc_status" => $status);
		$s = $prop->update('docs', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

if($meth=='job-del')
{
	$id = $_POST["id"];
	$status = $_POST['status'];
	$output = array('status'=>'Error','msg'=>'Updated Failed','err'=>'error');
	if($id>0){
		$t_cond = array("id" => $id);
		$values = array("job_status" => $status);
		$s = $prop->update('jobs', $values, $t_cond);
		if($s){
			$output = array('status'=>'Status','msg'=>'Deleted Successfully','err'=>'success','result'=>1);
		}
	}
	echo json_encode($output); exit;
}

/*get-training-data Start*/
if($meth=='get-training-data')
{
	$id = $_POST["id"];
	$catfetdoc =  "SELECT * FROM docs WHERE doc_type=2 AND doc_id = '".$id."' AND doc_status=0";
	$rowdoc=$prop->getAll_Disp($catfetdoc);
	$data = $rowdoc[0][doc_content];
	$old_name = "images/docs/".$rowdoc[$i]['doc_file'] ;
	$extension = end(explode('.',strtolower($old_name)));
	$new_name = "images/docs/".$rowdoc[0][doc_name].".".$extension ;
	rename( $old_name, $new_name);
	
	if($extension == 'pdf')
	$class = 'fa fa-file-pdf-o';
	else if($extension == 'doc' || $extension == 'docx')
	$class = 'fa fa-file-word-o';
	
	$data = $data.'<h1>Downloads</h1><div class="tab_inner"><ul class="handout-sst"><li><a href="'.$new_name.'"> <span class="title"><i class="'.$class.'"></i>'.$rowdoc[0][doc_name].'</span><span class="iconn"><i class="fa fa-download" aria-hidden="true"></i></span></a></li></ul></div>';
	$output = array('status'=>'Status','msg'=>$data,'err'=>'success','result'=>1);
	echo json_encode($output); exit;
}
/*get-training-data END*/

/*filter_cities Start*/
if($meth=='filter_cities')
{
	$all_cities = $_POST["all_cities"];
	$all_cities_check = $_POST["all_cities"];
	$all_cities = explode(',',$all_cities);
	$where = '';
	if(count($all_cities)>0)
	{
		for($i = 0; $i < count($all_cities)-1; $i++)
		{
			if($i != count($all_cities)-2 )
			$where .= 'job_city like "%'.$all_cities[$i].'%" or ';
			else
			$where .= 'job_city like "%'.$all_cities[$i].'%"';
		}	
	}
	$sql =  "SELECT * FROM jobs WHERE ".$where;
	$row=$prop->getAll_Disp($sql);
	if(count($row) > 0)
	{
		$data = '';
		for($i=0; $i<count($row); $i++)
		{
			$job_title = strip_tags($row[$i]["job_title"]); 
			$job_title = substr($job_title, 0, 35);
			$job_content = strip_tags($row[$i]["job_responsibilities"]); 
			$job_content = substr($job_content, 0, 350); 
														 
			$data .= '<div class="col-md-12 col-sm-12 col-xs-12 no-top-modal title-block">
                            <div class="title-block-container lobipanel-parent-sortable" data-lobipanel-child-inner-id="F4L4DABlZ3 8othh10Gnf eW3l6">

                                <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" id="widget-GmpM4"><h1 class="hdtitle"><span>'.$job_title.'</span></h1>
                                    <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ZU04W"><p class="hdtitle"><i class="fa fa-map-marker"></i><span> '.$row[$i]["job_city"].','.$row[$i]["job_state"].'</span></p></div>
                                    <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ZU04W"><p class="hdtitle"><i class="fa fa-clock-o"></i><span> '. $row[$i]["duration"].'</span></p></div>
                                    <div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ZU04W"><p class="hdtitle"><i class="fa fa-money"></i><span> '. $row[$i]["pay_range"].'</span></p></div>
									<div class="edifice-widget" data-block-type="widget" data-widget-type="heading" data-widget-id="002" div-selector="heading" id="widget-ZU04W" style="width:25% !important"><p class="hdtitle"><i class="fa fa-building"></i><span> '. $row[$i]["company_name"].'</span></p></div>
                                </div>


                                <div class="edifice-widget" data-block-type="widget" data-widget-type="divider" data-widget-id="019">
                                    <div class="wid-divider line-separator"></div>
                                </div>

                            </div>
                        </div><div class="col-md-12 col-sm-12 col-xs-12 no-top-modal content-block content-block-style-3">
                            <div class="content-block-container">

                                <div class="display-table">
                                    
                                    <div class="table-cell-vt">
                                        <div class="lobipanel-parent-sortable" data-lobipanel-child-inner-id="VQboCuM0EF Posubi3XnD Q5x1a">

                                            

                                            <div class="edifice-widget" data-block-type="widget" data-widget-type="text-block" data-widget-id="003" id="widget-f6NU4"><h1 class="hdtitle"><span></span></h1>
                                                
                                                <div class="d-edi-content-block">
                                                    <p class="para-content">
                                                    	'.$job_content.'
                                                    </p>
                                                </div>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><div class="col-md-12 col-sm-12 col-xs-12 no-top-modal content-block content-block-style-3 job_end_border">
                            <!-- Content Block Container -->
                            <div class="content-block-container">
								<div class="btn-group" id="btn-group-d25H4lk"><a class="btn btn-custom btn-square btn-standard" id="btn-ZmFzsur" href="/job-details.php?jobID='.$row[$i]["id"].'#apply-now"><span>Apply Now</span></a></div> 
                                <div class="btn-group" id="btn-group-d25H4lk"><a class="btn btn-custom btn-square btn-standard" id="btn-ZmFzsur" href="/job-details.php?jobID='.$row[$i]["id"].'"><span>View Details</span></a></div> 
                            </div><!-- /End Content Block Container -->
                        </div>';
		}
	}
	else
	{
		$data = '<p style="margin-left:10px;">No jobs found</p>';
	}	
	
	
	
	$output = array('status'=>'Status','msg'=>$data,'err'=>'success','result'=>1);
	echo json_encode($output); exit;
}
/*filter_cities END*/

/*Assign DepartMent Start*/
if($meth=='assignDepart')
{
	$catID = $_POST["catID"];
	$subCatID = $_POST["subCatID"];
	$deprtID = $_POST['deprtID'];
	$programID = $_POST['programID'];
	$type = $_POST['type'];
	if($type == 'assign')
	{
		$input = array(
			'depart_id'	=>$deprtID,
			'catID'	=>$catID ,
			'subCatID'	=>$subCatID,
			'programID'	=>$programID,
			'status'	=>0
		);
		$insert_count =0;
		$exits = $prop->getName('count(id)', 'assign_depart', "depart_id=".$deprtID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
		   if($exits === 0){
				$result = $prop->add('assign_depart', $input);
				if ($result) {
					$insert_count++;
				}
		   }
		   else
		   {
				$unassignDepID = $prop->getName('id', 'assign_depart', "status=2 AND depart_id=".$deprtID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
				if($unassignDepID != 0)
				{
					$t_cond = array("id" => $unassignDepID);
					$result = $prop->update('assign_depart', $input, $t_cond);
					if ($result) {
						$insert_count++;
					}
					
				}
		   }
		   
		$output = array('status'=>'Error','msg'=>'Department already Assigned','err'=>'error');
		if($insert_count != 0)
		{
			$output = array('status'=>'Status','msg'=>'Department Assigned Successfully','err'=>'success','result'=>1);
		}
	}
	else
	{
		$input = array(
			'depart_id'	=>$deprtID,
			'catID'	=>$catID ,
			'subCatID'	=>$subCatID,
			'programID'	=>$programID,
			'status'	=>2
		);
		$unassignDepID = $prop->getName('id', 'assign_depart', "depart_id=".$deprtID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
		$output = array('status'=>'Status','msg'=>'Department Unassigned Failed','err'=>'success','result'=>1);
		if($unassignDepID != 0)
		{
			$t_cond = array("id" => $unassignDepID);
			$result = $prop->update('assign_depart', $input, $t_cond);
			if ($result) {
				$insert_count++;
				$output = array('status'=>'Status','msg'=>'Department Unassigned Successfully','err'=>'success','result'=>1);
			}
			
		}
	}	
	echo json_encode($output); exit;
}
/*Assign DepartMent END*/

/*Assign Employee Start*/
if($meth=='assignEmp')
{
	$catID = $_POST["catID"];
	$subCatID = $_POST["subCatID"];
	$empID = $_POST['empID'];
	$programID = $_POST['programID'];
	$type = $_POST['type'];
	if($type == 1)
	{
		$input = array(
			'emp_id'	=>$empID,
			'catID'	=>$catID ,
			'subCatID'	=>$subCatID,
			'programID'	=>$programID,
			'status'	=>0
		);
		$insert_count =0;
		$exits = $prop->getName('count(id)', 'assign_emp', "emp_id=".$empID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
		   if($exits === 0){
				$result = $prop->add('assign_emp', $input);
				if ($result) {
					$insert_count++;
				}
		   }
		   else
		   {
				$unassignEmpID = $prop->getName('id', 'assign_emp', "status=2 AND emp_id=".$empID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
				if($unassignEmpID != 0)
				{
					$t_cond = array("id" => $unassignEmpID);
					$result = $prop->update('assign_emp', $input, $t_cond);
					if ($result) {
						$insert_count++;
					}
					
				}
		   }
		   
		$output = array('status'=>'Error','msg'=>'Employee already Assigned'.$unassignEmpID,'err'=>'error');
		if($insert_count != 0)
		{
			$output = array('status'=>'Status','msg'=>'Employee Assigned Successfully','err'=>'success','result'=>1);
		}
	}
	else
	{
		$input = array(
			'emp_id'	=>$empID,
			'catID'	=>$catID ,
			'subCatID'	=>$subCatID,
			'programID'	=>$programID,
			'status'	=>2
		);
		$unassignEmpID = $prop->getName('id', 'assign_emp', "emp_id=".$empID." AND catID=".$catID." AND subCatID=".$subCatID." AND programID=".$programID);
		$output = array('status'=>'Status','msg'=>'Employee Unassigned Failed','err'=>'success','result'=>1);
		if($unassignEmpID != 0)
		{
			$t_cond = array("id" => $unassignEmpID);
			$result = $prop->update('assign_emp', $input, $t_cond);
			if ($result) {
				$insert_count++;
				$output = array('status'=>'Status','msg'=>'Employee Unassigned Successfully','err'=>'success','result'=>1);
			}
			
		}
	}	
	echo json_encode($output); exit;
}
/*Assign Employee END*/
?>
