<?php
session_start();
include_once 'settings.php';
$conn = mysqli_connect($host, $username, $password, $database); // pass parametres to connect to the database

// check if the user is logged in?, if ! route to login.php
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = trim($_POST['new_email']);

}

// update the email in the database
$query  = "UPDATE users SET email = '$new_email' WHERE username = '{$_SESSION['username']}'"; // primary key username, update the email field
$result = mysqli_query($conn, $query);



// Update session data with the new email
        $_SESSION['email'] = $new_email;


 // email has been updated now return to profile page
    header("Location: profile.php");
    exit();

?>