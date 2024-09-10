<?php
  include "components/header.php";
?>

<!-- Start #main -->
<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Book your <b>field</b></h1>
  </div>
  <!-- End Page Title -->

  <section class="section dashboard">
    <div class="row d-flex justify-content-center align-items-center">

      <!-- Start Calendar -->
      <div id='calendar'></div>

      <!-- Add modal -->

      <div class="modal fade edit-form" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog" role="document">
              <!-- <div class="modal-content">
                  <div class="modal-header border-bottom-0">
                      <h5 class="modal-title" id="modal-title">Add Event</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="myForm">
                      <div class="modal-body">
                          <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                              End date should be greater than start date.
                            </div>
                          <div class="form-group">
                              <label for="event-title">Event name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="event-title" placeholder="Enter event name" required>
                          </div>
                          <div class="form-group">
                              <label for="start-date">Start date <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="start-date" placeholder="start-date" required>
                          </div>
                          <div class="form-group">
                              <label for="end-date">End date - <small class="text-muted">Optional</small></label>
                              <input type="date" class="form-control" id="end-date" placeholder="end-date">
                          </div>
                          <div class="form-group">
                              <label for="event-color">Color</label>
                              <input type="color" class="form-control" id="event-color" value="#3788d8">
                            </div>
                      </div>
                      <div class="modal-footer border-top-0 d-flex justify-content-center">
                          <button type="submit" class="btn btn-success" id="submit-button">Submit</button>
                        </div>
                  </form>
              </div> -->
          </div>
      </div>

      <!-- Delete Modal -->
      <!-- <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="delete-modal-title">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="delete-modal-body">
              Are you sure you want to delete the event?
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-sm" data-dismiss="modal" id="cancel-button">Cancel</button>
              <button type="button" class="btn btn-danger rounded-lg" id="delete-button">Delete</button>
            </div>
          </div>
        </div>
      </div> -->
        
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
        <div class="d-flex justify-content-center">
          <div class="card info-card revenue-card" onclick="goTo(<?php echo $index; ?>)">
            <div class="card-body text-center">
              <hr style="border: 2px solid green;">
              <div>
                <h4 id="card-date-<?php echo $index; ?>"></h4>
                <h6 id="card-slot-<?php echo $index; ?>"><?php echo $slot; ?></h6>
                <b class="text-muted small">!? BOOK NOW !?</b>
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