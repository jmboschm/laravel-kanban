<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calendar</h2>   
            <span>{{ $page.user }}</span>
        </template>    
        <div class="py-12">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <Calendar @dateClick="dateClick"/>
            </div>
        </div>
    </div>
    <modal-calendar v-if="showModal" :form="newEvent" @closeModal="closeModal" @saveAppt="saveAppt"></modal-calendar>
    
    </app-layout>
</template>
<script>

import Calendar from '../../Components/Calendar.vue'
import ModalCalendar from '../../Components/Modals/CalendarModal.vue'
//import AddAppointmentModal from '../../Components/Modals/AddAppointmentModal.vue'
import formatTime from '../../Mixins/transformTime'
import { usePage } from "@inertiajs/vue3"
import { router  } from "@inertiajs/vue3"
//import route from '../../ziggy'
//import axios from 'axios'

export default {
    name: 'Books',
    components: {
        Calendar,
        //AddAppointmentModal,
        ModalCalendar
    },
    data() {
        return {
            showModal: false,
            newEvent: {
                title: '',
                date_at: '',
                end_at: '',
                color: ''
            }
        }
    },
    methods : {
        dateClick(arg){
            this.$data.showModal = true;
            this.setModalOpen(arg);
            //console.log('recibiendo datos: ',arg)
        },
    closeModal() {
        this.$data.showModal = false
    },
    setModalOpen(obj) {
        this.$data.showModal = true
        //console.log(obj);
        const page = usePage()
        //let dateAndTime = obj.dateStr
        this.newEvent.date_at = obj.dateStr
        let endTime = obj.dateStr
        this.newEvent.end_at = endTime
        this.newEvent.color = ''
        this.newEvent.user_id = page.props.auth.user.id
        //console.log('el user id es ' + form.user_id)
        return;
    },
    saveAppt(param){
        console.log(param)
        if(param.title === ''){
            alert('No puedes dejar el campo titulo vacio')
        }
        //seteamos una variable
      //  let dataAppt = this.setTypeVacation(param)
      //  console.log('aixo es datappt ' + dataAppt);
        //console.log(dataAppt);
     /*   $this.Inertia.post(route('appointment.store'), dataAppt, {
            onSuccess: page =>
                if(Object.entries(page.props.errors).length === 0){
                    this.closeModal()
                }
            });
        
        //capturamos excepciones
        /*$this.Inertia.on("error", event => {
            event.preventDefault();
            console.log('capturamos este error ', error.message);
        });*/
        router.post(route('appointments.store'), param)
        /*
        const form = useForm({dataAppt});
        
        form.submit('post',route('appointment.store'), {
            preserveState: true,
            replace: true,
            onSuccess: () => this.closeModal()
        });
        form.submit('post',route('appointment.store'), {
        onError: () => event => {
            event.preventDefault();
            console.log('capturamos este error ', error.message);
        }});*/
    
    },
    setTypeVacation(form) {
        let dateApt = form.date_at;
        let dateEnd = form.end_at;
        let colorVacation = form.color

        //let initSesion = new Date(dateApt);
        const page = usePage()
        //const getSecondsSesion = initSesion.getSeconds() + form.session;

        //initSesion.setSeconds(getSecondsSesion);

     //   console.info(initSesion.getMonth());

        return {
            title: form.title,
            start: dateApt,
            end: dateEnd, 
            color: colorVacation,
            user_id: page.props.auth.user.id 
        }
    }
    }
}
</script>

<style>

</style>