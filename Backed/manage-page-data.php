<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name=PAGES;
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$catid = $requestData[category];
$search = $requestData[search];


$columns = array(
// datatable column index  => database column name
	0 =>'',
	1 =>'title',
	2 =>'category',
);
/*if($catid>0)
{
$sql .=" AND `category` =".$catid."";
}*/
if($catid>0)
{
$sql .=" AND `category` =".$catid."";
}
if(!empty($search))
{
$sql .=" AND `title` like ".$search."%";
}

$totalData = $totalFiltered = $prop->getName('count(p_id) AS tot',PAGES,' 1=1 AND page_status!=2 '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
$sql = "SELECT p_id,title,page_status,category FROM ".PAGES." WHERE 1=1";
/*
if(!empty($catid>0))
{
$sql .=" AND `category` =".$catid."";
}*/
if($catid>0)
{
$sql .=" AND `category` =".$catid."";
}
if(!empty($search))
{
$sql .=" AND `title` LIKE '$search%'";
}

/*ORDER BY*/
$sql.=" AND `page_status`!=2  ORDER BY `p_id` DESC";
//echo $sql;exit;
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//echo $sql;exit;
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
{  	$subCat = $prop->getName('sc_name', SUB_CATEGORY, ' 1=1 AND c_id='.$row[$i][category]);
	$nestedData=array();
	$nestedData[] = $row[$i]["title"];
	if($subCat === false)
	$nestedData[] = '';
	else
	$nestedData[] = $subCat;

	$eq="";

	$eq.='<a data-toggle="tooltip" data-placement="top" title="Edit" href="page-builder.php?id='.$row[$i][p_id].'&method=modify" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-pencil"></i></span></a>';

	 $eq.='<a class="deleteone" id="'.$row[$i][p_id].'" data-status="'.($row[$i]['page_status']==0?2:0).'"><span class="label i-lable label-danger bttn"><i class="i-font17 ti-trash"></i></span></a>';
	
	$eq.='<a data-toggle="tooltip" data-placement="top" title="'.($row[$i]['page_status']==0?'Publish':'Unpublish').'" class="page-status" data-id="'.$row[$i][p_id].'" data-status="'.($row[$i]['page_status']==0?1:0).'"><span class="label i-lable label-'.($row[$i]['page_status']==0?'success':'warning').' bttn"><i class="i-font17 ti-'.($row[$i]['page_status']==0?'unlock':'lock').'"></i></span></a>';
	
	$eq.='<a data-toggle="tooltip" data-placement="top" title="Duplicate" class="page-copy" data-id="'.$row[$i][p_id].'" ><span class="label i-lable label-info bttn"><i class="fa i-font17 fa-copy"></span></a>';

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
