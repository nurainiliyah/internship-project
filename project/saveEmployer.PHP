<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internship";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$companyName = $_POST['companyName'];
$email = $_POST['email'];
$password = $_POST['password'];


// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Save employer data to the database
$sql = "INSERT INTO employers (companyName, email, password) VALUES ('$companyName', '$email', '$hashedPassword')";
if (mysqli_query($conn, $sql)) {
    echo "Employer registered successfully.";
    // Redirect to employer login page
    header("Location: login.html");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
