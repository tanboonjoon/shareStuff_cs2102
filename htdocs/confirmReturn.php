<?php
session_start();
include_once 'dbconnect.php';

$itemID = (int) $_GET['id'];

$query = "DELETE FROM loan
		  WHERE item_id = '{$itemID}'";
pg_query($conn, $query) or die (pg_last_error());

$query = "UPDATE item SET availability = true WHERE ID = '{$itemID}'";
pg_query($conn, $query) or die (pg_last_error());

header("Location: index.php");
?>
