require('./bootstrap');

window.Vue = require('vue');

// import dependecies tambahan
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';

Vue.use(VueRouter,VueAxios,Axios);

// import file yang dibuat tadi
import App from './App.vue';
import Products from './pages/products/Products.vue';
import Overview from './pages/overview/Overview.vue';

// membuat router
const routes = [
    {
        name: 'overview',
        path: '/',
        component: Overview
    },
    {
        name: 'products',
        path: '/products',
        component: Products
    },
]

const router = new VueRouter({ mode: 'history', routes: routes });
new Vue(Vue.util.extend({ router }, App)).$mount("#app");