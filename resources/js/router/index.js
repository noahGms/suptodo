import { createRouter, createWebHistory } from "vue-router"

export default createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: () => import(/* webpackChunkName: "container" */ '../views/Home.vue'), name: 'home' },
        { path: '/register', component: () => import(/* webpackChunkName: "container" */ '../views/auth/Register.vue') },
    ]
})