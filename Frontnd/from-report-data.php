<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$com_id = $_SESSION['US']['user_id'] ;
$table_name="form_fields";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;

$formname = $requestData[formname];
$datec = $requestData[datec];

$columns = array(
// datatable column index  => database column name
	0 =>'',
	1 =>'d_template_name',
	2 => 'created_date',
);
$sqls = "SELECT * FROM `form_fields` f JOIN dynamic_form d ON d.d_form_id=f.form_id  WHERE 1=1 AND f.`created_by`='$com_id' AND f.`is_deleted`=0";

if(!empty($formname))
{
$sqls.=" AND  d.`d_template_name` LIKE '".$formname."%'";
}
if(!empty($datec))
{
$sqls .=" AND  DATE(f.`created_date`) ='".date('Y-m-d',strtotime($datec))."'";
}

/*ORDER BY*/
$sqls.=" ORDER BY f.`id` DESC";

$rows=$prop->getAll_Disp($sqls);
//$totalData = $totalFiltered = $prop->getName('count(id) AS tot',$table_name,' 1=1 AND created_by='.$com_id.' AND is_deleted	=0 '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
$totalData = $totalFiltered = count($rows);

$sql = "SELECT * FROM `form_fields` f JOIN dynamic_form d ON d.d_form_id=f.form_id  WHERE 1=1 AND f.`created_by`='$com_id' AND f.`is_deleted`=0";

if(!empty($formname))
{
$sql.=" AND  d.`d_template_name` LIKE '".$formname."%'";
}
if(!empty($datec))
{
$sql .=" AND  DATE(f.`created_date`) ='".date('Y-m-d',strtotime($datec))."'";
}

/*ORDER BY*/
$sql.=" ORDER BY f.`id` DESC";
//echo $sql;
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//echo $sql;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
	 {  // preparing an array
	$nestedData=array();
	$nestedData[] = $row[$i]["d_template_name"];
	$nestedData[] = date('d-m-Y',strtotime($row[$i]['created_date']));
	$eq="";

	$eq.='<a href="form-page.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'" class="btn-rounded btn-primary btn-outline m-r-10 v-btn" data-toggle="tooltip" data-original-title="Edit"> <i class="icon-pencil"></i></a>';

	$eq.='<a href="pdf/formpdprint.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'&type=I&method=frm" target="_blank" class="btn-rounded btn-primary btn-outline m-r-10 v-btn" data-toggle="tooltip" data-original-title="Edit"> <i class="icon-eye"></i></a>';

	$eq.='<a href="pdf/form_pdf_print.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'&type=D&method=frm" target="_blank" class="btn-rounded btn-success btn-outline v-btn" data-toggle="tooltip" data-original-title="Delete"> <i class="icon-cloud-download"></i> </a>';
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
