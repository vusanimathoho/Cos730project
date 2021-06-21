<template>
    <div> 
        <div class="acceptQuote container" style="padding-top: 120px;">
            <div class="col-12">
                <h3>Do You Accept</h3>
                <br/> 
            </div>

            <div class="col-6">
                <button class="btn" @click="yes" >Yes</button>
            </div><div class="col-6">
                <button class="btn" @click="location.href = '/my-quotes'" >No</button>
            </div>
        </div>
    </div>
</template>
<script>



    export default{
        created() {
            setTitle("ACCPET QUOTE")
        },
        methods: {
            async yes() {
                var result = await this.post("api/requests.php?fun=accept-quote", {quote_id: this.$route.params.id})
                location.href = "/attendee"
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