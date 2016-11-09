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

if(isset($_POST['item'])) {
  $id = $_POST['id'];
  $name = $_POST['item_name'];
  $owner = $_POST['owner'];
  $description = $_POST['description'];
  $cateogry = $_POST['category'];
  $return = $_POST['return_instruction'];
  $pickup = $_POST['pickup_instruction'];
  $status = $_POST['status'];
  $bidtype = $_POST['bid_type'];

  $query = "UPDATE item
            SET item_name = '{$name}', description = '{$description}', category = '{$cateogry}', return_instruction = '{$return}', pickup_instruction = '{$pickup}', status = '{$status}', bid_type = '{$bidtype}'
            WHERE ID = '{$id}' AND owner = '{$owner}'";
  pg_query($conn, $query) or die (pg_last_error());
  header("Location: adminIndex.php");
}

if(isset($_POST['bid'])) {

  $time = $_POST['creation_time'];
  $bid = (int) $_POST['bid_amount'];
  $bidder = $_POST['bidder'];
  $id = $_POST['item_id'];
  $owner = $_POST['owner'];
  $status = $_POST['status'];

  $query = "UPDATE bid
            SET creation_time = '{$time}', bid_amount = '{$bid}', status = '{$status}'
            WHERE item_id = '{$id}' AND owner = '{$owner}' AND bidder = '{$bidder}'";
  pg_query($conn, $query) or die (pg_last_error());
  header("Location: adminIndex.php");
}

if(isset($_POST['loan'])) {

  $return = $_POST['return_date'];
  $borrow = $_POST['borrowed_date'];  
  $id = $_POST['item_id'];
  $owner = $_POST['owner'];
  $borrower = $_POST['borrower'];

  $query = "UPDATE loan
            SET return_date = '{$return}', borrowed_date = '{$borrow}'
            WHERE item_id = '{$id}' AND owner = '{$owner}' AND borrower = '{$borrower}'";
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
$edit = (int) $_GET['edit'];

if ($edit == 0) {
  echo "You are editing a user";

  $id = $_GET['id'];
  $query = "SELECT * FROM users WHERE email = '{$id}' ";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  if($row = pg_fetch_array($result)) {        
    echo "<form control='form' method='post' name='users' >";
    echo "<input type ='hidden' name ='id' value = '{$id}' >";
    echo "Email <input type='text' name='email' value='{$row[0]}' class='form-control'/>";
    echo "Name <input type='text' name='name' value='{$row[1]}' class='form-control'/>";
    echo "Password <input type='text' name='password' value='{$row[2]}' class='form-control'/>";
    echo "Is Admin <select required name='isAdmin'> <option value='{$row[3]}'>'{$row[3]}'</option>";
    if ($row[3] == 't') {
      echo "<option value= 'false' > 'f'</option>";
    } else {
      echo "<option value= 'true' > 't'</option>";
    }
    echo "</select> <br>";
    echo "<input type='submit' name='users' value='Edit' > </form>";
  }
  pg_free_result($result);

}else if ($edit == 1) {
  echo "You are editing an item";

  $id = $_GET['id'];
  $owner = $_GET['owner'];
  $query = "SELECT * FROM item WHERE ID = '{$id}' AND owner = '{$owner}'";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  if($row = pg_fetch_array($result)) {        
    echo "<form control='form' method='post' name='item' >";
    echo "<input type ='hidden' name ='id' value = '{$id}' >";
    echo "Item Name <input type='text' name='item_name' value='{$row[1]}' class='form-control'/>";
    echo "<input type ='hidden' name ='owner' value = '{$owner}' >";
    echo "Description <input type='text' name='description' value='{$row[3]}' class='form-control'/>";

    echo "Category <select required name='category'> <option value='{$row[4]}'>Select Category</option>";
    echo "<option value= 'Tools & Gardening' > Tools & Gardening</option>
          <option value= 'Sport & Outdoors' > Sport & Outdoors</option>
          <option value= 'Parties & Events' > Parties & Events</option>
          <option value= 'Apparel & Accessories' > Apparel & Accessories</option>
          <option value= 'Kids & Baby' > Kids & Baby</option>
          <option value= 'Electronic' > Electronic</option>
          <option value= 'Movies, Music, Book & Games' > Movies, Music, Book & Games</option>
          <option value= 'Motor Vehicles' >Motor Vehicles </option>
          <option value= 'Arts and Crafts' >Arts and Crafts </option>
          <option value= 'Home & Appliances' > Home & Appliances</option>
          <option value= 'Office & Education' > Office & Education</option>
          <option value= 'Spaces & Venues' > Spaces & Venues</option>
          <option value= 'Other' > Other</option> </select> <br>";

    echo "Return Instruction <input type='text' name='return_instruction' value='{$row[5]}' class='form-control'/>";
    echo "Pick Up instruction <input type='text' name='pickup_instruction' value='{$row[6]}' class='form-control'/>";

    echo "Status <select required name='status'> <option value='{$row[7]}'>Select Status</option>";
    echo "<option value= 'ongoing' > Ongoing</option>
          <option value= 'over' > Over</option> </select> <br>";

    echo "Bid Type <select required name='bid_type'> <option value='{$row[8]}'>Select Bid Type</option>";
    echo "<option value= 'free' > Free</option>
          <option value= 'require fee' > Require Fee</option> </select> <br>";

    echo "<input type='submit' name='item' value='Edit' > </form>";
  }
  pg_free_result($result);

}else if ($edit == 2) {

  echo "You are editing a bid";

  $id = $_GET['id'];
  $owner = $_GET['owner'];
  $bidder = $_GET['bidder'];
  $query = "SELECT * FROM bid WHERE item_id = '{$id}' AND owner = '{$owner}' AND bidder = '{$bidder}'";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  if($row = pg_fetch_array($result)) {        
    echo "<form control='form' method='post' name='bid' >";
    echo "Creation Time <input type='text' name='creation_time' value='{$row[0]}' class='form-control'/>";
    echo "Bid Amount <input type='text' name='bid_amount' value='{$row[1]}' class='form-control'/>";
    echo "<input type ='hidden' name ='bidder' value = '{$bidder}' >";
    echo "<input type ='hidden' name ='item_id' value = '{$id}' >";
    echo "<input type ='hidden' name ='owner' value = '{$owner}' >";
    echo "Status <input type='text' name='status' value='{$row[5]}' class='form-control'/>";
    echo "<input type='submit' name='bid' value='Edit' > </form>";
  }
  pg_free_result($result);

}else if ($edit == 3) {

  echo "You are editing a loan";

  $id = $_GET['id'];
  $owner = $_GET['owner'];
  $borrower = $_GET['borrower'];
  $query = "SELECT * FROM loan WHERE item_id = '{$id}' AND owner = '{$owner}' AND borrower = '{$borrower}'";
  $result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");

  if($row = pg_fetch_array($result)) {        
    echo "<form control='form' method='post' name='loan' >";
    echo "Return Date <input type='text' name='return_date' value='{$row[0]}' class='form-control'/>";
    echo "Borrow Date <input type='text' name='borrowed_date' value='{$row[1]}' class='form-control'/>";    
    echo "<input type ='hidden' name ='item_id' value = '{$id}' >";
    echo "<input type ='hidden' name ='owner' value = '{$owner}' >";
    echo "<input type ='hidden' name ='borrower' value = '{$borrower}' >";
    echo "<input type='submit' name='loan' value='Edit' > </form>";
  }
  pg_free_result($result);
}

?>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
