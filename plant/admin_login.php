<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plants_nursery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Validate input
    if (empty($username) || empty($password)) {
        header("Location: admin_login.html?error=empty");
        exit();
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT admin_id, username, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start session
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_logged_in'] = true;

            // Redirect to admin dashboard
            header("Location: admin.php");
            exit();
        } else {
            // Invalid password
            header("Location: admin_login.html?error=invalid");
            exit();
        }
    } else {
        // Invalid username
        header("Location: admin_login.html?error=invalid");
        exit();
    }

    $stmt->close();
}

$conn->close();
?> 