<html>
<head> 
  <title>Add Item</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" >
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" /> 
</head>

<body>

  <tr> <td colspan="2" style="background-color:#FFA500;">
    <h1> Add Item for Lendings</h1>
  </td> </tr>

  <?php
  session_start();
  include_once 'dbconnect.php';
  ?>

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
      <li><a href="index.php">Home</a></li>
      <li><a href="search-item.php">Search Online Item Catalogue</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <?php } else { ?>
        <li><a href="login.php">Log In</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <?php } ?>
      </ul>
    </div>

  </div>
</nav>



<table>


  <tr>
    <td style="background-color:#eeeeee;">
      <div class="container-fluid">
        <div class ="row">
          <div class="col-md-6">


            <form>
              Item Name <input type="text" name="ItemName" id="ItemName"> <br>

              Description <input type="text" name="Description" id="Description"> <br>

              Category <select required name="Category"> <option value="">Select Category</option>

              <option value= "Tools & Gardening" > Tools & Gardening</option>
              <option value= "Sport & Outdoors" > Sport & Outdoors</option>
              <option value= "Parties & Events" > Parties & Events</option>
              <option value= "Apparel & Accessories" > Apparel & Accessories</option>
              <option value= "Kids & Baby" > Kids & Baby</option>
              <option value= "Electronic" > Electronic</option>
              <option value= "Movies, Music, Book & Games" > Movies, Music, Book & Games</option>
              <option value= "Motor Vehicles" >Motor Vehicles </option>
              <option value= "Arts and Crafts" >Arts and Crafts </option>
              <option value= "Home & Appliances" > Home & Appliances</option>
              <option value= "Office & Education" > Office & Education</option>
              <option value= "Spaces & Venues" > Spaces & Venues</option>
              <option value= "Other" > Other</option>


            </select><br>

            Return Instruction <input type="text" name="ReturnInstruction" id="ReturnInstruction"> <br>

            Pick Up Instruction <input type="text" name="PickUpInstruction" id="PickUpInstruction"> <br>

            <input type="radio" name="BidType" id="BidType1" value="free" checked="">free 
            <input type="radio" name="BidType" id="BidType2" value="require fee">with fee
            <br>
            <?php
              $id = (int) $_GET['id'];
              $edit = (int) $_GET['edit'];
              echo "<input type ='hidden' name ='id' value = {$id} >";
              echo "<input type ='hidden' name ='edit' value = {$edit} >";
            ?>
            <input type="submit" name="formSubmit" value="Add" >
          </form>
        </div>
      </div>
    </div>
    <?php

    if(isset($_GET['formSubmit'])) {
      $edit = (int) $_GET['edit'];
      if($edit == 1) {
        $itemID = (int) $_GET['id'];
        $query = "UPDATE item
                 SET item_name = '".$_GET['ItemName']."', description = '".$_GET['Description']."', category = '".$_GET['Category']."',
                     return_instruction = '".$_GET['ReturnInstruction']."', pickup_instruction = '".$_GET['PickUpInstruction']."',
                     bid_type = '".$_GET['BidType']."'
                 WHERE ID = '{$itemID}'";
      } else {
        $query = "INSERT INTO item(item_name, owner, description, category,return_instruction,pickup_instruction, availability, bid_type)
                  VALUES ('".$_GET['ItemName']."', '{$_SESSION['usr_email']}', '".$_GET['Description']."', '".$_GET['Category']."',
                          '".$_GET['ReturnInstruction']."', '".$_GET['PickUpInstruction']."', true, '".$_GET['BidType']."')";
      }
      echo "<b>SQL:   </b>".$query."<br><br>";
      pg_query($query) or die('Query failed: ' . pg_last_error());
    }
    ?>

  </td> </tr>
  <?php
  pg_close($dbconn);
  ?>
  <tr>
    <td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
    </td> </tr>
  </table>


  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>    
</body>
</html>
