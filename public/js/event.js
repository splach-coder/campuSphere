$(document).ready(function () {
    // Initialize fullCalendar with options and event data
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventLimit: true,
        events: '../controller/events.php', // URL to fetch event data from server using AJAX
        eventClick: function (event) {
            // Show the event data in a modal for editing
            $('#eventModalLabel').text('Event');
            $('#eventName').val(event.name);
            $('#eventDate').val(event.date);
            $('#eventTime').val(event.time);
            $('#eventLocation').val(event.location);
            $('#eventDescription').val(event.description);
            $('#eventId').val(event.id);
            $('#eventModal').modal('show');
        },
        eventDrop: function (event, delta, revertFunc) {
            // Update the event data when the user drags and drops an event
            updateEvent(event);
        },
        eventResize: function (event, delta, revertFunc) {
            // Update the event data when the user resizes an event
            updateEvent(event);
        }
    });
});