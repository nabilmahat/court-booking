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
                        totalBookings: event.total_bookings,
                        backgroundColor: eventDate < today ? 'grey' : event.total_bookings < 1 ? 'green' :
                                          event.total_bookings > 0 && event.total_bookings < 11 ? 'orange' : 'red',
                        allDay: true,
                        editable: false
                    };
                } else {
                    aggregatedEvents[date].totalBookings += event.total_bookings;
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
        fetchBookingsForDate(formatDate(getCurrentDate()));
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
            
                var selectedDate = formatDate(info.dateStr);
                // updateCardDate(selectedDate);
                fetchBookingsForDate(info.dateStr);
            },            

            datesRender: function (info) {
                const start = info.view.currentStart;
                const end = info.view.currentEnd;

                console.log('Start of the current month:', formatDate(start));
                console.log('End of the current month:', formatDate(end));
            },
            showNonCurrentDates: false,
        });

        calendar.render();
    }

    function formatDate(dateStr) {
        var date = new Date(dateStr);
        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function fetchBookingsForDate(date) {
        $.ajax({
            url: 'query/slots.php',
            type: 'POST',
            data: { date: date },
            success: function(response) {
                var bookings = JSON.parse(response);
                updateRevenueCards(bookings, date);
            }
        });
    }

    function updateRevenueCards(bookings, date) {
        for (var i = 0; i < 11; i++) {
            var bookingInfo = bookings[i] ? bookings[i].team_name : '!? BOOK NOW !?';
            document.getElementById('card-date-' + i).innerText = date;
            document.getElementById('booking-info-' + i).innerText = bookingInfo;
        }
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
