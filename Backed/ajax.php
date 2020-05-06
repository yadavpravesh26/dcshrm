<?php

require_once('../config.php');

require_once(DOC_CONFIG.'inc/pdoconfig.php');

require_once(DOC_CONFIG.'inc/pdoFunctions.php');

$cdb = new DB();

$db = $cdb->getDb();

$prop = new PDOFUNCTION($db);

extract($_REQUEST);

if($meth=="certdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("ec_id" => $rowid);

	$values = array("status" => (1));

	$prop->update(EMPLOYEE_CERTIFICATES, $values, $t_cond);

	   }

}

if($meth=="catdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("category_id" => $rowid);

	$values = array("category_status" => (1));

	$prop->update(CATEGORY, $values, $t_cond);

	   }

}

if($meth=="depdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("dept_id" => $rowid);

	$values = array("dep_status" => (1));

	$prop->update(DEPARTMENT, $values, $t_cond);

	   }

}

if($meth=="catdocdelete"){	 $variable = $_POST["ids"];	  $var=explode(',',$variable);	   foreach($var as $rowid)	   {		   $t_cond = array("category_id" => $rowid);	$values = array("category_status" => (1));	$prop->update(CATEGORY_DOC, $values, $t_cond);	   }}

if($meth=="subcatdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("sub_id" => $rowid);

	$values = array("subcate_status" => (1));

	$prop->update(SUBCATEGORY, $values, $t_cond);

	   }

}

if($meth=="docdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("doc_id" => $rowid);

	$values = array("doc_status" => (1));

	$prop->update("docs", $values, $t_cond);

	   }

}

if($meth=="cdelete")

{



	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $catsql = "SELECT count(*) AS form_count from `dynamic_form` WHERE (`d_form_status`=0 OR `d_detele_status`=0 ) AND scat_id='".$rowid."'";

                              $catfet=$prop->get_Disp($catsql);

			if($catfet['form_count']<=0){

		   $t_cond = array("c_id" => $rowid);

	$values = array("status" => (1));

	$prop->update(SUB_CATEGORY, $values, $t_cond);

	   }

	   else{

		   echo $catfet['form_count'];

	   }

	   }

}

if($meth=="catdelete")

{



	$variable = $_POST["ids"];

	$var=explode(',',$variable);

	foreach($var as $rowid)

	{

		$catsql = "SELECT count(*) AS form_count from `dynamic_form` WHERE (`d_form_status`=0 OR `d_detele_status`=0 ) AND cat_id='".$rowid."'";

        $catfet=$prop->get_Disp($catsql);

		if($catfet['form_count']<=0){

			$t_cond = array("c_id" => $rowid);

			$values = array("status" => (1));

			$prop->update(MAIN_CATEGORY, $values, $t_cond);

		}else{

		   echo $catfet['form_count'];

		}

	}

}

if($meth=="formdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("d_form_id" => $rowid);

	$values = array("d_detele_status" => (1));

	$prop->update("dynamic_form", $values, $t_cond);

	   }

}

if($meth=="catdetaildelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("c_id" => $rowid);

	$values = array("status" => (1));

	$prop->update(CAT_DETAILS, $values, $t_cond);

	   }

}

if($meth=="pagedelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("p_id" => $rowid);

	$values = array("page_status" => (1));

	$prop->update("pages", $values, $t_cond);

	   }

}



if($meth=="companydelete" || $meth=="empdelete")

{

	$variable = $_POST["ids"];

	$var=explode(',',$variable);

	foreach($var as $rowid)

	{

		$t_cond = array("id" => $rowid);

		$values = array("status" => (2)); /* Me changed 1 to 2 */

		$prop->update(USERS, $values, $t_cond);

	}

	setcookie("status", "Success", time()+10);

	setcookie("title", "Employee Deleted Successfully", time()+10);

	setcookie("err", "success", time()+10);

}

if($meth=="admindelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("id" => $rowid);

	$values = array("status" => (1));

	$prop->update("appuser", $values, $t_cond);

	   }

}

if($meth=="certdelete")

{

	 $variable = $_POST["ids"];

	  $var=explode(',',$variable);

	   foreach($var as $rowid)

	   {

		   $t_cond = array("c_id" => $rowid);

	$values = array("c_status" => (1));

	$prop->update(CERTIFICATE_DETAILS, $values, $t_cond);

	   }

}

if($meth=="addnewpro")

{

	 $proname = $_POST["id"];

	 $insdata   = array(

            'category_name'           =>$proname

			);

		$result = $prop->add(CATEGORY_DOC, $insdata);

}





if($meth=="emailexist")

{

	 $variable = $_POST["emailid"];

	  $catsql = "SELECT email from ".USERS." WHERE email ='$variable'";

		$catfet=$prop->getAll_Disp($catsql);

		$countemail = count($catfet);

		if($countemail>0)

		{

			echo "exist";

		}
		

}

