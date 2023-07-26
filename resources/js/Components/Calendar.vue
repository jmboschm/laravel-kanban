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
import { usePage } from "@inertiajs/vue3"

//import AddAppointmentModal from './Modals/AddAppointmentModal.vue'
//import notie from 'notie'
//import axios from 'axios';

export default {
    components: {
        FullCalendar
        //AddAppointmentModal
    },
emits: {'dateClick': null},
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
            /*calendarEvents:
            {
                url: '/appointments/filter'
            },*/
            dateClick: this.handleDateClick,
        }
        }
    },
    methods: {
        handleDateClick(clickInfo){
            this.$emit('dateClick',clickInfo)
        }/*,
        handleEventDrop(e) {
            let updatedEventData = {
              start: e.event.start,
              end: e.event.end
            }
            axios.appointment.post(e.event.id, updatedEventData)
              .then( ({data}) => {
                new notie({
                  text: `Event has been updated.`,
                  timeout: 700,
                  type: 'success'
                }).show()
              })
              .catch( error => {
                e.revert()
                new notie({
                  text: `Oops, something bad happened while updating your event.`,
                  timeout: 1000,
                  type: 'error'
                }).show()
              })
        },
        handleEventClick(e) {
            this.current_event = e.event
            this.showModal = true
        },
        formatDate(date) {
          return moment.utc(date).format('DD/MM/YY HH:mm')
        },
        resetNewEventData() {
          this.newEvent.start = null
          this.newEvent.end = null
          this.newEvent.title = null
          this.newEvent.showModal = false
        },
        newEventCreated() {
          this.rerenderCalendar()
          this.newEvent.showModal = false
          this.resetNewEventData()
          new notie({
            text: `Appointment has been created.`,
            timeout: 1000,
            type: 'success'
          }).show()
        },
        eventResize(e) {
          let updatedEventData = {
            start: e.event.start,
            end: e.event.end
          }
           axios.appointments.update(e.event.id, updatedEventData)
            .then( ({data}) => {
              new notie({
                text: `Appointment duration updated.`,
                timeout: 1000,
                type: 'success'
              }).show()
            })
            .catch( error => {
              e.revert()
              new notie({
                text: `Oooops, couldn't update appointment duration. Sorry.`,
                timeout: 1000,
                type: 'error'
              }).show()
            })
        },

        rerenderCalendar() {
          this.$refs.fullCalendar.getApi().refetchEvents()
        }*/
        
    }
}
</script>
