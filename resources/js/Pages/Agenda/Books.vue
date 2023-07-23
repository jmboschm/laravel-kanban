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
import formatTime from '../../Mixins/transformTime'
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
                hour: '',
                user_id: '',
                session:  1800
            }
        }
    },
    methods : {
        dateClick(arg){
            this.$data.showModal = true
            this.setModalOpen(arg)
            console.log('recibiendo datos: ',arg)
        }
    },
    closeModal() {
        this.$data.showModal = false
    },
    setModalOpen(obj) {
        let dateAndTime = obj.dateStr.split("|")

        this.newEvent.date_at = dateAndTime[0]
        this.newEvent.hour = dateAndTime[1].substr(0,8)
        this.newEvent.user_id = this.$page.user.id
        return;
    },
    saveAppt(param){
        if(param.title === ''){
            alert('No puedes dejar el campo titulo vacio')
        }
        let dataAppt = this.setDurationSession(param)
        
        /*Inertia.post(route('appointment.store'), dataAppt, {
            onSuccess: page =>
            if(Object entries(page.props.errors).length === 0){
                this.closeModal()
            }
            }
        });
        //capturamos excepciones
        Inertia.on("error", event => {
            event.preventDefault();
            console.log('capturamos este error ', error.message);
        });*/

    },
    setDurationSession(form) {
        let dateApt = forn.date_at + " " + forn.hour

        let initSesion = new Date(dateApt)

        const getSecondsSesion = initSesion.getSeconds() + form.session

        initSesion.setSeconds(getSecondsSesion)

        console.info(initSesion.getMonth())

        return {
            title: form.title,
            start: dateApt,
            end: formatTime(initSesion),
            session: form.session,
            user_id: form.user_id
        }
    }
}
</script>

<style>

</style>