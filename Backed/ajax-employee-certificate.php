<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name=EMPLOYEE_CERTIFICATES;
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;


$sqlc = "SELECT COUNT(ec.ec_id) as count FROM `".$table_name."` ec LEFt JOIN ".USERS." e ON e.id=ec.e_id LEFT JOIN ".DEPARTMENT." d ON d.dept_id=e.department_id LEFT JOIN certificate_details cd ON cd.c_id=ec.c_id WHERE ec.c_id=".$requestData['cert_id']."";

$sql = "SELECT ec.ec_id,ec.c_date,ec.status,e.name,d.dep_name,cd.c_logo_type,cd.c_title FROM `".$table_name."` ec LEFt JOIN ".USERS." e ON e.id=ec.e_id LEFT JOIN ".DEPARTMENT." d ON d.dept_id=e.department_id LEFT JOIN certificate_details cd ON cd.c_id=ec.c_id WHERE ec.c_id=".$requestData['cert_id']."";
if( !empty($requestData['search']['value']) ) { 
    $sql.=" AND ( e.name  LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR d.dep_name  LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR e.contact_no LIKE '".$requestData['search']['value']."%' )" ;
	
	$sqlc.=" AND ( e.name  LIKE '".$requestData['search']['value']."%' ";
    $sqlc.=" OR d.dep_name  LIKE '".$requestData['search']['value']."%' ";
	$sqlc.=" OR e.contact_no LIKE '".$requestData['search']['value']."%' )" ;
}

/*ORDER BY*/
$sql.=" AND ec.`status`=0  ORDER BY ec.`ec_id` DESC";
$sqlc.=" AND ec.status=0 ";
$getTotal = $prop->get_Disp($sqlc);
$totalData = $totalFiltered = $getTotal['count'];
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$data = array();
if($totalData>0){
	$row=$prop->getAll_Disp($sql);
	for($i=0; $i<count($row); $i++){  

		$nestedData=array();
		$nestedData[] = ucfirst($row[$i]['name']);
		$nestedData[] = ucfirst($row[$i]['c_title']);
		$nestedData[] = date('Y-m-d',strtotime($row[$i]['c_date']));
		$nestedData[] = ucfirst($row[$i]['dep_name']);

		if($row[$i]["c_logo_type"]==1)
		{
			$page = "pdnew.php";
		}
		elseif ($row[$i]["c_logo_type"]==2) {
			$page = "pdnew1.php";
		}
		elseif ($row[$i]["c_logo_type"]==4) {
			$page = "pdnew3.php";
		}
		else {
			$page = "pdnew4.php";
		}
		$eq ='<a class="deleteone" id="'.$row[$i]['ec_id'].'"><span class="label i-lable label-danger bttn"><i class="i-font17 ti-trash"></i></span></a>&nbsp;';

		$eq.='<a href="pdf/'.$page.'?id='.$row[$i]['ec_id'].'" target="_blank" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-eye"></i></span></a>&nbsp;';

		$nestedData[] = $eq;
		$data[] = $nestedData;
	}
}
$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
