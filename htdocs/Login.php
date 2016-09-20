<?php
session_start();
if(isset($_SESSION['usr_email']) != "") {
	header("Location: index.php");
}

include_once 'dbconnect.php';

if(isset($_POST['login'])) {

	$email = pg_escape_string($_POST['email']);
	$password = pg_escape_string($_POST['password']);

	$query = " SELECT * FROM users WHERE email =  '{$email}' AND password_digest =  '{$password}' ";

	$result = pg_query($conn, $query);

	if($row = pg_fetch_array($result)) {
		$_SESSION['usr_email'] = $row[0];
		$_SESSION['usr_name'] = $row[1];

		$login = $row[4];
		if($login = true) {
			$_SESSION['is_admin'] = true;
		} 
		header("Location: index.php");
	} else {
		$failure = "Incorrect email or password";
	}
}

?>

<!DOCTYPE html>
<html>


<head>
    <title>PHP Login Script</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
			<fieldset>
				<legend>Login</legend>

				<div class="form-group">
					<label for="name">Email</label>
					<input type="text" name="email" required class="form-control" />
				</div>

				<div class="form-group">
					<label for="name">Password</label>
					<input type="password" name="password" required class="form-control"/>
				</div>

				<div class="form group">
					<input type="submit" name="login" value="Login" class="btn btn-primary" />
				</div>
			</fieldset>
			</form>

			<span class="text-danger"><?php if (isset($failure)) { echo $failure;} ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
			New User? <a href="signup.php">Sign Up Here</a>
		</div>
	</div>
</div>







<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>    
</body>


</html>
