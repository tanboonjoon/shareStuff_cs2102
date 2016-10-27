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
owner VARCHAR(256),
status VARCHAR(256) CHECK(status = 'pending' or status = 'failure' or status = 'success'),
FOREIGN KEY(item_id, owner) REFERENCES ITEM(ID, owner),
PRIMARY KEY(item_id, bidder))";
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

$query = "INSERT INTO users VALUES('inaba@gmail.com', 'inaba', 'inaba', false)";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO users VALUES('fong@gmail.com', 'fong', 'fong', false)";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO users VALUES('goh@gmail.com', 'goh', 'goh', false)";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO users VALUES('yu@gmail.com', 'yu', 'yu', false)";
pg_query($conn, $query) or die (pg_last_error());



//Sample User's Items
$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('handphone', 'tan@gmail.com', 'Sony Z2', 'Electronic', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('novel', 'tan@gmail.com', 'The wonderful tales of the pigs and cows in my backyard', 'Movies, Music, Book & Games', 'Meet at Jurong MRT', 'Meet at Jurong MRT', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('bicycle', 'tan@gmail.com', 'Mountain bike', 'Sport & Outdoors', 'Call/Text', 'Meet at Jurong MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('cs2102 textbook', 'tan@gmail.com', 'Databse textbook', 'Office & Education', 'Call/Text', 'Meet at Jurong MRT', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('baseball glove', 'tan@gmail.com', 'Bought in middle school but never used it', 'Sport & Outdoor', 'Meet at Clementi Mall', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('electric guitar', 'tan@gmail.com', 'Gibson (Black), never touched it, well maybe a few strums...BUT STILL NEW', 'Movies, Music, Book & Games', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('guitar combo amplifier', 'tan@gmail.com', 'Mustang, never touched it along with the guitar, IN PERFECT CONDITION', 'Movies, Music, Book & Games', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('guitar tool kit', 'tan@gmail.com', '...never broke any guitars so there was no opportunity to use it, IN PERFECT CONDITION', 'Tools & Gardening', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('tricycle', 'tan@gmail.com', 'You want to ride it, pay for it', 'Sport & Outdoor', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('cs1231 textbook', 'tan@gmail.com', 'Discrete structure textbook', 'Office & Education', 'Call/Text', 'Call/Text', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('mercedes benz', 'tan@gmail.com', 'Cheap and negotiable rental rate.', 'Motor Vehicles', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());


//Extra's Items
$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('jamming studio', 'inaba@gmail.com', 'Want to hold a live? Rate is cheap and negotiable', 'Spaces & Venues', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('paint brush set', 'inaba@gmail.com', 'For art lessons', 'Sport & Outdoors', 'Meet at Commonwealth MRT', 'Meet at Commonwealth MRT', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('helicopter', 'inaba@gmail.com', 'The one that flies and people ride on', 'Motor Vehicles', 'Call/Text', 'Call/Text', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());



$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('ma1101r textbook', 'fong@gmail.com', 'Linear algebra textbook', 'Arts and Crafts', 'Meet at Bukit Batok MRT', 'Meet at Bukit Batok MRT', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('st2334 textbook', 'fong@gmail.com', 'Probability & statistics textbook', 'Office & Education', 'Meet at Bukit Batok MRT', 'Meet at Bukit Batok MRT', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('tablet', 'fong@gmail.com', 'iPad', 'Electronic', 'Call/Text', 'Meet at Bukit Batok MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('laptop', 'fong@gmail.com', 'Toshiba, works fine', 'Electronic', 'Call/Text', 'Meet at Bukit Batok MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('keyboard', 'fong@gmail.com', 'Razer, gaming keyboard', 'Electronic', 'Call/Text', 'Meet at Bukit Batok MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());





$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('air fryer', 'goh@gmail.com', 'Take good care of it!', 'Home & Appliances', 'Call/Text', 'Meet at Chua Chu Kang MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('oven', 'goh@gmail.com', 'It is not mine', 'Home & Appliances', 'Call/Text', 'Meet at Chua Chu Kang MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('fry pan', 'goh@gmail.com', 'Belongs to my mum', 'Home & Appliances', 'Call/Text', 'Meet at Chua Chu Kang MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('hocket stick', 'goh@gmail.com', 'My prized stick', 'Sport & Outdoors', 'Call/Text', 'Meet at Chua Chu Kang MRT', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());



$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('party hat', 'yu@gmail.com', 'You can have it for good', 'Parties & Events', 'Call/Text', 'Call/Text', true, 'free')";
pg_query($conn, $query) or die (pg_last_error());

$query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, availability, bid_type)
		  VALUES ('santa costume', 'yu@gmail.com', 'Surprise your kids!', 'Parties & Events', 'Call/Text', 'Call/Text', true, 'require fee')";
pg_query($conn, $query) or die (pg_last_error());



pg_close($conn);


?>
