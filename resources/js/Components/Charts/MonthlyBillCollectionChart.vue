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
        data() {
            return {
                chartData:{
                    labels: this.generalLabelsForMonth(),
                    datasets: [
                        {
                            label: 'Bill',
                            backgroundColor:'#4b87f4',
                            data: [400, 750, 120, 309, 2100, 440, 39, 810, 540, 200, 102, 740, 1000, 2300, 250, 150, 102, 309, 1400],
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
