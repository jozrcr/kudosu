import { createWebHistory, createRouter } from 'vue-router'
import HomePage from '../components/HomePage.vue'
import GamePage from '../components/GamePage.vue'
import NotFound from '../components/NotFoundPage.vue'

const routes = [
    { path: '/', component: HomePage },
    { path: '/game', component: GamePage },
    { path: '/:pathMatch(.*)*', component: NotFound },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
