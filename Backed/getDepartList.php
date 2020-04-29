<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
if(isset($_POST['company_id']) and $_POST['company_id'] != '')
{
	$company_id = $_POST['company_id'];
	$where_dep = ' where dep_status != 2 and company_id='.$company_id;
	$listDepart = $prop->getAll('*',DEPARTMENT_NEW, $where_dep, '', 0, 0);
	$departmentIDs='';
	for($i=0; $i < count($listDepart); $i++){ 
		echo "<option value='".$listDepart[$i]['dept_id']."'>".$listDepart[$i]['dep_name']."</option>";
	}
}
?>