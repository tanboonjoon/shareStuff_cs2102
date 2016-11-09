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

if(isset($_POST['item'])) {
  $item_name = $_POST['item_name'];
  $owner = $_POST['owner'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $return_instruction = $_POST['return_instruction'];
  $pickup_instruction = $_POST['pickup_instruction'];
  $bid_type = $_POST['bid_type'];


  $query = "INSERT INTO item(item_name, owner, description, category, return_instruction, pickup_instruction, bid_type)
            VALUES ('{$item_name}', '{$owner}', '{$description}', '{$category}', '{$return_instruction}', '{$pickup_instruction}', '{$bid_type}')";

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
echo "You are adding an item";
echo "<p></p>";

echo "<form control='form' method='post' name='item' >";
echo "Item Name <input type='text' name='item_name' class='form-control'/>";
echo "Owner <select required name='owner'> <option value=''>Select Owner</option>";
$query = "SELECT email FROM users";
$result = pg_query($conn, $query) or die("Query Failed: '{pg_last_error()}'");
while($row = pg_fetch_array($result)) {
  echo "<option value= '{$row[0]}' > '{$row[0]}'</option>";
}
echo "</select> <br>";
pg_free_result($result);

echo "Description <input type='text' name='description' class='form-control'/>";

echo "Category <select required name='category'> <option value=''>Select Category</option>";
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

echo "Return Instruction <input type='text' name='return_instruction' class='form-control'/>";
echo "Pick Up Instruction <input type='text' name='pickup_instruction' class='form-control'/>";

echo "Bid Type <select required name='bid_type'> <option value=''>Select Bid Type</option>";
echo "<option value= 'free' > Free</option>
<option value= 'require fee' > Require Fee</option> </select> <br>";

echo "<input type='submit' name='item' value='Add' > </form>";
?>


<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
