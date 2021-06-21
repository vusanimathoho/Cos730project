<template>
    <div class="register container">
        <div class="col-12 center">
            <h1>Register</h1>
            <br/>
            <br/>
        </div>
        <div class="col-3">

        </div>
        <div class="col-6">
            <div>
                <label>Email Address</label>
                <input type="text" placeholder="Email Address" v-model="email" class="form-controller"/>
            </div>
            <div>
                <label>Password</label>
                <input type="password" placeholder="**********" v-model="password" class="form-controller"/>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" placeholder="**********" class="form-controller"/>
            </div>
            <div>
                <br/>
                <button class="btn" @click="register">Register</button>
            </div>
            <div>
                <br/>
                <a href="/login" >Login</a>
            </div>
        </div>
    </div>
</template>
<script>



    export default{
        data() {
            return {
                email: "",
                password: ""
            }
        },
        created() {
            setTitle("Register")
        }, methods: {
           async register() {
                var result =await  this.post("api/users.php?fun=register", {email: this.email, password: this.password})
                if (!result.error) {
                    return window.location.href = "/login"
                }
                this.message = "Invaild Data";
            }
        }
    }
</script>
<style>
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
    .register{
        padding-top: 120px;
    }
</style>