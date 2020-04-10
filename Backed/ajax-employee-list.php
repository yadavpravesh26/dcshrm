<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$requestData= $_REQUEST;
$t_where = $s_where = '';
if(isset($_REQUEST['s'])){
	if($_REQUEST['s']=='active'){
		$t_where = ' AND status=0 ';
		$s_where = ' AND e.status=0 ';
	}
	if($_REQUEST['s']=='inactive'){
		$t_where = ' AND status=1 ';
		$s_where = ' AND e.status=1 ';
	}
}
if($session['b_type']===0){
$totalData = $totalFiltered = $prop->getName('count(id) AS tot',USERS,' 1=1 AND department_id!=0 AND status!=2 AND u_type=4 '.$t_where);
$sql = "SELECT e.id,e.name,e.email,e.contact_no,d.dep_name FROM ".USERS." e INNER JOIN ".DEPARTMENT_NEW." d ON d.dept_id = e.department_id WHERE e.status!=2 AND e.u_type=4 $s_where";
}else{
$totalData = $totalFiltered = $prop->getName('count(id) AS tot',USERS,' 1=1 AND department_id!=0 AND status!=2 AND u_type=4 AND u_id='.$session['bid'].$t_where);
$sql = "SELECT e.id,e.name,e.email,e.contact_no,d.dep_name FROM ".USERS." e INNER JOIN ".DEPARTMENT_NEW." d ON d.dept_id = e.department_id WHERE e.status!=2 AND e.u_type=4 $s_where AND e.u_id=".$session['bid'];
}

if( !empty($requestData['search']['value']) ) {  
    $sql.=" AND ( e.name  LIKE '".$requestData['search']['value']."%' OR e.email  LIKE '".$requestData['search']['value']."%' OR e.contact_no LIKE '".$requestData['search']['value']."%' OR d.dep_name LIKE '".$requestData['search']['value']."%' )";
}
/*ORDER BY*/
$sql.=" ORDER BY e.id DESC LIMIT ".$requestData['start']." ,".$requestData['length'];

$data = array();

$row=$prop->getAll_Disp($sql);
$count = count($row);
for($i=0; $i<$count; $i++)
{
	$nestedData =array();
    $nestedData[] = ucfirst($row[$i]['name']);
    $nestedData[] = $row[$i]['email'];
    $nestedData[] = $row[$i]['contact_no'];
    $nestedData[] = ucfirst($row[$i]['dep_name']);
    $eq = '<a data-toggle="tooltip" data-placement="top" title="Edit" href="add-employee.php?id='.$row[$i]['id'].'&method=modify"><span class="label i-lable label-primary"><i class="i-font17 ti-pencil"></i></span></a>';
	//$eq .= '<a data-toggle="tooltip" data-placement="top" title="Edit Permission Category" href="employee-assign-category.php?id='.$row[$i]['id'].'&method=modify"><span class="label i-lable label-warning"><i class="i-font17 ti-pencil"></i></span></a>';
    $eq .='<a class="deleteone" id="'.$row[$i]['id'].'" href="javascript:void(0);"><span id="sa-delete" class="label i-lable label-danger "><i class="i-font17 ti-trash"></i></span></a>';
    $nestedData[] =$eq;
	$data[] = $nestedData;
}
$json_data = array(
    'draw'				=> intval( $requestData['draw'] ),
    'recordsTotal'		=> intval( $totalData ),
    'recordsFiltered'	=> intval( $totalFiltered ),
    'data'				=> $data,
	'sql'				=> $sql
);
echo json_encode($json_data);exit;
?>
