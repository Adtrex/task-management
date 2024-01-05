<script setup>

    import axios from 'axios';
    import $ from 'jquery';
    import { ref, onMounted} from 'vue';

    const task = ref([]);
    const tasks = ref([]);


    const getTaskCount = () => {
        const rootUrl = window.location.origin;
        axios.get(`${rootUrl}/api/task/count`, {
        })
        .then((response) => {
            task.value = response.data;
            console.log(response.data);
        })
    }

    const getTasks = () => {
        const rootUrl = window.location.origin;
        axios.get(`${rootUrl}/api/task/latest`, {
        })
        .then((response) => {
            tasks.value = response.data.tasks;
            console.log(response.data);
        })
    }


    onMounted(() => {
        getTaskCount();
        getTasks();
    });
</script>

<template>

    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Whole data about your task here</p>
        </div>
        <div>
            <router-link to="task/create" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Create Task</router-link>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Created Task</h6>
                        <span>{{ task.owned_task }}</span>
                        <span class="text-sm"> Tasks created by you </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Assigned Task</h6>
                        <span>{{ task.assigned_task }}</span>
                        <span class="text-sm"> Tasks assigned to you </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Ongoing Task</h6>
                        <span>{{ task.inprogress }}</span>
                        <span class="text-sm"> Task you have started </span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i class="text-info material-icons md-shopping_basket"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Completed Task</h6>
                        <span>{{ task.completed }}</span>
                        <span class="text-sm"> Tasks you have completed </span>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <h4 class="card-title">Latest tasks</h4>
            <div class="row align-items-center">
                <!-- <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <div class="custom_select">
                        <select class="form-select select-nice">
                            <option selected>All Categories</option>
                            <option>Women's Clothing</option>
                            <option>Men's Clothing</option>
                            <option>Cellphones</option>
                            <option>Computer & Office</option>
                            <option>Consumer Electronics</option>
                            <option>Jewelry & Accessories</option>
                            <option>Home & Garden</option>
                            <option>Luggage & Bags</option>
                            <option>Shoes</option>
                            <option>Mother & Kids</option>
                        </select>
                    </div>
                </div> -->
                <!-- <div class="col-md-2 col-6">
                    <input type="date" value="02.05.2021" class="form-control" />
                </div> -->
                <!-- <div class="col-md-2 col-6">
                    <div class="custom_select">
                        <select class="form-select select-nice">
                            <option selected>Status</option>
                            <option>All</option>
                            <option>Paid</option>
                            <option>Chargeback</option>
                            <option>Refund</option>
                        </select>
                    </div>
                </div> -->
            </div>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle" scope="col">ID</th>
                                <th class="align-middle" scope="col">Title</th>
                                <th class="align-middle" scope="col">Description</th>
                                <th class="align-middle" scope="col">Status</th>
                                <th class="align-middle" scope="col">Due Date</th>
                                <th class="align-middle" scope="col">View Details</th>
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
                                    <router-link :to="'/dashboard/task/'+ task.id" class="btn btn-xs">View details</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table-responsive end// -->
        </div>
    </div>
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