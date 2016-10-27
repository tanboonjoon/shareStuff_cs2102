<?php
session_start();
include_once 'dbconnect.php';

$itemID = (int) $_GET['id'];
$query = "DELETE FROM item
		  WHERE ID = '{$itemID}'";
pg_query($conn, $query) or die (pg_last_error());
header("Location: index.php");
?>