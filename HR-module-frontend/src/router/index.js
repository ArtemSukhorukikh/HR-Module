import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import OfficeMapFloor2View from "../views/OfficeMapFloor2View";
import OfficeMapFloo3View from "@/views/OfficeMapFloo3View";
const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  },
  {
    path: '/officemap/floor2',
    name: 'Карта офиса этаж 2',
    component: OfficeMapFloor2View
  },
  {
    path: '/officemap/floor3',
    name: 'Карта офиса этаж 3',
    component: OfficeMapFloo3View
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
