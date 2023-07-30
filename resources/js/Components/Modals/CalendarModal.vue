<template>
  <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div
      class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
    >
      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <!-- This element is to trick the browser into centering the modal contents. -->
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
                
                
                      <!-- start select -->
                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="user_id"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >Usuario</label>
                        <!--//form.user_id-->
                        <select
                          
                          v-model="form.user_id"
                          @getIdByUser="getIdByUser"
                        :label="'All users'"
                        :usersData="users"
                          class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        >
                        <option v-for="user in users" :key="user.id" :value="user.id" :selected="user.id">
                                      {{ user.name }}
                        </option>
                        </select>
                      </div>
                      <!-- end select -->
                  <!-- Options select -->
                  <div
                    class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj"
                  >
                    <!-- partial component -->
                  </div>
                  <!-- end Options -->
                  <div v-if="$page.props.errors.user_id" class="text-red-500">{{ $page.props.errors.user_id[0]}}</div>
                <!-- comienzo input -->
              </div>
              
              <div class="mb-4">
                <label
                  for="exampleFormControlInput1"
                  class="block text-gray-700 text-sm font-bold mb-2"
                >Fecha de Inicio</label>
               
                <appdate-picker
                  v-model="form.date_at"
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
                  v-model="form.end_at"
                  placeholder="Select Date"
                  :value="defaultValue"
                  language="es"
                  class="vcalendar"
                  @input="dateSelected"
                >
                </appdate-picker>
                <div v-if="$page.props.errors.end_at" class="text-red-500">{{ $page.props.errors.end_at[0]}}</div>
              </div>
              <!-- start select -->
              <div class="col-span-6 sm:col-span-3">
                <label
                  for="typeVacation"
                  class="block text-sm font-medium leading-5 text-gray-700"
                >Motivo</label>
                <select
                  id="typeVacation"
                  v-model="form.color"
                  class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                >
                  <option value="red">Vacances</option>
                  <option value="khaki">Dies Personals</option>
                  <option value="black">Baixa</option>
                </select>
                <div v-if="$page.props.errors.color" class="text-sm text-red-600">{{ $page.props.errors.color[0] }}</div>
              </div>
              <!-- end select -->
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
              type="button"
              class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline"
              @click.prevent="store(form)"
            >Guardar</button>
            <button
              type="button"
              class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline"
              @click.prevent="remove(form)"
            >Eliminar</button>
            <button
              type="button"
              class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline"
              @click.prevent="closeModal"
            >atrás</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AppdatePicker from 'vuejs3-datepicker'
import { ref } from 'vue';

export default {
  name: "Modal",
  components: {
    AppdatePicker,
  },
  props:{
    errors:{
      type: Object,
      default: ()=>{}
    },
    form:{
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
  data(){
    return{
      user_id: '',
      users: [],
    }
  },
  mounted() {
        axios.get('/users')
            .then(({
                data
            }) => {
                this.users = data
            })
            .catch(error => {
                this.users = []
            })
    },
  methods:{
    addCloseEvents() {
      if (!this.closeEventListener) {
        this.closeEventListener = e => this.inspectCloseEvent(e);
        ['click', 'keyup'].forEach(
            eventName => document.addEventListener(eventName, this.closeEventListener)
        );
        }
      },
    closeModal(){
      this.$emit('closeModal')
    },
    store(form){
      this.$emit('saveAppt',form)
    },
    remove(form){
      this.$emit('deleteAppt',form)
    },
    handleEventClick(form){
      this.$emit('editAppt',form[1])
    },
    getIdByUser(user) {
      // get user id
      this.user_id = user.id;
    },
  },
};
</script>

<style scoped>
.top-100 {
  top: 100%;
}
.bottom-100 {
  bottom: 100%;
}

.max-h-select {
  max-height: 300px;
}

.vuejs3-datepicker__calendar {
    display: contents;
}
</style>