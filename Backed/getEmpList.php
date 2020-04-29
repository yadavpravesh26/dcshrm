<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
if(isset($_POST['depIds']) and $_POST['depIds'] != '')
{
	$depIds = $_POST['depIds'];
	$where_dep = ' where status != 2 and department_id IN ('.$depIds.')';
	$listEMP = $prop->getAll('*',USERS, $where_dep, '', 0, 0);
	$empIDs='';
	for($i=0; $i < count($listEMP); $i++){ 
		echo "<option value='".$listEMP[$i]['id']."'>".$listEMP[$i]['name']."</option>";
	}
}
?>