
<?php
$servername = "10.2.0.57";
$username = "git_training";
$password = "nVnr93?c";
$dbname = "git_training";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected!"; // added comment line
?>
