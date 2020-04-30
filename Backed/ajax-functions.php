<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
extract($_REQUEST);
$meth = (isset($_REQUEST['meth'])?$_REQUEST['meth']:'');
if($meth=="ajaxsaveVideo")
{
		$table_name = "docs";
		$insdata = array(
					'doc_cat'		=>$_POST['cat_id'],
					'doc_scat'		=>$_POST['subcat_id'],
					'doc_name'		=>$_POST['video_title'],
					'doc_file'		=>$_POST['video_url'],
					'doc_type'		=>3
			);
		$msg = 'Video Creation Error';
		$lastId = $prop->addID($table_name, $insdata);
		
		if ($lastId != 0) {
			$msg = 'Video Creation Success';
			echo json_encode(array('lastId'=>$lastId,'videoTitle'=>$_POST['video_title'],'err'=>0,'msg'=>$msg)); exit;
			
		}else{
			echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
        }
}
if($meth=="ajaxsaveHand")
{
	$table_name = "handouts";
	$insdata = array(
					//'doc_cat'		=>$_POST['catId'],
					//'doc_scat'		=>$_POST['subCatID'],
					'doc_name'		=>$_POST['document_name'],
					'doc_type'		=>1,
					
			);
		$result = 1;
		$msg = 'Programs Creation Error';
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=''){
			$result = 0;
			$allowedExtensions = array('doc', 'docx', 'pdf', 'docx');
			
			
			$extension = end(explode('.',strtolower($_FILES['file']['name'])));
			$msg = 'File invalid format';
			if(in_array($extension, $allowedExtensions)){
				$doc_file = rand(10,100).time().'.'.$extension;
				if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/docs/'.$doc_file)) {
					$insdata['doc_file'] = $doc_file;
					$result = 1;
				}else{
					$msg = 'File not upload';
				}
			}
		}
		if($result)
		$lastId = $prop->addID($table_name, $insdata);
		
		if ($lastId == 0)
		$msg = 'Programs Creation Faild';
		
        if ($lastId != 0) {
			$msg = 'Programs Creation Success';
			echo json_encode(array('lastId'=>$lastId,'handTitle'=>$_POST['document_name'],'err'=>0,'msg'=>$msg)); exit;
		}
	    else{
			echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
		}
}

if($meth=="ajaxsaveQuiz")
{
	$table_name = "dynamic_form";
	$insdata = array(
					'cat_id'		=>$_POST['catId'],
					'scat_id'		=>$_POST['subCatID'],
					'd_template_name'		=>$_POST['quiz_name'],
					'quiz_url'		=>$_POST['quiz_url'],
					'form_type'		=>0,
					
			);
		
		$msg = 'Quiz Creation Error';
		$lastId = $prop->addID($table_name, $insdata);
		
		if ($lastId == 0)
		$msg = 'Quiz Creation Faild';
		
        if ($lastId != 0) {
			$msg = 'Quiz Creation Success';
			echo json_encode(array('lastId'=>$lastId,'quizTitle'=>$_POST['quiz_name'],'err'=>0,'msg'=>$msg)); exit;
		}
	    else{
			echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
		}
	
}


if($meth=="ajaxsaveCheckList")
{
	$table_name = "docs";
	$insdata = array(
					'doc_cat'		=>$_POST['catId'],
					'doc_scat'		=>$_POST['subCatID'],
					'doc_name'		=>$_POST['checklist_name'],
					'doc_file'		=>$_POST['checklist_url'],
					'doc_type'		=>4,
					
			);
		
		$msg = 'Checklist Creation Error';
		$lastId = $prop->addID($table_name, $insdata);
		
		if ($lastId == 0)
		$msg = 'Checklist Creation Faild';
		
        if ($lastId != 0) {
			$msg = 'Checklist Creation Success';
			echo json_encode(array('lastId'=>$lastId,'checkListTitle'=>$_POST['checklist_name'],'err'=>0,'msg'=>$msg)); exit;
		}
	    else{
			echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
		}
	
}


