import { createWebHistory, createRouter } from 'vue-router'
import Home from '../components/Home.vue';
import Game from '../components/Game.vue';
import NotFound from '../components/NotFoundPage.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/game', component: Game },
    { path: '/:pathMatch(.*)*', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router