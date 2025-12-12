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

        // Insert into MySQL
        $sql = "select * from users where username = '$username' and password = '$password'";

        if ($conn->query($sql) === TRUE) {
            // header("Location: signup_result.php?status=success");
            header("Location: profile.php?status=success");
            exit();
        } else {
            // header("Location: signup_result.php?status=error&msg=" . urlencode($conn->error));
            header("Location: login.php?status=error&msg=" . urlencode($conn->error));
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body style="font-family: Arial; padding: 40px;">

    <h2>Welcome</h2>

    <!-- Show errors above the form -->
    <?php if (count($errors) > 0): ?>
        <div style="color:red; margin-bottom: 15px;">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">

        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <input type="submit" value="Login">
    </form>

</body>
</html>
