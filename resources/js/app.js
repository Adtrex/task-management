import './vendors/jquery-3.6.0.min.js';

import './bootstrap';

import './vendors/bootstrap.bundle.min.js';

// import './vendors/select2.min.js';

import './vendors/perfect-scrollbar.js';

import './vendors/chart.js';

import './custom-chart.js';

// import './vendors/jquery.fullscreen.min.js';

import './main.js';

import { createApp } from 'vue';

import { createRouter, createWebHistory } from 'vue-router';

import Routes from './routes.js';

import LogoutButton from './components/auth/Logout.vue';




// import AppComp from './App.vue';

const app = createApp({});

const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});

const loggedIn = () =>{
    return localStorage.getItem('token');
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        console.log('requiresAuth');
        if (!loggedIn()) {
            // next({
            // path: '/login',
            // query: { redirect: to.fullPath }
            // })
            window.location.href = '/login';
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        console.log('guest');
        if (loggedIn()) {
            // next({
            // path: '/dashboard/home',
            // query: { redirect: to.fullPath }
            // })
            window.location.href = '/dashboard/home';
        } else {
            next()
        }
    } else {
        console.log('else');
        next() // make sure to always call next()!
    }
})

// const router = createRouter({
//     routes: Routes,
//     history: createWebHistory(),
// });

app.component('logout-button', LogoutButton);


app.use(router);

app.mount('#app'); 
