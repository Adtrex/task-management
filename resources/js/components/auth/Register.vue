<template>
    <div class="card mx-auto card-login">
        <div class="card-body">
            <h4 class="card-title mb-4">Create an Account</h4>
            <form action="javascript:void(0)" class="row" method="post">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Your Name" name="name" v-model="auth.name" type="text" />
                    <p class="text-danger" v-text="errors.name"></p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Your email" name="email" v-model="auth.email" type="text" />
                    <p class="text-danger" v-text="errors.email"></p>
                </div>
                <!-- form-group// -->
                <div class="mb-3">
                    <label class="form-label">Create password</label>
                    <input class="form-control" placeholder="Password" name="password" v-model="auth.password" type="password" />
                    <p class="text-danger" v-text="errors.password"></p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm password</label>
                    <input class="form-control" placeholder="Password" name="password_confirmation" v-model="auth.password_confirmation" type="password" />
                    <p class="text-danger" v-text="errors.password_confirmation"></p>
                </div>
                <!-- form-group  .// -->
                <div class="mb-4">
                    <!-- <button type="submit" class="btn btn-primary w-100">Login</button> -->
                    <button :disabled="processing" @click="registerUser" type="submit" class="btn btn-primary w-100">{{ processing ? "Please wait" : "Register" }}</button>
                </div>
                <!-- form-group// -->
            </form>
            
            <p class="text-center mb-2">Already have an account? <router-link to="/login">Sign in now</router-link></p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                auth: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {}
            }
        },
        methods: {
            registerUser(){
                this.processing = true
                console.log(this.auth)
                axios.post('api/register', this.auth).then((response) => {
                    console.log(response.data)
                    this.auth.name = this.auth.email = this.auth.password = this.auth.password_confirmation = ''
                    this.errors = {}
                    this.$router.push('/login')
                    this.$toaster.success('Account created successfully, now you can login!')
                    this.processing = false
                }).catch((errors) => {
                    this.errors = errors.response.data
                    console.log(errors.response.data)
                    this.processing = false
                });
            }
        }   
    }
</script>