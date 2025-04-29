<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>

<div class="container">
    <h1>Payment Form</h1>
    <form action="" method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" placeholder="John Doe" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="john@example.com" required>

        <label>Address</label>
        <input type="text" name="address" placeholder="123 Main Street" required>

        <label>City</label>
        <input type="text" name="city" placeholder="City" required>

        <label>State</label>
        <input type="text" name="state" placeholder="State" required>

        <label>ZIP</label>
        <input type="text" name="zip" placeholder="123456" required>

        <label>Name on Card</label>
        <input type="text" name="cardname" placeholder="Card Holder Name" required>

        <label>Card Number</label>
        <input type="text" name="cardnumber" placeholder="1111-2222-3333-4444" maxlength="16" required>

        <label>Expiry Month</label>
        <input type="text" name="expmonth" placeholder="January" required>

        <label>Expiry Year</label>
        <input type="text" name="expyear" placeholder="2026" required>

        <label>CVV</label>
        <input type="password" name="cvv" placeholder="123" maxlength="3" required>

        <button type="submit" name="submit">Confirm Payment</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expmonth = $_POST['expmonth'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];

    // Database Connection
    $conn = new mysqli("localhost", "root", "", "plants");

    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO payments (fullname, email, address, city, state, zip, cardname, cardnumber, expmonth, expyear, cvv) 
            VALUES ('$fullname', '$email', '$address', '$city', '$state', '$zip', '$cardname', '$cardnumber', '$expmonth', '$expyear', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment Successful!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>
