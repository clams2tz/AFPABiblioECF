// assets/js/calendar.js

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin],
        initialView: 'timeGridWeek', // Set to weekly view
        events: [
            // Your events data here
            // Example:
            // {
            //     title: 'Reserved',
            //     start: '2024-12-15T09:00:00',
            //     end: '2024-12-15T11:00:00',
            //     color: 'red'
            // }
        ]
    });

    calendar.render();
});
