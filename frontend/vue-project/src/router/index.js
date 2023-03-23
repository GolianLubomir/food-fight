import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import FoodMenu from '../views/FoodMenu.vue'
import DescriptionApi from '../views/DescriptionApi.vue'
import Api from '../views/Api.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/foodmenu',
      name: 'Home',
      component: Home,
      children: [
        {path: '/foodmenu', name: 'FoodMenu', component: FoodMenu},
        {path: '/apidescription', name: 'DescriptionApi', component: DescriptionApi},
        {path: '/api', name: 'api', component: Api},
      ],
    },

  ]
})

export default router
