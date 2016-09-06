CREATE TABLE user
(
email VARCHAR(256) PRIMARY KEY,
username VARCHAR(256) NOT NULL,
password VARCHAR(256) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
)

CREATE TABLE item
(
item_id VARCHAR(256) PRIMARY KEY,
item_name VARCHAR(256),
description VARCHAR(256),
category VARCHAR(256),
)

CREATE TABLE copy
availability BOOLEAN NOT NULL,
noOfCopies INT CHECK(noOfCopies > 0),
pick_up_instruction VARCHAR(256),
return_instruction VARCHAR(256),
fee_type VARCHAR(11) CHECK(fee_type = "free" OR fee_type = "require fee"),
item_id VARCHAR(256) REFERENCES iem(item_id),
owner VARCHAR(256) REFERENCES user(email),
PRIMARY KEY(owner, item_id, noOfCopies)
)

CREATE TABLE bid(
start_date DATE,
end_date DATE CHECK(end_date >= start_date),
bid_amount INT CHECK(bid_amount >= 0),
bidder VARCHAR(256) REFERENCES user(email),
noOfCopies INT ,
owner VARCHAR(256),
item_id VARCHAR(256),
FOREIGN KEY (owner, item_id , noOfCopies) REFERENCES copy(owner, item_id , noOfCopies),
PRIMARY KEY(owner,item_id,noOfCopies, bidder, bid_amount)
)

CREATE TABLE loan(
borrower VARCHAR(256) REFERENCES student(email),
noOfCopies INT ,
owner VARCHAR(256),
item_id VARCHAR(256),
borrowed DATE,
returned DATE CHECK(returned >= borrowed),
FOREIGN KEY (owner, item_id , noOfCopies) REFERENCES copy(owner, item_id , noOfCopies),
PRIMARY KEY (borrowed, borrower, owner, book, copy),
)