<template>
    <div class="container attendee gap-20"> 
        <div class="col-12">
            <h2>Attendee</h2>
        </div>
        <div class="col-2 col-m-6 text-center">
            <a class="btn center" href="/requests" ><i class="fa fa-search"></i></a>
            <span>Requests</span>
        </div>
         <div class="col-2 col-m-6 text-center">
            <a class="btn center" href="/my-invoices"><i class="fa fa-boxes"></i></a>
            <span>My Invoice</span>
        </div>
    </div>
</template>
<script>



    export default{
        created() {
            setTitle("Attendet")
        }
    }
</script>
<style>
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
</style>