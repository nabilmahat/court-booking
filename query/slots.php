<?php

header('Content-Type: application/json');

include "../connection/connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_POST['date'];
if (!DateTime::createFromFormat('Y-m-d', $date)) {
    echo json_encode(['error' => 'Invalid date format']);
    exit;
}

// Prepare the SQL query to fetch bookings for the specified date
$query = "
    SELECT t.name AS team_name, b.slot 
    FROM bookings b
    JOIN booking_teams bt ON b.id = bt.booking_id
    JOIN teams t ON bt.team_id = t.id
    WHERE b.booking_date = ?
    ORDER BY b.slot ASC
";

// Prepare the statement
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}

// Bind the parameter and execute the statement
$stmt->bind_param('s', $date);
$stmt->execute();

// Get the results
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

// Close connections
$stmt->close();
$conn->close();

// Send JSON response back to the frontend
echo json_encode($bookings);
?>