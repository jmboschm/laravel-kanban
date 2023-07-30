<template>
    <FullCalendar :options="calendarOptions" />   
  
    <modal-calendar v-if="showModal" :form="newEvent" @closeModal="closeModal" @saveAppt="saveAppt" @deleteAppt="deleteAppt" @editAppt="editAppt"></modal-calendar>
</template>
<script>

import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import esLocale from '@fullcalendar/core/locales/es'
import iCalendarPlugin from '@fullcalendar/icalendar'
import axios from 'axios'
import ModalCalendar from './Modals/CalendarModal.vue'
import { router  } from "@inertiajs/vue3"


export default {
    components: {
        FullCalendar,
        ModalCalendar
    },
  emits: {
        'deleteAppt':{
          id:'',
        },
        'editAppt':{
          id:'',
        },
        'closeModal':true,
        'saveAppt':{id:'',},
      },
    data() {
        return {
          showModal: false,
          editing : false,
          newEvent: {
                title: '',
                date_at: '',
                end_at: '',
                color: ''
            },
        //    details: [], //  My data that is filled in by the AJAX call
        //    hash:  '',   //  My blank variable
        //    url:  route('appointments.filter', hash),   //  route that needs the variable loaded by AJAX
        calendarOptions : {
            plugins: [ dayGridPlugin,timeGridPlugin, listPlugin,interactionPlugin,iCalendarPlugin],
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
            events: [],
            dateClick: this.handleDateClick,
            eventClick: this.handleEventClick,
            eventSources: [
            {
              url : '/calendarifestius_ca.ics',
              format : 'ics',
              color: 'darkred',
            },
            ]
        }
        }
    },
    beforeMount(){
      this.$data.calendarOptions.events = {
        url: route('appointments.index'),
        method: 'GET',
        failure: error => {
          console.log('tenemos este error: ', error.message);
        }
      }
    },
    methods: {
        handleDateClick(clickInfo){
          //console.log('handleClickEventInfo : ',clickInfo);
            this.$emit('dateClick',clickInfo)
        },
        getEvents: function(){
          axios.get('/appointments').then((response) => {
            this.calendarOptions.events = response.data;
          }, (error)=> {
          })
            
        },
        handleEventClick(eventInfo) {
        //console.log(eventInfo);
        let updatedData = {
              date_at: eventInfo.event._instance.range.start,
              end_at: eventInfo.event._instance.range.end
            }
        let start_time = updatedData.date_at.toISOString().split("T")[0];
        let finish_time = updatedData.end_at.toISOString().split("T")[0];
        let title = eventInfo.el.fcSeg.eventRange.def.title;
        let appointmentId = eventInfo.el.fcSeg.eventRange.def.publicId;
        //console.log(appointmentId);
        let params = { id: [appointmentId], start: [start_time], finish: [finish_time], title: [title], }
        let parseado = JSON.parse(JSON.stringify(params));
        axios.get(route('appointments.filter',{parseado,type:1})).then( ({data}) => {
          //this.$data.showModal=true;
          //this.setModalOpen(data);
          //console.log('aqui ve data: ',data);
          var updatedEventData = {
            id: data.id,
            user_id: data.user_id,
            start_time: data.start_time,
            finish_time: data.finish_time,
            color: data.color,
          }
          //console.log(updatedEventData);
          this.editing = true,
          this.setModalOpen(updatedEventData);

        });
          
          
          
       //   console.log(updatedEventData);
          
        },
       
        setModalOpen(obj) {
          this.$data.showModal = true
          
            this.newEvent.title = obj.title,
            this.newEvent.date_at = obj.start_time,
            this.newEvent.end_at = obj.finish_time, 
            this.newEvent.color = obj.color,
            this.newEvent.user_id = obj.user_id
        
            //console.log(obj);
            if(this.editing == true){
              return  {
              //title : this.obj.title,
              id: obj.id,
              title: obj.title,
              date_at : obj.start_time,
              end_at : obj.finish_time, 
              color : obj.color,
              user_id : obj.user_id
              }
              //this.editing = false
              
            }else {
            return;
            }
           
        },
        closeModal() {
          this.$data.showModal = false
        },
        deleteAppt(param) {
          
          let event = JSON.parse(JSON.stringify(param));
          //console.log(appointment.date_at);
          event = { start: [event.date_at], end: [event.end_at], title: [event.title], user_id: [event.user_id] }
         // console.log('params: ', event);
          let parseado = JSON.parse(JSON.stringify(event));
          axios.get(route('appointments.filter', {parseado , type: 2}
            
          ))
          .then( ({data}) => {
         // console.log('aqui ve data: ', data[0]);
          var updatedEventData = {
            id: data[0].id,
            user_id: data[0].user_id,
            start_time: data[0].start_time,
            finish_time: data[0].finish_time,
            color: data[0].color,
          }
          //console.log('vaig a borrar: ', updatedEventData);
          router.delete(route('appointments.destroy',{appointment: data[0]}), {
            onSuccess: this.closeModal()
          });
        });
           
        },
        saveAppt(param){
          let event = JSON.parse(JSON.stringify(param));
          
          this.id = param.id
          this.end_at = param.end_at;
          this.date_at = param.date_at;
          this.user_id = param.user_id;
          this.color = param.color;

          //console.log(param);
            router.put(route('appointments.update', {appointment:event,id:param.id,start_time:param.date_at,finish_time:param.end_at,user_id:param.user_id,color:param.color}), { 
                onSuccess: this.closeModal()
            });
        
        },
      
        /*,
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
        },*/
        /*
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
*/
        rerenderCalendar() {
          this.$refs.fullCalendar.getApi().refetchEvents()
        }
    },
}
</script>

