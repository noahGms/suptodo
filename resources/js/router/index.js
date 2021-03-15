import { createRouter, createWebHistory } from "vue-router"
import store from "../store/index"

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', name: 'home', component: () => import(/* webpackChunkName: "container" */ '../views/Home.vue'), meta: { requiresAuth: true } },
        { path: '/register', name: 'register', component: () => import(/* webpackChunkName: "container" */ '../views/auth/Register.vue'), meta: { requiresAuth: false } },
        { path: '/login', name: 'login', component: () => import(/* webpackChunkName: "container" */ '../views/auth/Login.vue'), meta: { requiresAuth: false } },
        { path: '/todos', name: 'todos', component: () => import(/* webpackChunkName: "container" */ '../views/Todolist.vue'), meta: { requiresAuth: true } },
        { path: '/todos/:id', name: 'todo', component: () => import(/* webpackChunkName: "container" */ '../views/TodolistDetails.vue'), meta: { requiresAuth: true } },
    ]
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !store.getters.isLoggedIn) {
        return {
            name: 'login',
            query: { redirect: to.fullPath },
        }
    }
})

export default router;
