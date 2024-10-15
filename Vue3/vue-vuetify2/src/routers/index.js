import { createRouter, createWebHistory } from 'vue-router'
import App from '@/components/App.vue'
import List from '@/components/List/index.vue'
import Card from '@/components/Card/index.vue'
import Sheet from '@/components/Sheet/index.vue'
import Bottom from '@/components/Bottom/index.vue'
import Bottom2 from '@/components/Bottom2/index.vue'
import Menu from '@/components/Menu/index.vue'
import Toolbars from '@/components/Toolbars/index.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: App
        },
        {
            path: '/List',
            component: List
        },
        {
            path: '/Card',
            component: Card
        },
        {
            path: '/Sheet',
            component: Sheet
        },
        {
            path: '/Bottom',
            component: Bottom
        },
        {
            path: '/Bottom2',
            component: Bottom2
        },
        {
            path: '/Menu',
            component: Menu
        },
        {
            path: '/Toolbars',
            component: Toolbars
        },
    ]
})

export default router