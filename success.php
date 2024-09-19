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
        <p>1. Transfer payment to (use Booking Refferal ID) BANK ACCOUNT -> <b> 5643 9714 0979 [MAYBANK - MD STRATEGIC]</b></p>
        <p>2. Screenshot Your Receipt And Click Here To Share Directly To RAFA Whatsapp Number 017-8858327(MAN) / 011-3776 7483</p>
        <a class="btn" href="https://dragoarena.wasap.click/" target="_blank">Whatsapps for Confirm Booking</a>
        <br>
        <a class="btn" href="index.php">Home</a>
      </section>

    </div>
  </main>

  <?php
    include "components/footer.php";
  ?>