<?php
	$cemail=$_POST["subemail"];
	$subject="Subscribe";
    $page_url=$_POST["suburl"];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://edificecms.com/curl/subscribe.php");			
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array("cemail" => $cemail,"subject" => $subject,"page_url" => $page_url));
		$response = curl_exec($curl);
		curl_close($curl);
		$result_array = json_decode($response, true);
		header("Location:$page_url");
		die();
	?>