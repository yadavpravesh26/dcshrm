<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
if(isset($_REQUEST['method']) && $_REQUEST['method']!='')
{
	$method = $_REQUEST['method'];
	$id=$_REQUEST['id'];
	$row = array();
	switch($method)
	{
		case 'category':
			if($id!='' && $id>0)
			$row = $prop->getAll_Disp('SELECT c_id as id,sc_name as name FROM `'.SUB_CATEGORY.'` WHERE status=0 AND c_name='.$id);
	}
	echo json_encode($row); exit;
}


?>
