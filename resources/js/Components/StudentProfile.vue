<script setup>
defineProps({
    student: Object,
});
</script>

<template>
    <div class="student">
        <div class="student-avatar">
            <img v-if="student.gender === 'male'" src="@/assets/images/male.png" alt="">
            <img v-if="student.gender === 'female'" src="@/assets/images/female.png" alt="">
        </div>
        <div class="student-container">
            <div class="student-container-top d-flex justify-content-between">
                <h4>{{ student.name }}</h4>
                <h4><span>Student ID: </span> {{ student.student_id }}</h4>
            </div>
            <div class="student-container-bottom">
                <div class="items">
                    <ul v-if="student.academic_plans.length > 0">
                        <li v-if="student.academic_plans[0].academic_year">Academic Year: {{ student.academic_plans[0].academic_year.name }}</li>
                        <li v-if="student.academic_plans[0].academic_class">Class<span v-if="student.academic_plans[0].academic_section">/Section</span>: {{ student.academic_plans[0].class.name }}<span v-if="student.academic_plans[0].academic_section">/{{ student.academic_plans[0].academic_section.name }}</span></li>
                        <li v-if="student.academic_plans[0].academic_group">Group: {{ student.academic_plans[0].academic_group.name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
