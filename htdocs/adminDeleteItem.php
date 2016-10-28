<?php
session_start();
include_once 'dbconnect.php';

$id = (int) $_GET['id'];
$owner = $_GET['owner'];

$query = "DELETE FROM item WHERE ID = '$id' AND owner = '$owner' ";
pg_query($conn, $query) or die (pg_last_error());
header("Location: adminindex.php");
?>