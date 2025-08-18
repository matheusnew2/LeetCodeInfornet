import AppLayout from '@/layout/AppLayout.vue';
import { useLayout } from '@/layout/composables/layout';
import { createRouter, createWebHistory } from 'vue-router';
const { toggleMenu, toggleDarkMode, isDarkTheme } = useLayout();
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/prestadores',
                    name: 'prestadores',
                    component: () => import('@/views/pages/PrestadoresView.vue')
                }
            ]
        },

          { path: '/:pathMatch(.*)*', name: 'NotFound', component: () => import('@/views/pages/NotFound.vue') },
        {
            path: '/login',
            name: 'login',
            component: () => import('@/views/pages/auth/Login.vue')
        },
    ]
});
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !isAuthenticated()) { // isAuthenticated() is a placeholder for your auth check
    next('/login'); // Redirect to login if not authenticated
  } else {
    toggleMenu();
    next(); // Continue to the route
  }
});
export default router;
