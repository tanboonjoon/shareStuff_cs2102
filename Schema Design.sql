CREATE TABLE users
(
email VARCHAR(256) PRIMARY KEY,
usersname VARCHAR(256) NOT NULL,
password_digest VARCHAR(256) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE);
)


CREATE TABLE item
(
ID SERIAL NOT NULL,
item_name VARCHAR(256) NOT NULL,
owner VARCHAR(256) REFERENCES users(email),
description VARCHAR(256),
category VARCHAR(256),
return_instruction VARCHAR(256),
pickup_instruction VARCHAR(256),
status VARCHAR(256) CHECK(status = 'ongoing' OR status = 'over') DEFAULT 'ongoing',
bid_type VARCHAR(256) CHECK(bid_type = 'free' OR bid_type = 'require fee'),
PRIMARY KEY(ID, owner)
)


CREATE TABLE bid(
creation_time DATE,
bid_amount REAL CHECK(bid_amount >= 0),
bidder VARCHAR(256) REFERENCES users(email),
item_id INT  ,
owner VARCHAR(256) ,
status VARCHAR(256) CHECK(status = 'pending' or status = 'failure' or status = 'success'),
FOREIGN KEY(item_id, owner) REFERENCES item(ID, owner) ON DELETE CASCADE,
PRIMARY KEY(item_id, owner, bidder)
)

CREATE TABLE loan(
return_date DATE CHECK(return_date >= borrowed_date),
borrowed_date DATE,
item_id INT,
owner VARCHAR(256),
borrower VARCHAR(256) REFERENCES users(email),
FOREIGN KEY(item_id, owner) REFERENCES item(ID, owner) ON DELETE CASCADE,
PRIMARY KEY(item_id, owner, borrower)
)