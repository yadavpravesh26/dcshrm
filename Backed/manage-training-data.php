<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name="dynamic_form";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$catid = $requestData[category];
$scatid = $requestData[scategory];
$dat = $requestData[dat];
$columns = array(
// datatable column index  => database column name
	0 =>'',
	1 =>'d_template_name',
	2 =>'sc_name',
	3=> 'd_created_date',
);
if(!empty($catid))
{
$sql .=" AND `cat_id`=".$catid."";
}
if(!empty($scatid))
{
$sql .=" AND `scat_id`=".$scatid."";
}
if(!empty($dat))
{
$sql .=" AND DATE(`d_created_date`)=".date('Y-m-d',strtotime($dat))."";
}

$totalData = $totalFiltered = $prop->getName('count(d_form_id) AS tot',$table_name,' 1=1 AND d_detele_status=0 AND form_type=1 '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
$sql = "SELECT f.`d_form_id`,f.`d_template_name`, f.`d_contat_html`, f.`cat_id`, f.`scat_id`, f.`d_form_status`, f.`d_detele_status`, f.`d_created_date`,sc.sc_name,c.c_name FROM ".$table_name." f left join cat_sub sc ON sc.c_id = f.`scat_id` LEFT JOIN cats c on c.c_id=f.cat_id WHERE form_type=1";

if(!empty($catid))
{
$sql .=" AND f.`cat_id`=".$catid."";
}
if(!empty($scatid))
{
$sql .=" AND f.`scat_id`=".$scatid."";
}
if(!empty($dat))
{
$sql .=" AND DATE(f.`d_created_date`)='".date('Y-m-d',strtotime($dat))."'";
}
/*ORDER BY*/
$sql.=" AND f.`d_detele_status`=0  ORDER BY f.`d_form_id` DESC";
//echo $sql;exit;
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//echo $sql;exit;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
	 {  // preparing an array
	$nestedData=array();
	$userResponse = 	str_replace("–","-",$row[$i]["d_template_name"]);
	//$userResponse = preg_replace("~[^a-zA-Z',.?!\s]~", "", $userResponse);
	//echo $userResponse;
		$nestedData[] = $userResponse;
	$nestedData[] = $row[$i]["sc_name"].",".$row[$i]["c_name"];
$nestedData[] = $row[$i]["d_created_date"];

	$eq="";

	$eq.='<a href="cms/training-editor.php?op=edit-template&id='.$row[$i][d_form_id].'" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-pencil"></i></span></a>';

	$eq.='<a class="deleteone" id="'.$row[$i][d_form_id].'"><span class="label i-lable label-danger bttn"><i class="i-font17 ti-trash"></i></span></a>';

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
