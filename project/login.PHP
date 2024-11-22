<?php
session_start();
$servername = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$dbName = "internship"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture data from form
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch employer credentials from the database
$sql = "SELECT * FROM employers WHERE email='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, start session
        $_SESSION['loggedin'] = true;
        $_SESSION['employer_id'] = $row['id'];
        header("Location: post.html");
        exit;
    } else {
        echo "Invalid password. Please try again.";
    }
} else {
    echo "No account found with that email. Please try again.";
}

$conn->close();
?>
