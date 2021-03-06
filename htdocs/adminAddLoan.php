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

if(isset($_POST['loan'])) {

  $borrowedTime = pg_escape_string(date('Y-m-d'));
  $item_id = $_POST['item_id'];

  $query = "SELECT owner FROM item WHERE ID = '{$item_id}'";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
  $row = pg_fetch_array($result);
  $owner = $row[0];

  $borrower = $_POST['borrower'];
  
  $query = "INSERT INTO loan(borrowed_date, item_id, owner, borrower)
            VALUES('{$borrowedTime}', '{$item_id}', '{$owner}','{$borrower}')";
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
      <li><a href="adminIndex.php">Home</a></li>
      <li><a href="adminAddUser.php">Add User</a></li>
      <li><a href="adminAddItem.php">Add Item </a></li>
      <li><a href="adminAddBid.php">Add Bid </a></li>
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
echo "You are adding a loan";
echo "<p></p>";

echo "<form control='form' method='post' name='loan' >";

echo "Item ID <select required name='item_id'> <option value=''>Select Item ID</option>";
$query = "SELECT ID FROM item";
$result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
while($row = pg_fetch_array($result)) {
  echo "<option value= '{$row[0]}' > '{$row[0]}'</option>";
}
echo "</select> <br>";
pg_free_result($result);

echo "Borrower <select required name='borrower'> <option value=''>Select Borrower</option>";
$query = "SELECT email FROM users";
$result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
while($row = pg_fetch_array($result)) {
  echo "<option value= '{$row[0]}' > '{$row[0]}'</option>";
}
echo "</select> <br>";
pg_free_result($result);

echo "<input type='submit' name='loan' value='Add' > </form>";
?>


<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
