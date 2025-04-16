<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $Email = $_POST['email'] ?? null;
    $Password = $_POST['password'] ?? null;

    // Validate required fields
    if (!$Email || !$Password) {
        echo '<script>alert("Email and password are required!"); window.location="login.php";</script>';
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'plants_nursery');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare SQL statement with placeholder
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameter and execute
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password using the same hashing method from registration
        if (password_verify($Password, $user['password'])) {
            // Start session and store user info
            session_start();
            $_SESSION['user_id'] = $user['id'];  // Assuming you have an id column
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            
            echo '<script>alert("Login Successful!"); window.location="Homepage.php";</script>';
        } else {
            echo '<script>alert("Invalid password!"); window.location="login.php";</script>';
        }
    } else {
        echo '<script>alert("Email not found!"); window.location="login.php";</script>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Invalid request method!"); window.location="login.php";</script>';
}
?>