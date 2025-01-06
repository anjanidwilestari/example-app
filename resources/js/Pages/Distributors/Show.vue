<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    distributor: Object,
});
</script>

<template>
    <section>
        <Head title="Distributor Details" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Distributor Details
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    View the details of the distributor here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="space-y-6">
                            <!-- Distributor Name -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Name
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.distributor.name }}
                                </p>
                            </div>

                            <!-- Distributor Province -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Province
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.distributor.province }}
                                </p>
                            </div>

                            <!-- Distributor Island -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Island
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.distributor.island }}
                                </p>
                            </div>

                            <!-- Distributor Color -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Color
                                </h3>
                                <p
                                    class="text-lg text-gray-600"
                                    :style="{
                                        backgroundColor:
                                            props.distributor.color,
                                        color:
                                            props.distributor.color === '#fff'
                                                ? '#000'
                                                : '#fff',
                                    }"
                                >
                                    {{ props.distributor.color }}
                                </p>
                            </div>
                        </div>

                        <!-- Back to List Button -->
                        <div class="mt-6">
                            <inertia-link
                                :href="route('distributors.index')"
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
