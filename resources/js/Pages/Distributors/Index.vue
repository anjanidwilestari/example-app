<template>
    <div>
        <h1>Distributors</h1>
        <div class="mb-4">
            <inertia-link :href="route('distributors.create')" class="btn btn-primary">Add New Distributor</inertia-link>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Province</th>
                    <th>Island</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="distributor in distributors" :key="distributor.id">
                    <td>{{ distributor.name }}</td>
                    <td>{{ distributor.province }}</td>
                    <td>{{ distributor.island }}</td>
                    <td>
                        <inertia-link :href="route('distributors.show', distributor.id)" class="btn btn-info btn-sm">View</inertia-link>
                        <inertia-link :href="route('distributors.edit', distributor.id)" class="btn btn-warning btn-sm">Edit</inertia-link>
                        <button @click="deleteDistributor(distributor.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        distributors: Array,
    },

    methods: {
        async deleteDistributor(id) {
            if (confirm('Are you sure you want to delete this distributor?')) {
                await this.$inertia.delete(route('distributors.destroy', id));
            }
        },
    },
};
</script>
