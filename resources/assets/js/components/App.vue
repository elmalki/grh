<template>
    <router-view name="app"></router-view>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.$router.push('login');
        }
    }
</script>
