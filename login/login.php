<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'UserManagement');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $enteredCaptcha = $_POST['captcha'];

    // Check if CAPTCHA is correct
    if (!isset($_SESSION['captcha']) || $enteredCaptcha !== $_SESSION['captcha']) {
        echo "Invalid CAPTCHA. Please go back and try again.";
        exit;
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            echo "Login successful!";
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();
?>
