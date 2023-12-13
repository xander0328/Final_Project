import { createRouter, createWebHistory } from 'vue-router'
import clerk from '../views/Clerk.vue'

const routes = [
  {
    path: '/',
    component: () => import('../views/Login.vue')
  },
  {
    path: '/verify_email',
    component: () => import('../views/VerifyEmail.vue')
  },
  {
    path: '/client_info',
    component: () => import('../views/ClientInfo.vue')
  },
  {
    path: '/clerk',
    component: clerk,
  },
  {
    path: '/clerk/view_client',
    component: () => import('../views/ViewClient.vue')
  },
  {
    path: '/messages',
    component: () => import('../views/Messages.vue')
  },
  {
    path: '/client',
    component: () => import('../views/Client.vue')
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
