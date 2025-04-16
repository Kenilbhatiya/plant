<?php
session_start();

if (isset($_SESSION['email'])) {
    session_destroy();
}

echo "<script>
    alert('Logout Successful!');
    window.location = 'Login_Register.html';
</script>";
?>
