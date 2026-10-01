import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import AjoutView from '../views/AjoutView.vue'
import ListeView from '../views/ListeView.vue'
import BilanView from '../views/BilanView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/login', name: 'login', component: LoginView },
    { path: '/', name: 'ajout', component: AjoutView, meta: { requiresAuth: true } },
    { path: '/liste', name: 'liste', component: ListeView, meta: { requiresAuth: true } },
    { path: '/bilan', name: 'bilan', component: BilanView, meta: { requiresAuth: true } },
  ],
})

// Protection des pages
router.beforeEach((to, from, next) => {
  const isAuth = localStorage.getItem('auth')
  if (to.meta.requiresAuth && !isAuth) {
    next('/login')
  } else {
    next()
  }
})

export default router
