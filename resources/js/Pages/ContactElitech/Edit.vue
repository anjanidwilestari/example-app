<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Define props to receive the contact data
const props = defineProps({
    contact: Object,
});

// Initialize the form with the contact data
const form = useForm({
    whatsapp_number: [...JSON.parse(props.contact.whatsapp_number)],
    phone_number: [...JSON.parse(props.contact.phone_number)],
    email: [...JSON.parse(props.contact.email)],
    instagram: [...JSON.parse(props.contact.instagram)],
    youtube: [...JSON.parse(props.contact.youtube)],
    address: [...JSON.parse(props.contact.address)],
    link_maps: [...JSON.parse(props.contact.link_maps)],
});

// Function to submit the form
const submitForm = () => {
    form.put(route("contact_elitechs.update", props.contact.id));
};
</script>

<template>
    <section>
        <Head title="Edit Contact Elitech" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Contact Elitech
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form
                            @submit.prevent="submitForm"
                            class="mt-6 space-y-6"
                        >
                            <div v-for="(values, key) in form" :key="key">
                                <h3 class="text-lg font-medium capitalize">
                                    {{ key.replace("_", " ") }}
                                </h3>
                                <div
                                    v-for="(value, index) in values"
                                    :key="index"
                                >
                                    <label
                                        :for="`${key}-${index}`"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        {{ key.replace("_", " ") }} #{{
                                            index + 1
                                        }}
                                    </label>
                                    <input
                                        type="text"
                                        v-model="form[key][index]"
                                        :id="`${key}-${index}`"
                                        class="mt-1 block w-full"
                                    />
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button
                                    type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
