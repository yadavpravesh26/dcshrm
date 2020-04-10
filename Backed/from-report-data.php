<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');

$requestData= $_REQUEST;

$formname = $requestData['formname'];
$datec = $requestData['datec'];
$where = ' AND u.u_id='.$session['bid'];
if($session['b_type']===0)
	$where = '';
$sqls = "SELECT COUNT(f.id) as count FROM `".FORM_FIELDS."` f INNER JOIN `".DYNAMIC_FORM."` d ON d.d_form_id=f.form_id INNER JOIN `".USERS."` u ON f.created_by=u.id WHERE u.status!=2 AND f.`is_deleted`=0 $where";
/* $sql_c = 'SELECT COUNT(d.id) as count FROM `'.FORM_FIELDS.'` f JOIN `'.DYNAMIC_FORM.'` d ON d.d_form_id=f.form_id WHERE 1=1 AND f.is_deleted=0 '; */
if(!empty($formname))
{
$sqls.=" AND  d.`d_template_name` LIKE '%".$formname."%'";
}
if(!empty($datec))
{
$sqls .=" AND  DATE(f.`created_date`) ='".date('Y-m-d',strtotime($datec))."'";
}

$sqls.=" ORDER BY f.`id` DESC";

$rows=$prop->get_Disp($sqls);
$totalData = $totalFiltered = $rows['count'];

$sql = "SELECT f.id,d.d_template_name,f.form_id,u.name,f.created_date,f.reassign FROM `".FORM_FIELDS."` f INNER JOIN `".DYNAMIC_FORM."` d ON d.d_form_id=f.form_id INNER JOIN `".USERS."` u ON f.created_by=u.id WHERE u.status!=2 AND f.`is_deleted`=0 $where";

if(!empty($formname))
{
$sql.=" AND  d.`d_template_name` LIKE '%".$formname."%'";
}
if(!empty($datec))
{
$sql .=" AND  DATE(f.`created_date`) ='".date('Y-m-d',strtotime($datec))."'";
}

$sql.=" ORDER BY f.`id` DESC";

$sql.= "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$data = array();
if($totalData>0){
	$row=$prop->getAll_Disp($sql);
	for($i=0; $i<count($row); $i++)
	{  
			$nestedData=array();
			$nestedData[] = $row[$i]["d_template_name"];
			$nestedData[] = $row[$i]["name"];
			$nestedData[] = date('d/M/Y',strtotime($row[$i]['created_date']));
			$eq="";

		//$eq.='<a href="form-page.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'" class="btn-rounded btn-primary btn-outline m-r-10 v-btn" data-toggle="tooltip" data-original-title="Edit"> <i class="icon-pencil"></i></a>';

		$eq.='<a href="pdf/formpdprint.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'&type=I&method=frm" target="_blank" class="btn-rounded btn-primary btn-outline m-r-10 v-btn" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="icon-eye"></i></a>';

		$eq.='<a href="pdf/form_pdf_print.php?id='.$row[$i]['form_id'].'&row_id='.$row[$i]['id'].'&type=D&method=frm" target="_blank" class="btn-rounded btn-success btn-outline v-btn" data-toggle="tooltip" data-placement="top" title="Download"> <i class="icon-cloud-download"></i> </a>';
		
		$eq.='<a data-toggle="tooltip" data-placement="top" title="'.($row[$i]['reassign']?'Assign':'UnAssign').'" href="javascript:void(0)" data-ass="'.($row[$i]['reassign']?'0':'1').'" data-id="'.$row[$i]['id'].'" class="btn-rounded btn-'.($row[$i]['reassign']?'info':'warning').' btn-outline v-btn reassignQuiz"> <i class="'.($row[$i]['reassign']?'ti-unlock':'ti-lock').'"></i></a>';
		$nestedData[] = $eq;
		$data[] = $nestedData;
	}
}
$json_data = array(
			'draw'            => intval( $requestData['draw'] ),
			'recordsTotal'    => intval( $totalData ),
			'recordsFiltered' => intval( $totalFiltered ),
			'data'            => $data
			);

echo json_encode($json_data);

?>
