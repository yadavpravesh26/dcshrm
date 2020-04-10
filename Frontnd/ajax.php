<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
extract($_POST);
$com_id = $_SESSION['US']['user_id'] ;
if(isset($_REQUEST['tab']) && $_REQUEST['tab']=='New-Site-Menu'){
	$row=$prop->getAll_Disp('SELECT c_id,c_name as name from `'.MAIN_CATEGORY.'` WHERE status=0 ');
	$count = count($row);
	$option = '';
	for($i=0;$i<$count;$i++){
		$option .= '<li><a href="#">'.$row[$i]['name'].'</a></li>';
	}
	echo $option; exit;
}
if($math=='passupdate'){
	if($com_id!=''){
		$t_cond = array("r_id" => $com_id);
	$insdatalog   = array(
             'admin_pass'           =>crypt($_REQUEST['newpass']),
			 'enc_pass'				=>$_REQUEST['newpass']
			);
		if($prop->update(REGISTER, $insdatalog, $t_cond))
		{
			echo "Updated Successfully";
		}
	}
}
if($math=='comupdate'){
	$com_id=$_REQUEST['com_id'];
	$com_name=$_REQUEST['com_name'];
	$ad_name=$_REQUEST['ad_name'];
	$com_mail=$_REQUEST['com_mail'];
	if($com_id!=''){
		$t_cond = array("r_id" => $com_id);
	$insdatalog   = array(
             'company_name'           =>$com_name,
             'admin_name'           =>$ad_name,
            'admin_email'           =>$com_mail
			);
		if($prop->update(REGISTER, $insdatalog, $t_cond))
		{
			echo "Updated Successfully";
		}
	}
}
if($meth=='Formdelete'){
	$variable = $_POST["ids"];
	$var=explode(',',$variable);
	foreach($var as $rowid)
	{
		$t_cond = array("id" => $rowid);
		$values = array("is_deleted" => (1));
		$prop->update("form_fields", $values, $t_cond);
	}
}
if($meth=="subcatlist")
{
	 $variable = $_POST["catid"];
	 $catsql = "SELECT  s.`sub_id`,s.`subcate_name`,s.`subcate_status`,c.`category_name` from ".SUBCATEGORY." s LEFT JOIN ".CATEGORY." c ON c.category_id=s.category_id WHERE s.category_id='$variable' AND s.`subcate_status`!='1' order by s.`subcate_name` ASC";
		$catfet=$prop->getAll_Disp($catsql);
		echo '<option value="">Select Category</option>';
		for($i=0; $i<count($catfet); $i++)
					{
				echo '<option value="'.$catfet[$i]['sub_id'].'">'.$catfet[$i]['subcate_name'].'</option>';
	   }
}
else
{
	extract($_REQUEST);
	 $catsql = "SELECT * from dynamic_form WHERE d_template_name LIKE '$q%' AND d_detele_status=0";
		$catfet=$prop->getAll_Disp($catsql);
		$return_arr = array();
		for($i=0; $i<count($catfet); $i++)
					{
$row_array['id'] = $catfet[$i]['d_form_id'];
$row_array['name'] = $catfet[$i]['d_template_name'];
$row_array['doclink'] = "form-page.php";
$row_array['logo'] = "img/notepad12.png";
$row_array['domain'] = "Form";
array_push($return_arr,$row_array);
}
$return_arrs = array();
 $catsqls = "SELECT * from docs WHERE doc_name LIKE '$q%' AND doc_status=0";
		$catfets=$prop->getAll_Disp($catsqls);
		$return_arrs = array();
		for($id=0; $id<count($catfets); $id++)
					{
$row_arrays['id'] = base64_encode($catfets[$id]['doc_id']);
$row_arrays['name'] = $catfets[$id]['doc_name'];
$row_arrays['doclink'] = "document-page.php";
$row_arrays['logo'] = "img/doc.png";
$row_arrays['domain'] = "Document";
array_push($return_arrs,$row_arrays);
}
//echo json_encode($return_arrs);
echo json_encode(array_merge($return_arr,$return_arrs));
}
?>
