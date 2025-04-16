<?php
$Firstname = $_POST['firstname'];
$Lastname = $_POST['lastname'];
$Email = $_POST['email'];
$Mobile = $_POST['mobile'];
$PlantType = $_POST['type'];
$PlantSize = $_POST['size'];
$State = $_POST['state'];
$District = $_POST['district'];
$Address = $_POST['add'];
$Handover = $_POST['handover'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'plants_nursery');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare statement to avoid SQL Injection
$stmt = $conn->prepare("INSERT INTO handover (firstname, lastname, email, mobile, plant_type, plant_size, state, district, address, handover) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssssssss", $Firstname, $Lastname, $Email, $Mobile, $PlantType, $PlantSize, $State, $District, $Address, $Handover);

if ($stmt->execute()) {
    echo "<script>alert('Form Submitted Successfully'); window.location.href='Handover.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
