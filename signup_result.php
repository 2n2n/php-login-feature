<?php
$status = isset($_GET['status']) ? $_GET['status'] : "";
$msg    = isset($_GET['msg']) ? urldecode($_GET['msg']) : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Result</title>
</head>
<body style="font-family: Arial; padding: 40px;">

<h2>Sign Up Status</h2>

<?php if ($status == "success"): ?>
    <p style="color:green;">Account successfully created!</p>

<?php elseif ($status == "error"): ?>
    <p style="color:red;">Sign-up failed.</p>
    <?php if ($msg != "") echo "<p>Error: $msg</p>"; ?>

<?php else: ?>
    <p style="color:red;">Invalid access.</p>
<?php endif; ?>

<br>
<a href="signup.php">Back to Sign Up</a>

</body>
</html>
