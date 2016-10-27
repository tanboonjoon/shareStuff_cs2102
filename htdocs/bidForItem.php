<?php
session_start();
include_once 'dbconnect.php';

if(isset($_POST['bid'])) {
	$creationTime = pg_escape_string(date('Y-m-d'));
	$bidAmount = (int) $_POST['bidAmount'];
	$itemID = (int) $_GET['id'];
	$owner = pg_escape_string($_POST['owner']);
	$status = pg_escape_string('pending');

	if($_GET['new'] == 1) {
		$query = "INSERT INTO bid
			  	  VALUES('$creationTime', 
			  		 	 '{$bidAmount}',
			  		 	 '" . $_SESSION['usr_email'] . "',
			  		 	 '{$itemID}', 
			  		 	 '$owner', 
			  		 	 '$status')";
	} else {
		$query = "UPDATE bid
				  SET bid_amount = $bidAmount
				  WHERE bidder = '" . $_SESSION['usr_email'] . "'";
	}
	pg_query($conn, $query) or die (pg_last_error());
	header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Bidding Page</title>

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

			$id = (int) $_GET['id'];
			$query = "SELECT * FROM item WHERE id = '{$id}' ";
			$result = pg_query($conn, $query);

			if($itemRow = pg_fetch_array($result)) {				
				echo "itemName : {$itemRow[1]} <br>
				Owner : {$itemRow[2]} <br>
				Descripition : {$itemRow[3]} <br>
				Category : {$itemRow[4]} <br>
				Return instruction : {$itemRow[5]} <br>
				Pickup instruction : {$itemRow[6]} <br>
				bid_type : {$itemRow[8]} <br>";

				$query = "SELECT COUNT(DISTINCT bidder), MAX(bid_amount)
						  FROM bid
						  WHERE item_id = '{$id}' ";
				$result = pg_query($conn, $query);
				if($countRow = pg_fetch_array($result)) {
					echo "Number of bidders : {$countRow[0]} <br>
						  Current highest bid : {$countRow[1]} <br>";
				} else {
					echo "Number of bidders : 0 <br>
						  Current highest bid : 0 <br>";
				}

				$query = "SELECT bid_amount
						  FROM bid
						  WHERE item_id = '{$id}'
						  AND bidder = '" . $_SESSION['usr_email'] . "'";
				$result = pg_query($conn, $query);
				if($bidRow = pg_fetch_array($result)) {
					echo "Your current bid : {$bidRow[0]} <br>";
				} else {
					echo "Your current bid : 0 <br>";
				}

				echo "<form control='form' method='post' name='bid' >
				<input type ='hidden' name ='owner' value = {$itemRow[2]} >
				Bid Amount <input type='number' name='bidAmount' id='bidAmount' min='1' required class='form-control'>
				<input type='submit' name='bid' value='bid' > </form>";
			}



			?>
			<span class="text-danger"><?php if (isset($failure)) { echo $failure;} ?></span>


			<script src="js/jquery-1.10.2.js"></script>
			<script src="js/bootstrap.min.js"></script>





		</body>
		</html>
