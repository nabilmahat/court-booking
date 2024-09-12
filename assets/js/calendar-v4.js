$(document).ready(function() {
    const calendarEl = document.getElementById('calendar');
    let calendar;

    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth() + 1; // Months are zero-based in JavaScript

    function fetchEvents(year, month) {
        $.get("query/bookings.php", { year: year, month: month }, function(data) {
            const aggregatedEvents = {};
    
            data.bookings.forEach(event => {
                const date = event.booking_date;
                const totalBookings = Number(event.total_bookings); // Convert total_bookings to a number
                console.log("totalBookings: ", totalBookings);
    
                // Check if the event date is in the past
                const eventDate = new Date(date);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time for accurate comparison
                eventDate.setHours(0, 0, 0, 0);
    
                if (!aggregatedEvents[date]) {
                    aggregatedEvents[date] = {
                        id: date, // Use date as a unique ID
                        title: '', // Default to empty string if title is not provided
                        start: date,
                        totalBookings: totalBookings, // Store as a number
                        backgroundColor: eventDate < today ? 'grey' : totalBookings < 1 ? 'green' :
                                          totalBookings > 0 && totalBookings < 22 ? 'orange' : 'red',
                        allDay: true,
                        editable: false
                    };
                } else {
                    aggregatedEvents[date].totalBookings = totalBookings; // Add as a number
                    aggregatedEvents[date].backgroundColor = eventDate < today ? 'grey' : aggregatedEvents[date].totalBookings < 1 ? 'green' :
                                              aggregatedEvents[date].totalBookings > 0 && aggregatedEvents[date].totalBookings < 11 ? 'orange' : 'red';
                }
            });
    
            const events = Object.values(aggregatedEvents);
    
            console.log(events);
    
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching events:', textStatus, errorThrown);
        });
    }

    function initializeCalendar() {
        updateCardDate(formatDate(getCurrentDate()));
        calendar = new FullCalendar.Calendar(calendarEl, {
            header: { // layout header
                left: 'title', 
                center: '',
                right: 'prev, next'
              },
            plugins: ['dayGrid', 'interaction'],
            allDay: false,
            editable: true,
            selectable: true,
            unselectAuto: false,
            displayEventTime: false,
            events: [], // Initially empty, to be populated via fetchEvents

            // eventDrop: function (info) {
            //     // Handle event drop (if needed)
            //     console.log('Event dropped:', info.event);
            // },

            select: function(info) {
                var startDate = new Date(info.startStr);
                var endDate = new Date(info.endStr);
                var differenceMs = endDate - startDate;
                var differenceDays = differenceMs / (1000 * 60 * 60 * 24);
                if (differenceDays > 1) {
                    calendar.unselect();
                }
            },

            dateClick: function(info) {
                var clickedDate = new Date(info.dateStr);
                var today = new Date();
                
                // Reset time for comparison
                today.setHours(0, 0, 0, 0);
                clickedDate.setHours(0, 0, 0, 0);
            
                if (clickedDate < today) {
                    calendar.unselect();
                    return;
                }
                updateCardDate(formatDate(info.dateStr));
            },            

            datesRender: function (info) {
                const start = info.view.currentStart;
                const end = info.view.currentEnd;

                // console.log('Start of the current month:', formatDate(start));
                // console.log('End of the current month:', formatDate(end));
            },
            showNonCurrentDates: false,
            eventLongPressDelay: 0,
        });

        calendar.render();
    }

    function formatDate(dateStr) {
        var date = new Date(dateStr);
        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function updateCardDate(date) {
        // Format the date to be compatible with your PHP script
        var formattedDate = new Date(date);
        var year = formattedDate.getFullYear();
        var month = String(formattedDate.getMonth() + 1).padStart(2, '0');
        var day = String(formattedDate.getDate()).padStart(2, '0');
        
        var startDate = `${year}-${month}-${day}`;
    
        // Perform an AJAX request to fetch bookings data
        $.ajax({
            url: 'query/slots.php',
            method: 'GET',
            data: {
                date: startDate
            },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                    return;
                }
    
                // Reset the UI for all slots
                for (var a = 0; a < 11; a++) {
                    var element = document.getElementById('card-date-' + a);
                    if (element) {
                        element.innerText = `${date}`;
                    }

                    document.getElementById('card-team-' + a + '-1').textContent = "!?";
                    document.getElementById('colorIndicator-' + a + '-1').style.display = 'none';
                    document.getElementById('card-team-' + a + '-2').textContent = "!?";
                    document.getElementById('colorIndicator-' + a + '-2').style.display = 'none';
                    document.getElementById('hr-' + a).style.border = '2px solid green';
                }
    
                // Map response data to the correct slots and teams
                response.forEach(function(booking) {
                    var slot = booking.booking_slot;
                    var order = booking.team_order;
                    
                    // Update the team and color for the correct slot and order
                    document.getElementById('card-team-' + slot + '-' + order).textContent = booking.team_name + " (" + booking.team_age + ")";
                    document.getElementById('colorIndicator-' + slot + '-' + order).style.display = 'block';
                    document.getElementById('colorIndicator-' + slot + '-' + order).style.backgroundColor = booking.jersey_color;
    
                    // Change the border color based on the team order
                    if (order == 1) {
                        document.getElementById('hr-' + slot).style.border = '2px solid orange';
                    } else if (order == 2) {
                        document.getElementById('hr-' + slot).style.border = '2px solid red';

                        // Select the element by its id
                        var cardElement = document.getElementById('cardInfo-'+slot); // Replace '1' with the appropriate index or variable
                        // Remove the onclick function
                        if (cardElement) {
                            cardElement.onclick = null;
                        }
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching bookings:', textStatus, errorThrown);
            }
        });
    }
    

    function getCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(today.getDate()).padStart(2, '0'); // Pad single-digit days
        
        return `${year}-${month}-${day}`;
    }

    initializeCalendar();
    fetchEvents(currentYear, currentMonth);

    // Handle navigation buttons
    $(document).on('click', '.fc-prev-button', function() {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        fetchEvents(currentYear, currentMonth);
    });

    $(document).on('click', '.fc-next-button', function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        fetchEvents(currentYear, currentMonth);
    });
});
