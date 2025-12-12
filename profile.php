<?php
require 'connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

// handle profile update (name)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    $name = trim($_POST["name"]);
    $id   = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE  users SET name = ? WHERE id = ?");
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

    <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; }
    .container { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align:center; margin-bottom:20px; }
    label { display:block; margin-top:10px; font-weight:bold; }
    input[type="text"], input[type="password"] {
      width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:4px;
    }
    button {
      margin-top:15px; width:100%; padding:10px; background:#28a745; color:#fff; border:none; border-radius:4px; font-size:16px; cursor:pointer;
    }
    button:hover { background:#218838; }
  </style>
  
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
