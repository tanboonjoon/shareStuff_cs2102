<?php
session_start();
include_once 'dbconnect.php';

$id = (int) $_GET['id'];
$owner = $_GET['owner'];
$bidder = $_GET['bidder'];

$query = "DELETE FROM bid WHERE item_id = '$id' AND owner = '$owner' AND bidder = '$bidder'";
pg_query($conn, $query) or die (pg_last_error());
header("Location: adminindex.php");
?>