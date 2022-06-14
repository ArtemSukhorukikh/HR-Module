import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import OfficeMapFloor2View from "../views/OfficeMapFloor2View";
import OfficeMapFloo3View from "@/views/OfficeMapFloo3View";
import LoginView from "@/views/Auth/LoginView";
import RegistrationView from "@/views/Auth/RegistrationView";
import UserView from "@/views/UserView";
import PageNotFound from "@/components/ErrorPages/Page-not-found";
import LogOut from "@/components/LogOut";
import ErrorServer from "@/components/ErrorPages/ErrorServer";
import KnowledgeBase from "@/views/KnowledgeBaseView";
import CreateAFT from "@/views/Application/CreateApplication";
import UserAFT from "@/views/Application/UserApplications";
import CompMap from "@/views/CompetenceMap";
import CompMatr from "@/views/CompetenceMatrixView";
import SkillAs from "@/views/SkillsAssessment";
import DepAFT from "@/views/Application/DepartmentApplication";
import CreateEdRes from "@/views/CreateEducationResource";
import CreateComp from "@/views/CreateChangeCompetence";
import CreateSkills from "@/views/CreateChangeSkill";
import SettingRes from "@/views/EducationResources/SettingsResourcesView";
import UsersView from "@/views/UsersView";
import ProjectView from "@/views/ProjectView";
import DevPlan from "@/views/ProfessionalDevelopmentPlan";
import TasksView from "@/views/TasksView";
import Test from "@/views/Test";
import NotificationsViews from "@/views/NotificationsViews";
const isAuthenticated = localStorage.getItem('token')
const timeAddToken = localStorage.getItem('date')
const authGuard = function beforeEach(to, from, next) {
  let nowDate = new Date()
  let lastDate = new Date(timeAddToken)
  let diff = nowDate - lastDate
  let hour = Math.round(diff/1000/60/60 % 24);
  console.log(hour)
  if (!isAuthenticated || hour > 1) {
    next({name: "Вход"})
  }
  else {
    next()
  }
}
const authHRGuard = function beforeEach(to, from, next) {
  let nowDate = new Date()
  let lastDate = new Date(timeAddToken)
  let diff = nowDate - lastDate
  let hour = Math.round(diff/1000/60/60 % 24);
  console.log(hour)
  let roles = JSON.parse(localStorage.getItem('roles'))
  if (!isAuthenticated || hour > 1 || roles[1] === "ROLE_HR") {
    next({name: ""})
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
    path: '/project/:id',
    name: 'project',
    component: ProjectView,
    beforeEnter: authGuard
  },
  {
    path: '/users-all',
    name: 'usersAll',
    component: UsersView,
    beforeEnter: authHRGuard
  },
  {
    path: '/tasks',
    name: 'tasks',
    component: TasksView,
    beforeEnter: authHRGuard
  },
  {
    path: '/notifications',
    name: 'notifications',
    component: NotificationsViews,
    beforeEnter: authHRGuard
  },
  {
    path: '/error/:errorCode',
    name: 'errorPage',
    component: ErrorServer,
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
    path:'/logout',
    name: "Logout",
    component: LogOut
  },
  {
    path:'/:pathMatch(.*)*',
    name: "PageNorFound",
    component: PageNotFound,
    beforeEnter: authGuard
  },
  {
    path: '/knowledgeBase/:id',
    name: 'knowledgeBase',
    component: KnowledgeBase,
    beforeEnter: authGuard
  },
  {
    path: '/CreateAFT',
    name: 'Создание заявок',
    component: CreateAFT,
    beforeEnter: authGuard
  },
  {
    path: '/UserAFT',
    name: 'Просмотр заявок пользователь',
    component: UserAFT,
    beforeEnter: authGuard
  },
  {
    path: '/compMap',
    name: 'Карта компетенций',
    component: CompMap,
    beforeEnter: authGuard
  },
  {
    path: '/compMatr',
    name: 'Матрица компетенций',
    component: CompMatr,
    beforeEnter: authGuard
  },
  {
    path: '/skillAs',
    name: 'Оценка навыков',
    component: SkillAs,
    beforeEnter: authGuard
  },
  {
    path: '/DepAFT',
    name: 'Просмотр заявок отдела',
    component: DepAFT,
    beforeEnter: authGuard
  },
  {
    path: '/createEdRes',
    name: 'Создание образовательного ресурса НЕТУ',
    component: CreateEdRes,
    beforeEnter: authGuard
  },
  {
    path: '/compRed',
    name: 'Создание изменение компетенции',
    component: CreateComp,
    beforeEnter: authGuard
  },
  {
    path: '/skillsRed',
    name: 'Создание изменение навыков',
    component: CreateSkills,
    beforeEnter: authGuard
  },
  {
    path: '/settingRes',
    name: 'Создание изменение образовательных ресурсов',
    component: SettingRes,
    beforeEnter: authGuard
  },
  {
    path: '/DevPlan',
    name: 'План повышения квалификации',
    component: DevPlan,
    beforeEnter: authGuard
  },
  {
    path: '/test',
    name: 'План повышения квалификации',
    component: Test
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  linkExactActiveClass: "active"
})

export default router
