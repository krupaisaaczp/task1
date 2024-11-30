<?php
include 'db_config.php';

// Capture the form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender']; 
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

// Insert into the database
$sql = "INSERT INTO users (name, email, phone, gender, password) 
        VALUES ('$name', '$email', '$phone', '$gender', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
