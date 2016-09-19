<html>
<head>
    <title>Demo Main Page</title>
</head>

<body>

    <?php
    include_once 'dbconnect.php';


    $query = "DROP TABLE IF EXISTS user";
    pg_query($conn, $query) or die ("drop table fail");

    $query = "CREATE TABLE users(
    email VARCHAR(256) PRIMARY KEY,
    username VARCHAR(256) NOT NULL,
    password_digest VARCHAR(256) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE)";
    pg_query($conn, $query) or die ("user table already exists\n");

    $query = "DROP TABLE IF EXISTS item";
    pg_query($conn, $query) or die ("drop table fail");

    $query = "CREATE TABLE item(
    ID INT SERIAL,
    item_name VARCHAR(256) NOT NULL,
    owner VARCHAR(256) REFERENCES user(email),
    description VARCHAR(256),
    category VARCHAR(256),
    return_instruction VARCHAR(256),
    pickup_instruction VARCHAR(256),
    availability BOOLEAN DEFAULT TRUE,
    bid_type VARCHAR(256) CHECK(bid_type = 'free' OR bid_type = 'require fee'),
    PRIMARY KEY(ID, owner)";
    pg_query($conn, $query) or die ("item already exist");


    $query = "DROP TABLE IF EXISTS bid";
    pg_quey($conn, $query) or die ("drop table fail");

    $query = "CREATE TABLE bid(
    creation_time DATE,
    bid_amount REAL CHECK(bid_amount >= 0),
    bidder VARCHAR(256) REFERENCES user(email),
    item_id INT REFERENCES item(ID),
    PRIMARY KEY(bid_amount, ID, bidder)";
    pg_query($conn, $query) or die ("bid already exist");

    $query = "DROP TABLE IF EXISTS loan";
    pg_quey($conn, $query) or die ("drop table fail");

    $query = "CREATE TABLE loan(
    return_date DATE CHECK(return_date >= borrowed_date),
    borrowed_date DATE,
    item_id INT,
    owner VARCHAR(256),
    borrower VARCHAR(256) REFERENCES item(email),
    FOREIGN KEY(item_id, owner) REFERENCES item(ID, owner),
    PRIMARY KEY(ID, owner, borrower)";
    pg_query($conn, $query) or die ("loan already exists");



    pg_close($conn);
    

    ?>
    <p>Hey</p>


    
</body>


</html>
