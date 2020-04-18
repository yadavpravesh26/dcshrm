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

$curr_Catval = $prop->get('c_name','cat_sub', array("c_id"=>$currSubCatID ,'status'=>0));
$currCatID = $curr_Catval['c_name'];

if(isset($_POST['keyword']) and $_POST['keyword'] != '')
$keySearch = ' and dep_name like "%'.$_POST['keyword'].'%"';

$where_dep = ' where dep_status != 2' .$keySearch. ' and company_id='.$session['bid'];
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
	echo '<div class="col-md-4">';
	for($i=0; $i<$count; $i++){
		$checked = 'data-val'; 
		$departID = $listDepart[$i]['dept_id'];
		
		if (in_array($departID, $alreadyAssigned)) {
		$checked = 'checked';
		}	
		$depName = $prop->getName('dep_name', DEPARTMENT_NEW, "dept_id=".$depID);
		$empCount = $prop->getName('count(id)', USERS, "status!=2 AND department_id='".$departID."' and u_id='".$session['bid']."'");
		if( ($i+1)%4 == 0)
		echo '</div><div class="col-md-4">';
		
		echo '<div class="checkbox checkbox-success">
			<input id="depart-'.$listDepart[$i]['dept_id'].'" data-class="checkbox-all" data-id="'.$listDepart[$i]['dept_id'].'" class="category" name="department[]" onClick="assignDepart(this,'.$currCatID.','.$currSubCatID.','.$listDepart[$i]['dept_id'].')" value="'.$listDepart[$i]['dept_id'].'" type="checkbox" '.$checked.'>
			<label class="category-label" for="depart-'.$listDepart[$i]['dept_id'].'"><b>'. $listDepart[$i]['dep_name'] .'('.$empCount.')</b></label>
		</div>';
	}
	echo '</div>';
	?>
    <div class="clearfix"></div>
<?php
}else
{
	echo 'No records found';
}
?>    