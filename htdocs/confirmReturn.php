<?php
session_start();
include_once 'dbconnect.php';

$itemID = (int) $_GET['id'];
$timestamp = pg_escape_string(date('Y-m-d'));
$updateDateQuery = "UPDATE loan SET return_date = '$timestamp' WHERE item_id = '$itemID'";
pg_query($conn, $updateDateQuery) or die (pg_last_error());


$query = "SELECT * FROM item WHERE ID = '$itemID'"; 
$result = pg_query($conn, $query) or die (pg_last_error());

while($row = pg_fetch_row($result)) {

$item_name = $row[1];
$owner = $row[2];
$description = $row[3];
$category = $row[4];
$return_instruction = $row[5];
$pickup_instruction = $row[6];
$bid_type = $row[8];

$insertQuery = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, bid_type) VALUES('$item_name', '$owner' ,'$description' ,'$category' , '$return_instruction', '$pickup_instruction', 
'$bid_type') ";
pg_query($conn, $insertQuery) or die (pg_last_error());
header("Location: index.php");
}


?>
