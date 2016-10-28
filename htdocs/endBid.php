<?php
session_start();
include_once 'dbconnect.php';

$itemID = (int) $_GET['id'];
$query = "SELECT MAX(bid_amount)
		  FROM bid 
		  WHERE item_id = '{$itemID}'
		  AND status = 'pending'";
$result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
$row = pg_fetch_row($result);
$winningBid = $row[0];
pg_free_result($result);



$query = "SELECT b1.bidder
		  FROM bid b1
		  WHERE b1.bid_amount = '{$winningBid}'
		  AND b1.status = 'pending'
		  AND b1.creation_time <= ALL(SELECT b2.creation_time
		  						  	  FROM bid b2
		  						  	  WHERE b2.bid_amount = b1.bid_amount
		  						  	  AND b2.status = 'pending')";
$result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
$row = pg_fetch_row($result);
$bidWinner = $row[0];
pg_free_result($result);



$query = "UPDATE bid
		  SET status = 'failure'
		  WHERE item_id = '{$itemID}'
		  AND status = 'pending'
		  AND bidder <> '{$bidWinner}'";
pg_query($conn, $query) or die (pg_last_error());



$query = "UPDATE bid
		  SET status = 'success'
		  WHERE item_id = '{$itemID}'
		  AND status = 'pending'
		  AND bidder = '{$bidWinner}'";
pg_query($conn, $query) or die (pg_last_error());



$borrowedTime = pg_escape_string(date('Y-m-d'));
$owner = $_SESSION['usr_email'];
$query = "INSERT INTO loan(borrowed_date, item_id, owner, borrower)
		  VALUES('{$borrowedTime}', '{$itemID}', '{$owner}','{$bidWinner}')";
pg_query($conn, $query) or die (pg_last_error());

header("Location: index.php");
?>