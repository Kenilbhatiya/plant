<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch and sanitize form data
    $Firstname = $_POST['firstname'] ?? null;
    $Lastname = $_POST['lastname'] ?? null;
    $Email = $_POST['email'] ?? null;
    $Mobile = $_POST['mobile'] ?? null;
    $Address = $_POST['address'] ?? null;
    $Password = $_POST['password'] ?? null;

    // Validate required fields
    if (!$Firstname || !$Lastname || !$Email || !$Mobile || !$Address || !$Password) {
        echo '<script>alert("All fields are required!"); window.location="register.php";</script>';
        exit;
    }

    // Hash the password
    $Password = password_hash($Password, PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'plants_nursery');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO registration (firstname, lastname, email, mobile, address, password) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("ssssss", $Firstname, $Lastname, $Email, $Mobile, $Address, $Password);
    if ($stmt->execute()) {
        echo '<script>alert("Registered Successfully!"); window.location="Homepage.php";</script>';
    } else {
        echo '<script>alert("Registration Failed! Error: ' . htmlspecialchars($stmt->error) . '"); window.location="register.php";</script>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Invalid request method!"); window.location="register.php";</script>';
}
?>