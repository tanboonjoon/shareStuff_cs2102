<html>
<head> 
    <title>Online Item Catalog</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>
    <tr> <td colspan="2" style="background-color:#FFA500;">
        <h1> Online Item Catalog</h1>
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
              <li><a href="additem.php">Add Items for Lending</a></li>
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
            <div class = "container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            Item Name <input type="text" name="Keyword" id="Keyword" required class="form-control">

                            <select name="Category"> <option value="All">All</option>

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


                            </select>
                            <label class="radio-inline">
                                <input type="radio" name="BidType" id="BidType1" value="free" checked>free 
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="BidType" id="BidType2" value="require fee">require fee
                            </label>
                           lo <input type="submit" name="formSubmit" value="Search" >
                        </form>
                        <?php

                        if(isset($_GET['formSubmit'])) 

                        {   
                            $email = $_SESSION['usr_email'];
                            if(strcasecmp("All", $_GET['Category']) == 0) {
                                $query =  "SELECT * FROM item WHERE item_name like '%".$_GET['Keyword']."%' AND  bid_type='".$_GET['BidType']."' AND status = 'ongoing' AND owner <> '{$email}'";
                            } else {
                                $query = "SELECT * FROM item WHERE item_name like '%".$_GET['Keyword']."%' AND category='".$_GET['Category']."' AND bid_type='".$_GET['BidType']."' AND status = 'ongoing' AND owner <> '{$email}'";
                            }

                            echo "<b>Search result for your item <br><br>";
                            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                            echo "<table border=\"1\" >
                            <tr>
                                <th>ID</th>
                                <th>Item</th>
                                <th>Owner</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Pick up instruction</th>
                                <th>Return instruction</th>
                                <th>Bid type</th>
                                <th></th>
                            </tr>";

                            if(pg_num_rows($result) == 0) {
                                echo "<tr><td align='center' colspan ='8'> No one is currently trying to lend out the item you are searching for </td></tr>";
                            }
                            while ($row = pg_fetch_row($result)){
                              echo "<tr>";
                              $arrlength = count($row);
                              $itemId = $row[0];
                                for ($i = 0; $i < $arrlength; $i++) {
                                    if($i == 7) {

                                    }else {
                                    echo "<td>" . $row[$i] . "</td>";

                                    }
                                }
                            $free = 'free';
                            $fee = 'require fee';
                            
                            if (strcmp($row[8], $free) == 0)  {
                                echo "<td> <a href=\"freeItemLoan.php?id=$itemId\">Borrow</a> </td>"; 
                            } else {
                                $query = "SELECT *
                                          FROM bid
                                          WHERE bidder = '" . $_SESSION['usr_email'] . "'";
                                $bidResult = pg_query($conn, $query);
                                if(pg_num_rows($bidResult) == 0) {
                                    echo "<td> <a href=\"bidForItem.php?id=$itemId&new=1\">Bid</a> </td>";
                                } else {
                                    echo "<td> <a href=\"bidForItem.php?id=$itemId\">Change bid</a> </td>";
                                }
                                pg_free_result($bidResult);                             
                            }

                            
                            echo "</tr>";
                        }
                        echo "</table>";

                        pg_free_result($result);
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
            </div>
        </div>
    </div>

</body>
</html>
