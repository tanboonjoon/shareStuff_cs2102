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
        Item Name <input type="text" name="Keyword" id="Keyword">

        <select name="Category"> <option value="">Select Category</option>
        <?php
        $query = 'SELECT DISTINCT category FROM item';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
           foreach ($line as $col_value) {
              echo "<option value=\"".$col_value."\">".$col_value."</option><br>";
            }
        }
        pg_free_result($result);
        ?>
        </select>

        <input type="radio" name="BidType" id="BidType1" value="free">free
        <input type="radio" name="BidType" id="BidType2" value="paid">paid

        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(isset($_GET['formSubmit'])) 
{ 
    $query = "SELECT * FROM item WHERE item_name like '%".$_GET['Keyword']."%' AND category='".$_GET['Category']."' AND bid_type='".$_GET['BidType']."'";
    echo "<b>SQL:   </b>".$query."<br><br>";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <tr>
    <th>ID</th>
    <th>Item</th>
    <th>Owner</th>
    <th>Category</th>
    <th>Description</th>
    <th>Pick up instruction</th>
    <th>Return instruction</th>
    <th>Availability</th>
    <th>Bid type</th>
    </tr>";


    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      $arrlength = count($row);
      for ($i = 0; $i < $arrlength; $i++) {
        echo "<td>" . $row[$i] . "</td>";
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
