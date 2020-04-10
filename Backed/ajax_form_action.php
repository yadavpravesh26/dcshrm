<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author Chandru
 */

require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$dbCon = new PDOFUNCTION($db);

class formSave {
   
  
    public function updateForm(){
        global $dbCon;
        $returnArray = array();

	// Check if field already exist or not
	$getRowID = $_REQUEST['row_id'];
 	
	$serialArray = implode(',',$_REQUEST['insData']);	

        // Preparing DataSet for DB updation
        $dataset = array(
            "form_id"            => ($_REQUEST['formid']) ? $_REQUEST['formid'] : '',
            "title"        	 => ($_REQUEST['title']) ? $_REQUEST['title'] : '',
            "serialValue"        => $serialArray,
            "created_by"         => ($_SESSION['US']['user_id']) ? $_SESSION['US']['user_id'] : '',
        );
        
        // Updating Password Area
	if($getRowID)
        	$returnArray=$dbCon->update('form_fields', $dataset, array("id"=>$getRowID));
        else 
		$returnArray= $dbCon->addID('form_fields', $dataset);

        return $returnArray;
    }
   
    public function fetchForm($getID) {
	global $dbCon;
	$returnArray = array();
	$getRow = $dbCon->getAll_Disp(" SELECT serialValue FROM `form_fields` WHERE id='".$getID."' ");
	
	// Get Serialized Array 	
	$returnArray = explode(',', $getRow[0]['serialValue']);
	return $returnArray; 
    }
    
}


//Retrieving Function to add Notes
$formObj=new formSave();
    
$action = $_REQUEST['module']!=''?$_REQUEST['module']:'';
switch ($action) { 
    case 'saveFormField':
        $res=$formObj->updateForm();
        echo json_encode($res);
    break;

    case 'fetchFormField':
	$getID = $_REQUEST['edit_id'];
        $res=$formObj->fetchForm($getID);
        echo json_encode($res);
    break;
}

