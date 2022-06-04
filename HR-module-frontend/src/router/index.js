import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import OfficeMapFloor2View from "../views/OfficeMapFloor2View";
import OfficeMapFloo3View from "@/views/OfficeMapFloo3View";
import LoginView from "@/views/Auth/LoginView";
import RegistrationView from "@/views/Auth/RegistrationView";

const isAuthenticated = localStorage.getItem('token')
const authGuard = function beforeEach(to, from, next) {
  if (!isAuthenticated) {
    next({name: "Вход"})
  }
  else {
    next()
  }
}

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    beforeEnter: authGuard
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue'),
    beforeEnter: authGuard
  },
  {
    path: '/officemap/floor2',
    name: 'Карта офиса этаж 2',
    component: OfficeMapFloor2View,
    beforeEnter: authGuard
  },
  {
    path: '/officemap/floor3',
    name: 'Карта офиса этаж 3',
    component: OfficeMapFloo3View,
    beforeEnter: authGuard
  },
  {
    path: '/login',
    name: 'Вход',
    component: LoginView,
  },
  {
    path: '/registration',
    name: 'Регистрация',
    component: RegistrationView,
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
