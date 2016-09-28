<?php
include_once 'dbconnect.php';

$delete = "DROP TABLE IF EXISTS users CASCADE";
pg_query($conn, $delete) or die (pg_last_error());

$create = "CREATE TABLE users(
email VARCHAR(256) PRIMARY KEY,
usersname VARCHAR(256) NOT NULL,
password_digest VARCHAR(256) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE)";
pg_query($conn, $create) or die (pg_last_error());

$delete ="DROP TABLE IF EXISTS item CASCADE";
pg_query($conn, $delete) or die (pg_last_error());

$query = "CREATE TABLE item(
ID SERIAL NOT NULL,
item_name VARCHAR(256) NOT NULL,
owner VARCHAR(256) REFERENCES users(email),
description VARCHAR(256),
category VARCHAR(256),
return_instruction VARCHAR(256),
pickup_instruction VARCHAR(256),
availability BOOLEAN DEFAULT TRUE,
bid_type VARCHAR(256) CHECK(bid_type = 'free' OR bid_type = 'require fee'),
PRIMARY KEY(ID, owner))";
pg_query($conn, $query) or die (pg_last_error());


$delete ="DROP TABLE IF EXISTS bid CASCADE";
pg_query($conn, $delete) or die (pg_last_error());


$query = "CREATE TABLE bid(
creation_time DATE,
bid_amount REAL CHECK(bid_amount >= 0),
bidder VARCHAR(256) REFERENCES users(email),
item_id INT ,
owner VARCHAR(256)
status VARCHAR(256) CHECK(status = 'pending' or 'status' or status = 'success',
FOREIGN KEY(item_id, owner) REFERENCES ITEM(ID ,owner),
PRIMARY KEY(bid_amount, item_ID, bidder))";
pg_query($conn, $query) or die (pg_last_error());

$delete ="DROP TABLE IF EXISTS loan CASCADE";
pg_query($conn, $delete) or die (pg_last_error());

$query = "CREATE TABLE loan(
return_date DATE CHECK(return_date >= borrowed_date),
borrowed_date DATE,
item_id INT,
owner VARCHAR(256),
borrower VARCHAR(256) REFERENCES users(email),
FOREIGN KEY(item_id, owner) REFERENCES item(ID, owner),
PRIMARY KEY(item_id, owner, borrower))";
pg_query($conn, $query) or die (pg_last_error());


$query = "INSERT INTO users VALUES('admin@gmail.com', 'admin', 'admin', true)";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO users VALUES('tan@gmail.com', 'tan', 'tan', false)";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO users VALUES('richguy@gmail.com', 'richguy', 'richguy', false)";
pg_query($conn, $query) or die (pg_last_error());


$query = "INSERT INTO item(item_name, owner, description, category,return_instruction,pickup_instruction, availability, bid_type) VALUES ('handphone', 'tan@gmail.com', 'sony z2', 'Electronic', 'call me ', 'call me', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction,pickup_instruction, availability, bid_type) VALUES ('novel', 'tan@gmail.com', 'it a book', 'Movies, Music, Book & Games', 'call me ',    'call me', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction,pickup_instruction, availability, bid_type) VALUES ('mercz', 'tan@gmail.com', 'CARRRRR', 'Motor Vehiclesc', 'call me ', 'call me', true,	'require fee')";
pg_query($conn, $query) or die (pg_last_error());






pg_close($conn);


?>
