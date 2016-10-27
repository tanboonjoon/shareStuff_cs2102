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
   <ul class="nav navbar-nav navbar-right">
    <?php if (isset($_SESSION['usr_email'])) { ?>
      <li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?> </p></li>
      <li><a href="logout.php">Log Out</a></li>
      <li><a href="search-item.php">Search Online Item Catalogue</a></li>
      <li><a href="additem.php">Add Items for Lending</a></li>
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
  $query = "SELECT * FROM item WHERE owner = '{$email}' ";


  echo "<b>Item that you are currently trying to lend out!<br></br>";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  echo "<table border=\"1\" >
  <col width=\"10%\">
  <col width=\"10%\">
  <col width=\"20%\">
  <col width=\"19%\">
  <col width=\"19%\">
  <col width=\"15%\">
  <col width=\"5%\">
  <tr>
    <th>ID</th>
    <th>item_name</th>
    <th>description</th>
    <th>return_instruction</th>
    <th>pickup_instructionn</th>
    <th>current MaxBid</th>
    <th>Actions</th>
  </tr>";
  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='7'> All your items are currently loaned out OR you did not lend any item at all </td></tr> ";
  }


  while($row = pg_fetch_row($result)) {
    $id = $row[0];
    $item_name = $row[1];
    $desc = $row[3];
    $pickup = $row[5];
    $return = $row[6];
    $availability = $row[7];

    echo "<td> '{$id}' </td>";
    echo "<td> '{$item_name}'</td>";
    echo "<td> '{$desc}'</td>";
    echo "<td> '{$pickup}'</td>";
    echo "<td> '{$return}'</td>";
    if ($availability == 'f') {
      echo "<td> NA </td>";
      echo "<td> <a href=\"confirmReturn.php?id=$id\">Confirm Return</a> </td>";
    } else {
      $query2 = "SELECT MAX(bid_amount) FROM bid WHERE item_id = '{$id}' ";
      $maxResult = pg_query($conn, $query2) or die (pg_last_error());
      if ($maxRow = pg_fetch_row($maxResult)) {
        echo "<td> '$maxRow[0]' </td> ";

      } else {
        echo "<td> 0 </td> ";
      }

      echo "<td> <a href=\"endBid.php?id=$arr\">End Bid</a> </td>";
    }
    echo "</tr>";

  }
  echo "</table>";
  pg_free_result($result);

   $query ="SELECT max(b.bid_amount), b.item_id, i.item_name FROM bid b, item i WHERE b.item_id = i.ID AND b.bidder = '{$email}' AND b.status = 'pending' GROUP BY b.item_id, i.item_name";
  echo "<p><b><br></br></p>";
  echo "<p>Item that you are currently trying to bid for !</p>";
  $result = pg_query($conn, $query) or die(pg_last_error());


  echo "<table border=\"1\" >
  <col width=\"20%\">
  <col width=\"30%\">
  <col width=\"30%\">

  <tr>
    <th>curerent bid</th>
    <th>item_id</th>
    <th>item_name</th>
    <th>actions</th>
  </tr>";

  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='4'> you are not bidding for any item currently  </td></tr> ";
  }

  while($row = pg_fetch_row($result)) {
    $amount = $row[0];
    $itemID = $row[1];
    $itemName = $row[2];


    echo "<tr>";
    echo "<td> '{$amount}' </td>";
    echo "<td> '{$itemID}'</td>";
    echo "<td> '{$itemName}'</td>";
    echo "<td>
          <a href=\"bidForItem.php?id=$itemID\">Change bid</a> </br>
          <a href=\"deleteBidForItem.php?id=$itemID\">Remove</a>
          </td>";
    echo "</tr>";
  }
  echo "</table>";
  pg_free_result($result);


  $query = "SELECT l.borrowed_date, l.item_id , i.item_name , l.owner FROM loan l, item i  
  WHERE l.item_id = i.ID AND l.borrower = '" . $_SESSION['usr_email'] . "' ";
  echo "<b>Item that you are currently borrowing!<br></br>";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  echo "<table border=\"1\" >
  <col width=\"10%\">
  <col width=\"10%\">
  <col width=\"20%\">
  <tr>
    <th>borrowed_date</th>
    <th>item_id</th>
    <th>item_name</th>
    <th>owner</th>
  </tr>";
  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='7'> You have return all borrowed item or have not borrowed any </td></tr> ";
  }

  while($row = pg_fetch_row($result)) {
    $return = $row[0];
    $id = $row[1];
    $name = $row[2];
    $owner = $row[3];

    echo "<tr>";
    echo "<td> '{$return}' </td>";
    echo "<td> '{$id}'</td>";
    echo "<td> '{$name}'</td>";
    echo "<td> '{$owner}'</td>";
    echo "</tr>";
  }
  echo "</table>";
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
