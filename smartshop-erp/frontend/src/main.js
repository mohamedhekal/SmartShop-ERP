import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import './style.css'

import App from './App.vue'
import routes from './router'
import { useAuthStore } from './store/auth'

const app = createApp(App)
const pinia = createPinia()
const router = createRouter({
    history: createWebHistory(),
    routes,
})

// Global properties
app.config.globalProperties.$toast = toast

// Router guards
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next('/login')
    } else if (to.meta.requiresGuest && authStore.isAuthenticated) {
        next('/dashboard')
    } else {
        next()
    }
})

app.use(pinia)
app.use(router)

app.mount('#app') 