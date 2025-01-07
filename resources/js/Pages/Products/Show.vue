<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props for receiving product data
const props = defineProps({
    product: Object,
    categories: Array,
    subCategories: Array,
});

// Method for formatting price
const numberFormat = (value) => {
    if (value) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        }).format(value);
    }
    return "Rp 0"; // Default fallback in case the value is not provided.
};
</script>

<template>
    <section>
        <Head title="Product Details" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Details
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    View the details of the product here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="space-y-6">
                            <!-- Product Name -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Name
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{
                                        props.product?.name ||
                                        "No Name Available"
                                    }}
                                </p>
                            </div>

                            <!-- Product Description -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Description
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{
                                        props.product?.description ||
                                        "No Description Available"
                                    }}
                                </p>
                            </div>

                            <!-- Product Price -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Price
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ numberFormat(props.product?.price) }}
                                </p>
                            </div>

                            <!-- Product Category -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Category
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{
                                        props.categories?.find(
                                            (cat) =>
                                                cat.id ===
                                                props.product?.category_id,
                                        )?.name || "Unknown"
                                    }}
                                </p>
                            </div>

                            <!-- Product Subcategory -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Subcategory
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{
                                        props.subCategories?.find(
                                            (sub) =>
                                                sub.id ===
                                                props.product?.sub_category_id,
                                        )?.name || "Unknown"
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Back to List Button -->
                        <div class="mt-6">
                            <inertia-link
                                :href="route('products.index')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Back to List
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
