<html>
<head> <title>Online Item Catalog</title> </head>

<body>
    <table>
        <tr> <td colspan="2" style="background-color:#FFA500;">
            <h1> Online Item Catalog</h1>
        </td> </tr>

        <?php
        session_start();
        include_once 'dbconnect.php';
        ?>

        <tr>
            <td style="background-color:#eeeeee;">
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

                    <input type="radio" name="BidType" id="BidType1" value="free" checked>free
                    <input type="radio" name="BidType" id="BidType2" value="require fee">require fee

                    <input type="submit" name="formSubmit" value="Search" >
                </form>
                <?php

                if(isset($_GET['formSubmit'])) 
                {   

                    if(strcasecmp("All", $_GET['Category']) == 0) {
                        $query =  "SELECT * FROM item WHERE item_name like '%".$_GET['Keyword']."%' AND  bid_type='".$_GET['BidType']."' AND availability = true";
                    } else {
                        $query = "SELECT * FROM item WHERE item_name like '%".$_GET['Keyword']."%' AND category='".$_GET['Category']."' AND bid_type='".$_GET['BidType']."' AND availability = true ";
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
                    </tr>";

                    if(pg_num_rows($result) == 0) {
                        echo "<tr><td align='center' colspan ='8'> No one is currently trying to lend out the item you are searching for </td></tr>";
                    }
                    while ($row = pg_fetch_row($result)){
                      echo "<tr>";
                      $arrlength = count($row);
                      for ($i = 0; $i < $arrlength; $i++) {
                        if($i == 7) {

                        }else {
                            echo "<td>" . $row[$i] . "</td>";
                        }

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

    </body>
    </html>
