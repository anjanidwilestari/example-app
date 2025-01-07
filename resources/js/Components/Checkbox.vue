<template>
    <div
        :class="[
            'p-4 rounded flex items-center border-gray-300 text-indigo-600 shadow-sm',
            hover &&
                'hover:bg-indigo-100 hover:border-indigo-400 hover:rounded-xl',
        ]"
    >
        <input
            type="checkbox"
            :value="value"
            :checked="Array.isArray(modelValue) && modelValue.includes(value)"
            @change="updateValue"
            :id="id"
            class="mr-2 rounded border-gray-300 text-indigo-600 shadow-sm hover:border-indigo-400"
        />
        <label :for="id">{{ label }}</label>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    value: {
        type: [String, Number],
        required: true,
    },
    modelValue: {
        type: Array,
        required: true,
        default: () => [], // Default value as an empty array
    },
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    hover: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

// Fungsi untuk memperbarui nilai model
const updateValue = (event) => {
    const checked = event.target.checked;
    // Menggunakan props.modelValue untuk mengakses nilai saat ini
    if (checked) {
        emit("update:modelValue", [...props.modelValue, props.value]); // Menambahkan nilai yang dipilih
    } else {
        emit(
            "update:modelValue",
            props.modelValue.filter((id) => id !== props.value),
        ); // Menghapus nilai yang tidak dipilih
    }
};
</script>
