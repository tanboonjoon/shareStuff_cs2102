<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['is_admin']) != "") {
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
  $query = "SELECT i.ID, i.item_name, l.borrower, l.borrowed_date
            FROM item i, loan l
            WHERE l.owner = '{$email}'
            AND l.item_id = i.ID
            AND l.return_date IS NULL";       
  echo "<h1>Items currently on loan:</h1>";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  echo "<table border=\"1\">
          <col width=\"15%\">
          <col width=\"15%\">
          <col width=\"15%\">
          <col width=\"15%\">
          <tr>
            <th>item</th>
            <th>borrower</th>
            <th>borrowed date</th>
            <th>ACTIONS</th>
          </tr>";

  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='4'>No items are loaned.</td></tr> ";
  } else {
    while($row = pg_fetch_row($result)) {
      $itemID = $row[0];
      $itemName = $row[1];
      $borrower = $row[2];
      $borrowedDate = $row[3];

      echo "<td> '{$itemName}' </td>";
      echo "<td> '{$borrower}'</td>";
      echo "<td> '{$borrowedDate}'</td>";
      echo "<td> <a href=\"confirmReturn.php?id=$itemID\">Confirm Return</a> </td>";
      echo "</tr>";
    }
  }
  echo "</table><br>";
  pg_free_result($result);



  $itemsWithBidQuery = "SELECT i.*, COUNT(i.ID), MAX(b.bid_amount)
                        FROM item i, bid b
                        WHERE i.owner = '{$email}'
                        AND i.status = 'ongoing'
                        AND i.ID = b.item_id
                        GROUP BY i.ID, i.item_name, i.owner, i.description, i.category, i.return_instruction, i.pickup_instruction, i.status, i.bid_type";

  $itemsWithoutBidQuery = "SELECT i1.*
                           FROM item i1
                           WHERE i1.owner = '{$email}'
                           AND i1.status = 'ongoing'
                           AND i1.id <> ALL(SELECT i2.ID
                                            FROM item i2, bid b
                                            WHERE i2.owner = '{$email}'
                                            AND i2.status = 'ongoing'
                                            AND i2.ID = b.item_id
                                            GROUP BY i2.ID)";
  echo "<h1>Your items:</h1>";
  $resultWithBid = pg_query($conn, $itemsWithBidQuery) or die(pg_last_error());
  $resultWithoutBid = pg_query($conn, $itemsWithoutBidQuery) or die(pg_last_error());

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
            <th>description</th>
            <th>category</th>
            <th>pickup instruction</th>
            <th>return instruction</th>
            <th>bid type</th>
            <th>no. of bidders</th>
            <th>current max bid</th>
            <th>ACTIONS</th>
          </tr>";
  if(pg_num_rows($resultWithBid) == 0 && pg_num_rows($resultWithoutBid) == 0) {
    echo "<tr><td align='center' colspan='10'> You have yet to add any items for loaning </td></tr> ";
  } else {

    while($row = pg_fetch_row($resultWithBid)) {
      $itemID = $row[0];
      $itemName = $row[1];
      $owner = $row[2];
      $description = $row[3];
      $category = $row[4];
      $return = $row[5];
      $pickup = $row[6];
      $status = $row[7];
      $bidType = $row[8];
      $bidderCount = $row[9];
      $maxBid = $row[10];

      echo "<td> '{$itemName}' </td>";
      echo "<td> '{$description}'</td>";
      echo "<td> '{$category}'</td>";
      echo "<td> '{$pickup}'</td>";
      echo "<td> '{$return}'</td>";
      echo "<td> '{$bidType}'</td>";
      echo "<td> '{$bidderCount}'</td>";
      echo "<td> '{$maxBid}'</td>";
      echo "<td> <a href=\"addItem.php?id=$itemID&edit=1\">Edit</a>
            <br> <a href=\"deleteItem.php?id=$itemID\">Delete</a>
            <br> <a href=\"endBid.php?id=$itemID\">End Round</a>
            </td>";
      echo "</tr>";
    }

    while($row = pg_fetch_row($resultWithoutBid)) {
      $itemID = $row[0];
      $itemName = $row[1];
      $owner = $row[2];
      $description = $row[3];
      $category = $row[4];
      $return = $row[5];
      $pickup = $row[6];
      $status = $row[7];
      $bidType = $row[8];
      $bidderCount = 0;
      $maxBid = 0;

      echo "<td> '{$itemName}' </td>";
      echo "<td> '{$description}'</td>";
      echo "<td> '{$category}'</td>";
      echo "<td> '{$pickup}'</td>";
      echo "<td> '{$return}'</td>";
      echo "<td> '{$bidType}'</td>";
      echo "<td> '{$bidderCount}'</td>";
      echo "<td> '{$maxBid}'</td>";
      echo "<td> <a href=\"addItem.php?id=$itemID&edit=1\">Edit</a>
            <br> <a href=\"deleteItem.php?id=$itemID\">Delete</a>
            </td>";
      echo "</tr>";
    }

  }
  echo "</table><br>";
  pg_free_result($resultWithBid);
  pg_free_result($resultWithoutBid);



  $query = "SELECT i.item_name, i.ID, b.bid_amount, b.owner, b.status
            FROM item i, bid b
            WHERE b.item_id = i.ID
            AND b.bidder = '{$email}'";
  echo "<h1>Your bids:</h1>";
  $result = pg_query($conn, $query) or die(pg_last_error());

  echo "<table border=\"1\" >
        <col width=\"15%\">
        <col width=\"5%\">
        <col width=\"15%\">
        <col width=\"10%\">
        <col width=\"15%\">
        <tr>
          <th>item_name</th>
          <th>current bid</th>
          <th>owner</th>
          <th>status</th>
          <th>ACTIONS</th>
        </tr>";

  if(pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='5'>You have not bidded for any items.</td></tr> ";
  } else {
    while($row = pg_fetch_row($result)) {
      $itemName = $row[0];
      $itemID = $row[1];
      $amount = $row[2];
      $owner = $row[3];
      $status = $row[4];

      echo "<tr>";
      echo "<td> '{$itemName}'</td>";
      echo "<td> '{$amount}' </td>";
      echo "<td> '{$owner}'</td>";
      echo "<td> '{$status}'</td>";
      echo "<td>";
      if ($status != 'success') {
        echo "<a href=\"bidForItem.php?id=$itemID\">Change bid</a> </br>";
      }
      echo "<a href=\"deleteBidForItem.php?id=$itemID\">Remove</a> </td>";
      echo "</tr>";
    }
  }
  echo "</table><br>";
  pg_free_result($result);



  $query = "SELECT l.borrowed_date, i.item_name, i.owner, i.description, i.return_instruction, i.pickup_instruction
            FROM loan l, item i
            WHERE l.item_id = i.ID
            AND l.borrower = '" . $_SESSION['usr_email'] . "' ";
  echo "<h1>You are currently borrowing:</h1>";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  echo "<table border=\"1\" >
        <col width=\"10%\">
        <col width=\"10%\">
        <col width=\"20%\">
        <col width=\"10%\">
        <col width=\"10%\">
        <col width=\"10%\">
        <tr>
          <th>borrowed date</th>
          <th>item</th>
          <th>description</th>
          <th>owner</th>
          <th>pickup</th>
          <th>return</th>
        </tr>";
  if (pg_num_rows($result) == 0) {
    echo "<tr><td align='center' colspan='6'> You have no borrowed items. </td></tr> ";
  } else {
    while($row = pg_fetch_row($result)) {
      $borrowDate = $row[0];
      $itemName = $row[1];
      $owner = $row[2];
      $description = $row[3];
      $return = $row[4];
      $pickup = $row[5];

      echo "<tr>";
      echo "<td> '{$borrowDate}' </td>";
      echo "<td> '{$itemName}'</td>";
      echo "<td> '{$description}'</td>";
      echo "<td> '{$owner}'</td>";
      echo "<td> '{$pickup}'</td>";
      echo "<td> '{$return}'</td>";
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
