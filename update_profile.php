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
    $statement = mysqli_prepare($conn, "UPDATE users SET email = ? WHERE username = ?"); // ? is a placeholder for the data to be inserted later
    mysqli_stmt_bind_param($statement, "ss", $new_email, $_SESSION['username']); // Binding the parameters to the statement (insert the data as strings)
    $result = mysqli_stmt_execute($statement);
    mysqli_close($conn); // Close the database connection
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