<?php
  include "components/header.php";
?>

<!-- Start #main -->
<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Check your <b>bookings</b></h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Check Your Bookings</li>
    </ol>
  </div>
  <!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">BOOKING DETAILS</h5>

            <!-- Start Form Elements -->
            <form action="status.php" method="post">
              <div class="row mb-5">
                <label class="col-sm-2 col-form-label">Phone Number: </label>
                <div class="col-sm-10">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="0123456789">
                    <label for="phoneNumber">Phone Number</label>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">Check</button>
              </div>
            </form>
            <br>
            <br>
            <!-- End Form Elements -->

            <!-- Booking results will be displayed here -->
            <?php
              // Booking results table is already handled above

              // Function to sanitize input data
              function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }

              // Function to map booking slot to time slot
              function getTimeSlot($slot, $timeSlots) {
                  if (isset($timeSlots[$slot])) {
                      return $timeSlots[$slot]['time'];
                  }
                  return "Unknown Slot"; // Default if slot not found
              }

              // Check if phone number is provided
              if (isset($_POST['phoneNumber'])) {
                  $phoneNumber = sanitize_input($_POST['phoneNumber']);

                  // Prepare the SQL query to fetch bookings by phone number
                  $sql = "SELECT 
                              bookings.id, 
                              bookings.booking_date, 
                              bookings.booking_slot, 
                              teams.team_name, 
                              teams.booking_name, 
                              teams.booking_contact_number
                          FROM 
                              bookings
                          JOIN 
                              booking_teams ON bookings.id = booking_teams.booking_id
                          JOIN 
                              teams ON booking_teams.team_id = teams.id
                          WHERE 
                              teams.booking_contact_number = ?";

                  if ($stmt = $conn->prepare($sql)) {
                      $stmt->bind_param('s', $phoneNumber);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if ($result->num_rows > 0) {
                          echo '<table class="table table-striped">';
                          echo '<thead>';
                          echo '<tr>';
                          echo '<th>Booking ID</th>';
                          echo '<th>Booking Date</th>';
                          echo '<th>Booking Slot</th>';
                          echo '<th>Team Name</th>';
                          echo '<th>Contact Name</th>';
                          echo '<th>Contact Number</th>';
                          echo '</tr>';
                          echo '</thead>';
                          echo '<tbody>';

                          while ($row = $result->fetch_assoc()) {
                              $bookingSlot = $row['booking_slot'];
                              $timeSlot = getTimeSlot($bookingSlot, $timeSlots);

                              echo "<tr>";
                              echo "<td>" . $row['id'] . "</td>";
                              echo "<td>" . $row['booking_date'] . "</td>";
                              echo "<td>" . $timeSlot . "</td>"; // Display mapped time slot
                              echo "<td>" . $row['team_name'] . "</td>";
                              echo "<td>" . $row['booking_name'] . "</td>";
                              echo "<td>" . $row['booking_contact_number'] . "</td>";
                              echo "</tr>";
                          }

                          echo '</tbody>';
                          echo '</table>';
                      } else {
                          echo "<div class='alert alert-warning'>No bookings found for the given phone number.</div>";
                      }
                      
                      $stmt->close();
                  } else {
                      echo "Error preparing the statement: " . $conn->error;
                  }
              } else {
                  echo "<div class='alert alert-info'>Please enter a contact number.</div>";
              }

              // Close the connection
              $conn->close();
            ?>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>
<!-- End #main -->

<?php
  include "components/footer.php";
?>
