<?php
  include "components/header.php";
?>

<!-- Start #main -->
<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1><!--<img src="assets/img/dragoarena.jpg" alt="" style="height: 40px; width: auto">&nbsp;&nbsp;-->Book your <b>field</b></h1>
  </div>
  <!-- End Page Title -->

  <section class="section dashboard">
    <div class="row d-flex justify-content-center align-items-center">

      <!-- Start Calendar -->
      <div id='calendar'></div>
        
      <!-- End Calendar -->

      <!-- Start Label -->
      <div class="col-lg-12">
        <div class="d-flex justify-content-center">
          <div class="row" style="width: 320px;">
            <div class="col-6">

              <div class="activity mb-4">

                <div class="activity-item d-flex">
                  <i class='bi bi-circle-fill activity-badge text-success'></i>
                  <div class="activity-content">
                    Slot Available
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <i class='bi bi-circle-fill activity-badge text-warning'></i>
                  <div class="activity-content">
                    Selling Fast
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <i class='bi bi-circle-fill activity-badge text-danger'></i>
                  <div class="activity-content">
                    Fully Booked
                  </div>
                </div>

              </div>
            </div>
            <div class="col-6">
              
              <div class="activity mb-4">

                <div class="activity-item d-flex">
                  (V)
                  <div class="activity-content">
                  Veteran
                  </div>
                </div>

                <div class="activity-item d-flex">
                  (SV)
                  <div class="activity-content">
                  Semi Veteran
                  </div>
                </div>

                <div class="activity-item d-flex">
                  (O)
                  <div class="activity-content">
                    Open
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <br>
      </div>
      
      <!-- End Label -->

      <!-- Start Time Card -->
      <div class="col-lg-12">
        <div class="row d-flex justify-content-center">

        <?php
          $index = 0;
          foreach ($timeSlots as $timeSlot) {
            $price = $timeSlot['price'];
            $slot = $timeSlot['time'];
        ?>
        <!-- Card Content -->
        <div class="col-lg-4 col-md-6 col-12 d-flex justify-content-center mb-3"> <!-- Responsive columns -->
            <div id="cardInfo-<?php echo $index; ?>" class="card info-card revenue-card w-100" onclick="goTo(<?php echo $index; ?>)">
                <div class="card-body text-center">
                    <hr id="hr-<?php echo $index; ?>" style="border: 2px solid green;">
                    <div>
                        <h4 id="card-date-<?php echo $index; ?>"></h4>
                        <h6 id="card-slot-<?php echo $index; ?>"><?php echo $slot; ?></h6>
                        <b class="text-muted small">
                            <div style="display: flex; align-items: center; justify-content: center">
                                <div id="colorIndicator-<?php echo $index; ?>-1" class="color-indicator-slot" style="display: none"></div>&nbsp;
                                <span id="card-team-<?php echo $index; ?>-1">!?</span><br>
                            </div>
                            VS <br>
                            <div style="display: flex; align-items: center; justify-content: center">
                                <div id="colorIndicator-<?php echo $index; ?>-2" class="color-indicator-slot" style="display: none"></div>&nbsp;
                                <span id="card-team-<?php echo $index; ?>-2">!?</span><br>
                            </div>
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Content -->
        <?php
          $index++;
        }
        ?>

        </div>
      </div>
      <!-- End Time Card -->

    </div>
  </section>

</main>
<!-- End #main -->

<?php
  include "components/footer.php";
?>