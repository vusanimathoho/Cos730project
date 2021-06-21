<template>
    <div> 
        <navbar></navbar>
        <router-view></router-view>

    </div>
</template>
<script>


    import navbar from "components/navbar.vue"
    export default{
        components: {
            navbar
        },
        created() {

        }
    }
</script>
<style>
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
</style>