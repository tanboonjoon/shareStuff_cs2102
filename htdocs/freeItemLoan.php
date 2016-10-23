<?php
session_start();
include_once 'dbconnect.php';



if(isset($_POST['borrow'])) {
	$borrowerID = pg_escape_string($_POST['borrowerID']);
	$itemID = pg_escape_string($_POST['itemID']);
	$owner = pg_escape_string($_POST['owner']);
	$timestamp = date('Y-md G:i:s');
	$id = (int) $_GET['id'];

	$query = "INSERT INTO loan values({$timestamp} , {$timestamp} , {$id}, {$owner}, {$borrowerID})";
	$result = pg_query($conn, $query);

	if($row = pg_fetch_array($result)) {
		header('Location: index.php');
	} else {
		echo  pg_result_error($result);
	}

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Lending Page</title>

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
			$query = " SELECT * FROM users WHERE email =  '{$email}' AND password_digest =  '{$password}' ";

			$query = "SELECT * FROM item i WHERE i.id = '{$id}' ";
			$result = pg_query($conn, $query);

			if($row = pg_fetch_array($result)) {
				

				echo "itemName : {$row[1]} <br>
				Owner : {$row[2]} <br>
				Descripition : {$row[3]} <br>
				Category : {$row[4]} <br>
				Return instruction : {$row[5]} <br>
				Pickup instruction : {$row[6]} <br>
				bid_type : {$row[8]} <br>";

				$borrowerEmail = $_SESSION['usr_email'];

				echo "<form control='form' method='post' name='borrow' >
				<input type='hidden' name ='borrowerID' value ='{$borrowerEmail}>
				<input type ='hidden' name ='itemID' value = {$id} >
				<input type ='hidden' name ='owner' value = {$row[2]} >
				<input type='submit' name='borrow' value='borrow' > </form>"; 
			}


			?>
			<span class="text-danger"><?php if (isset($failure)) { echo $failure;} ?></span>


			<script src="js/jquery-1.10.2.js"></script>
			<script src="js/bootstrap.min.js"></script>





		</body>
		</html>
