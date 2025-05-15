<?php
session_start();
include_once 'settings.php';
$conn = mysqli_connect($host, $username, $password, $database); // pass parametres to connect to the database
// check if the connection is successful
if (!$conn){
    die("Database connection failed: " .mysqli_connect_error());
}

// check if the user is logged in?, if ! route to login.php
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = trim($_POST['new_email']);
    // check if the email is valid
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: profile.php");
        exit();
    }

    // update the email in the database
    $query  = "UPDATE users SET email = '$new_email' WHERE username = '{$_SESSION['username']}'"; // primary key username, update the email field
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Update session data with the new email
        $_SESSION['email'] = $new_email;
        $_SESSION['success'] = "email updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating email";
    }
    header("Location: profile.php");
    exit();
}
?>