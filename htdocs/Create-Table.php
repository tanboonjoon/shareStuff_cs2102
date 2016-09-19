<html>
<head>
    <title>Demo Main Page</title>
</head>

<body>

    <?php
    $servername = "localhost";
    $username ="postgres";
    $password = "cs2102";
    $db = "shareStuff";

    $conn = pg_connect("host=$servername dbname=$db user=$username password=$password")
    or die (" Could not connect to server\n");

    $query = "CREATE TABLE users(
        email VARCHAR(256) PRIMARY KEY,
        username VARCHAR(256) NOT NULL,
        password VARCHAR(256) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE)";
    pg_query($conn, $query) or die ("cannot create table\n");

    $query = "INSERT INTO users VALUES(
        'tbj_999@hotmail.com',
        'tanboonjoon',
        '91451337',
        true)";
    pg_query($conn, $query) or die ("cannot insert");

    $query = "INSERT INTO users VALUES(
        'boonjoonhotmail.com',
        'boonjoon',
        '91451337',
        false)";
    pg_query($conn, $query) or die ("cannot insert");


    pg_close($conn);
    

    ?>
    <p>Hey</p>


    
</body>


</html>
