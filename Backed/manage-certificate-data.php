<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name=CERTIFICATE_DETAILS;
/* Database connection end */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$catid = $requestData[category];
$typ = $requestData[tpe];

$columns = array(
// datatable column index  => database column name
	0 =>'',
	1 =>'c_title',
	2 =>'c_subtitle',
);

if($session['b_type']===0){
	$totalData = $totalFiltered = $prop->getName('count(c_id) AS tot',$table_name,' 1=1 AND c_status!=2 '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
	$sql = "SELECT * FROM ".$table_name." WHERE 1=1 ";
}else{
	$totalData = $totalFiltered = $prop->getName('count(c_id) AS tot',$table_name,' 1=1 AND u_id='.$session['bid'].' AND c_status=0 '.$sql); // when there is no search parameter then total number rows = total number filtered rows.
	$sql = "SELECT * FROM ".$table_name." WHERE 1=1 AND u_id=".$session['bid'];
}

/*ORDER BY*/
$sql.=" AND `c_status`!=2  ORDER BY `c_id` DESC";
//echo $sql;exit;
$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$data = array();
$row=$prop->getAll_Disp($sql);
for($i=0; $i<count($row); $i++)
	 {  // preparing an array

	$nestedData=array();
		$nestedData[] = $row[$i]["c_title"];
	$nestedData[] = $row[$i]["c_subtitle"];

	$eq="";
  if($row[$i]["c_logo_type"]==1)
  {
    $page = "pdnew.php";
    $ctype = "pdf1.png";
  }
  elseif ($row[$i]["c_logo_type"]==2) {
      $page = "pdnew1.php";
			$ctype = "pdf2.png";
  }
  elseif ($row[$i]["c_logo_type"]==4) {
      $page = "pdnew3.php";
			$ctype = "pdf4.png";
  }
  else {
    $page = "pdnew4.php";
		$ctype = "pdf3.png";
  }
/*$eq.='<a href="pdf/'.$page.'?id='.$row[$i][c_id].'" target="_blank" ><span class="label i-lable label-primary bttn"><i class="i-font17 ti-eye"></i></span></a>&nbsp;';*/


	$eq.='<a href="certificate-page.php?id='.$row[$i][c_id].'&method=modify" ><span class="label i-lable label-primary bttn" data-toggle="tooltip" data-original-title="Edit" title="Edit"><i class="i-font17 ti-pencil"></i></span></a>&nbsp;';

	//$eq.='<a class="deleteone" id="'.$row[$i][c_id].'"><span class="label i-lable label-danger bttn" data-toggle="tooltip" data-original-title="Delete"><i class="i-font17 ti-trash" title="Delete"></i></span></a>&nbsp;';

	$eq.='<a id="'.$row[$i][c_id].'"><span data-id="'.$row[$i][c_id].'" data-status="'.($row[$i]['c_status']==0?1:0).'" class="certificate-status label i-lable label-'.($row[$i]['c_status']==0?'success':'warning').' bttn" data-toggle="tooltip" data-original-title="Generate" title="Generate"><i class="i-font17 ti-'.($row[$i]['c_status']==0?'unlock':'lock').'"></i></span></a>';
	
	$eq.='<a class="generate" id="'.$row[$i][c_id].'"><span class="label i-lable label-danger bttn" data-toggle="tooltip" data-original-title="Generate" title="Generate"><i class="i-font17 ti-reload"></i></span></a>';

$nestedData[] = '<img src="img/'.$ctype.'" height="100">';

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
