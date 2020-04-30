<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
$keySearch = '';
$curr_subCatval = $prop->get('category',PAGES, array("p_id"=>$_POST['programID'],'page_status'=>0));
$currSubCatID = $curr_subCatval['category'];
$programID = $_POST['programID'];
$companyID = $_POST['companyID'];

$curr_Catval = $prop->get('c_name','cat_sub', array("c_id"=>$currSubCatID ,'status'=>0));
$currCatID = $curr_Catval['c_name'];

if(isset($_POST['keyword']) and $_POST['keyword'] != '')
$keySearch = ' and dep_name like "%'.$_POST['keyword'].'%"';

$where_dep = ' where dep_status != 2' .$keySearch. ' and company_id='.$companyID.' order by dep_name ASC';
$listDepart = $prop->getAll('*',DEPARTMENT_NEW, $where_dep, '', 0, 0);

$where_assign = ' where catID = '.$currCatID.' and subCatID = '.$currSubCatID.' and programID = '.$programID.' and status = 0';
$assignDepart = $prop->getAll('depart_id','assign_depart', $where_assign, '', 0, 0);
$alreadyAssigned = array();
for($j = 0; $j<count($assignDepart); $j++)
$alreadyAssigned[$j] = $assignDepart[$j]['depart_id'];

//var_dump($alreadyAssigned);
$count = count($listDepart);
if($count > 0)
{
	for($i=0; $i<$count; $i++){
		$checked = 'data-val'; 
		$departID = $listDepart[$i]['dept_id'];
		
		if (in_array($departID, $alreadyAssigned)) {
		$checked = 'checked';
		}
			
		$depName = $prop->getName('dep_name', DEPARTMENT_NEW, "dept_id=".$depID);
		//$empCount = $prop->getName('count(DISTINCT id)', USERS, "status!=2 AND department_id='".$departID."' and u_id='".$companyID."'");
		$empSql = 'select GROUP_CONCAT( DISTINCT id ORDER BY id SEPARATOR ",") as empIDs from '.USERS.' where status!=2 AND department_id='.$departID.' and u_id='.$companyID;
		//echo $empSql;
		$row_EmpCount = $prop->get_Disp($empSql);
		$empGET = $row_EmpCount['empIDs'];
		//echo $empGET; 
		$empIDs = explode(',',$empGET);
		$empCount = 0;
		if($empIDs[0]!='')
		{
			foreach($empIDs as $empID)
			{
				$countEmp = $prop->getName('count(depart_id)', 'assign_depart', " depart_id='".$empID."'");
				if($countEmp===0)
				$empCount++;
				
			}
		}
		//$programCount = $prop->getName('count(programID)', 'assign_depart', "status!=2 AND depart_id=".$departID);
		echo '<div class="col-md-3"><div class="checkbox checkbox-success">
			<input id="depart-'.$listDepart[$i]['dept_id'].'" data-class="checkbox-all" data-id="'.$listDepart[$i]['dept_id'].'" class="category" name="department[]" onClick="assignDepart(this,'.$currCatID.','.$currSubCatID.','.$listDepart[$i]['dept_id'].')" value="'.$listDepart[$i]['dept_id'].'" type="checkbox" '.$checked.'>
			<label class="category-label" for="depart-'.$listDepart[$i]['dept_id'].'"><b>'. $listDepart[$i]['dep_name'] .' ('.$empCount.')</b></label>
		</div></div>';
	}
	?>
    <div class="clearfix"></div>
<?php
}else
{
	echo 'No records found';
}
?>    