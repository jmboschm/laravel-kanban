<script>


import formatTime from '../../Mixins/transformTime'
import { usePage } from "@inertiajs/vue3"
import { router  } from "@inertiajs/vue3"
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'
import Calendar from '../../Components/Calendar.vue'
import ModalCalendar from '../../Components/Modals/CalendarModal.vue'
import axios from 'axios'


export default {
    name: 'Books',
    components: {
        Calendar,
        ModalCalendar,
        AuthenticatedLayout 
    },
    emits: {'deleteAppt':null,'editAppt':null,'closeModal':true,'saveAppt':null},
    props: {
        errors: Object,
    },
    data() {
        return {
            showModal: false,
            newEvent: {
                title: '',
                date_at: '',
                end_at: '',
                color: '',
                user_id: ''
            }
        }
    },
    methods : {
        dateClick(arg){
            this.$data.showModal = true;
            this.setModalOpen(arg);
        },
        handleEventClick(eventInfo){
          //  console.log('handleClickEventInfo :',eventInfo);
            let updatedData = {
              date_at: eventInfo.event._instance.range.start,
              end_at: eventInfo.event._instance.range.end
            }
        let start_time = updatedData.date_at.toISOString().split("T")[0];
        let finish_time = updatedData.end_at.toISOString().split("T")[0];
        let title = eventInfo.el.fcSeg.eventRange.def.title;
      
        let appointmentId = eventInfo.el.fcSeg.eventRange.def.publicId;
        console.log(appointmentId);
        let params = { id: [appointmentId], start: [start_time], finish: [finish_time], title: [title] }
        //console.log(datos);
        axios.get(route('appointments.filter'), {params}).then( ({data}) => {
         
          var updatedEventData = {
            user_id: data[0].user_id,
            start_time: data[0].start_time,
            finish_time: data[0].finish_time,
            color: data[0].color,
          }
        //  console.log(updatedEventData);
          this.$data.showModal = true
          this.setModalOpen(updatedEventData)
          //axios.delete(route('appointments.delete'),{updatedEventData});
        });
        },
    closeModal() {
        this.$data.showModal = false
    },
    setModalOpen(obj) {
        this.$data.showModal = true
        
        this.newEvent.date_at = obj.dateStr
        let endTime = obj.dateStr
        this.newEvent.end_at = endTime
        this.newEvent.color = obj.color
        this.newEvent.user_id = obj.user_id
        
    },
    resetModal() {
        
        this.newEvent = {
        title : '',
        date_at: '',
        end_at: '',
        color: '',
        user_id: ''
        }
       
    },
    saveAppt(param){
        
        router.post(route('appointments.store'), param, { 
            onSuccess: this.closeModal()
        });
    
    },
    setTypeVacation(form) {
        let dateApt = form.date_at;
        let dateEnd = form.end_at;
        let colorVacation = form.color

        return {
            title: '',
            start: dateApt,
            end: dateEnd, 
            color: colorVacation,
            user_id: form.user_id
        }
    },
    deleteAppt(param){
        
        console.log('aqui esta la destruccio del param ', param);

        router.post(route('appointments.destroy'), param, {
            onSuccess: 
            this.closeModal()
        });         
    },
                
        //});
    
    },
    
}
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calendar</h2>
        </template>  
      
        <div v-if="$page.props.flash.success"
      class="alert alert-dismissible fade show items-center justify-between rounded-lg bg-green-500 py-4 px-6 text-center text-white md:flex md:text-left">
      <div class="mb-4 flex flex-wrap items-center justify-center md:mb-0 md:justify-start">
        {{ $page.props.flash.success }}
      </div>
    </div>
        
        <div class="py-12">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Calendar @dateClick="dateClick" @eventClick="handleEventClick"/>
            </div>
        </div>
    </div>
    <modal-calendar v-if="showModal" :form="newEvent" @closeModal="closeModal" @saveAppt="saveAppt" @eventClick="handleEventClick" @deleteAppt="deleteAppt" @editAppt="editAppt"></modal-calendar>
</AuthenticatedLayout>
</template>