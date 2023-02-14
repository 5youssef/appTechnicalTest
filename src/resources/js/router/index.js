import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Projects from '../components/Projects/Projects';

import Statuses from '../components/Statuses/Statuses';

import Tasks from '../components/Tasks/Tasks';

import TasksList from '../components/Tasks/TasksList.vue'



export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'TasksList',
        path: '/tasklist',
        component: TasksList
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },

    {
        name: 'projects',
        path: '/projects',
        component: Projects
    },
    
    {
        name: 'statuses',
        path: '/statuses',
        component: Statuses
    },

    {
        name: 'tasks',
        path: '/tasks',
        component: Tasks
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
