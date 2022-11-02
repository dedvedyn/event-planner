import Vue from "vue";
import VueRouter from "vue-router";

import Events from './components/Events';
import Calendar from './components/Calendar';

Vue.use(VueRouter);

const routes = [
    {
        path: '/events',
        component: Events
    },
    {
        path: '/calendar',
        component: Calendar
    },
];

export default new VueRouter({
    mode: 'history',
    routes
});
