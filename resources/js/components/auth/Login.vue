<template>

    <div class="card mx-auto card-login">
        <div class="card-body">
            <h4 class="card-title mb-4">Sign in</h4>
            <form  action="javascript:void(0)" class="row" method="post">

                <div class="mb-3">
                    <p class="text-danger" v-text="errors.email"></p>
                    <input v-model="auth.email" name="email" id="email" class="form-control" placeholder="Email" type="text" />
                </div>
                <!-- form-group// -->
                <div class="mb-3">
                    <p class="text-danger" v-text="errors.password"></p>
                    <input v-model="auth.password" name="password" id="password" class="form-control" placeholder="Password" type="password" />
                </div>
                <!-- form-group// -->
                <div class="mb-3">
                    <a href="#" class="float-end font-sm text-muted">Forgot password?</a>
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" checked="" />
                        <span class="form-check-label">Remember</span>
                    </label>
                </div>
                <!-- form-group form-check .// -->
                <div class="mb-4">
                    <!-- <button @click="login" class="btn btn-primary">Login</button> -->
                    <button :disabled="processing" @click="login" type="submit" class="btn btn-primary w-100">{{ processing ? "Please wait" : "Login" }}</button>
                </div>
                <!-- form-group// -->
            </form>
            <p class="text-center mb-4">Don't have account? <router-link to="/register">Sign up</router-link></p>
        </div>
    </div>

</template>

<script>
export default {
        data(){
            return {
                auth: {
                    email: '',
                    password: '',
                    device_name: 'browser'
                },
                errors: {},
                processing:false
            }
        },
        methods: {
            login(){
                this.processing = true
                axios.post('api/login', this.auth).then((response) => {
                    localStorage.setItem('token', response.data)
                    window.location.href = '/dashboard/home';
                    this.processing = false
                }).catch((errors) => {
                    this.errors = errors.response.data.errors
                    this.processing = false
                })
            }
        }
    }


</script>