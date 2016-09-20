<?php
include_once 'dbconnect.php';


$delete = "DROP TABLE IF EXISTS users";
pg_query($conn, $delete) or die (pg_last_error());


?>