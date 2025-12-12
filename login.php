<?php
include "connect.php"; // your DB connection file

$errors = array();
$success = "";

// Run only when form is submitted
if (!empty($_POST)) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if ($username == "")  $errors[] = "Username is required.";
    if ($password == "")  $errors[] = "Password is required.";

    if (count($errors) == 0) {

        $sql = "select * from users where username = '$username' and password = '$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["id"];
            header("Location: profile.php?status=success");
            exit();
        } else {
            header("Location: login.php?status=error&msg=invalid_credentials");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #ffffff;
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: fadeIn 0.4s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background: #0056d2;
        }

        .error-box {
            background: #ffe5e5;
            color: #d60000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #d60000;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>
<body>

<div class="login-container">

    <h2>Welcome Back</h2>

    <?php if (count($errors) > 0): ?>
        <div class="error-box">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">

        <label>Username</label>
        <input type="text" name="username">

        <label>Password</label>
        <input type="password" name="password">

        <input type="submit" value="Login">

        <div style="text-align:center; margin-top:15px;">
            <a href="signup.php" style="color:#3498db; text-decoration:none; font-size:14px;">
                Create an Account
            </a>
        </div>
    </form>

</div>

</body>
</html>
