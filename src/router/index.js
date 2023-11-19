import { createRouter, createWebHistory } from 'vue-router'
import Admin from '../views/Admin.vue'

const routes = [
  {
    path: '/admin',
    name: 'admin',
    component: Admin
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
