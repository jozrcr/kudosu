import { createWebHistory, createRouter } from 'vue-router'
import HomePage from '../components/HomePage.vue'
import GameSelection from '../components/GameSelection.vue'
import GamePage from '../components/GamePage.vue'
import NotFound from '../components/NotFoundPage.vue'

const routes = [
    { path: '/', component: HomePage },
    { path: '/play/daily', component: GameSelection, props: {challengeType: 'daily'} },
    { path: '/play/random', component: GameSelection, props: {challengeType: 'random'} },
    { path: '/game', component: GamePage },
    { path: '/:pathMatch(.*)*', component: NotFound },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
