<?php
$servername = "localhost";
$username ="postgres";
$password = "cs2102";
$db = "postgres";

$conn = pg_connect("host=$servername dbname=$db user=$username password=$password")
or die (" Could not connect to server\n");
?>