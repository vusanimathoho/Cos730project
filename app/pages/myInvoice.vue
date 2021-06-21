<template>
    <div class="container gap-20" style="padding-top: 120px"> 
        <div class="col-6 col-m-12 card" v-for="request in requests" >
            <h3>Delivery Fee : {{request.delivery_fee}}</h3>
            <h5>Petrol Fee : {{request.litre_fee}}</h5>
            <h5>Create At : {{request.created_at}}</h5>
        </div>
    </div>
</template>
<script>
    export default{
        data() {
            return {
                requests : []
            }
        },
        created() {
            setTitle("My Invoice");
            this.fetchRequests()
        }, methods: {
            async fetchRequests() {
                var result =  await this.get("api/requests.php?fun=get-invoice")
                this.requests = result.data 
            },
        }
    }
</script>
<style>
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
</style>