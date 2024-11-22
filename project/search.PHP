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

// Retrieve form data
$industry = isset($_POST['industry']) ? $_POST['industry'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$allowance = isset($_POST['allowance']) ? $_POST['allowance'] : 0;

// Build the query with filters
$query = "SELECT * FROM internships WHERE industry = ? AND state LIKE ? AND allowance >= ?";
$stmt = $conn->prepare($query);
$state = "%" . $state . "%"; // Enable partial match for state
$stmt->bind_param("ssi", $industry, $state, $allowance);

// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Generate HTML for search results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Use logo from the 'uploads/logos' folder or fallback to a default image
        $logo = !empty($row['logo']) ? "uploads/logos/" . htmlspecialchars($row['logo']) : "uploads/logos/default-logo.jpg";

        echo "<div class='col-md-4 mb-4'>";
        echo "<div class='card'>";
        echo "<img class='card-img-top' src='" . $logo . "' alt='Company Logo' style='width: 100%; height: 150px; object-fit: cover;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($row['company']) . "</h5>";
        echo "<p class='card-text'><strong>Title:</strong> " . htmlspecialchars($row['title']) . "</p>";
        echo "<p class='card-text'><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
        echo "<p class='card-text'><strong>Industry:</strong> " . htmlspecialchars($row['industry']) . "</p>";
        echo "<p class='card-text'><strong>Location:</strong> " . htmlspecialchars($row['state']) . "</p>";
        echo "<p class='card-text'><strong>Allowance:</strong> RM " . htmlspecialchars($row['allowance']) . "</p>";
        echo "<a href='register.html' target='_blank'><img src='applynow.PNG' alt='Submit Your Resume' style='width: 144px; height: 50px;'></a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No internships found matching your criteria.</p>";
}

$stmt->close();
$conn->close();
?>
