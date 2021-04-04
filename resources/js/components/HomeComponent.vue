<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Home</h3>
            </div>
            <div class="card-body">
                Welcome!
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
            };
        },
        methods: {
        },
        watch: {
        },
        created() {
        },
        mounted() {
            this.$emit('loadBreadcrumbLink', {url: '/', pageName: 'Home'});
        }
    }
</script>
