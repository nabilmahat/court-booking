<?php
    include "components/header.php";
    $refId = filter_input(INPUT_GET, 'refid', FILTER_SANITIZE_STRING);
?>

<main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>Success</h1>
        <h2>Thank you for booking</h2>
        <h2>Booking Refferal ID: <?php echo $refId; ?></h2>
        <p>Instructions: </p>
        <p>1. Transfer payment to (use Booking Refferal ID) BANK ACCOUNT -> 8605117580 [CIMB BANK - RAFA SPORT SDN BHD]</p>
        <p>2. SCREENSHOT YOUR RECEIPT AND CLICK HERE TO SHARE DIRECTLY TO RAFA WHATSAPP NUMBER 01123239902(KHALID)</p>
        <a class="btn" href="index.php">Continue</a>
      </section>

    </div>
  </main>

  <?php
    include "components/footer.php";
  ?>