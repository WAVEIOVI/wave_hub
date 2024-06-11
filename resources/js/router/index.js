import { useUserStore } from '@/stores/user'
import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    ...setupLayouts(routes),
  ],
})

router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore()
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const role = to.meta.role

  if (requiresAuth && !userStore.isAuthenticated) {
    next('/login')
  } else if (requiresAuth && userStore.isAuthenticated) {
    const userRole = userStore.roles[0] // Assuming roles is an array
    if (role && userRole !== role) {
      next('/login') // Or redirect to an appropriate page
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
