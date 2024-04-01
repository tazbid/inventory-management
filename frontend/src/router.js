import { createRouter, createWebHistory } from 'vue-router';

import Registration from "./components/Registration.vue";
import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";
import GoogleCallback from "./components/GoogleCallback.vue";
import GenerateJob from "./components/GenerateJob.vue";
import GeneratedJobs from "./components/GeneratedJobs.vue";
import JobDetails from "./components/JobDetails.vue";
import JobApply from "./components/JobApply.vue";
import JobApplications from "./components/JobApplications.vue";
import JobApplicationDetails from "./components/JobApplicationDetails.vue";


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
    path: '/google/callback',
    component: GoogleCallback,
  },
  {
    path: '/user/generate-job',
    component: GenerateJob,
  },
  {
    path: '/user/generated-jobs',
    component: GeneratedJobs,
  },
  {
    path: '/job/:id',
    component: JobDetails,
  },
  {
    path: '/apply/:id',
    component: JobApply,
  },
  {
    path: '/job/:id/applications',
    component: JobApplications,
  },
  {
    path: '/job/:id/application/:applicationId',
    component: JobApplicationDetails,
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