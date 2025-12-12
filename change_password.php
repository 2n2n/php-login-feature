
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
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
  <div class="container">
    <h2>Change Password</h2>
    <form action="process_change_password.php" method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="old_password">Old Password</label>
      <input type="password" id="old_password" name="old_password" required>

      <label for="new_password">New Password</label>
      <input type="password" id="new_password" name="new_password" required>

      <label for="confirm_password">Confirm New Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>
