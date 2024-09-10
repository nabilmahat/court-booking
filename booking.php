<?php
  include "components/header.php";

  $paramSlot = filter_input(INPUT_GET, 'slot', FILTER_SANITIZE_STRING);
  $paramDate = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);
?>

<!-- Start #main -->
<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Complete your <b>details</b></h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Your Details</li>
    </ol>
  </div>
  <!-- End Page Title -->

  <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">1. YOUR DETAILS</h5>
              
                <div class="row mb-5">
                  <label class="col-sm-2 col-form-label">Total Payment: RM<?php echo $timeSlots[$paramSlot]['price'] ; ?> / team</label>
                </div>

              <!-- Start Form Elements -->
              <form action="booking-confirm.php" method="post">
              
              <!-- hidden data -->
              <input type="hidden" name="slot" value="<?php echo htmlspecialchars($paramSlot); ?>">
              <input type="hidden" name="date" value="<?php echo htmlspecialchars($paramDate); ?>">
              <!-- hidden data -->

                <div class="row mb-5">
                  <label class="col-sm-2 col-form-label">TEAM DETAILS</label>
                  <div class="col-sm-10">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="teamName" name="teamName" placeholder="Memerang Sakti">
                      <label for="teamName">Team Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="yourName" name="yourName" placeholder="John Doe">
                      <label for="yourName">Your Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="+60123456789">
                      <label for="contactNumber">Contact Number</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-5">
                  <label class="col-sm-2 col-form-label">CATEGORY TEAM AGE</label>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="teamCategory" id="gridRadios1" value="vet" checked>
                      <label class="form-check-label" for="gridRadios1">Vet</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="teamCategory" id="gridRadios2" value="semi_vet">
                      <label class="form-check-label" for="gridRadios2">Semi Vet</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="teamCategory" id="gridRadios3" value="open">
                      <label class="form-check-label" for="gridRadios3">Open</label>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">JERSEY COLOR</label>
                  <div class="col-sm-2">
                    <div class="color-container">
                      <select id="colorSelect1" name="jerseyColor1" class="form-select" aria-label="Jersey Color Select">
                        <option value="#FFFFFF" style="background-color: #FFFFFF;">White</option>
                        <option value="#C0C0C0" style="background-color: #C0C0C0;">Silver</option>
                        <option value="#808080" style="background-color: #808080;">Gray</option>
                        <option value="#000000" style="background-color: #000000;">Black</option>
                        <option value="#FF0000" style="background-color: #FF0000;">Red</option>
                        <option value="#800000" style="background-color: #800000;">Maroon</option>
                        <option value="#808000" style="background-color: #808000;">Olive</option>
                        <option value="#FFFF00" style="background-color: #FFFF00;">Yellow</option>
                        <option value="#00FF00" style="background-color: #00FF00;">Lime</option>
                        <option value="#008000" style="background-color: #008000;">Green</option>
                        <option value="#00FFFF" style="background-color: #00FFFF;">Aqua</option>
                        <option value="#008080" style="background-color: #008080;">Teal</option>
                        <option value="#0000FF" style="background-color: #0000FF;">Blue</option>
                        <option value="#000080" style="background-color: #000080;">Navy</option>
                        <option value="#FF00FF" style="background-color: #FF00FF;">Fuchsia</option>
                        <option value="#800080" style="background-color: #800080;">Purple</option>
                      </select>
                      <div id="colorIndicator1" class="color-indicator"></div>
                    </div>
                  </div>
                </div>

                <div class="row mb-5">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="opponent" id="no_opponent" value="no_opponent" checked>
                      <label class="form-check-label" for="no_opponent">Looking For Opponent?</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="opponent" id="have_opponent" value="have_opponent">
                      <label class="form-check-label" for="have_opponent">Add Opponent</label>
                    </div>
                  </div>
                </div>

                <!-- Only when have_opponent -->
                <div class="row mb-5" id="opponent-details" style="display:none;">
                  <label class="col-sm-2 col-form-label">OPPONENT DETAILS</label>
                  <div class="col-sm-10">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="teamOpponentName" name="teamOpponentName" placeholder="Memerang Sakti">
                      <label for="teamOpponentName">Team Opponent Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="teamOpponentContactNumber" name="teamOpponentContactNumber" placeholder="+60123456789">
                      <label for="teamOpponentContactNumber">Team Opponent Contact Number</label>
                    </div>
                    <label class="col-sm-2 col-form-label">JERSEY COLOR</label>
                    <div class="col-sm-2">
                      <div class="color-container">
                        <select id="colorSelect2" name="jerseyColor2" class="form-select" aria-label="Jersey Color Select">
                          <option value="#FFFFFF" style="background-color: #FFFFFF;">White</option>
                          <option value="#C0C0C0" style="background-color: #C0C0C0;">Silver</option>
                          <option value="#808080" style="background-color: #808080;">Gray</option>
                          <option value="#000000" style="background-color: #000000;">Black</option>
                          <option value="#FF0000" style="background-color: #FF0000;">Red</option>
                          <option value="#800000" style="background-color: #800000;">Maroon</option>
                          <option value="#808000" style="background-color: #808000;">Olive</option>
                          <option value="#FFFF00" style="background-color: #FFFF00;">Yellow</option>
                          <option value="#00FF00" style="background-color: #00FF00;">Lime</option>
                          <option value="#008000" style="background-color: #008000;">Green</option>
                          <option value="#00FFFF" style="background-color: #00FFFF;">Aqua</option>
                          <option value="#008080" style="background-color: #008080;">Teal</option>
                          <option value="#0000FF" style="background-color: #0000FF;">Blue</option>
                          <option value="#000080" style="background-color: #000080;">Navy</option>
                          <option value="#FF00FF" style="background-color: #FF00FF;">Fuchsia</option>
                          <option value="#800080" style="background-color: #800080;">Purple</option>
                        </select>
                        <div id="colorIndicator2" class="color-indicator"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                  <button type="submit" class="btn btn-primary">Book</button>
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