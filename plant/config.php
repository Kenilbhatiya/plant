<?php
// Database configuration
$db_host = "localhost:3306";
$db_user = "root";
$db_password = ""; // Default XAMPP MySQL password is blank
$db_name = "plants_nursery"; // Using underscore instead of space

// Create connection
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?> 