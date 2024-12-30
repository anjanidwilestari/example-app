<template>
    <div>
        <h1>Edit Distributor</h1>

        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input v-model="form.name" id="name" class="form-control" type="text" required />
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input v-model="form.province" id="province" class="form-control" type="text" required />
            </div>

            <div class="mb-3">
                <label for="island" class="form-label">Island</label>
                <input v-model="form.island" id="island" class="form-control" type="text" required />
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input v-model="form.color" id="color" class="form-control" type="text" required />
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        distributor: Object,
    },

    data() {
        return {
            form: {
                ...this.distributor,
            },
        };
    },

    methods: {
        submitForm() {
            this.$inertia.put(route('distributors.update', this.distributor.id), this.form);
        },
    },
};
</script>
