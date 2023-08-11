<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from 'vue';
import {Bar,Pie} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, 
    LinearScale, ArcElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale
,ArcElement);

const props = defineProps({
    data:{type:Object}
});

const baixes = ref([]);
const months = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

console.log(props.data['baixes']);


chartOptions.value= { responsive:true}
chartData.value = {
    labels:props.data['months'],
    datasets:[
        {label:'Dies de Baixes', data:props.data['baixes'], backgroundColor:'red'}
    ]
}
</script>

<template>
    <Head title="Charts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Graphic</h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Bar :data="chartData" :options="chartOptions"></Bar>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