if($meth=="get-training-data")
{
	$table_name = "docs";
	$curr_val = $prop->get('*',$table_name, array("doc_id"=>$_REQUEST['training_id'],'doc_type'=>2));
	if(!empty($curr_val)){
		$msg = 'Training Getting Success';
		$data = $curr_val['doc_content'];
		echo json_encode(array('data'=>$data,'err'=>0,'msg'=>$msg)); exit;
	}
	else
	{
		$msg = 'Training Getting Faild';
		echo json_encode(array('err'=>1,'msg'=>$msg)); exit;
	}	
}
if($meth=="auto-save-draft")
{
	$table_name = 'pages';
	
	if($_REQUEST['draft_id'] == '')
	{
	
		$dir = "uploads/catdetails/";

		$thumb = $dir."thumb/";

		$fthumb = $dir."fthumb/";

		$regular = $dir."regular/";

		if(!is_dir($dir) || !is_dir($thumb) || !is_dir($fthumb)){



			mkdir($dir,0755,true);

			mkdir($thumb,0755,true);

			mkdir($regular,0755,true);

			mkdir($fthumb,0755,true);

		}



		$imagetype = explode('.',basename($_FILES['image']['name']));

		if(!empty($imagetype)){

			$imagename = time().".".end($imagetype);

			move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename);



		}else{

			$imagename = "";

		}

		if($_POST['training']!="")

		{

		$training  = implode(",",$_POST['training']);

		}

		else {

			$training  = "emp";

		}

		if($_POST['quiz']!="")

		{

		$quiz  = implode(",",$_POST['quiz']);

		}

		else {

			$quiz  = "emp";

		}

		if($_POST['images']!="")

		{

		$images = implode(",",$_POST['images']);

		}

		else {

			$images  = "emp";

		}

		if($_POST['videos']!="")

		{

		$videos = implode(",",$_POST['videos']);

		}

		else {

			$videos  = "emp";

		}

		if($_POST['handout']!="")

		{

		$handout = implode(",",$_POST['handout']);

		}

		else {

			$handout  = "emp";

		}



$insdata   = array(

		'title'         =>$_POST['title'],

		'meta_title'         =>$_POST['mtitle'],

		'meta_desc'         =>$_POST['mdesctt'],

		'ban_title'     =>$_POST['btitle'] ,

		'ban_sub_title'       =>$_POST['btitle'],

		'ban_image'         =>$imagename,

		'ban_alt_title'         =>$_POST['balttitle'],

		'descript'         =>$_POST['desc'],

		'trainings'		=>$training,

		'quiz'			=>$quiz,

		'images'		=>$images,

		'videos'		=> $videos,

		'handout'		=>$handout,

		'category' => $_POST['cat1'],
		
		'page_status' => 1

		);



	$lastId = $prop->addID($table_name, $insdata);

	$msg = 'Besafe Program Successfully save as Draft';
	echo json_encode(array('err'=>1,'msg'=>$msg,'LastID'=>$lastId)); exit;
	
	}
	else
	{
		
	   $dir = "uploads/catdetails/";

		$iname = $_REQUEST['oldimg'];

		if($iname =='')

		{

			$iname1 = time();

		}else{

			$ext = explode(".",$iname);

			$iname1 = $ext[0];

		}

		if(!is_dir($dir)){

			mkdir($dir,0777,true);

		}



		$chkimg = basename($_FILES['image']['name']);

		if($chkimg != ''){

			$extn = explode(".",$chkimg);

			$imagename = $iname1.".".end($extn);

			move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imagename);



			}

			else{

				$imagename = $iname;

			}



	$t_cond = array("p_id" => $_REQUEST['draft_id']);



	if($_POST['training']!="")

		{

		$training  = implode(",",$_POST['training']);

		}

		else {

			$training  = "emp";

		}

		if($_POST['quiz']!="")

		{

		$quiz  = implode(",",$_POST['quiz']);

		}

		else {

			$quiz  = "emp";

		}

		if($_POST['images']!="")

		{

		$images = implode(",",$_POST['images']);

		}

		else {

			$images  = "emp";

		}

		if($_POST['videos']!="")

		{

		$videos = implode(",",$_POST['videos']);

		}

		else {

			$videos  = "emp";

		}

		if($_POST['handout']!="")

		{

		$handout = implode(",",$_POST['handout']);

		}

		else {

			$handout  = "emp";

		}



	$value   = array(

		'title'         =>$_POST['title'],

		'meta_title'         =>$_POST['mtitle'],

		'meta_desc'         =>$_POST['mdesctt'],

		'ban_title'     =>$_POST['btitle'] ,

		'ban_sub_title'       =>$_POST['bsubtitle'],

		'ban_image'         =>$imagename,

		'ban_alt_title'         =>$_POST['balttitle'],

		'descript'         =>$_POST['desc'],

		'trainings'		=>$training,

		'quiz'			=>$quiz,

		'images'		=>$images,

		'videos'		=> $videos,

		'handout'		=>$handout,

		'category' => $_POST['cat1'],
		
		'page_status' => $_POST['page_status']

		);



	if($prop->update($table_name, $value, $t_cond))

	 {

		$msg = 'Besafe Program Successfully save as Draft';
		echo json_encode(array('err'=>1,'msg'=>$msg,'LastID'=>$_REQUEST['draft_id'])); exit;

	 }else{

		$msg = 'Besafe Program Failed to save as Draft';
		echo json_encode(array('err'=>0,'msg'=>$msg)); exit;

	}
	
	
	}
}

?>