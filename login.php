<?php
session_start();

require_once 'settings.php';   

$conn = mysqli_connect($host, $username, $password, $database); // pass parametres to connect to the database

if (!$conn){
    die("Database connection failed: " .mysqli_connect_error());
}
include "header.inc"
?>



<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    $query = "SELECT * FROM users WHERE username = '$input_username' AND password = '$input_password'";
    $result = mysqli_query($conn, $query);

    if($user = mysqli_fetch_assoc($result)){
        $_SESSION['username'] = $user['username']; // Store username in session
        $_SESSION['email'] = $user['email']; // Store email in session

        if($user['username'] == 'john'){
            header("Location: profile.php");
            exit();
          }else{
            $_SESSION['error'] = "User does access not allowed!"; // only john can access the profile page
          }
        }else{
          $_SESSION['error'] = "**Invalid username or password**";  // incorrect username or password
    }
}
// Check if there is an error message to display
if (isset($_SESSION['error'])) {
    echo "<p>{$_SESSION['error']}</p>";
    unset($_SESSION['error']);
}
?>


<h2>Login</h2>
<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>
<br><br>
<a href="profile.php">profile.php</a> <!-- practise link to profile.php -->

<?php
include "footer.inc" 
?>