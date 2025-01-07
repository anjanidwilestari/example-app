<script setup>
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    specification: Object,
});

const form = useForm({
    product_id: props.specification.product_id,
    specification: props.specification.specification,
    description: props.specification.description,
});

const submitForm = () => {
    form.put(route("product_specifications.update", props.specification.id), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product Specification
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Edit the product specification details here.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <div>
                            <InputLabel for="product_id" value="Product" />
                            <TextInput
                                id="product_id"
                                v-model="form.product_id"
                                type="select"
                                :error="form.errors.product_id"
                                class="mt-1 block w-full"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="specification"
                                value="Specification"
                            />
                            <TextInput
                                id="specification"
                                v-model="form.specification"
                                type="text"
                                class="mt-1 block w-full"
                                :error="form.errors.specification"
                            />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <TextInput
                                id="description"
                                v-model="form.description"
                                type="text"
                                class="mt-1 block w-full"
                                :error="form.errors.description"
                            />
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <PrimaryButton :disabled="form.processing">
                                Save Changes
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
