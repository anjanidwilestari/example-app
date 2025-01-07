<script setup>
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    specifications: Array, // Receiving specifications data from Inertia
});

const deleteSpecification = (specificationId) => {
    if (
        confirm("Are you sure you want to delete this product specification?")
    ) {
        Inertia.delete(
            window.route("product_specifications.destroy", specificationId),
        );
    }
};

const truncateDescription = (description) => {
    if (description) {
        return description.length > 50
            ? description.slice(0, 50) + "..."
            : description;
    }
    return "";
};
</script>

<template>
    <section>
        <Head title="Product Specifications" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Specifications List
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <inertia-link
                                    :href="
                                        route('product_specifications.create')
                                    "
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                    >Add Product Specification</inertia-link
                                >
                            </div>

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">
                                            Specification Name
                                        </th>
                                        <th class="px-4 py-2 border">
                                            Description
                                        </th>
                                        <th class="px-4 py-2 border">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="specification in specifications"
                                        :key="specification.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ specification.specification }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{
                                                truncateDescription(
                                                    specification.description,
                                                )
                                            }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_specifications.show',
                                                        specification.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >View</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_specifications.edit',
                                                        specification.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <button
                                                @click="
                                                    deleteSpecification(
                                                        specification.id,
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
