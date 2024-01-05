<script setup>

    import axios from 'axios';
    import { ref, onMounted, watch} from 'vue';

    const tasks = ref([]);

    const selectedFilter = ref('');
    
    const loading = ref(false);


    const getTasks = () => {
        loading.value = true;
        const rootUrl = window.location.origin;
        axios.get(`${rootUrl}/api/task/list`, {})
            .then((response) => {
                tasks.value = response.data.tasks;
                console.log(response.data);
            })
            .finally(() => {
                loading.value = false;
            });
    }

    const filterTasks = () => {
        loading.value = true;
        const rootUrl = window.location.origin;
        axios.get(`${rootUrl}/api/task/list`, {
            params: {
                filter: 'status',
                value: selectedFilter.value
            }
        }).then((response) => {
            tasks.value = response.data.tasks;
            console.log(response.data);
        }).catch((errors) => {
            console.error('Error:', errors);
        }).finally(() => {
            loading.value = false;
        });
    }

    onMounted(() => {
        getTasks();
    });

    watch(selectedFilter, filterTasks);
</script>


<template>

    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Task List</h2>
        </div>
        <div>
            <router-link to="/dashboard/task/create" class="btn btn-primary btn-sm rounded">Create new</router-link>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col col-check flex-grow-0">
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="checkbox" value="" />
                    </div>
                </div>
                <!-- <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <select class="form-select">
                        <option selected>All category</option>
                        <option>Electronics</option>
                        <option>Clothes</option>
                        <option>Automobile</option>
                    </select>
                </div> -->
                <div class="col-md-2 col-6">
                    <select class="form-select" v-model="selectedFilter" @change="filterTasks">
                        <option selected value="">All</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inprogress">In Progress</option>
                        <option value="overdue">Overdue</option>
                        <option value="expired">Expired</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div v-if="loading" class="text-center mt-3">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Due Date</th>
                            <th scope="col" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task, index) in tasks" :key="task.id">
                            <td>{{ index + 1 }}</td>
                            <td><b>{{ task.title }}</b></td>
                            <td>{{ task.description }}</td>
                            <td>{{ task.status }}</td>
                            <td>{{ task.end_date }}</td>
                            <td>
                                <router-link :to="'/dashboard/task/'+ task.id" class="btn btn-sm btn-brand">View</router-link>
                                <!--make delete button-->
                                <button @click="deleteTask(task.id)" class="btn btn-sm btn-light">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <!-- <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                <li class="page-item"><a class="page-link" href="#">02</a></li>
                <li class="page-item"><a class="page-link" href="#">03</a></li>
                <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">16</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                </li>
            </ul>
        </nav>
    </div> -->
</template>

<script>
export default {
    data() {
        return {

            tasks: [],
        };
    },
    methods: {
        deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                const rootUrl = window.location.origin;

                axios.post(`${rootUrl}/api/task/delete`, {task_id:taskId}).then((response) => {
                    console.log(response.data)
                     window.location.reload();
                }).catch((errors) => {
                    console.error('Error deleting task:', errors);
                });
            }
        },
    },
    mounted() {
        // Fetch tasks from API or any other method
        // Assign the fetched tasks to the tasks array
        // Example:
        // this.tasks = fetchTasks();
    },
};
</script>


