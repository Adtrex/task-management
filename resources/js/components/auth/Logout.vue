<!-- resources/js/components/LogoutButton.vue -->

<template>
  <button class="btn btn-light" @click="logout">Logout</button>
</template>

<script>
    export default {
        data() {
            return {
            };
        },
        methods: {
            logout(){
                axios.get('api/logout').then((response) => {
                    localStorage.removeItem('token')
                    //use window
                    window.location.href = '/login';
                    // this.$router.push('/login')
                }).catch((errors) => {
                    console.log(errors)
                })
            }
        },
        mounted() {
            // Fetch tasks from API or any other method
            // Assign the fetched tasks to the tasks array
            // Example:
            // this.tasks = fetchTasks();
        },
    };
</script>


