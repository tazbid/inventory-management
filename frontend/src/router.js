import { createRouter, createWebHistory } from 'vue-router';

import Registration from "./components/Registration.vue";
import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";


const routes = [
  {
    path: '/register',
    component: Registration,
  },
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/dashboard',
    component: Dashboard,
  },
  {
    path: '/add/inventory',
    component: () => import('./components/AddInventory.vue'),
  },
  {
    path: '/inventory/:id',
    component: () => import('./components/InventoryDetails.vue'),
  },
  {
    path: '/inventory/:id/details',
    component: () => import('./components/AddItem.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if(to.path === '/dashboard' && !localStorage.getItem('token')) {
    next('/login');
  } else {
    //redirect to dashboard if user is logged in
    if((to.path === '/login' || to.path === '/register' || to.path === '/') && localStorage.getItem('token')) {
      next('/dashboard');
    } else {
      next();
    }
  }
});

export default router;