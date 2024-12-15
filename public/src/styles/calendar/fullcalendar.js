
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        events: '/reservations/api', // Endpoint to fetch reservations
        eventColor: 'red',
        selectable: true,
        selectOverlap: false,
        select: function(info) {
            // Handle slot selection
            console.log(info.startStr, info.endStr);
        }
    });

    calendar.render();
});

    