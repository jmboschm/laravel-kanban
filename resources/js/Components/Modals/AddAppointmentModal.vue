<template>
    <div v-if="show">
        <div class="modal fade show display" v-cloak tabindex="-1" role="dialog" aria-labelledby="AddAppointmentModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Appointment</h5>
                        <button type="button" class="close" @click="closeModal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
    
                    <div class="p-2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons">edit</i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control w-100 modal-title" v-model="event.title" placeholder="Add title ..." ref="eventTitle" autofocus>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <i class="material-icons">event</i>
                                {{ formatDate(date.start) }}
                            </li>
                            <li v-if="users.length > 0" class="list-group-item">
                                <div class="input-group input-group-seamless mb-3" v-if="users.length > 0">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="userSelect">
                                            <i class="material-icons">assignment_ind</i>
                                        </label>
                                    </div>
                                    <select class="custom-select" id="userSelect" v-model="event.user_id">
                                        <option disabled selected value="">
                                            Assign to:
                                        </option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal" data-dismiss="modal">
                            Annulla
                        </button>
                        <button type="button" class="btn btn-primary" @click="saveEvent" :disabled="!validEventData">
                            Salva
                        </button>
                    </div>
    
                </div>
            </div>
        </div>
        <div v-cloak class="modal-backdrop fade show custom-modal-backdrop"></div>
    </div></template>
    <!--<template>
        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
          <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
          >
            <div class="fixed inset-0 transition-opacity">
              <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
             This element is to trick the browser into centering the modal contents. 
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
              role="dialog"
              aria-modal="true"
              aria-labelledby="modal-headline"
            >
              <form>
                <div class="flex justify-between border-b border-gray-100 px-5 py-4">
                  <div>
                    <i class="fas fa-exclamation-circle text-blue-500"></i>
                    <span class="font-bold text-gray-700 text-lg">Reservas</span>
                  </div>
                  <div>
                    <button>
                      <i
                        class="fa fa-times-circle text-red-500 hover:text-red-600 transition duration-150"
                      ></i>
                    </button>
                  </div>
                </div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div class>
                    <div class="mb-4">
                      
                      
                            
                           start select 
                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="userSelect"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        ></label>
                        //form.user_id
                        <select
                          id="userSelect"
                          v-model="event.user_id" 
                          class="custom-select mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        >
                        <option disabled selected value="">
                            Usuario
                                        </option>
                        <option v-for="user in users" :key="user.id" :value="user.id">
                                      {{ user.name }}
                        </option>
                        </select>
                      </div>
                       end select -->
                        <!-- Options select 
                        <div
                          class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj"
                        >
                          partial component 
                        </div>
                         end Options 
                        <div v-if="$page.props.errors.user_id" class="text-red-500">{{ $page.props.errors.user_id[0]}}</div>
                       comienzo input 
                    </div>
                    
                    <div class="mb-4">
                      <label
                        for="exampleFormControlInput1"
                        class="block text-gray-700 text-sm font-bold mb-2"
                      >Fecha de Inicio</label>
                     
                      <appdate-picker
                        v-model="event.start"
                        placeholder="Select Date"
                        :value="defaultValue"
                        language="es"
                        class="vcalendar"
                        :minimum-view="'day'"
                        :maximum-view="'day'"
                        @input="dateSelected"
                      >
                      </appdate-picker>
                      <div v-if="$page.props.errors.date_at" class="text-red-500">{{ $page.props.errors.date_at[0]}}</div>
                    </div>
                    <div class="mb-4">
                      <label
                        for="exampleFormControlInput2"
                        class="block text-gray-700 text-sm font-bold mb-2"
                      >Fecha de Finalización</label>
                      
                      <appdate-picker
                        v-model="event.end"
                        placeholder="Select Date"
                        :value="defaultValue"
                        language="es"
                        class="vcalendar"
                        @input="dateSelected"
                      >
                      </appdate-picker>
                      <div v-if="$page.props.errors.end_at" class="text-red-500">{{ $page.props.errors.end_at[0]}}</div>
                    </div>
                     start select 
                    <div class="col-span-6 sm:col-span-3">
                      <label
                        for="typeVacation"
                        class="block text-sm font-medium leading-5 text-gray-700"
                      >Motivo</label>
                      <select
                        id="typeVacation"
                        v-model="event.color"
                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                      >
                        <option value="red">Vacances</option>
                        <option value="yellow">Dies Personals</option>
                        <option value="black">Baixa</option>
                      </select>
                      <div v-if="$page.props.errors.color" class="text-sm text-red-600">{{ $page.props.errors.color[0] }}</div>
                    </div>
                     end select 
                  </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button
                    type="button"
                    class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline"
                    :disabled="!validEventData" @click="saveEvent"
                  >Guardar</button>
                  <button
                    type="button"
                    class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline"
                    
                  >Eliminar</button>
                  <button
                    type="button"
                    class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline"
                    @click="closeModal"
                  >atrás</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </template>-->
    
    <script>
import axios from 'axios'
import formatTime from '../../Mixins/transformTime'
import moment from 'moment'
import AppdatePicker from 'vuejs3-datepicker'
import { ref } from 'vue';

    export default{
        components: {
            AppdatePicker,
        },
        props: { 
                
            
                errors:{
                    type: Object,
                    default: ()=>{}
                    },
                    
                    defaultValue : {
                    type: String,
                    default: ()=>{ref(new Date())}
                    },
                    dateSelected: {
                    type: String,
                    default: ()=>{payload: Date}
                    },
            },
            data: () => ({
                event: {
                    title: '',
                    user_id: '',
                    start: '',
                    end: '',
                    color: ''
                },
                users: []
            }),
            computed: {
                validEventData() {
                    return !!(this.event.title && this.event.user_id != '')
                }
            },
    
            mounted() {
                // I absctracted my API calls, this would be the same as:
                // axios.get('/users').then( .... ) ...
               /* const instance = (token) => axios.create({
                baseURL: 'http://feina.test/api/',
                timeout: 1000,
                headers: {'Authorization': 'Bearer '+token}
                });*/
                axios.get('/users')
                .then(({
                        data
                    }) => {
                        this.users = data
                    })
                    .catch(error => {
                        this.users = []
                        this.event.assignee = null
                    })
                    
                
                    
            },
            methods: {
                closeModal() {
                    this.event.title = null
                    this.event.user_id = ''
                    this.$emit('close')
                },
    
                formatDate(date, format = 'DD/MM/YY HH:mm') {
                    return moment.utc(date).format(format)
                },
    
                transformEventDates(start, end) {
                    // if start is same as end add 1hr
                    let startTime = new Date(start)
                    let endTime = new Date(end)
    
                    if (startTime.getTime() === endTime.getTime()) {
                        let endTime = (new Date(end))
                        endTime.setHours(endTime.getHours() + 1)
                        return {
                            start,
                            end: endTime.toISOString()
                        }
                    }
                    return {
                        start,
                        end
                    }
                },
    
                saveEvent() {
                    let eventData = this.transformEventDates(this.date.start, this.date.end)
                    let newEventData = {
                        start: eventData.start,
                        end: eventData.end,
                        title: this.event.title,
                        user_id: this.event.user_id,
                    }
    
                axios.appointments.create(newEventData)
                        .then(({
                            data
                        }) => {
                            this.closeModal()
                            this.$emit('event-created')
                        })
                        .catch(error => {
                            this.$emit('error')
                        })
                }
    
            }
        }
    </script>