if($meth=="companyemailexist")

{

	 $variable = $_POST["emailid"];

	  $catsql = "SELECT email from ".USERS." WHERE email ='$variable'";

		$catfet=$prop->getAll_Disp($catsql);

		$countemail = count($catfet);

		if($countemail>0)

		{

			$status = 1;

		}
		else
		{
			$status = 0;
		}
		echo json_encode(array('status'=>$status)); exit;

}

if($meth=="queryjs")

{

	  $catsql = "SELECT category_id,category_name from ".CATEGORY_DOC."";

		$catfet=$prop->getAll_Disp($catsql);

		$return_arr = array();

		for($i=0; $i<count($catfet); $i++)

					{

$row_array['id'] = $catfet[$i]['category_name'];

$row_array['text'] = $catfet[$i]['category_name'];

array_push($return_arr,$row_array);

}

echo json_encode($return_arr);

}

if($meth=="queryjs1")

{

	  $catsql = "SELECT * from ".CAT_DETAILS." GROUP by cat2";

		$catfet=$prop->getAll_Disp($catsql);

		$return_arr = array();

		for($i=0; $i<count($catfet); $i++)

					{

$row_array['id'] = $catfet[$i]['cat2'];

$row_array['text'] = $catfet[$i]['cat2'];

array_push($return_arr,$row_array);

}

echo json_encode($return_arr);

}

if($meth=="queryjs2")

{

	  $catsql = "SELECT * from ".CAT_DETAILS." GROUP by cat3";

		$catfet=$prop->getAll_Disp($catsql);

		$return_arr = array();

		for($i=0; $i<count($catfet); $i++)

					{

$row_array['id'] = $catfet[$i]['cat3'];

$row_array['text'] = $catfet[$i]['cat3'];

array_push($return_arr,$row_array);

}

echo json_encode($return_arr);

}





/* Me Start It */

if($meth=='company-status')

{

	$id = $_POST["ids"];

	$status = $_POST['status']?0:1;

	$alert = $_POST['status']?'active':'inactive';

	$alert_s = $_POST['status']?'Activated':'Inactivated';

	setcookie("status", 'Error', time()+20);

	setcookie("title", 'Company '.$alert.' failed!', time()+20);

	setcookie("err", "error", time()+20);

	if($id>0){

		$t_cond = array("id" => $id);

		$values = array("status" => $status);

		$s = $prop->update(USERS, $values, $t_cond);

		if($s){

			setcookie("status", "Success", time()+20);

			setcookie("title", $alert_s, time()+20);

			setcookie("err", "success", time()+20);

		}

	}

}

if($meth=='QuizCert')

{

	$id = $_POST["id"];

	$status = $_POST['status'];

	$a_s = 'Error';

	$a_r = 'error';

	$a_m = 'Updated Failed';

	if($id>0){

		$t_cond = array("d_form_id" => $id);

		$values = array("assign_cert" => $status);

		$s = $prop->update(DYNAMIC_FORM, $values, $t_cond);

		if($s){

			$a_s = 'Success';

			$a_r = 'success';

			$a_m = 'Updated Successfully';

		}

	}

	echo json_encode(array('status'=>$a_s,'err'=>$a_r,'msg'=>$a_m)); exit;

}

if($meth=='QuizAss')

{

	$id = $_POST["id"];

	$status = $_POST['status'];

	$a_s = 'Error';

	$a_r = 'error';

	$a_m = 'Updated Failed';

	if($id>0){

		$t_cond = array("id" => $id);

		$values = array("reassign" => $status);

		$s = $prop->update(FORM_FIELDS, $values, $t_cond);

		if($s){

			$a_s = 'Success';

			$a_r = 'success';

			$a_m = 'Updated Successfully';

		}

	}

	echo json_encode(array('status'=>$a_s,'err'=>$a_r,'msg'=>$a_m)); exit;

}

if($meth=='Page-Category')

