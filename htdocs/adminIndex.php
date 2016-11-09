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
if(isset($_SESSION['usr_email'])) {



  $email = $_SESSION['usr_email'];
  $userQuery = "SELECT * FROM users";    
  echo "<h1>Users:</h1>";
  $result = pg_query($conn, $userQuery) or die("Query Failed: '{pg_last_error()}'");

  echo "<table border=\"1\">
  <col width=\"15%\">
  <col width=\"15%\">
  <col width=\"15%\">
  <col width=\"15%\">
  <tr>
    <th>email</th>
    <th>username</th>
    <th>password</th>
    <th>is_admin</th>
    <th>ACTIONS</th>
  </tr>";

  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='4'>No users exists.</td></tr> ";
  } else {
    while($row = pg_fetch_row($result)) {
      $email = $row[0];
      $username = $row[1];
      $password = $row[2];
      $is_admin = $row[3];

      echo "<td> '{$email}' </td>";
      echo "<td> '{$username}'</td>";
      echo "<td> '{$password}'</td>";
      echo "<td> '{$is_admin}'</td>";
      echo "<td> <a href=\"adminEdit.php?id=$email&edit=0\">Edit</a>
      <br> <a href=\"adminDeleteUser.php?id=$email\">Delete</a>
    </td>";
    echo "</tr>";
  }
}
echo "</table><br>";
pg_free_result($result);


$itemQuery = "SELECT * from item";

echo "<h1>Items:</h1>";
$itemResult = pg_query($conn, $itemQuery) or die("Query Failed: '{pg_last_error()}'");

echo "<table border=\"1\" >
<col width=\"4%\">
<col width=\"10%\">
<col width=\"6%\">
<col width=\"3%\">
<col width=\"3%\">
<col width=\"3%\">
<col width=\"1%\">
<col width=\"1%\">
<col width=\"5%\">
<tr>
  <th>item</th>
  <th>owner</th>
  <th>description</th>
  <th>category</th>
  <th>pickup instruction</th>
  <th>return instruction</th>
  <th>bid type</th>
  <th>status</th>
  <th>ACTIONS</th>
</tr>";
if(pg_num_rows($itemResult) == 0) {
  echo "<tr><td align='center' colspan='10'> there is no item </td></tr> ";
} else {

  while($row = pg_fetch_row($itemResult)) {
    $itemID = $row[0];
    $itemName = $row[1];
    $owner = $row[2];
    $description = $row[3];
    $category = $row[4];
    $return = $row[5];
    $pickup = $row[6];
    $status= $row[7];
    $bidType = $row[8];


    echo "<td> '{$itemName}' </td>";
    echo "<td> '{$owner}' </td>";
    echo "<td> '{$description}'</td>";
    echo "<td> '{$category}'</td>";
    echo "<td> '{$pickup}'</td>";
    echo "<td> '{$return}'</td>";
    echo "<td> '{$bidType}'</td>";
    echo "<td> '{$status}'</td>";
    echo "<td> <a href=\"adminEdit.php?id=$itemID&owner=$owner&edit=1\">Edit</a>
    <br> <a href=\"adminDeleteItem.php?id=$itemID&owner=$owner\">Delete</a>
  </td>";
  echo "</tr>";
}



}
echo "</table><br>";
pg_free_result($itemResult);




$bidQuery = "SELECT bid_amount, bidder, item_id, owner, status FROM bid";
echo "<h1>Bids:</h1>";
$result = pg_query($conn, $bidQuery) or die(pg_last_error());

echo "<table border=\"1\" >
<col width=\"15%\">
<col width=\"5%\">
<col width=\"15%\">
<col width=\"10%\">
<col width=\"10%\">
<col width=\"15%\">
<tr>
  <th>bid_amount</th>
  <th>bidder</th>
  <th>item_id</th>
  <th>owner</th>
  <th>status</th>
  <th>ACTIONS</th>
</tr>";

if(pg_num_rows($result) == 0) {
  echo "<tr><td align='center' colspan='6'>There is no bid.</td></tr> ";
} else {
  while($row = pg_fetch_row($result)) {
    $bidAmount = $row[0];
    $bidder= $row[1];
    $item_id = $row[2];
    $owner = $row[3];
    $status = $row[4];

    echo "<tr>";
    echo "<td> '{$bidAmount}'</td>";
    echo "<td> '{$bidder}' </td>";
    echo "<td> '{$item_id}'</td>";
    echo "<td> '{$owner}'</td>";
    echo "<td> '{$status}'</td>";
    echo "<td> <a href=\"adminEdit.php?id=$item_id&owner=$owner&bidder=$bidder&edit=2\">Edit</a>
    <br> <a href=\"adminDeleteBid.php?id=$item_id&owner=$owner&bidder=$bidder\">Delete</a>
  </td>";
  echo "</tr>";
}
}
echo "</table><br>";
pg_free_result($result);



$loanQuery = "SELECT * FROM loan";
echo "<h1>Loan:</h1>";
$result = pg_query($conn, $loanQuery) or die("Query Failed: '{pg_last_error()}'");

echo "<table border=\"1\" >
<col width=\"10%\">
<col width=\"10%\">
<col width=\"20%\">
<col width=\"10%\">
<col width=\"10%\">
<col width=\"10%\">
<tr>
  <th>return_date</th>
  <th>borrowed_date</th>
  <th>item_id</th>
  <th>owner</th>
  <th>borrower</th>
  <th>ACTIONS</th>
</tr>";
if (pg_num_rows($result) == 0) {
  echo "<tr><td align='center' colspan='6'> There is no loan. </td></tr> ";
} else {
  while($row = pg_fetch_row($result)) {
    $return_date = $row[0];
    $borrowed_date = $row[1];
    $item_id = $row[2];
    $owner = $row[3];
    $borrower = $row[4];

    echo "<tr>";
    echo "<td> '{$return_date}'</td>";
    echo "<td> '{$borrowed_date}'</td>";
    echo "<td> '{$item_id}'</td>";
    echo "<td> '{$owner}'</td>";
    echo "<td> '{$borrower}'</td>";
    echo "<td> <a href=\"adminEdit.php?id=$item_id&owner=$owner&borrower=$borrower&edit=3\">Edit</a>
    <br> <a href=\"adminDeleteLoan.php?id=$item_id&owner=$owner&borrower=$borrower\">Delete</a>
  </td>";
    echo "</tr>";
  }
}
echo "</table><br>";
pg_free_result($result);



}
?>

<?php
pg_close($conn);
?>


<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
