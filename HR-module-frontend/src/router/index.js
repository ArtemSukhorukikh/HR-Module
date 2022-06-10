import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import OfficeMapFloor2View from "../views/OfficeMapFloor2View";
import OfficeMapFloo3View from "@/views/OfficeMapFloo3View";
import LoginView from "@/views/Auth/LoginView";
import RegistrationView from "@/views/Auth/RegistrationView";
import UserView from "@/views/UserView";
import PageNotFound from "@/components/ErrorPages/Page-not-found";
import KnowledgeBase from "@/views/KnowledgeBaseView";
import CreateAFT from "@/views/Application/CreateApplication";
import UserAFT from "@/views/Application/UserApplications";

const isAuthenticated = localStorage.getItem('token')
const timeAddToken = localStorage.getItem('date')
const authGuard = function beforeEach(to, from, next) {
  let nowDate = new Date()
  let lastDate = new Date(timeAddToken)
  let diff = nowDate - lastDate
  let hour = Math.floor(diff / 3.6e5);
  console.log(hour)
  if (!isAuthenticated || hour > 1) {
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
    path: '/user/:username',
    name: 'userPage',
    component: UserView,
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
  },
  {
    path:'/:pathMatch(.*)*',
    name: "PageNorFound",
    component: PageNotFound,
  },
  {
    path: '/knowledgeBase',
    name: 'База знаний',
    component: KnowledgeBase,
  },
  {
    path: '/CreateAFT',
    name: 'Создание заявок',
    component: CreateAFT,
  },
  {
    path: '/UserAFT',
    name: 'Просмотр заявок пользователь',
    component: UserAFT,
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  linkExactActiveClass: "active"
})

export default router
