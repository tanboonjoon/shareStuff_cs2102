<?php
session_start();
include_once 'dbconnect.php';

$email = $_GET['id'];
$query = "DELETE FROM users WHERE email = '$email'";
pg_query($conn, $query) or die (pg_last_error());
header("Location: adminindex.php");
?>