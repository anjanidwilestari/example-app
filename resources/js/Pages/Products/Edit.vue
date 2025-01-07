<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props for receiving product data
const props = defineProps({
    product: Object,
    categories: Array,
    subCategories: Array,
});

// Initialize form using product data
const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    category_id: props.product.category_id,
    sub_category_id: props.product.sub_category_id,
});

// Submit form function
const submitForm = () => {
    form.put(route("products.update", props.product.id), {
        onSuccess: () => {
            form.reset(); // Reset the form after successful submission
        },
        onError: (errors) => {
            console.error(errors); // Handle errors if any
        },
    });
};
</script>

<template>
    <section>
        <Head title="Edit Product" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Product
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Update the product details here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form
                            @submit.prevent="submitForm"
                            class="mt-6 space-y-6"
                        >
                            <!-- Product Name -->
                            <div>
                                <InputLabel for="name" value="Product Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.name"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Description -->
                            <div>
                                <InputLabel
                                    for="description"
                                    value="Description"
                                />
                                <TextInput
                                    id="description"
                                    v-model="form.description"
                                    class="form-input mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.description"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Price -->
                            <div>
                                <InputLabel for="price" value="Price" />
                                <TextInput
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    class="form-input mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.price"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Category -->
                            <div>
                                <InputLabel
                                    for="category_id"
                                    value="Category"
                                />
                                <select
                                    id="category_id"
                                    v-model="form.category_id"
                                    class="form-input mt-1 block w-full"
                                >
                                    <option value="" disabled>
                                        Select Category
                                    </option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.category_id"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Subcategory -->
                            <div>
                                <InputLabel
                                    for="sub_category_id"
                                    value="Subcategory"
                                />
                                <select
                                    id="sub_category_id"
                                    v-model="form.sub_category_id"
                                    class="form-input mt-1 block w-full"
                                >
                                    <option value="" disabled>
                                        Select Subcategory
                                    </option>
                                    <option
                                        v-for="subCategory in subCategories"
                                        :key="subCategory.id"
                                        :value="subCategory.id"
                                    >
                                        {{ subCategory.name }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.sub_category_id"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing"
                                    >Save</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
