<?php 
    include "components/headerAdmin.php";
    include "constants/timeslot.php";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query
    $sql = "SELECT 
                b.id AS booking_id, 
                b.booking_date, 
                b.booking_slot, 
                bt.bill_id,
                bt.created_at,
                GROUP_CONCAT(DISTINCT CASE WHEN bt.team_order = 1 THEN t.id ELSE NULL END) AS team1_ids, 
                GROUP_CONCAT(DISTINCT CASE WHEN bt.team_order = 2 THEN t.id ELSE NULL END) AS team2_ids, 
                GROUP_CONCAT(DISTINCT CASE WHEN bt.team_order = 1 THEN t.team_name ELSE NULL END) AS team1_names, 
                GROUP_CONCAT(DISTINCT CASE WHEN bt.team_order = 2 THEN t.team_name ELSE NULL END) AS team2_names
            FROM 
                bookings b
            INNER JOIN 
                booking_teams bt ON b.id = bt.booking_id
            INNER JOIN 
                teams t ON t.id = bt.team_id
            GROUP BY 
                b.id, b.booking_date, b.booking_slot, bt.bill_id, bt.created_at;";

    // Execute the query
    $result = $conn->query($sql);
?>

  <main id="main-admin" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Created Booking List</h5>
                <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

                <!-- Table with stripped rows -->
                        <?php
                            // Check if there are results
                            if ($result->num_rows > 0) {
                                echo '<table class="table datatable">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>ID</th>';
                                echo '<th>Bill ID</th>';
                                echo '<th>Booking Date</th>';
                                echo '<th>Booking Slot</th>';
                                // echo '<th>Team 1 IDs</th>';
                                // echo '<th>Team 2 IDs</th>';
                                echo '<th>Team 1 Names</th>';
                                echo '<th>Team 2 Names</th>';
                                echo '<th>Booking Time</th>';
                                echo '<th>Action</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';

                                $index = 1;

                                // Output data for each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $index . '</td>';
                                    echo '<td>' . htmlspecialchars($row['bill_id']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['booking_date']) . '</td>';
                                    echo '<td>' . htmlspecialchars($timeSlots[$row['booking_slot']]['time']) . '</td>';
                                    // echo '<td>' . htmlspecialchars($row['team1_ids']) . '</td>';
                                    // echo '<td>' . htmlspecialchars($row['team2_ids']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['team1_names']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['team2_names']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                                    echo '<td><a href="detail.php?booking_id='.$row['booking_id'].'" class="btn btn-primary">Details</button></td>';
                                    echo '</tr>';

                                    $index++;
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo "0 results";
                            }

                            // Close connection
                            $conn->close();
                        ?>
                <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include "components/footerAdmin.php"; ?>