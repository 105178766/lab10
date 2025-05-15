<?php
session_start();
include "header.inc";
require_once 'settings.php';   

$conn = mysqli_connect($host, $username, $password, $database); // pass parametres to connect to the database

if (!$conn){
    die("Database connection failed: " .mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    // check if the username and password are not empty
    $statement = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "ss", $input_username, $input_password); // Binding the parameters to the statement (insert the data as strings)
    mysqli_stmt_execute($statement); // Executes thr sql query
    $result = mysqli_stmt_get_result($statement); // get the result of the statement

    if($user = mysqli_fetch_assoc($result)){
        $_SESSION['username'] = $user['username']; // Store username in session
        $_SESSION['email'] = $user['email']; // Store email in session

        if($user['username'] == 'john'){
            header("Location: profile.php");
            exit();
          }else{
            $_SESSION['error'] = "User access not allowed!"; // only the hardcoded john can access the profile page
          }
        }else{
          $_SESSION['error'] = "**Invalid username or password**";  // incorrect username or password
    }
    mysqli_close($conn); // Close the database connection
}
// Check if there is an error message to display
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Clear it so it doesn't show again
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
include "footer.inc";
?>