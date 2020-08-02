<?php

header('Content-Type: application/json');

$DB_HOST = 'localhost';
$DB_USERNAME = 'root';
$DB_PASSWORD = '';
$DB_NAME = 'price_tracker';

$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if(!$conn){
	die("Connection failed: " . $conn->error);
}

$query = sprintf("SELECT * FROM `price_details` WHERE `product_id` = 1");
$result = $conn->query($query);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

$result->close();
$conn->close();

print json_encode($data);