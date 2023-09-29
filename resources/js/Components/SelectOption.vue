<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: String,
    defaultValue: String,
    options: {
        type: Array,
        required: true,
        validator: (options) =>
            options.every((option) => 'value' in option && 'label' in option),
    },
});

const { emit } = defineEmits(['update:modelValue']);

const input = ref(null);

const selectedValue = ref(props.modelValue);

const focus = () => input.value.focus();

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const handleInput = (event) => {
    selectedValue.value = event.target.value;
    emit('update:modelValue', event.target.value);
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select ref="input" class="form-select" :value="selectedValue" @input="handleInput">
        <option v-if="defaultValue" :value="defaultValue">{{ defaultValue }}</option>
        <option v-for="option in options" :key="option.value" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>
