import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/survey',
      name: 'survey',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/future',
      name: 'future',
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
