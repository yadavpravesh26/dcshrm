<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name="job_applications";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$job_id = $_REQUEST['job_id'];
$sql = 'select * from '.$table_name.' where job_id='.$job_id.' and status!=2';
$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
	 {  // preparing an array
	$nestedData=array();
	$nestedData[] = $row[$i]["name"];
	$nestedData[] = $row[$i]["email"];
	$nestedData[] = $row[$i]["city"].",".$row[$i]["country"];
	$nestedData[] = $row[$i]["phone"];
	
	$old_name = "../images/docs/".$row[$i]['resume'] ;
	$extension = end(explode('.',strtolower($old_name)));
	$new_name = "../images/docs/".$row[$i][name]." resume.".$extension ;
	rename( $old_name, $new_name);

	$eq="";

	$eq.='<a href="'.$new_name.'" ><span class="label i-lable label-primary bttn" title="View Applications"><i class="i-font17 ti-download" title="Download Resume"></i></span></a>';
	
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
