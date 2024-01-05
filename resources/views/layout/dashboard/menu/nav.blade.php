<ul class="menu-aside">
    <li class="menu-item" v-bind:class="{ 'active': $route.path === '/dashboard/home' }">
        <router-link class="menu-link" to="/dashboard/home">
            <i class="icon material-icons md-home"></i>
            <span class="text">Home</span>
        </router-link>
    </li>

    <li class="menu-item" v-bind:class="{ 'active': $route.path === '/dashboard/tasks' }">
        <router-link class="menu-link" to="/dashboard/tasks">
            <i class="icon material-icons md-shopping_bag"></i>
            <span class="text">All Task</span>
        </router-link>
    </li>

    <li class="menu-item" v-bind:class="{ 'active': $route.path === '/dashboard/task/create' }">
        <router-link class="menu-link" to="/dashboard/task/create">
            <i class="icon material-icons md-shopping_bag"></i>
            <span class="text">Create Task</span>
        </router-link>
    </li>

    <li class="menu-item" v-bind:class="{ 'active': $route.path === '/dashboard/task/assigned' }">
        <router-link class="menu-link" to="/dashboard/task/assigned">
            <i class="icon material-icons md-shopping_bag"></i>
            <span class="text">Assigned Tasks</span>
        </router-link>
    </li>
</ul>

<br />
<br />