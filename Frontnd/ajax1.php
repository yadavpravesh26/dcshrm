<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$table_name= BBP_BLOODBORNE_PATHOGENS;
extract($_POST);
if($meth=="bbpadd")
{
   	 $saveddta = array(
   		"form_names" =>'Nil',
   		'form_path_id' =>base64_decode($_POST['formid']),  
   		"form_type_name" =>$_POST['formname'],
   		"created_date" =>date('Y-m-d'),
   		"link_print" =>'Print_Bloodborne_Pathogens_Equipment_List.php',
   		"company_id" =>$_SESSION['US']['user_id']
   		);
   		$results = $prop->addID(SAVED_FORMS, $saveddta);
   	
   	$insdata   = array(
   			 'v1' =>$_POST['v1'],  
   			 'v2' =>$_POST['v2'],  
   			 'v3' =>$_POST['v3'],  
   			 'v4' =>$_POST['v4'],  
   			 'v5' =>$_POST['v5'],  
   			 'v6' =>$_POST['v6'],  
   			 'v7' =>$_POST['v7'],  
   			 'v8' =>$_POST['v8'],  
   			 'v9' =>$_POST['v9'],  
   			 'v10' =>$_POST['v10'],  
   			 'v11' =>$_POST['v11'],  
   			 'v12' =>$_POST['v12'],  
   			 'v13' =>$_POST['v13'],  
   			 'v14' =>$_POST['v14'],  
   			 'v15' =>$_POST['v15'],  
   			 'v16' =>$_POST['v16'],  
   			 'v17' =>$_POST['v17'],  
   			 'v18' =>$_POST['v18'],  
   			 'v19' =>$_POST['v19'],  
   			 'v20' =>$_POST['v20'],  
   			 'save_form_id'  =>$results  
   			);	
   		$resultssa = $prop->add($table_name, $insdata);
			 setcookie("status", "Success", time()+100);
   			 setcookie("title", "Form Saved Successfully", time()+100);
   			 setcookie("err", "success", time()+100);
}
   		
 if($meth=="bbpupdate")
{  		
   		
   		$t_cond = array("save_form_id" => $_REQUEST['ids']);
		$insdata   = array(
   			 'v1' =>$_POST['v1'],  
   			 'v2' =>$_POST['v2'],  
   			 'v3' =>$_POST['v3'],  
   			 'v4' =>$_POST['v4'],  
   			 'v5' =>$_POST['v5'],  
   			 'v6' =>$_POST['v6'],  
   			 'v7' =>$_POST['v7'],  
   			 'v8' =>$_POST['v8'],  
   			 'v9' =>$_POST['v9'],  
   			 'v10' =>$_POST['v10'],  
   			 'v11' =>$_POST['v11'],  
   			 'v12' =>$_POST['v12'],  
   			 'v13' =>$_POST['v13'],  
   			 'v14' =>$_POST['v14'],  
   			 'v15' =>$_POST['v15'],  
   			 'v16' =>$_POST['v16'],  
   			 'v17' =>$_POST['v17'],  
   			 'v18' =>$_POST['v18'],  
   			 'v19' =>$_POST['v19'],  
   			 'v20' =>$_POST['v20']
   			);	
   			$prop->update($table_name, $insdata , $t_cond);
			setcookie("status", "Success", time()+100);
   			setcookie("title", "Form Updated Successfully", time()+100);
   			setcookie("err", "success", time()+100);
   }
   if($meth=="craneadd") {
    $saveddta = array(
		"form_names" =>'Nil',
		'form_path_id' =>base64_decode($_POST['formid']),  
		"form_type_name" =>$_POST['formname'],
		"created_date" =>date('Y-m-d'),
		"link_print" =>"Print_Crane_And_Hoist_Safety_Program.php",
		"company_id" =>$_SESSION['US']['user_id']
		);
		$results = $prop->addID(SAVED_FORMS, $saveddta);
		
		$maindata   = array(
	        'line1' =>$_POST['line1'],  		
			 'line2' =>$_POST['line2'],  	
			 'lin3' =>$_POST['line3'],  	  
			 'week' =>$_POST['week'],  
			 'year' =>$_POST['year'],  
			 'addr' =>$_POST['siteaddr'],  
             'crane_make' =>$_POST['make'],  
             'model' =>$_POST['model'],
             'serial' =>$_POST['serial'],
             'remarks' =>$_POST['remark'],
             'oname' =>$_POST['oname'],
             'osign' =>$_POST['osign'],
             'sname' =>$_POST['sname'],
             'ssign' =>$_POST['ssign'],
			 'save_form_id'  =>$results  
			);	
		 $prop->add(FORM_CRANE, $maindata);
		
		$insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
		
		foreach($insdata as $dayType=>$innerArray){
			//$insdata[$dayType]['dayType'] = trim($dayType);
			$innerArray['dayType']= trim($dayType);
			$innerArray['save_form_id']= $results;
			 $prop->add('form_crane_inspection', $innerArray);
		}
	//echo "<pre>";
	//print_r($insdata);
	//echo "</pre>";exit;
	
	

}
 if($meth=="craneupdate") {
	 
	 $t_condi = array("save_form_id" => $_POST['ids']);
	 $maindata   = array(
	        'line1' =>$_POST['line1'],  		
			 'line2' =>$_POST['line2'],  	
			 'lin3' =>$_POST['line3'],  	  
			 'week' =>$_POST['week'],  
			 'year' =>$_POST['year'],  
			 'addr' =>$_POST['siteaddr'],  
             'crane_make' =>$_POST['make'],  
             'model' =>$_POST['model'],
             'serial' =>$_POST['serial'],
             'remarks' =>$_POST['remark'],
             'oname' =>$_POST['oname'],
             'osign' =>$_POST['osign'],
             'sname' =>$_POST['sname'],
             'ssign' =>$_POST['ssign'],
			);	
		 $prop->update(FORM_CRANE, $maindata , $t_cond1);
   
		$insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
	//	$t_cond = array("dayType" => 7,"level_id" => 7);
		foreach($insdata as $dayType=>$innerArray){
			$insdata[$dayType]['dayType'] = trim($dayType);
			//$innerArray[]= $insdata[$dayType]['dayType'];
			$t_cond = array("dayType" => trim($dayType),"save_form_id" => $_POST['ids']);
			$results = $prop->update('form_crane_inspection', $innerArray,$t_cond);
		}
	//echo "<pre>";
	//print_r($insdata);
	//echo "</pre>";exit;
	

}
 if($meth=="dailyforkadd") {
	  $saveddta = array(
		"form_names" =>'Nil',
		'form_path_id' =>base64_decode($_POST['formid']),  
		"form_type_name" =>$_POST['formname'],
		"created_date" =>date('Y-m-d'),
		"link_print" =>"Print_Daily_Forklift_Inspection_Form.php",
		"company_id" =>$_SESSION['US']['user_id']
		);
		$results = $prop->addID(SAVED_FORMS, $saveddta);
		
		$maindata   = array(
	        'life' =>$_POST['life'],  
	        'inspector' =>$_POST['inspector'],  
	        'jobname' =>$_POST['jobname'],  
	        'week' =>$_POST['week'],  
	        'notes' =>$_POST['notes'],  
	        'sign' =>$_POST['sign'],  
	        'ddate' =>date('Y-m-d',strtotime($_POST['ddate'])),  
			 'save_form_id'  =>$results  
			);	
		 $prop->add(FORM_DAILY_FORK, $maindata);
	 $insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
		foreach($insdata as $dayType=>$innerArray){
			//$insdata[$dayType]['dayType'] = trim($dayType);
			$innerArray['dayType']= trim($dayType);
			$innerArray['save_form_id']= $results;
			 $prop->add(FORM_DAILY_FORK_LIFT, $innerArray);
		}
    echo "<pre>";
	print_r($insdata);
	echo "</pre>";exit;
 }
 if($meth=="dailyforkupdate") {
	 
	 $t_condi = array("save_form_id" => $_POST['ids']);
	 $maindata   = array(
	        'life' =>$_POST['life'],  
	        'inspector' =>$_POST['inspector'],  
	        'jobname' =>$_POST['jobname'],  
	        'week' =>$_POST['week'],  
	        'notes' =>$_POST['notes'],  
	        'sign' =>$_POST['sign'],  
	        'ddate' =>date('Y-m-d',strtotime($_POST['ddate'])),  
			);	
		 $prop->update(FORM_DAILY_FORK, $maindata , $t_cond1);
   
		$insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
	//	$t_cond = array("dayType" => 7,"level_id" => 7);
		foreach($insdata as $dayType=>$innerArray){
			$insdata[$dayType]['dayType'] = trim($dayType);
			//$innerArray[]= $insdata[$dayType]['dayType'];
			$t_cond = array("dayType" => trim($dayType),"save_form_id" => $_POST['ids']);
			$results = $prop->update(FORM_DAILY_FORK_LIFT, $innerArray,$t_cond);
		}
	//echo "<pre>";
	//print_r($insdata);
	//echo "</pre>";exit;
	

}
if($meth=="aerialadd") {
	  $saveddta = array(
		"form_names" =>'Nil',
		'form_path_id' =>base64_decode($_POST['formid']),  
		"form_type_name" =>$_POST['formname'],
		"created_date" =>date('Y-m-d'),
		"link_print" =>"Print_Z05_Daily_Aerial_Lift_Inspection.php",
		"company_id" =>$_SESSION['US']['user_id']
		);
		$results = $prop->addID(SAVED_FORMS, $saveddta);
		
		$maindata   = array(
	        'life' =>$_POST['life'],  
	        'inspector' =>$_POST['inspector'],  
	        'jobname' =>$_POST['jobname'],  
	        'week' =>$_POST['week'],  
	        'notes' =>$_POST['notes'],  
	        'sign' =>$_POST['sign'],  
	        'ddate' =>date('Y-m-d',strtotime($_POST['ddate'])),  
			 'save_form_id'  =>$results  
			);	
		 $prop->add(FORM_AERIAL, $maindata);
	 $insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
		foreach($insdata as $dayType=>$innerArray){
			//$insdata[$dayType]['dayType'] = trim($dayType);
			$innerArray['dayType']= trim($dayType);
			$innerArray['save_form_id']= $results;
			 $prop->add(FORM_AERIAL_LIFT, $innerArray);
		}
    echo "<pre>";
	print_r($insdata);
	echo "</pre>";exit;
 }
 if($meth=="aerialupdate") {
	 
	 $t_condi = array("save_form_id" => $_POST['ids']);
	 $maindata   = array(
	        'life' =>$_POST['life'],  
	        'inspector' =>$_POST['inspector'],  
	        'jobname' =>$_POST['jobname'],  
	        'week' =>$_POST['week'],  
	        'notes' =>$_POST['notes'],  
	        'sign' =>$_POST['sign'],  
	        'ddate' =>date('Y-m-d',strtotime($_POST['ddate'])),  
			);	
		 $prop->update(FORM_AERIAL, $maindata , $t_cond1);
   
		$insdata = array();
		foreach($_POST['v1'] as $key=>$innerArray){
			$insdata[$innerArray['dayNo']][$innerArray['columnName']]= $innerArray['value'];	
		}
	//	$t_cond = array("dayType" => 7,"level_id" => 7);
		foreach($insdata as $dayType=>$innerArray){
			$insdata[$dayType]['dayType'] = trim($dayType);
			//$innerArray[]= $insdata[$dayType]['dayType'];
			$t_cond = array("dayType" => trim($dayType),"save_form_id" => $_POST['ids']);
			$results = $prop->update(FORM_AERIAL_LIFT, $innerArray,$t_cond);
		}
	//echo "<pre>";
	//print_r($insdata);
	//echo "</pre>";exit;
	

}


   ?>