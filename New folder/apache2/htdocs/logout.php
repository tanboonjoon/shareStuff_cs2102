<?php
session_start();

if(isset($_SESSION['usr_email'])) {
    session_destroy();
    unset($_SESSION['usr_email']);
    unset($_SESSION['usr_name']);
    header("Location: login.php");
} else {
    header("Location: login.php");
}
?>