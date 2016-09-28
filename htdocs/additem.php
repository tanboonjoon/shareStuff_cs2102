<html>
<head> <title>Add Item</title> </head>

<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1> Add Item for Lending</h1>
</td> </tr>

<?php
session_start();
include_once 'dbconnect.php';
?>

<tr>
<td style="background-color:#eeeeee;">
<form>
        Item Name <input type="text" name="ItemName" id="ItemName">

        Description <input type="text" name="Description" id="Description">

        <select name="Category"> <option value="Other">Select Category</option>

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

        Return Instruction <input type="text" name="ReturnInstruction" id="ReturnInstruction">

        Pick Up Instruction <input type="text" name="PickUpInstruction" id="PickUpInstruction">

        <input type="radio" name="BidType" id="BidType1" value="free">free
        <input type="radio" name="BidType" id="BidType2" value="withfee">with fee

        <input type="submit" name="formSubmit" value="Add" >
</form>

<?php

if(isset($_GET['formSubmit'])) 
{
    $query = "INSERT INTO item(item_name, owner, description, category,return_instruction,pickup_instruction, availability, bid_type) VALUES 
             ('".$_GET['ItemName']."',
              'tan@gmail.com',
              '".$_GET['Description']."',
              '".$_GET['Category']."',
              '".$_GET['ReturnInstruction']."',
              '".$_GET['PickUpInstruction']."',
              true,
              '".$_GET['BidType']."')";

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

</body>
</html>
