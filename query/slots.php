<?php

header('Content-Type: application/json');

include "../connection/connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the date from the GET request
$date = $_GET['date'];
if (!DateTime::createFromFormat('Y-m-d', $date)) {
    echo json_encode(['error' => 'Invalid date format']);
    exit;
}

// Prepare the SQL query to fetch bookings for the specified date
$query = "
    SELECT 
        b.booking_date, b.booking_slot, b.id AS bookingId, bt.team_id, bt.team_order, t.id AS teamID, t.team_name, booking_name, booking_contact_number, jersey_color, team_age
    FROM 
        bookings b
    INNER JOIN 
        booking_teams bt
    ON
        b.id = bt.booking_id
    INNER JOIN 
        teams t
    ON
        t.id = bt.team_id
    WHERE
        booking_date = '$date'
    ";

// Execute the query
$result = $conn->query($query);

// Check for query execution errors
if (!$result) {
    echo json_encode(['error' => 'Query failed']);
    exit;
}

// Fetch all results
$bookings = $result->fetch_all(MYSQLI_ASSOC);

// Close connection
$conn->close();

// Send JSON response back to the frontend
echo json_encode($bookings);
?>