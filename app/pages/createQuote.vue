<template>
    <div> 
        <div class="request" style="">
            <h3>Make Quote</h3>

            <br/>
            <div class="form">
                <div class="col-12 from-group">
                    <label>Petrol Fee</label>
                    <input type="text" placeholder="Petrol Fee" v-model="petrol_cost" class="form-controller" />
                </div>
                <br/>
                <div class="col-12 from-group">
                    <label>Delivery Fee</label>
                    <input type="text" placeholder="Delivery Fee" v-model="delivery_fee" class="form-controller" />
                </div>
                <br/>
                <button class="btn" @click="makeQuote" >Submit</button>  
                <br/>
                <br/>
            </div>
        </div>
    </div>
</template>
<script>



    export default{
        created() {

        },
        data(){
            return {
                petrol_cost: "",
                delivery_fee : ""
            }
        },
        methods: {
            async makeQuote() {
                var result = await this.post("api/requests.php?fun=make-quote", {request_id: this.$route.params.id,petrol_cost: this.petrol_cost,delivery_fee:this.delivery_fee})
                location.href = "/attendent"
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