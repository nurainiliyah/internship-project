<?php
// Database connection
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $company = $_POST['company'];
    $description = $_POST['description'];
    $industry = $_POST['industry'];
    $state = $_POST['state'];
    $allowance = $_POST['allowance'];

    // Debugging - check form data
    echo "Title: " . $title . "<br>";
    echo "Company: " . $company . "<br>";
    echo "Description: " . $description . "<br>";
    echo "Industry: " . $industry . "<br>";
    echo "State: " . $state . "<br>";
    echo "Allowance: " . $allowance . "<br>";

    // Handle file upload for company logo
    $logo_name = $_FILES['logo']['name'];
    $logo_tmp_name = $_FILES['logo']['tmp_name'];
    $logo_size = $_FILES['logo']['size'];
    $logo_error = $_FILES['logo']['error'];

    if ($logo_error === 0) {
        // Generate a unique name for the file
        $logo_extension = pathinfo($logo_name, PATHINFO_EXTENSION);
        $new_logo_name = uniqid('', true) . "." . $logo_extension;

        // Define the upload directory
        $upload_directory = "uploads/logos/";

        // Move the uploaded file to the server directory
        if (move_uploaded_file($logo_tmp_name, $upload_directory . $new_logo_name)) {
            // File upload successful
            // Insert data into the database
            $sql = "INSERT INTO internships (title, company, description, industry, state, allowance, logo)
                    VALUES ('$title', '$company', '$description', '$industry', '$state', '$allowance', '$new_logo_name')";

            // Debugging - check the query
            echo $sql; // Print query

            if ($conn->query($sql) === TRUE) {
                echo "New internship posted successfully!";
            } else {
                die("Error: " . $sql . "<br>" . $conn->error);
            }
        } else {
            echo "Error uploading logo file.";
        }
    } else {
        echo "Error with the logo file.";
    }
}

$conn->close();
?>
