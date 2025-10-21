import { createRouter, createWebHistory } from 'vue-router'

import { useAuthStore } from '@/stores/auth'
import ForgotPasswordView from '@/views/ForgotPasswordView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ResetPasswordView from '@/views/ResetPasswordView.vue'
import TicketView from '@/views/TicketView.vue'

import DashboardView from '../views/DashboardView.vue'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/forgot-password',
      name: 'forgotPassword',
      component: ForgotPasswordView,
    },
    {
      path: '/reset-password',
      name: 'resetPassword',
      component: ResetPasswordView,
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      meta: { requiresAuth: true },
    },
    {
      path: '/ticket',
      name: 'ticketList',
      component: TicketView,
      meta: { requiresAuth: true },
    },
    {
      path: '/ticket/:id',
      name: 'ticketDetail',
      component: () => import('../views/TicketDetailView.vue'),
      meta: { requiresAuth: true },
    },
  ],
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  if (authStore.user === null) {
    await authStore.checkAuth()
  }

  const isAuthenticated = authStore.isAuthenticated

  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'login' })
  } else if (to.name === 'login' && isAuthenticated) {
    next({ name: 'dashboard' })
  } else {
    next()
  }
})

export default router
