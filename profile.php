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

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-card {
            background: #fff;
            width: 420px;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
            animation: fadeIn 0.4s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .welcome {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .message {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            background: #e6ffed;
            color: #0a8a2a;
            border-left: 4px solid #0a8a2a;
        }

        .error {
            background: #ffe5e5;
            color: #d60000;
            border-left: 4px solid #d60000;
        }

        label {
            font-weight: bold;
            color: #444;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #0056d2;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            display: inline-block;
            margin: 5px 0;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>
<body>

<div class="profile-card">

    <h2>My Profile</h2>
    <p class="welcome">Bounty Day, <?php echo htmlspecialchars($name); ?>!</p>

    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Username (cannot change):</label>
        <input type="text" value="<?php echo htmlspecialchars($username); ?>" disabled>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <div class="links">
        <a href="change_password.php">Change Password</a><br>
        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>
