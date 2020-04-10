<?php
	session_start();
	$cur_url = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$live_url = rtrim($cur_url,"live_form_purecurl.php");
	$upfolder = "UploadFiles"; 
	
	$attachment = array();
    $formdata  = json_decode($_REQUEST["data"],true);
	$allemail  = $_REQUEST["allemail"];
	$allphone  = $_REQUEST["allphone"];
    $pro_id    = trim($_REQUEST["pro_id"]);
	$pagename  = trim($_REQUEST["pagename"]);
	$form_type = trim($_REQUEST["form_type"]);
	$receipient_email = trim($_REQUEST["sender_email"]);	
	$bcc_email = trim($_REQUEST["bcc_email"]);
    $email_notify = trim($_REQUEST["email_notify"]);
    $form_succ_notify = trim($_REQUEST["form_succ_notify"]);	
	$subject   = "Form Submitted";
	$cpatch    = $_REQUEST["captcha"];
	$captcha_type = ($_REQUEST["captcha_type"] != "" ? $_REQUEST["captcha_type"] : "default");	
	
	function RString($length = 4) 
	{
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charactersLength = strlen($characters);
		$randomString = "";
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	if (($cpatch == $_SESSION["cap_code"] && $captcha_type == "default") || $captcha_type == "google" || $captcha_type=="none") 
	{
		if(count($_FILES))
		{
			if (!file_exists($upfolder)) 
			{
				mkdir($upfolder, 0777, true);
			}
			$i = 0;
			foreach($_FILES AS $ind=>$data)
			{
				$attachment[$i]["file_name"] = $ind;
				$uploaded_files = "~";
				if(is_array ($data["name"]))
				{
					$uploaded_files = "~";
					foreach($data["name"] AS $key=>$file)
					{
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						$file_name = time().RString().".".$ext;
						if (move_uploaded_file($data["tmp_name"][$key],$upfolder."/".$file_name)) 
						{
							$uploaded_files .= $live_url."/".$upfolder."/".$file_name."~";
						}
					}
				}
				else
				{
					$ext = pathinfo($data["name"], PATHINFO_EXTENSION);
					$file_name = time().RString().".".$ext;
					if (move_uploaded_file($data["tmp_name"], $upfolder."/".$file_name)) 
					{
						$uploaded_files .= $live_url."/".$upfolder."/".$file_name."~";
					}
				}
				$attachment[$i]["file_path"] = trim($uploaded_files,"~");
				$i++;
			}
		}
		$input = array(
		"data" => json_encode($formdata),
		"allemail" => json_encode($allemail),
		"allphone" => json_encode($allphone),
		"attachment" => json_encode($attachment),
		"pro_id" => $pro_id,
		"pagename" => $pagename,
		"form_type" => $form_type,
		"sender_email" => $receipient_email,
		"bcc_email" => $bcc_email,
		"email_notify" => $email_notify
		);
		$url="https://edificecms.com/curl/dynamic_form_data.php";
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $input
		));
		$output = json_decode(curl_exec($ch),true);	
		if($output["error"])
		{
			$return["mtype"]=1;			
			$return["msg"]  = $output["msg"];
		}
		else
		{
			$return["mtype"]=0;
			if($form_succ_notify !="")
				$return["msg" ] = $form_succ_notify;
			else
				$return["msg"]  = $output["msg"];
		}
	}
	else
	{
		$return["mtype"]=1;
		$return["msg"]="Invalid Captcha Code";
	}
	echo json_encode($return);
?>