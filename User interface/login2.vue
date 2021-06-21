<template>
    <div class="login container">
        <div class="col-12 center" >
            <h1>Login</h1>
            <p style="color: red">{{message}}</p>
        </div>
        <div class="col-3"></div>
        <div class="col-6">
            <div class="form-group col-12">
                <label>Email Address</label>
                <input type="text" placeholder="Email Address" v-model="email" class="form-controller" />
            </div>
            <div class="form-group col-12">
                <label>Password</label>
                <input type="password" placeholder="**********" v-model="password" class="form-controller" />
            </div>
            <div class="form-group col-12">
                <button class="btn" @click="login" >Login</button>
            </div>
            <div>
                <a href="/login/attendant" >Login as a petrol attendant</a> | <a href="/register" >Register</a>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data() {
            return{
                email: "",
                password: "",
                message: ""
            }
        },
        created() {
            setTitle("Login")
        },
        methods: {
            async login() {
                var result = await this.post("api/users.php?fun=login", {email: this.email, password: this.password})
                if (!result.error) {
                 return window.location.href = "/attendant"
                }
                this.message = "Invaild Data";
            }
        }
    }
</script>
<style>
    .login{
        padding-top:120px;
    }
    a{
        color : #00AFF9;
        transition: 150ms ease-in;

    }
</style>