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
	$depIds = explode(',',$depIds);
	for($k = 0; $k < count($depIds); $k++)
	{
		$depId = $depIds[$k];
		$depName = $prop->getName('dep_name', 'department', "dept_id=".$depId );
		$where_dep = ' where status != 2 and department_id ='.$depId.' order by name ASC';
		$listEMP = $prop->getAll('*',USERS, $where_dep, '', 0, 0);
		$empIDs='';
		if(count($listEMP)>0)
		{
			echo '<optgroup label="'.$depName.'">';
			for($i=0; $i < count($listEMP); $i++){ 
				echo "<option value='".$listEMP[$i]['id']."'>".$listEMP[$i]['name']."</option>";
			}
			echo '</optgroup>';
		}	
	}	
}
?>