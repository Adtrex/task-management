import NotFound from './components/pages/NotFound.vue';

import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';

import Dashboard from './components/dashboard/Index.vue';
import CreateTask from './components/dashboard/tasks/CreateTask.vue';
import ListTask from './components/dashboard/tasks/ListTask.vue';
import SingleTask from './components/dashboard/tasks/SingleTask.vue';
import AssignedTask from './components/dashboard/tasks/AssignedTask.vue';

export default[
    { 
        path: '/:pathMatch(.*)*', 
        component: NotFound
    },

    { 
        path: '/', 
        redirect: { name: 'auth.login' } 
    },

    {
        path: '/login',
        name: 'auth.login',
        component: Login,
        meta: { guest: true },
    },

    {
        path: '/register',
        name: 'auth.register',
        component: Register,
        meta: { guest: true },
    },

    {
        path: '/dashboard/home',
        name: 'dashboard.index',
        component: Dashboard,
        meta: { requiresAuth: true },
    },

    {
        path: '/dashboard/task/create',
        name: 'task.create',
        component: CreateTask,
        meta: { requiresAuth: true },
    },

    {
        path: '/dashboard/tasks',
        name: 'task.list',
        component: ListTask,
        meta: { requiresAuth: true },
    },

    {
        path: '/dashboard/task/:id',
        name: 'task.single',
        component: SingleTask,
        meta: { requiresAuth: true },
    },

    {
        path: '/dashboard/task/assigned',
        name: 'task.assigned',
        component: AssignedTask,
        meta: { requiresAuth: true },
    },

    // {
    //     path: '/dashboard/task/single',
    //     name: 'dashboard.index',
    //     component: Dashboard
    // },
    

    
]