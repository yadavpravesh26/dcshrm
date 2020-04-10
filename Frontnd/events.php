<?php
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://edificecms.com/curl/events.php");			
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array("pro_id"=>201));
		$response = curl_exec($curl);
		curl_close($curl);
		$result_array = json_decode($response, true);
		echo $result_array["content"];	
	?>