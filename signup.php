<?php
include "connect.php"; // your DB connection file

$errors = array();
$success = "";

// Run only when form is submitted
if (!empty($_POST)) {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if ($fullname == "")  $errors[] = "Full name is required.";
    if ($username == "")  $errors[] = "Username is required.";
    if ($password == "")  $errors[] = "Password is required.";

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
</head>
<body style="font-family: Arial; padding: 40px;">

    <h2>Create an Account</h2>

    <!-- Show errors above the form -->
    <?php if (count($errors) > 0): ?>
        <div style="color:red; margin-bottom: 15px;">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="signup.php">
        <label>Full Name:</label><br>
        <input type="text" name="fullname"><br><br>

        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <input type="submit" value="Sign Up">
    </form>

</body>
</html>
