<?php 
ob_start();
error_reporting(0);
session_start();
date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d H:i:s');
define('DOC_ROOT',$_SERVER['DOCUMENT_ROOT'].'/newchanges/');
define('DOC_CONFIG',DOC_ROOT.'sadmin/');
define('TEMP_PATH',"http://".$_SERVER[HTTP_HOST]."/newchanges/");
define('LIVE_SITE',TEMP_PATH);
define('ADMIN_SITE',TEMP_PATH.'sadmin/');
define('_404',TEMP_PATH.'dashboard.php');

/* Biltly Credentials */
DEFINE("BITLY_USER", "o_41nao4cq44");
DEFINE("BITLY_APIKEY", "R_9fde6a5759b84f09a23cbef8e77b5fd0");
?>