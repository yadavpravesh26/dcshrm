<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
if(isset($_SESSION['U']['id'])){
	if(isset($_GET['status']) && isset($_SESSION['U']['permission']) && $_SESSION['U']['permission']==1){
		if($_GET['status']==='access' && (int)$_GET['q']>0){
			$_SESSION['backup'] = $_SESSION['U'];
			$reg_id = (int)$_GET['q'];
			$log = $prop->get_Disp('SELECT id,u_id,email,name,c_name,password,de_pass,user_type,u_type,status FROM `'.USERS.'` WHERE 1=1 AND status!=2 AND id='.$reg_id);
			if(!empty($log)){
				
				$_SESSION['U']['id']	=	$log['id'];
				$_SESSION['U']['uid']	=	$log['u_id'];
				$_SESSION['U']['email']	=	$log['email'];
				$_SESSION['U']['name']	=	$log['name'];
				$_SESSION['U']['pass']	=	$log['de_pass'];
				$_SESSION['U']['user_type'] = $log['user_type'];
				$_SESSION['U']['type'] = $log['u_type'];
				if($log['u_type']===0){
					$_SESSION['U']['menu'] = 1;
					$_SESSION['U']['permission'] = 1;
				}else{
					$_SESSION['U']['menu'] = 0;
				}
			}
		}
		if($_GET['status']==='close'){
			unset($_SESSION['U']);
			$_SESSION['U'] = $_SESSION['backup'];
			unset($_SESSION['backup']);
		}
	}
}
header("Location:".ADMIN_SITE);
exit;