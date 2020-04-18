<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$requestData= $_REQUEST;
$where='';
$whereEmp='';
$programID = $requestData['programID'];
$assignStatus = '';
$assignStatusValue ='';
$data = array();
if($requestData[empFilterByDep] != '')
{
	$where .= ' AND department_id='.$requestData[empFilterByDep];
}

if($requestData[empKeyword] != '')
{
	$where .= ' AND name like "%'.$requestData[empKeyword].'%"';
}

$sql = 'select * from '.USERS.' where u_type = 4 AND status != 2 '.$where.' and u_id='.$session['bid'];
/*$sql = 'Select U.name as name,U.department_id as department_id, U.id as id, A.status as assignType ,A.programID as programID 
		from '.USERS.' U 
		INNER JOIN assign_emp A 
		ON U.id = A.emp_id 
		where U.u_type = 4 '.$where.' and U.u_id='.$session['bid'].' GROUP BY U.id' ;*/

$row = $prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
{
	$empID = $row[$i]['id'];
	//$assignStatus = $prop->getName('status', 'assign_emp', "emp_id=".$empID." ".$whereEMP." AND programID=".$programID);
	if($requestData[empFilterByType] != '')
	$assignStatus = $prop->get('status','assign_emp', array('emp_id'=>$empID,'programID'=>$programID,'status'=>$requestData[empFilterByType]));
	else
	$assignStatus = $prop->get('status','assign_emp', array('emp_id'=>$empID,'programID'=>$programID));
	
	if($assignStatus == '' and $requestData[empFilterByType] != '')
	continue;
		
	$Achecked='';
	$Uchecked='';
	if($assignStatus['status'] === 0)
	$Achecked='checked';
	else if($assignStatus['status'] != '')
	$Uchecked='checked';
	
	$nestedData=array();
	$nestedData[] = $row[$i]["name"];
	$depID = $row[$i]['department_id'];
	$depName = $prop->getName('dep_name', DEPARTMENT_NEW, "dept_id=".$depID);
	$nestedData[] = $depName;
	$radio='<div class="row"><div class="col-md-6"><div class="radio radio-success">
	<input class="radioAssign" id="assign'.$depID.'"  data-id="'.$depID.'" name="assign_type'.$depID.'" value="" type="radio"  value="0" '.$Achecked.'>
	<label class="category-label" for="assign'.$depID.'"><b>Assign</b></label>
	</div></div>
	<div class="col-md-6"><div class="radio radio-success">
	<input class="radioAssign" id="unassign'.$depID.'"  data-id="'.$depID.'" name="assign_type'.$depID.'" value="" type="radio"  value="2" '.$Uchecked.'>
	<label class="category-label" for="unassign'.$depID.'"><b>UnAssign</b></label>
	</div></div></div>';
	$nestedData[] = $radio;
	$data[] = $nestedData;
}
$json_data = array("data" => $data );

echo json_encode($json_data);
?>