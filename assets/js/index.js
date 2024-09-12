function goTo(index) {
    const dateElement = document.getElementById(`card-date-${index}`);
    
    const date = dateElement.innerText;
    const formattedDate = convertDate(date);

    console.log("Date:", formattedDate);
    console.log("Slot:", index);
    
    // Add your navigation logic or other actions here
    window.location.href="booking.php?date=" + formattedDate + "&&slot=" + index;
  }

  // show/hide opponent form
  document.addEventListener('DOMContentLoaded', function() {
    const noOpponentRadio = document.getElementById('no_opponent');
    const haveOpponentRadio = document.getElementById('have_opponent');
    const opponentDetails = document.getElementById('opponent-details');

    function toggleOpponentDetails() {
      if (haveOpponentRadio.checked) {
        opponentDetails.style.display = 'block';
      } else {
        opponentDetails.style.display = 'none';
      }
    }

    // show color indicator 1
    const selectElement1 = document.getElementById('colorSelect1');
    const colorIndicator1 = document.getElementById('colorIndicator1');

    selectElement1.addEventListener('change', (event) => {
      console.log(event.target.value);
        colorIndicator1.style.backgroundColor = event.target.value;
    });

    // Set initial color 1
    colorIndicator1.style.backgroundColor = selectElement1.value;

    // show color indicator 2
    const selectElement2 = document.getElementById('colorSelect2');
    const colorIndicator2 = document.getElementById('colorIndicator2');

    selectElement2.addEventListener('change', (event) => {
        colorIndicator2.style.backgroundColor = event.target.value;
    });

    // Set initial color 2
    colorIndicator2.style.backgroundColor = selectElement2.value;

    noOpponentRadio.addEventListener('change', toggleOpponentDetails);
    haveOpponentRadio.addEventListener('change', toggleOpponentDetails);

    // Initial check
    toggleOpponentDetails();
  });