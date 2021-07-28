<?php
// init the resource
$ch = curl_init();

if(isset($_GET['remote'])){
	curl_setopt_array(
	$ch, array(
	CURLOPT_URL => 'http://dummy.restapiexample.com/api/v1/employee/2',
	CURLOPT_RETURNTRANSFER => true
	));
} else {
	curl_setopt_array(
	$ch, array(
	CURLOPT_URL => 'https://www.google.com/',
	CURLOPT_RETURNTRANSFER => true
	));
}
$output = curl_exec($ch);
echo $output;

// free
curl_close($ch);
?>