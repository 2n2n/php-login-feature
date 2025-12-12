<?php
require 'connect.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

// handle profile update (name)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    $name = trim($_POST["name"]);
    $id   = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    if ($stmt->execute()) {
        $_SESSION["name"] = $name;
        $message = "Profile updated successfully.";
    } else {
        $message = "Error updating profile.";
    }
    $stmt->close();
}

// get latest user data
$id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT username, name FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username, $name);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>
<h2>My Profile</h2>
<p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
<p style="color:green;"><?php echo $message; ?></p>

<form method="post" action="">
    <label>Username (cannot change):</label><br>
    <input type="text" value="<?php echo htmlspecialchars($username); ?>" disabled><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

    <button type="submit" name="update_profile">Update Profile</button>
</form>

<p><a href="change_password.php">Change Password</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
