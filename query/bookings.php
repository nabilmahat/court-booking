<?php
header('Content-Type: application/json');

include "../connection/connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

// Calculate the start and end dates of the month
$start_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
$end_date = date("Y-m-t", strtotime($start_date));

// Query to fetch all bookings for the month
$sql_all_bookings = "SELECT * 
                     FROM bookings 
                     WHERE booking_date BETWEEN '$start_date' AND '$end_date'";
$result_all_bookings = $conn->query($sql_all_bookings);

$all_bookings = array();
while ($row = $result_all_bookings->fetch_assoc()) {
    $all_bookings[] = $row;
}

// Query to count the number of bookings per day
$sql_counts_per_day = "SELECT 
                          booking_date, 
                          COUNT(*) AS total_bookings
                       FROM bookings
                       WHERE booking_date BETWEEN '$start_date' AND '$end_date'
                       GROUP BY booking_date";
$result_counts_per_day = $conn->query($sql_counts_per_day);

$counts_per_day = array();
while ($row = $result_counts_per_day->fetch_assoc()) {
    $counts_per_day[$row['booking_date']] = $row['total_bookings'];
}

// Generate a list of all dates in the month
$dates = array();
$current_date = $start_date;
while ($current_date <= $end_date) {
    $dates[] = $current_date;
    $current_date = date("Y-m-d", strtotime($current_date . " +1 day"));
}

// Ensure each day has at least one event
foreach ($dates as $date) {
    if (!isset($counts_per_day[$date])) {
        // Add a dummy event for the date with no actual bookings
        $counts_per_day[$date] = 0;
        $all_bookings[] = array(
            'booking_date' => $date,
            'total_bookings' => 0
        );
    }
}

// Append total_bookings to each booking
foreach ($all_bookings as &$booking) {
    $date = $booking['booking_date'];
    $booking['total_bookings'] = isset($counts_per_day[$date]) ? $counts_per_day[$date] : 0;
}

// Final response
$response = array(
    'bookings' => $all_bookings,
    'counts_per_day' => $counts_per_day
);

$conn->close();

echo json_encode($response);
?>
