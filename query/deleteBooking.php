<?php
    header('Content-Type: application/json');

    include "../connection/connection.php";

    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
    }

    // Get the booking_id from the POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
        $booking_id = intval($_POST['booking_id']);

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete related entries from the booking_teams table
            $deleteBookingTeams = $conn->prepare("DELETE FROM booking_teams WHERE booking_id = ?");
            $deleteBookingTeams->bind_param('i', $booking_id);
            $deleteBookingTeams->execute();

            if ($deleteBookingTeams->affected_rows === 0) {
                // Handle the case where no rows were affected in booking_teams
                $deleteBookingTeams->close();
                throw new Exception('No related teams found to delete for the booking.');
            }
            $deleteBookingTeams->close();

            // Delete the booking from the bookings table
            $deleteBooking = $conn->prepare("DELETE FROM bookings WHERE id = ?");
            $deleteBooking->bind_param('i', $booking_id);
            $deleteBooking->execute();

            if ($deleteBooking->affected_rows === 0) {
                // Handle the case where no rows were affected in bookings
                $deleteBooking->close();
                throw new Exception('No booking found with the provided ID.');
            }
            $deleteBooking->close();

            // Commit the transaction
            $conn->commit();

            // Return a success response
            echo json_encode(['success' => true, 'message' => 'Booking deleted successfully.']);
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        // Handle invalid requests
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }

    // Close the database connection
    $conn->close();
?>