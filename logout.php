<?php
session_start();
session_unset(); // deletes all session variables
session_destroy(); // Destroys the session
header("Location: login.php"); // routes back to login.php
exit();
?>
