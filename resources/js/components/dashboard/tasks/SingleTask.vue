<script setup>

    import { ref, onMounted, watch } from 'vue'
    import { useRoute } from 'vue-router'

    const route = useRoute();  
    const taskId = route.params.id;
    const task = ref([]);

    const selectedStatus = ref('');

    const loading = ref(false);


    


    const getTask = () => {
        const rootUrl = window.location.origin;
        axios.get(`${rootUrl}/api/task/single/${taskId}`, {
        })
        .then((response) => {
            task.value = response.data.task;
            console.log(response.data);
        })
    }

    const changeStatus = () => {
        loading.value = true;
        const rootUrl = window.location.origin;
        axios.post(`${rootUrl}/api/task/update/${taskId}`,{status: selectedStatus.value})
        .then((response) => {
            console.log(response.data);
        }).catch((errors) => {
            console.error('Error:', errors);
        }).finally(() => {
            loading.value = false;
        });
    }

    onMounted(() => {
        getTask();
    });


    watch(selectedStatus, changeStatus);
    
</script>

<template>

    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Task details</h2>
            <p>Task ID: {{ taskId }}</p>
            
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                    <p>Title: {{ task.title }}</p>
                    <p>Status: {{ task.status }}</p>
                    
                </div>
                <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                    <p>Status:</p>
                    <select class="form-select d-inline-block mb-lg-0 mb-15 mw-200" v-model="selectedStatus" @change="changeStatus">
                        <option value="pending" :selected="task.status ==  'pending'">To Do</option>
                        <option value="inprogress" :selected="task.status ==  'inprogress'">In Progress</option>
                        <option value="completed" :selected="task.status ==  'completed'">Completed</option>
                    </select>
                    <div v-if="loading" class="text-center mt-3">
                        <i class="fa fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap" v-if="task.user">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Asignee</h6>
                            <p class="mb-1">
                                {{ task.user ? task.user.name : 'No assigned user' }} <br />
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-calendar"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Start Date</h6>
                            <p class="mb-1">
                                {{ task.start_date ? task.start_date : '' }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-calendar"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">End Date</h6>
                            <p class="mb-1">
                                 {{ task.end_date ? task.end_date : '' }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
            </div>
            <!-- row // -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="box shadow-sm bg-light">
                        <h6 class="mb-15">Description</h6>
                        <p>
                            {{ task.description }}
                        </p>
                    </div>
                    <div class="h-25 pt-4" v-if="!task.user">
                        <form action="javascript:void(0)" class="row" method="post">
                            <p class="text-danger" v-text="errors.required"></p>
                            <div class="mb-3">
                                <p class="text-danger" v-text="errors.email"></p>
                                <label>Assign User</label>
                                <input type="text" class="form-control" v-model="formData.email" name="email" placeholder="Enter user email" />
                                <!-- <impu class="form-control" name="notes" id="notes" placeholder="Type some note"></textarea> -->
                            </div>

                            <div class="mb-3">
                                <p class="text-danger" v-text="errors.start_date"></p>
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start_date" v-model="formData.start_date" placeholder="Start Date" />
                                <!-- <impu class="form-control" name="notes" id="notes" placeholder="Type some note"></textarea> -->
                            </div>

                            <div class="mb-3">
                                <p class="text-danger" v-text="errors.end_date"></p>
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end_date" v-model="formData.end_date" placeholder="End date" />
                                <!-- <impu class="form-control" name="notes" id="notes" placeholder="Type some note"></textarea> -->
                            </div>
                        
                            <button class="btn btn-primary" :disabled="processing" @click="assignUser" type="submit">{{ processing ? "Please wait" : "Submit" }}</button>
                        </form>
                    </div>
                </div>
                <!-- col// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>

</template>

<script>
    export default {
        data() {
            return {
                formData: {
                    email: '',
                    start_date: '',
                    end_date: '',
                },
                errors: {}
            }
        },
        methods: {
            
            assignUser(){

                if (!this.formData.email || !this.formData.start_date || !this.formData.end_date) {
                    this.errors.required = "All fields are required";
                    return;
                }

                console.log(this.formData);
                this.processing = true
                const rootUrl = window.location.origin;
                const taskId = this.$route.params.id;
                axios.post(`${rootUrl}/api/task/update/${taskId}`, this.formData).then((response) => {
                    console.log(response.data)
                    this.formData.email = this.formData.start_date = this.formData.end_date = ''
                    this.errors = {}
                    this.processing = false
                    window.location.reload();
                }).catch((errors) => {
                    this.errors = errors.response.data
                    console.log(errors.response.data)
                    this.processing = false
                });
            },
        }   
    }
</script>

