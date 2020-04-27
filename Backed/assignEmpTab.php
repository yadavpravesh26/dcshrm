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

//$sql = 'select * from '.USERS.' where status != 2 and id='.$_SESSION['US']['user_id'];
$sql = 'Select U.name as name,U.email as EmailID,U.department_id as department_id, U.id as id, A.status as assignType, A.id as EID  ,A.programID as programID 
		from '.USERS.' U 
		INNER JOIN assign_emp A 
		ON U.id = A.emp_id 
		where U.u_type = 4 '.$where.' and U.u_id='.$session['bid'].' and  A.programID ='. $programID .' GROUP BY U.id' ;

$row = $prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
{
	$empID = $row[$i]['id'];
	$EID = $row[$i]['EID'];
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
	$nestedData[] = $row[$i]['EmailID'];
	$radio='<div class="row"><div class="col-md-4"><div class="radio radio-success">
	<input class="radioAssign" id="assign'.$empID.'"  data-id="'.$empID.'" name="assign_type'.$empID.'" onclick="assignEmp(1,'.$empID.')" type="radio" '.$Achecked.'>
	<label class="category-label" for="assign'.$empID.'"><b>Assign</b></label>
	</div></div>
	<div class="col-md-4"><div class="radio radio-success">
	<input class="radioAssign" id="unassign'.$empID.'"  data-id="'.$empID.'" name="assign_type'.$empID.'" onclick="assignEmp(2,'.$empID.')" type="radio" '.$Uchecked.'>
	<label class="category-label" for="unassign'.$empID.'"><b>UnAssign</b></label>
	</div></div><div class="col-md-4"><a class="deleteone" id="'.$EID.'" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a></div></div> ';
	$nestedData[] = $radio;
	$data[] = $nestedData;
}
$json_data = array("data" => $data );

echo json_encode($json_data);
?>