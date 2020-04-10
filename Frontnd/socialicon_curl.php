<?php
		$mode     ="";
		$pageurl  ="";
	    $pro_id   ="";
		$mode     = $_REQUEST["mode"];
		$pageurl  = $_REQUEST["pageurl"];
	    $pro_id   = $_REQUEST["pro_id"];
		$curl     = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://edificecms.com/curl/socialicon.php");			
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array("pageurl"=>$pageurl,"pro_id"=>$pro_id));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $result_array = $response;
	?>