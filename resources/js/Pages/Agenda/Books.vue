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
const user_id = window.user_id;
import Calendar from '../../Components/Calendar.vue'
import ModalCalendar from '../../Components/Modals/CalendarModal.vue'
import formatTime from '../../Mixins/transformTime'
import { router } from "@inertiajs/vue3"

export default {
    name: 'Books',
    components: {
        Calendar,
        ModalCalendar
    },
    data() {
        return {
            showModal: false,
            newEvent: {
                title: '',
                date_at: '',
                end_at: ''
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
        //console.log(obj);
        let dateAndTime = obj.dateStr
        this.newEvent.date_at = dateAndTime
        this.newEvent.end_at = dateAndTime
        //this.newEvent.user_id = this.$page.user.id
        //console.log('el user id es ' + form.user_id)
        return;
    },
    saveAppt(param){
        console.log(param)
        if(param.title === ''){
            alert('No puedes dejar el campo titulo vacio')
        }
        //seteamos una variable
       // let dataAppt = this.setDurationSession(param)
        
        /*$this.Inertia.post(route('appointment.store'), dataAppt, {
            onSuccess: page =>
                if(Object.entries(page.props.errors).length === 0){
                    this.closeModal()
                }
            });
        
        //capturamos excepciones
        $this.Inertia.on("error", event => {
            event.preventDefault();
            console.log('capturamos este error ', error.message);
        });*/
        router.post('/appointment'), {data: param}, {
            preserveState: true,
            replace: true,
            onSuccess: () => this.closeModal()
        };    
        
    },
    setTypeVacation(form) {
        let dateApt = form.date_at;
        let dateEnd = form.end_at;

        //let initSesion = new Date(dateApt);

        //const getSecondsSesion = initSesion.getSeconds() + form.session;

        //initSesion.setSeconds(getSecondsSesion);

     //   console.info(initSesion.getMonth());

        return {
            title: form.title,
            start: dateApt,
            end: dateEnd, 
        }
    }
    }
}
</script>

<style>

</style>