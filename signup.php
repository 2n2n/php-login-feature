<?php
include "connect.php"; // your DB connection file

$errors = array();
$success = "";

// Run only when form is submitted
if (!empty($_POST)) {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $c_password = trim($_POST['c_password']);

    // Basic validation
    if ($fullname == "")  $errors[] = "Full name is required.";
    if ($username == "")  $errors[] = "Username is required.";
    if ($password == "")  $errors[] = "Password is required.";
    if ($c_password == "")  $errors[] = "Confirm Password is required.";
    if ($password != $c_password)  $errors[] = "Confirm Password does not match.";

    if (count($errors) == 0) {

        // Insert into MySQL
        $sql = "INSERT INTO users (name, username, password)
                VALUES ('$fullname', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: signup_result.php?status=success");
            exit();
        } else {
            header("Location: signup_result.php?status=error&msg=" . urlencode($conn->error));
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            padding-top: 60px;
        }

        .container {
            background: #ffffff;
            padding: 30px 40px;
            width: 360px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #3498db;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        input[type="submit"]:hover {
            background: #2980b9;
        }

        .error-box {
            background: #ffe6e6;
            color: #b30000;
            padding: 10px 15px;
            border-left: 4px solid #cc0000;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .error-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Create an Account</h2>

        <?php if (count($errors) > 0): ?>
            <div class="error-box">
                <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="signup.php">
            <label>Full Name:</label>
            <input type="text" name="fullname">

            <label>Username:</label>
            <input type="text" name="username">

            <label>Password:</label>
            <input type="password" name="password">

            <label>Confirm Password:</label>
            <input type="password" name="c_password">

            <input type="submit" value="Sign Up">

            <div style="text-align:center; margin-top:15px;">
                <a href="login.php" style="color:#3498db; text-decoration:none; font-size:14px;">
                    Already have an account? Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>
