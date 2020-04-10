<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name="jobs";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;

$sql = 'select * from '.$table_name.' where job_status!=2';
$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
	 {  // preparing an array
	$nestedData=array();
	$nestedData[] = $row[$i]["job_id"];
	$nestedData[] = $row[$i]["job_city"].",".$row[$i]["job_state"];
	$nestedData[] = $row[$i]["company_name"];
	$nestedData[] = $row[$i]["job_title"];

	$eq="";

	$eq.='<a href="view-applications.php?id='.$row[$i][id].'" ><span class="label i-lable label-primary bttn" title="View Applications"><i class="i-font17 ti-eye" title="View Applications"></i></span></a>';
	
	$eq.='<a href="add-jobs.php?id='.$row[$i][id].'" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-pencil"></i></span></a>';

	$eq.='<a class="deleteone" id="'.$row[$i][id].'"><span class="label i-lable label-danger bttn"><i class="i-font17 ti-trash"></i></span></a>';

	$nestedData[] = $eq;
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
