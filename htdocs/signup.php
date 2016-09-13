<?php
session_start();

if(isset($_SESSION['usr_email'])) {
    header("Location: index.php");
}

include_once 'dbconnect.php';

if(isset($_POST['signup'])) {

    $email = pg_escape_string($_POST['email']);
    $name = pg_escape_string( $_POST['name']);
    $password = pg_escape_string($_POST['password']);


    $query = "INSERT INTO users VALUES('{$email}', '{$name}', '{$password}', false)";
    $result = pg_query($conn, $query);

    if(!$result) {
        $failure = "Email already exist :(";
    } else {
        $success = "Account created! <a href='login.php'>Click here to login now</a>";
 
    }
}

?>
<!DOCTYPE html>
<html>


<head>
    <title>Registration</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 well">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                    method="post" name="signup">
                    <fieldset>
                        <legend>Sign Up</legend>

                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" name="email" required value="<?php echo $email; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" required value="<?php echo $name; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" required value ="<?php echo $password; ?>" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="signup" value="Sign Up" class ="btn btn-primary"/>
                        </div>
                    </fieldset>
                </form>

                <span class="text-success"><?php if(isset($success)) { echo $success;} ?></span>
                <span class="text-danger"><?php if(isset($failure)) { echo $failure;} ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center">
                Already Registered? <a href="login.php">Login Here</a>
            </div>
        </div>
    </div>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>



    
</body>


</html>
