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
$name = $_POST['Name'];
$contact = $_POST['Contact'];
$email = $_POST['Email'];
$university = $_POST['University'];
$year = $_POST['Year'];
$allowance = $_POST['Allowance'];
$education = $_POST['education'];
$industry = $_POST['Industry'];

// File upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["Resume"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate file type and size
if ($_FILES["Resume"]["size"] > 2000000 || !in_array($fileType, ["pdf", "doc", "docx"])) {
    die("Invalid file. Only PDF, DOC, or DOCX files under 2MB are allowed.");
}

// Move uploaded file
if (!move_uploaded_file($_FILES["Resume"]["tmp_name"], $target_file)) {
    die("Sorry, there was an error uploading your file.");
}

// Insert data into database
$sql = "INSERT INTO resumeform (Name, Contact, Email, University, Year, Allowance, education, Industry, Resume) 
        VALUES ('$name', '$contact', '$email', '$university', '$year', '$allowance', '$education', '$industry', '$target_file')";

if (!$conn->query($sql)) {
    die("Error: " . $sql . "<br>" . $conn->error);
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>Submission Successful</h2>
    </header>
    <main>
        <h3>Here is the information you submitted:</h3>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($name); ?></td>
            </tr>
            <tr>
                <th>Contact</th>
                <td><?php echo htmlspecialchars($contact); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>University</th>
                <td><?php echo htmlspecialchars($university); ?></td>
            </tr>
            <tr>
                <th>Graduated Year</th>
                <td><?php echo htmlspecialchars($year); ?></td>
            </tr>
            <tr>
                <th>Allowance</th>
                <td><?php echo htmlspecialchars($allowance); ?></td>
            </tr>
            <tr>
                <th>Diploma/Bachelor</th>
                <td><?php echo htmlspecialchars($education); ?></td>
            </tr>
            <tr>
                <th>Industry</th>
                <td><?php echo htmlspecialchars($industry); ?></td>
            </tr>
            <tr>
                <th>Uploaded Resume</th>
                <td><a href="<?php echo $target_file; ?>" target="_blank">Print</a></td>
            </tr>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Internship Center</p>
    </footer>
</body>
</html>
