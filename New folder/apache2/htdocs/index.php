<?php
session_start();
include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home page</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>

    <nav class="navbar navbar-default" role= "navigation">
     <div class="container-fluid">
      <div class="navbar-header>">
       <button type="button" class ="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

</div>
<div class="collapse navbar-collapse" id="navbar1">
   <ul class="nav navbar-nav navbar-right">s
      <?php if (isset($_SESSION['usr_email'])) { ?>
      <li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?> </p></li>
      <li><a href="logout.php">Log Out</a></li> <?php } else { ?>
      <li><a href="login.php">Log In</a></li>
      <li><a href="signup.php">Sign Up</a></li>
      <?php } ?>
  </ul>
</div>

</div>
</nav>


<?php
if(isset($_SESSION['usr_email'])) { 
    $query = "SELECT * FROM users";
    echo "<b>SQL: </b> '{$query}'.<br></br>";
    $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

    echo "<table border=\"1\" >
    <col width=\"45%\">
    <col width=\"55%\">
    <tr>
    <th>Email</th>
    <th>Name</th>
    <th>is_Admin</th>
    </tr>";

    while($row = pg_fetch_row($result)) {
        echo "<tr>";
        echo "<td> '{$row[0]}' </td>";
        echo "<td> '{$row[1]}'</td>";
        echo "<td> '{$row[3]}'</td>";
        echo "</tr>";
    }
    echo "</table>";
    pg_free_result($result);
}
?>

<?php
pg_close($conn);
?>
<a href="Create-user.php"> initialize users table </a>


<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>





</body>
</html>
