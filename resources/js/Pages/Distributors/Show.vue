<template>
    <div>
        <h1>Distributor Details</h1>

        <div>
            <strong>Name:</strong> {{ distributor.name }}
        </div>
        <div>
            <strong>Province:</strong> {{ distributor.province }}
        </div>
        <div>
            <strong>Island:</strong> {{ distributor.island }}
        </div>
        <div>
            <strong>Color:</strong> <span :style="{ backgroundColor: distributor.color }">{{ distributor.color }}</span>
        </div>

        <div class="mt-4">
            <inertia-link :href="route('distributors.index')" class="btn btn-secondary">Back to List</inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        distributor: Object,
    },
};
</script>
