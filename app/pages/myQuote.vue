<template>
    <div class="container gap-20" style="padding-top: 120px;"> 
        <a class="col-6 col-m-12 card" v-for="request in requests" :href="'/accept-quote/'+request.QuoteID">
            <h3>Delivery Fee : {{request.delivery_fee}}</h3>
            <h5>Petrol Fee : {{request.litre_fee}}</h5>
            <h5>Create At : {{request.created_at}}</h5>
        </a>
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
            setTitle("My Quotes")
            this.fetchRequests()
        }, methods: {
            async fetchRequests() {
                var result =  await this.get("api/requests.php?fun=get-quote")
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