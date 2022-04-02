import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Users from '../views/Users.vue'
import UserWorks from '../views/UserWorks.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/pastane',
    name: 'Home',
    component: Home
  },
  {
    path: '/pastane/personeller',
    name: 'AllUsers',
    component: Users
  },
  {
    path: '/pastane/personel/:id',
    name: 'User',
    component: UserWorks
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
