<html>
<head>
	<title>Forgot Password</title>
	<style>
		body {
			background: lightgreen;
			font-family: Arial, sans-serif;
		}
		form {
			border: solid;
			border-radius: 10px;
			border-width: 5px;
			text-align: center;
			width: 40%;
			padding: 30px;
			margin: 120px auto;
			background: yellow;
			box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
		}
		.input-field {
			width: 90%;
			padding: 10px;
			margin: 10px 0;
			border: 1px solid #999;
			border-radius: 5px;
			outline: none;
			font-size: 18px;
		}
		.submit-btn {
			width: 95%;
			padding: 10px;
			cursor: pointer;
			background: lightgreen;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			transition: 0.3s;
		}
		.submit-btn:hover {
			background: skyblue;
		}
		.error {
			color: red;
			font-size: 18px;
		}
		.success {
			color: green;
			font-size: 18px;
		}
	</style>
</head>
<body>
	<form method="POST">
		<h2>Forgot Password</h2>
		<input type="email" class="input-field" placeholder="Enter your Email" name="email" required><br>
		<button type="submit" class="submit-btn" name="send_otp">Send OTP</button>
	</form>

	<?php
	$conn = new mysqli('localhost', 'root', '', 'Plants_Nursery');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	if (isset($_POST['send_otp'])) {
		$email = trim($_POST['email']);
		$email = $conn->real_escape_string($email);
		$otp = rand(100000, 999999);

		$sql = "SELECT id FROM Registration WHERE email = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$stmt = $conn->prepare("INSERT INTO otp_verification (email, otp) VALUES (?, ?) ON DUPLICATE KEY UPDATE otp = ?");
			$stmt->bind_param("sii", $email, $otp, $otp);
			$stmt->execute();
			echo "<div class='success'>OTP Sent to your Email!</div>";

			echo '<form method="POST">
				<input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
				<input type="text" class="input-field" placeholder="Enter OTP" name="otp" required><br>
				<button type="submit" class="submit-btn" name="verify_otp">Verify OTP</button>
			</form>';
		} else {
			echo "<div class='error'>Email Not Found!</div>";
		}
		$stmt->close();
	}

	if (isset($_POST['verify_otp'])) {
		$email = $_POST['email'];
		$otp = $_POST['otp'];

		$stmt = $conn->prepare("SELECT otp FROM otp_verification WHERE email = ? AND otp = ?");
		$stmt->bind_param("si", $email, $otp);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			echo "<div class='success'>OTP Verified! You can reset your password now.</div>";
			echo '<form method="POST">
				<input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
				<input type="password" class="input-field" placeholder="Enter New Password" name="new_password" required><br>
				<button type="submit" class="submit-btn" name="reset_password">Reset Password</button>
			</form>';
		} else {
			echo "<div class='error'>Invalid OTP!</div>";
		}
		$stmt->close();
	}

	if (isset($_POST['reset_password'])) {
		$email = $_POST['email'];
		$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

		$stmt = $conn->prepare("UPDATE Registration SET password = ? WHERE email = ?");
		$stmt->bind_param("ss", $new_password, $email);
		if ($stmt->execute()) {
			echo "<div class='success'>Password Reset Successfully!</div>";
			echo "<script>setTimeout(function(){ window.location.href='Login_Register.html'; }, 2000);</script>";
		} else {
			echo "<div class='error'>Failed to Reset Password!</div>";
		}
		$stmt->close();
	}

	$conn->close();
	?>
</body>
</html>