<template>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Add New Task</h2>
        </div>
        <div>
            <router-link to="/dashboard/tasks" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>All Task</router-link>
        </div>
    </div>
    <div class="row">
        <!-- <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Add New Task</h2>
                <router-link to="task/create" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Create Task</router-link>
            </div>
        </div> -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Basic</h4>
                </div>
                <div class="card-body">
                    <form action="javascript:void(0)" class="row" method="post">
                        <div class="mb-4">
                            <p class="text-danger" v-text="errors.title"></p>
                            <label for="product_name" class="form-label">Task Title</label>
                            <input type="text"  v-model="formData.title" name="title" placeholder="Type here" class="form-control" />
                        </div>
                        <div class="mb-4">
                            <p class="text-danger" v-text="errors.description"></p>
                            <label class="form-label">Description</label>
                            <textarea placeholder="Type here" v-model="formData.description" name="description" class="form-control" rows="4"></textarea>
                        </div>

                        <div>
                            <button :disabled="processing" @click="createTask" type="submit" class="btn btn-md rounded font-sm hover-up">{{ processing ? "Please wait" : "Submit" }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                formData: {
                    title: '',
                    description: '',
                },
                errors: {}
            }
        },
        methods: {
            createTask(){
                this.processing = true
                const rootUrl = window.location.origin;
                axios.post(`${rootUrl}/api/task/create`, this.formData).then((response) => {
                    console.log(response.data)
                    this.formData.title = this.formData.description = ''
                    this.errors = {}
                    this.$router.push('/dashboard/tasks')
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