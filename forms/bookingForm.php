<?php

include "../constants/timeslot.php";

// Function to sanitize input data
function sanitize_input($data) {
    // Trim whitespace
    $data = trim($data);
    // Remove backslashes
    $data = stripslashes($data);
    // Convert special characters to HTML entities to prevent XSS
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate POST data
    $slot = sanitize_input($_POST['slot']);
    $date = sanitize_input($_POST['date']);

    $teamName = sanitize_input($_POST['teamName']);
    $yourName = sanitize_input($_POST['yourName']);
    $contactNumber = sanitize_input($_POST['contactNumber']);
    $teamCategory = isset($_POST['teamCategory']) ? sanitize_input($_POST['teamCategory']) : '';
    $jerseyColor1 = isset($_POST['jerseyColor1']) ? sanitize_input($_POST['jerseyColor1']) : '';
    $opponent = isset($_POST['opponent']) ? sanitize_input($_POST['opponent']) : '';

    // Initialize variables for opponent details
    $teamOpponentName = '';
    $teamOpponentContactNumber = '';
    $jerseyColor2 = '';

    // Check if opponent details are provided
    if ($opponent === 'have_opponent') {
        $teamOpponentName = isset($_POST['teamOpponentName']) ? sanitize_input($_POST['teamOpponentName']) : '';
        $teamOpponentContactNumber = isset($_POST['teamOpponentContactNumber']) ? sanitize_input($_POST['teamOpponentContactNumber']) : '';
        $jerseyColor2 = isset($_POST['jerseyColor2']) ? sanitize_input($_POST['jerseyColor2']) : '';
    }

    // Process or store the sanitized data as needed
    // Example: Output the data (for debugging purposes only)
    echo "<h1>Form Submission Successful</h1>";
    echo "<p><strong>Slot:</strong>";
    print_r($timeSlots[$slot]['time']);
    echo "</p>";
    echo "<p><strong>Price:</strong> RM";
    print_r($timeSlots[$slot]['price']);
    echo "</p>";
    echo "<p><strong>Date:</strong> $date</p>";
    echo "<p><strong>Team Name:</strong> $teamName</p>";
    echo "<p><strong>Your Name:</strong> $yourName</p>";
    echo "<p><strong>Contact Number:</strong> $contactNumber</p>";
    echo "<p><strong>Team Category:</strong> $teamCategory</p>";
    echo "<p><strong>Jersey Color:</strong> $jerseyColor1</p>";

    if ($opponent === 'have_opponent') {
        echo "<h2>Opponent Details</h2>";
        echo "<p><strong>Opponent Team Name:</strong> $teamOpponentName</p>";
        echo "<p><strong>Opponent Contact Number:</strong> $teamOpponentContactNumber</p>";
        echo "<p><strong>Opponent Jersey Color:</strong> $jerseyColor2</p>";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
}
?>
