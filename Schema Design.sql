CREATE TABLE user
(
email VARCHAR(256) PRIMARY KEY,
username VARCHAR(256) NOT NULL,
password_digest VARCHAR(256) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
)


CREATE TABLE item
(
ID INT AUTO_INCREMENT,
item_name VARCHAR(256) NOT NULL,
owner VARCHAR(256) REFERENCES user(email),
description VARCHAR(256)
category VARCHAR(256),
return_instruction VARCHAR(256),
pickup_instruction VARCHAR(256),
availability BOOLEAN DEFAULT TRUE,
bid_type VARCHAR(256) CHECK(fee_type = "free" OR fee_type = "require fee")
PRIMARY KEY(id, owner)
)


CREATE TABLE bid(
creation_time DATE,
bid_amount REAL CHECK(bid_amount > 0.0),
bidder VARCHAR(256) REFERENCES user(email),
item_id INT REFERENCES item(ID),
PRIMARY KEY(bid_amount, ID , bidder)
)

CREATE TABLE loan(
return_date DATE CHECK(return_date >= borrowed_date),
borrowed_date DATE,
item_id INT,
owner VARCHAR(256),
borrower VARCHAR(256) REFERENCES user(name),
FOREIGN KEY(item_id, owner) REFERENCES item(ID, owner)
PRIMARY KEY(item_id, owner, borrower)
)