<?php 
//https://www.timeapi.io/api/Time/current/zone?timeZone=Asia/Tokyo
function get_datetime(){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.timeapi.io/api/Time/current/zone?timeZone=Asia%2FTokyo',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
	    'accept: application/json'
	  ),
	));

	$response = curl_exec($curl);
	//echo $response."<br>";
	//encode to json
	$result = (array) json_decode($response);
	echo $result['date'].$result['time'].$result['timeZone'];
	//jp time
	$date = date_create($result['date']);
	echo date_format($date,"Y/m/d")."<br>";
}
get_datetime();
?>