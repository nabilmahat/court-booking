<?php
    include "../connection/connection.php";
    include "../constants/timeslot.php";

    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize POST data
        $slot = sanitize_input($_POST['slot']);
        $date = sanitize_input($_POST['date']);
        $teamName = sanitize_input($_POST['teamName']);
        $yourName = sanitize_input($_POST['yourName']);
        $contactNumber = sanitize_input($_POST['contactNumber']);
        $teamCategory = isset($_POST['teamCategory']) ? sanitize_input($_POST['teamCategory']) : '';
        $jerseyColor1 = isset($_POST['jerseyColor1']) ? sanitize_input($_POST['jerseyColor1']) : '';
        $bookPrice = isset($_POST['bookPrice']) ? sanitize_input($_POST['bookPrice']) : '';
        $billId = isset($_POST['billId']) ? sanitize_input($_POST['billId']) : '';
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

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Check existing bookings for the given date and slot
            $sqlCheckBookings = "SELECT id FROM bookings WHERE booking_date = ? AND booking_slot = ?";
            if ($stmtCheck = $conn->prepare($sqlCheckBookings)) {
                $stmtCheck->bind_param('ss', $date, $slot);
                $stmtCheck->execute();
                $stmtCheck->bind_result($bookingId);
                $stmtCheck->fetch();
                $stmtCheck->close();
            } else {
                throw new Exception("Error preparing the statement: " . $conn->error);
            }

            // Case 4: Booking exists and opponent is selected
            if ($bookingId && $opponent === 'have_opponent') {
                throw new Exception("Cannot book with an opponent. There is already an existing booking.");
            }

            // If no booking exists, create a new booking
            if (!$bookingId) {
                $sqlBooking = "INSERT INTO bookings (booking_date, booking_slot) VALUES (?, ?)";
                if ($stmtBooking = $conn->prepare($sqlBooking)) {
                    $stmtBooking->bind_param('ss', $date, $slot);
                    if ($stmtBooking->execute()) {
                        $bookingId = $stmtBooking->insert_id;
                    } else {
                        throw new Exception("Error: " . $stmtBooking->error);
                    }
                    $stmtBooking->close();
                } else {
                    throw new Exception("Error preparing the statement: " . $conn->error);
                }
            }

            // Check how many teams are already associated with this booking
            $sqlCheckTeams = "SELECT COUNT(*) AS count FROM booking_teams WHERE booking_id = ?";
            if ($stmtCheckTeams = $conn->prepare($sqlCheckTeams)) {
                $stmtCheckTeams->bind_param('i', $bookingId);
                $stmtCheckTeams->execute();
                $stmtCheckTeams->bind_result($teamCount);
                $stmtCheckTeams->fetch();
                $stmtCheckTeams->close();
            } else {
                throw new Exception("Error preparing the statement: " . $conn->error);
            }

            // Case 4: Reject if there are already two teams and opponent is selected
            if ($teamCount >= 2 && $opponent === 'have_opponent') {
                throw new Exception("Cannot add more teams. There are already two teams for this booking.");
            }

            // Determine team_order
            if ($teamCount == 0) {
                $teamOrder = 1;
            } elseif ($teamCount == 1) {
                $teamOrder = 2;
            } else {
                throw new Exception("Cannot add more than 2 teams per booking.");
            }

            // Insert into teams table
            $sqlTeam = "INSERT INTO teams (team_name, booking_name, booking_contact_number, jersey_color, team_age)
                        VALUES (?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE team_name=VALUES(team_name), booking_name=VALUES(booking_name), booking_contact_number=VALUES(booking_contact_number), jersey_color=VALUES(jersey_color), team_age=VALUES(team_age)";
            if ($stmtTeam = $conn->prepare($sqlTeam)) {
                $stmtTeam->bind_param('sssss', $teamName, $yourName, $contactNumber, $jerseyColor1, $teamCategory);
                if ($stmtTeam->execute()) {
                    $teamId = $stmtTeam->insert_id;
                } else {
                    throw new Exception("Error: " . $stmtTeam->error);
                }
                $stmtTeam->close();
            } else {
                throw new Exception("Error preparing the statement: " . $conn->error);
            }

            // Insert into booking_teams table
            $sqlBookingTeam = "INSERT INTO booking_teams (booking_id, team_id, team_order, bill_id) VALUES (?, ?, ?, ?)";
            if ($stmtBookingTeam = $conn->prepare($sqlBookingTeam)) {
                $stmtBookingTeam->bind_param('iiis', $bookingId, $teamId, $teamOrder, $billId);
                if ($stmtBookingTeam->execute()) {
                    // Success
                } else {
                    throw new Exception("Error: " . $stmtBookingTeam->error);
                }
                $stmtBookingTeam->close();
            } else {
                throw new Exception("Error preparing the statement: " . $conn->error);
            }

            // Case 5: Insert opponent details if applicable
            if ($opponent === 'have_opponent') {
                // Insert into teams table for opponent
                $sqlOpponentTeam = "INSERT INTO teams (team_name, booking_name, booking_contact_number, jersey_color, team_age)
                                    VALUES (?, ?, ?, ?, ?)
                                    ON DUPLICATE KEY UPDATE team_name=VALUES(team_name), booking_name=VALUES(booking_name), booking_contact_number=VALUES(booking_contact_number), jersey_color=VALUES(jersey_color), team_age=VALUES(team_age)";
                if ($stmtOpponentTeam = $conn->prepare($sqlOpponentTeam)) {
                    $stmtOpponentTeam->bind_param('sssss', $teamOpponentName, $yourName, $teamOpponentContactNumber, $jerseyColor2, $teamCategory);
                    if ($stmtOpponentTeam->execute()) {
                        $opponentTeamId = $stmtOpponentTeam->insert_id;
                    } else {
                        throw new Exception("Error: " . $stmtOpponentTeam->error);
                    }
                    $stmtOpponentTeam->close();
                } else {
                    throw new Exception("Error preparing the statement: " . $conn->error);
                }

                // Check again if there is space for the opponent
                if ($teamCount >= 2) {
                    throw new Exception("Cannot add more teams. There are already two teams for this booking.");
                }

                // Insert into booking_teams table for opponent
                $sqlOpponentBookingTeam = "INSERT INTO booking_teams (booking_id, team_id, team_order, bill_id) VALUES (?, ?, 2, ?)";
                if ($stmtOpponentBookingTeam = $conn->prepare($sqlOpponentBookingTeam)) {
                    $stmtOpponentBookingTeam->bind_param('iiis', $bookingId, $opponentTeamId, $billId);
                    if ($stmtOpponentBookingTeam->execute()) {
                        // Success
                    } else {
                        throw new Exception("Error: " . $stmtOpponentBookingTeam->error);
                    }
                    $stmtOpponentBookingTeam->close();
                } else {
                    throw new Exception("Error preparing the statement: " . $conn->error);
                }
            }

            // Commit the transaction
            $conn->commit();
            echo "Booking and team information has been successfully saved.";
            // Redirect to index.php
            header("Location: ../index.php");
            exit();
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();
            echo "Failed to save booking and team information: " . $e->getMessage();
        }
    } else {
        echo "Invalid request method.";
    }

    // Close the connection
    $conn->close();

    // echo "<script>";
    // echo "window.location.href = '../index.php'";
    // echo "</script>";
?>