{

	$id = $_POST["id"];

	$status = 0;

	$hands = $quiz = $trainings = $video = $image = '';

	if($id>0){

		$status = 1;

		$subcatnewvideo	= '';

		$hands		= '<select class="select2 select2-multiple select-handout" id="addhandout" multiple="multiple" data-placeholder="Choose">';

		$quiz		= '<select class="select2 select2-multiple select-quiz" id="addquiz" multiple="multiple" data-placeholder="Choose">';

		$trainings	= '<select class="select2 select2-multiple select-training" id="addtraining" multiple="multiple" data-placeholder="Choose">';

		$video		= '<select class="select2 select2-multiple select-videos" id="addvideos" multiple="multiple" data-placeholder="Choose">';

		$image		= '<select class="select2 select2-multiple select-images" id="addimages" multiple="multiple" data-placeholder="Choose">';

		$sql =  "SELECT * FROM cat_sub WHERE status=0 AND c_id=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$subcatnewvideo = $row[$i][c_id];
			$videocategory_id = $row[$i][c_name];

		}

		

		$sql =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=1 AND doc_status=0 AND doc_scat=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$hands .= '<option value="'.$row[$i][doc_id].'">'.$row[$i][doc_name].'</option>';

		}

		$sql =  "SELECT d_form_id,d_template_name FROM dynamic_form WHERE form_type=0 AND d_detele_status=0 AND scat_id=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$quiz .= '<option value="'.$row[$i][d_form_id].'">'.$row[$i][d_template_name].'</option>';

		}

		$sql =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=2 AND doc_status=0 AND doc_scat=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$trainings .= '<option value="'.$row[$i][doc_id].'">'.$row[$i][doc_name].'</option>';

		}

		$sql =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=3 AND doc_status=0 AND doc_scat=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$video .= '<option value="'.$row[$i][doc_id].'">'.$row[$i][doc_name].'</option>';

		}

		$sql =  "SELECT doc_id,doc_name FROM docs WHERE doc_type=4 AND doc_status=0 AND doc_scat=$id";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)

		{

			$image .= '<option value="'.$row[$i][doc_id].'">'.$row[$i][doc_name].'</option>';

		}

		//$subcatnewvideo .='</select>';

		$hands .='</select>';

		$quiz .='</select>';

		$trainings .='</select>';

		$video	.='</select>'; 

		$image	.'=</select>';

	}

	echo json_encode(array('status'=>$status,'subcatnewvideo'=>$subcatnewvideo,'videocategory_id'=>$videocategory_id,'handout'=>$hands,'quiz'=>$quiz,'trainings'=>$trainings,'video'=>$video,'image'=>$image)); exit;

}

if($meth=='Action-Category')

{

	$id = $_POST["id"];

	$name = rtrim($_POST["name"]);

	$status = 'Error';

	$err = 'error';

	$msg = 'Enter category name';

	$s = 0;

	if($name!=''){

		$msg = 'Category already exits';

		$where = " AND c_name='$name' ";
		
		$newId = '';

		if($id!='' && $id>0 && $id!='undefined')

			$where .=" AND c_id!=$id";

		$count = $prop->getName('COUNT(c_id)', MAIN_CATEGORY, " status=0 $where ");

		if($count===0){

			if($id!='' && $id>0 && $id!='undefined'){

				$msg = 'Updated failed';

				$t_cond = array("c_id" => $id);

				$values = array("c_name" => $name);

				$s = $prop->update(MAIN_CATEGORY, $values, $t_cond);

				if($s){

					$msg = 'Category Updated successfully';

					$err = 'success';

					$status = 'Success';

				}

			}else{

				$msg = 'Added failed';

				$s = $prop->addID(MAIN_CATEGORY, array('c_name'=>$name));

				if($s != ''){

					$msg = 'Category Created Successfully';

					$err = 'success';

					$status = 'Success';
					
					$newId = $s;

				}

			}

		}

	}

	echo json_encode(array('result'=>$s,'status'=>$status,'err'=>$err,'newId'=>$newId,'msg'=>$msg)); exit;

}



if($meth=='Action-SubCategory')

{

	$status = 'Error';

	$err = 'error';

	$msg = 'Enter Sub category name';

	$s = 0;
	
	$newId = '';

	$name = $_POST['scat_name'];

	if($name!=''){

		$msg = 'Subcategory already exits';

		$count = $prop->counts('c_id',SUB_CATEGORY, array('c_name'=>$_POST['category_id'],'sc_name'=>$_POST['scat_name'],'status'=>0));

		if($count===0){

			

				$input = array(

					'c_name'	=>$_POST['category_id'],

					'sc_name'	=>$_POST['scat_name'],

					);

				$result = $prop->addID(SUB_CATEGORY, $input);

				if($result != ''){

					$msg = 'Subcategory Created Successfully';

					$err = 'success';

					$status = 'Success';

					$newId = $result;
					
					$s = 1;

				}

			

		}

	}

	echo json_encode(array('result'=>$s,'status'=>$status,'err'=>$err,'newId'=>$newId,'msg'=>$msg)); exit;

}

if($meth=='get-subCategory')
{
	$id = $_POST["id"];

	$status = 0;
    $subcate = '';
	if($id>0){

		$status = 1;
		$subcate = '<option value="">Select Sub Category</option>';

		$sql =  "SELECT * FROM cat_sub WHERE status=0 AND c_name=$id order by sc_name ASC";

		$row=$prop->getAll_Disp($sql);

		$count = count($row);

		for($i=0; $i<$count; $i++)
		{

			$subcate.= "<option value='".$row[$i][c_id]."'>".$row[$i][sc_name]."</option>";

		}
	}	
	echo json_encode(array('status'=>$status,'subcate'=>$subcate)); exit;
}
?>

