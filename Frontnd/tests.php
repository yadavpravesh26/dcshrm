<?php
require_once('bitly.php');

$client_id = '58989d0612817317372c79680be27f8ce8d46320';
$client_secret = 'e866b2b37a4e2706edb2002ae31d89ee64a9a3e0';
$user_access_token = '0dbfe11922a256a03e1d04ef93c40d6e9590329a';
$user_login = 'yadavpravesh26';
$user_api_key = '0dbfe11922a256a03e1d04ef93c40d6e9590329a';  


$params = array();
$params['access_token'] = $user_access_token;
$params['longUrl'] = 'https://pr.survey360pro.com/index-dcshrm.php?s=4BexdwxWZF&dcshrm_com_id=2&dcshrm_user_id=3&emp_fname=Mohan&emp_lname=Raj&emp_email=mohan@hexagonitsolutions.com&emp_number=9840862748';
$params['domain'] = 'bit.ly';
$results = bitly_get('shorten', $params);
var_dump($results);

echo $results['data']['url'];
?>