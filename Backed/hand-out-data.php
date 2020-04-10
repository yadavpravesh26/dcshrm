<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name="handouts";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$title = $requestData[title];
$typ = $requestData[tpe];
$catid = implode(',',$catid);
$columns = array(
// datatable column index  => database column name
	0 =>'',
	1 =>'doc_name',
	2 =>'doc_cat',
);
$sql="";
if(!empty($title))
{
$sql .=" AND `doc_name` like '%".$title."%'";
}

$totalData = $totalFiltered = $prop->getName('count(doc_id) AS tot',$table_name,' 1=1 AND  doc_status!=2 AND `doc_type`='.$typ.' '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
$sqlquery = "SELECT doc_id,doc_name,doc_cat,doc_scat,doc_status FROM ".$table_name." WHERE 1=1";

if(!empty($title))
{
$sqlquery .=" AND `doc_name` like '%".$title."%'";
}

/*ORDER BY*/
$sqlquery.=" AND `doc_type`=$typ AND `doc_status`!=2  ORDER BY `doc_id` DESC";
//echo $sql;exit;
$sqlquery.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//echo $sqlquery;exit;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$data = array();
$row=$prop->getAll_Disp($sqlquery);
for($i=0; $i<count($row); $i++)
{  // preparing an array
    $mainCat = $prop->getName('c_name', MAIN_CATEGORY, ' 1=1 AND c_id='.$row[$i]['doc_cat']);
    $subCat = $prop->getName('sc_name', SUB_CATEGORY, ' 1=1 AND c_id='.$row[$i]['doc_scat']);
	$nestedData=array();
	$nestedData[] = $row[$i]["doc_name"];
	//$nestedData[] = $mainCat.' / '.$subCat;

	$eq="";
	$eq.='<a data-toggle="tooltip" data-placement="top" title="Edit" href="action-hand-outs.php?id='.$row[$i][doc_id].'&method=modify" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-pencil"></i></span></a>';		
	$eq.='<a data-toggle="tooltip" data-placement="top" title="'.($row[$i]['doc_status']==0?'Publish':'Unpublish').'" href="javascript:void(0)"><span data-id="'.$row[$i][doc_id].'" data-status="'.($row[$i]['doc_status']==0?1:0).'" class="doc-status label i-lable label-'.($row[$i]['doc_status']==0?'success':'warning').' bttn"><i class="i-font17 ti-'.($row[$i]['doc_status']==0?'unlock':'lock').'"></i></span></a>';
	$eq.='<a class="deleteone" id="'.$row[$i][doc_id].'"><span class="label i-lable label-danger bttn"><i class="i-font17 ti-trash"></i></span></a>';
	
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
