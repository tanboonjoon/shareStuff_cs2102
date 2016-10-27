<?php
session_start();
include_once 'dbconnect.php';

$itemID = (int) $_GET['id'];
$query = "DELETE FROM bid
		  WHERE bidder = '" . $_SESSION['usr_email'] . "'
		  AND item_id = '{$itemID}'";
pg_query($conn, $query) or die (pg_last_error());
header("Location: index.php");
?>