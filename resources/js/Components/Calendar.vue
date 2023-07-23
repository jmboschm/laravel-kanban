<template>
    
    <FullCalendar :options="calendarOptions"/>    

</template>
<script>

import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import esLocale from '@fullcalendar/core/locales/es'

export default {
    components: {
        FullCalendar,
    },
    data() {
        return {
        calendarOptions : {
            plugins: [ dayGridPlugin,timeGridPlugin, listPlugin,interactionPlugin],
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
            },
            initialView: 'dayGridMonth',
            locale: esLocale,
            dayMaxEvents: true,
            navLinks: true,
            firstDay: 1,
            defaultAllDay: true,
            timeZone: 'Europe/Madrid',
            height: "auto",
            dateClick: this.handleDateClick,
        }
        }
    },
    methods: {
        handleDateClick(clickInfo){
            this.$emit('dateClick',clickInfo)
        }
    }
}
</script>
