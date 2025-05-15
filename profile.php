<?php
session_start();
include "header.inc";
include_once 'settings.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// was email updates successfully?
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Clear it so it doesn't show again
}

if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']); // Clear after showing once
}




?>
<h1>Welcome, <?php echo $_SESSION['username']; ?> your email is: </h1>
<h2><?php echo $_SESSION['email']; ?></h2>

<h3>Edit Profile</h3>
<form method="POST" action="update_profile.php">
    <label>New Email:</label>
    <input type="email" name="new_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required><br><br> <!-- htmlspecialchars prevents any hacking -->
    <input type="submit" value="Update Email">
</form>
<br><br>
<a href="logout.php">Logout</a> <!-- logout link -->

<?php
include "footer.inc" 
?>