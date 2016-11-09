<?php
session_start();
include_once 'dbconnect.php';


if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == false) {
  if (isset($_SESSION['usr_email'])) {
    header("Location: index.php");
  } else {
    header("Location: login.php");
  }


}

if(isset($_POST['adduser'])) {

  $email = pg_escape_string($_POST['email']);
  $name = pg_escape_string( $_POST['name']);
  $password = pg_escape_string($_POST['password']);
  $isadmin =  $_POST['isadmin'];

  $query = "INSERT INTO users VALUES('{$email}', '{$name}', '{$password}', '$isadmin')";
  $result = pg_query($conn, $query);

  if(!$result) {
    $failure = "INAVLID OR DUPLICATE EMAIL!";
  } else {
    $success = "Account created! <a href='adminIndex.php'>go back to index page</a>";
  }
}

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
   <ul class="nav navbar-nav navbar-right">
    <?php if (isset($_SESSION['usr_email'])) { ?>
      <li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?> </p></li>
      <li><a href="logout.php">Log Out</a></li>
      <li><a href="adminIndex.php">Home</a></li>
      <li><a href="adminAddUser.php">Add User</a></li>
      <li><a href="adminAddItem.php">Add Item </a></li>
      <li><a href="adminAddBidphp">Add Bid </a></li>
      <li><a href="adminAddLoan.php">Add Loan </a></li>
      <?php } else { ?>
        <li><a href="login.php">Log In</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <?php } ?>
      </ul>
    </div>

  </div>
</nav>

<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signup">

  <label for="name">Email</label>
  <input type="text" name="email" required value="<?php echo $email; ?>" class="form-control"/>
  <label for="name">Name</label>
  <input type="text" name="name" required value="<?php echo $name; ?>" class="form-control"/>
  <label for="password">Password</label>
  <input type="password" name="password" required value ="<?php echo $password; ?>" class="form-control"/>

  isAdmin <select required name='isadmin'> <option value='false'>False</option>";
  <option value= 'true' > True</option>
  </select> <br>
  <input type="submit" name="adduser" value="Add User" class ="btn btn-primary"/>


</form>
<span class="text-success"><?php if(isset($success)) { echo $success;} ?></span>
<span class="text-danger"><?php if(isset($failure)) { echo $failure;} ?></span>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
