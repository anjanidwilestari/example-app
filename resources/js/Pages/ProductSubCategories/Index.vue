<script setup>
import { defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    subCategories: Array,
});

const deleteSubCategory = (subCategoryId) => {
    if (confirm("Are you sure you want to delete this subcategory?")) {
        Inertia.delete(route("product_sub_categories.destroy", subCategoryId));
    }
};
</script>

<template>
    <section>
        <Head title="Product Subcategories" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Subcategories
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <!-- Link to create a new subcategory -->
                            <inertia-link
                                :href="route('product_sub_categories.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded"
                                >Create Subcategory</inertia-link
                            >
                            <table class="w-full mt-6">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Name</th>
                                        <th class="px-4 py-2 border">
                                            Category
                                        </th>
                                        <th class="px-4 py-2 border">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="subCategory in subCategories"
                                        :key="subCategory.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ subCategory.name }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ subCategory.category.name }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_sub_categories.show',
                                                        subCategory.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >View</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_sub_categories.edit',
                                                        subCategory.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <button
                                                @click="
                                                    deleteSubCategory(
                                                        subCategory.id,
                                                    )
                                                "
                                                class="bg-red-500 text-white px-4 py-2 rounded"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
