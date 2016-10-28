<?php
session_start();
include_once 'dbconnect.php';

$id = (int) $_GET['id'];
$owner = $_GET['owner'];
$borrower = $_GET['borrower'];

$query = "DELETE FROM loan WHERE item_id = '$id' AND owner = '$owner' AND borrower = '$borrower'";
pg_query($conn, $query) or die (pg_last_error());
header("Location: adminindex.php");
?>