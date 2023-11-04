<script setup>
const props = defineProps({
    student: Object,
});

const academic_plan = props.student.academic_plans && props.student.academic_plans.length > 0 ? props.student.academic_plans[0] : null;
const transport_fee = props.student.transport_fee;

</script>

<template>
    <div class="student">
        <div class="avatar">
            <img v-if="student.gender === 'male'" src="@/assets/images/male.png" alt="">
            <img v-if="student.gender === 'female'" src="@/assets/images/female.png" alt="">
        </div>
        <h3>{{ student.name }}</h3>
        <ul class="items">
            <li>
                <span class="label">Student ID</span>
                <span class="value">{{ student.student_id }}</span>
            </li>
        </ul>
        <ul v-if="academic_plan" class="items">
            <li>
                <span class="label">Academic Year</span>
                <span class="value">{{ academic_plan.academic_year.name ?? '-' }}</span>
            </li>
            <li>
                <span class="label">Class</span>
                <span class="value">{{ academic_plan.academic_class.name ?? '-' }}</span>
            </li>
            <li>
                <span class="label">Section</span>
                <span class="value">{{ academic_plan.academic_section.name ?? '-' }}</span>
            </li>
            <li>
                <span class="label">Group</span>
                <span class="value">{{ academic_plan.academic_group.name ?? '-' }}</span>
            </li>
        </ul>
        <ul v-if="transport_fee" class="items">
            <li>
                <span class="label">Area</span>
                <span class="value">{{ transport_fee.fee.area.name ?? '-' }}</span>
            </li>
            <li>
                <span class="label">Fee</span>
                <span class="value">{{ transport_fee.discounted_amount ?? transport_fee.fee.amount }}</span>
            </li>
        </ul>
    </div>
</template>
