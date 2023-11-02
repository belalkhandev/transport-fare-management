<template>
    <Bar :data="chartData" :options="chartOptions" class="chart-canvas"></Bar>
</template>

<script>
    import {Bar} from "vue-chartjs";
    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
        BarElement,
        CategoryScale,
        LinearScale
    } from "chart.js";

    ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

    export default {
        name: 'StudentAttendanceChart',
        components: {
            Bar
        },
        props: {
            chart_data: {
                type: Object
            }
        },
        data() {
            return {
                chartData:{
                    labels: this.chart_data.labels,
                    datasets: [
                        {
                            label: 'Bill',
                            backgroundColor:'#4b87f4',
                            data: this.chart_data.data,
                        },
                    ]
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },
        methods: {
            generalLabelsForMonth () {
                const daysInMonth = new Date(
                    new Date().getFullYear(),
                    new Date().getMonth() + 1,
                    0
                ).getDate();

                const labels = [];
                for (let day = 1; day <= daysInMonth; day++) {
                    labels.push(day.toString().padStart(2, '0'));
                }

                return labels;
            }
        }
    }
</script>

<style>
    .chart-canvas {
        height: 340px;

        @media screen and (max-width: 768px) {
            height: 240px;
        }
    }
</style>
