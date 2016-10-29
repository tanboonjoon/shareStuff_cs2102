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

if(isset($_POST['users'])) {
  $userID = $_POST['id'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $isAdmin = $_POST['isAdmin'];

  $query = "UPDATE users
            SET email = '{$email}', usersname = '{$name}', password_digest = '{$password}', is_admin = '{$isAdmin}'
            WHERE email = '{$userID}'";
  pg_query($conn, $query) or die (pg_last_error());
  header("Location: adminIndex.php");
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
      <li><a href="adminAddUser.php">Add User</a></li>
      <li><a href="adminAddItem.php">Add Item </a></li>
       <li><a href="adminAddLoan.php">Add Loan </a></li>
      <?php } else { ?>
        <li><a href="login.php">Log In</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <?php } ?>
      </ul>
    </div>

  </div>
</nav>

<?php
$edit = (int) $_GET['edit'];

if ($edit == 0) {

  $id = $_GET['id'];
  $query = "SELECT * FROM users WHERE email = '{$id}' ";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  if($row = pg_fetch_array($result)) {        
    echo "<form control='form' method='post' name='users' >";
    echo "<input type ='hidden' name ='id' value = '{$id}' >";
    echo "Email <input type='text' name='email' value='{$row[0]}' class='form-control'/>";
    echo "Name <input type='text' name='name' value='{$row[1]}' class='form-control'/>";
    echo "<label for='password'>Password</label>";
    echo "<input type='text' name='password' value='{$row[2]}' class='form-control'/>";
    echo "Is Admin <input type='text' name='isAdmin' value='{$row[3]}' class='form-control'/>";
    echo "<input type='submit' name='users' value='Edit' > </form>";
  }
  pg_free_result($result);

}else if ($edit == 1) {

echo "you are editing item";
}else if ($edit == 2) {

echo "you are editing bid";
}else if ($edit == 3) {

  echo "you are editing loan";



}

?>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
