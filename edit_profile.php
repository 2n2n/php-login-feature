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
$message_type = "";

$id = $_SESSION["user_id"];

// Handle profile update (full CRUD operation)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_profile"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $bio = trim($_POST["bio"]);

    // Validation
    if (empty($name)) {
        $message = "Name is required.";
        $message_type = "error";
    } else {
        // Update user profile
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $bio, $id);

        if ($stmt->execute()) {
            $_SESSION["name"] = $name;
            $message = "Profile updated successfully!";
            $message_type = "success";
        } else {
            $message = "Error updating profile: " . $stmt->error;
            $message_type = "error";
        }
        $stmt->close();
    }
}

// Get latest user data (READ operation)
$stmt = $conn->prepare("SELECT username, name, email, phone, address, bio FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username, $name, $email, $phone, $address, $bio);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-card {
            background: #fff;
            width: 500px;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
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
            font-size: 14px;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
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
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        input[type="text"]:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
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
            margin-top: 10px;
        }

        button:hover {
            background: #0056d2;
        }

        .button-secondary {
            background: #6c757d;
        }

        .button-secondary:hover {
            background: #5a6268;
        }

        .button-danger {
            background: #dc3545;
        }

        .button-danger:hover {
            background: #c82333;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            display: inline-block;
            margin: 5px 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row label {
            margin-top: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <h2>Edit Profile</h2>
        <p class="welcome">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <label>Username (cannot change):</label>
            <input type="text" value="<?php echo htmlspecialchars($username); ?>" disabled>

            <label>Full Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <div class="form-row">
                <div>
                    <label>Phone:</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <div>
                    <label>Address:</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
            </div>

            <label>Bio:</label>
            <textarea name="bio"><?php echo htmlspecialchars($bio); ?></textarea>

            <button type="submit" name="edit_profile">Update Profile</button>
        </form>

        <div class="links">
            <a href="profile.php">← Back to Profile</a>
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

</body>

</html>