<?php
    include "components/header.php";   

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
        // echo "<h1>Form Submission Successful</h1>";
        // echo "<p><strong>Slot:</strong>";
        // print_r($timeSlots[$slot]['time']);
        // echo "</p>";
        // echo "<p><strong>Price:</strong> RM";
        // print_r($timeSlots[$slot]['price']);
        // echo "</p>";
        // echo "<p><strong>Date:</strong> $date</p>";
        // echo "<p><strong>Team Name:</strong> $teamName</p>";
        // echo "<p><strong>Your Name:</strong> $yourName</p>";
        // echo "<p><strong>Contact Number:</strong> $contactNumber</p>";
        // echo "<p><strong>Team Category:</strong> $teamCategory</p>";
        // echo "<p><strong>Jersey Color:</strong> $jerseyColor1</p>";

        // if ($opponent === 'have_opponent') {
        //     echo "<h2>Opponent Details</h2>";
        //     echo "<p><strong>Opponent Team Name:</strong> $teamOpponentName</p>";
        //     echo "<p><strong>Opponent Contact Number:</strong> $teamOpponentContactNumber</p>";
        //     echo "<p><strong>Opponent Jersey Color:</strong> $jerseyColor2</p>";
        // }
    } else {
        // Not a POST request
        echo "Invalid request method.";
    }


    $randomString = generateRandomString(6);

?>

<!-- Start #main -->
<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Complete your <b>details</b></h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="booking.php?date=<?php echo $date; ?>&&slot=<?php echo $slot; ?>">Your Details</a></li>
        <li class="breadcrumb-item active">Payment</li>
    </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">2. PAYMENT</h5>

              <!-- Start Form Elements -->
              <form action="forms/bookingForm.php" method="post">
              
              <!-- hidden data -->
              <input type="hidden" name="slot" value="<?php echo htmlspecialchars($slot); ?>">
              <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
              <!-- hidden data -->

                <div class="row mb-5">
                  <label class="col-sm-2 col-form-label">PAYMENT DETAILS</label>
                  <div class="col-sm-10">
                    <label class="col-sm-2 col-form-label">Field amount / team</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="RM <?php echo $timeSlots[$slot]['price']; ?>" disabled>
                    </div>
                    <label class="col-sm-2 col-form-label">Can pay full amount or deposit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="RM 100" disabled>
                    </div>
                    <label class="col-sm-2 col-form-label">Bill ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="REF-<?php echo date('Ymd').'-'.$randomString; ?>" disabled>
                    </div>
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $yourName; ?>" disabled>
                    </div>
                    <label class="col-sm-2 col-form-label">Contact Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $contactNumber; ?>" disabled>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                  <button type="submit" class="btn btn-primary">Pay</button>
                </div>
              </form>

              <!-- End Form Elements -->

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