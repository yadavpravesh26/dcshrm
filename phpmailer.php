<?php
require 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->Host = 'mail.dcshrm.com';
$mail->SMTPAuth = true;
$mail->Username = 'noreply@dcshrm.com';
$mail->Password = 'ou1{k.6G8YyU';
$mail->SMTPSecure = 'ssl';
$mail->Port = 2080;

$mail->From = "noreply@dcshrm.com";
$mail->FromName = "DCSHRM";

function sendemail($to,$subject,$body,$bcc)
{
	$mail->addAddress($to, "DCSHRM");
	if($bcc != '')
	$mail->addBCC($bcc);
	
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	
	if(!$mail->send()) 
	return false;
	else 
	return true;
}	
?>