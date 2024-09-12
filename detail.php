<?php 
    include "components/headerAdmin.php";
    include "constants/timeslot.php";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate the booking ID
    $bookingId = filter_var($_GET['booking_id'], FILTER_VALIDATE_INT);
    if ($bookingId === false) {
        die("Invalid booking ID.");
    }

    // Initialize an array to store team details
    $teams = [
        ['teamName' => '', 'bookingName' => '', 'bookingContactNumber' => '', 'jerseyColor' => ''],
        ['teamName' => '', 'bookingName' => '', 'bookingContactNumber' => '', 'jerseyColor' => '']
    ];

    // Fetch booking details
    $sql = "SELECT b.booking_date, b.booking_slot, t.team_name, t.booking_name, t.booking_contact_number, t.jersey_color
            FROM bookings b
            JOIN booking_teams bt ON b.id = bt.booking_id
            JOIN teams t ON bt.team_id = t.id
            WHERE b.id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $stmt->bind_result($bookingDate, $bookingSlot, $teamName, $teamContactName, $teamContactNumber, $teamJerseyColor);

        $index = 0;
        // Fetch all teams for the given booking ID
        while ($stmt->fetch() && $index < 2) {
            $teams[$index] = [
                'teamName' => htmlspecialchars($teamName),
                'bookingName' => htmlspecialchars($teamContactName),
                'bookingContactNumber' => htmlspecialchars($teamContactNumber),
                'jerseyColor' => htmlspecialchars($teamJerseyColor)
            ];
            $index++;
        }

        $stmt->close();
    } else {
        error_log("Error preparing the statement: " . $conn->error);
        die("An error occurred while preparing the request.");
    }

    // Fetch booking date and slot (assuming the date and slot are the same for all teams)
    $sql = "SELECT booking_date, booking_slot FROM bookings WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $stmt->bind_result($bookingDate, $bookingSlot);
        $stmt->fetch();
        $stmt->close();

        $bookingDate = htmlspecialchars($bookingDate);
        $bookingSlot = htmlspecialchars($bookingSlot);
    } else {
        error_log("Error preparing the statement: " . $conn->error);
        die("An error occurred while preparing the request.");
    }

    // Close the connection
    $conn->close();
?>

<main id="main-admin" class="main">
    <div class="pagetitle">
        <h1>Booking Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Booking Detail</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Booking Details</h5>
                        <!-- Booking Info -->
                        <form class="row g-3">
                            <div class="col-12">
                                <label for="inputBookingDate" class="form-label">Booking Date</label>
                                <input type="text" class="form-control" id="inputBookingDate" value="<?php echo $bookingDate; ?>" readonly>
                            </div>
                            <div class="col-12">
                                <label for="inputBookingSlot" class="form-label">Booking Slot</label>
                                <input type="text" class="form-control" id="inputBookingSlot" value="<?php echo $bookingSlot; ?>" readonly>
                            </div>

                            <!-- Team Details -->
                            <div class="row">
                                <div class="col-5">
                                    <!-- Team 1 Details -->
                                    <h5 class="card-title">Team 1 Details</h5>
                                    <div class="col-12">
                                        <label for="inputTeamName0" class="form-label">Team Name</label>
                                        <input type="text" class="form-control" id="inputTeamName0" value="<?php echo $teams[0]['teamName']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputBookingName0" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="inputBookingName0" value="<?php echo $teams[0]['bookingName']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputContactNumber0" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="inputContactNumber0" value="<?php echo $teams[0]['bookingContactNumber']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputJerseyColor0" class="form-label">Jersey Color</label>
                                        <div id="inputJerseyColor0" class="jersey-svg" style="width: 100px; height: 100px;">
                                            <?php
                                            $jerseyColor = !empty($teams[0]['jerseyColor']) ? $teams[0]['jerseyColor'] : '#CCCCCC'; // Default to grey if no color is provided
                                            echo <<<EOD
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 150" fill="$jerseyColor">
                                                <path d="M50 10 L70 30 L70 60 L50 80 L30 60 L30 30 Z" />
                                                <!-- Add more paths or shapes to define the jersey shape -->
                                            </svg>
                                            EOD;
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 text-center">
                                    <!-- <h3>VS</h3> -->
                                </div>

                                <div class="col-5">
                                    <!-- Team 2 Details -->
                                    <h5 class="card-title">Team 2 Details</h5>
                                    <div class="col-12">
                                        <label for="inputTeamName1" class="form-label">Team Name</label>
                                        <input type="text" class="form-control" id="inputTeamName1" value="<?php echo $teams[1]['teamName']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputBookingName1" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="inputBookingName1" value="<?php echo $teams[1]['bookingName']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputContactNumber1" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="inputContactNumber1" value="<?php echo $teams[1]['bookingContactNumber']; ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputJerseyColor1" class="form-label">Jersey Color</label>
                                        <div id="inputJerseyColor1" class="jersey-svg" style="width: 100px; height: 100px;">
                                            <?php
                                            $jerseyColor = !empty($teams[1]['jerseyColor']) ? $teams[1]['jerseyColor'] : '#CCCCCC'; // Default to grey if no color is provided
                                            echo <<<EOD
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 150" fill="$jerseyColor">
                                                <path d="M50 10 L70 30 L70 60 L50 80 L30 60 L30 30 Z" />
                                                <!-- Add more paths or shapes to define the jersey shape -->
                                            </svg>
                                            EOD;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include "components/footerAdmin.php"; ?>
