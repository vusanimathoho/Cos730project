<template>
    <div class="container attendee gap-20"> 
        <div class="col-12">
            <h2>Attendee</h2>
        </div>
        <div class="col-2 col-m-6 text-center">
            <a class="btn center" href="/map" ><i class="fa fa-search"></i></a>
            <span>Search Stations</span>
        </div>
         <div class="col-2 col-m-6 text-center">
            <a class="btn center" href="/my-quotes"><i class="fa fa-boxes"></i></a>
            <span>Quotes</span>
        </div>
    </div>
</template>
<script>


    
    export default{
            created(){

            }
    }
</script>
<style>
    .attendee{
        padding-top: 120px;
    }
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
</style>