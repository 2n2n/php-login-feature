<?php
$status = isset($_GET['status']) ? $_GET['status'] : "";
$msg    = isset($_GET['msg']) ? urldecode($_GET['msg']) : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Result</title>
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
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .success {
            background: #e8f9e8;
            padding: 12px;
            border-left: 4px solid #2ecc71;
            color: #2e7d32;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error {
            background: #ffe6e6;
            padding: 12px;
            border-left: 4px solid #cc0000;
            color: #b30000;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        a.button {
            display: block;
            background: #3498db;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        a.button:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Sign Up Status</h2>

        <?php if ($status == "success"): ?>
            <div class="success">Account successfully created!</div>

        <?php elseif ($status == "error"): ?>
            <div class="error">
                Sign-up failed.
                <?php if ($msg != "") echo "<p>Error: $msg</p>"; ?>
            </div>

        <?php else: ?>
            <div class="error">Invalid access.</div>
        <?php endif; ?>

        <a href="login.php" class="button">Go to Login</a>
    </div>

</body>
</html>
