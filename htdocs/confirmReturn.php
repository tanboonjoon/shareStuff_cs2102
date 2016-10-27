<?php
session_start();
include_once 'dbconnect.php';


if(isset($_POST['comfirmReturn'])) {
	$borrowerID = pg_escape_string($_POST['borrowerID']);
	$itemID = pg_escape_string($_POST['itemID']);
	$owner = $_SESSION['usr_email'];

	$query = "DELETE FROM loan WHERE item_id = '{$itemID}'";
	$result = pg_query($conn, $query) or die (pg_last_error());


	$query = "UPDATE item SET availability = true WHERE ID = '{$itemID}'";
	pg_query($conn, $query) or die (pg_last_error());
	header("Location: index.php");


}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ending bid</title>

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

	

			$query = "SELECT l.item_id ,l.borrower ,i.item_name FROM loan l , item i WHERE l.item_id = i.ID AND l.item_id = '{$id}'";


			$result = pg_query($conn, $query) or die (pg_last_error());
			if($row = pg_fetch_array($result)) {


			echo "item_id : {$row[0]} <br>
			item_name : {$row[2]} <br>
			Borrower : {$row[1]} <br>";


			echo "<form control='form' method='post' name='comfirmReturn' >
			<input type ='hidden' name ='itemID' value = {$id} >
			<input type ='hidden' name ='borrowerID' value = {$row[1]} >
			<input type='submit' name='comfirmReturn' value='comfirmReturn' > </form>"; 
		}
		?>
		<span class="text-danger"><?php if (isset($failure)) { echo $failure;} ?></span>


		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/bootstrap.min.js"></script>





	</body>
	</html>
