import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save
import checkLogin from "./checkLogin";
const routes = [
    {
        path: "/",
        component: () => import("../layout/wrapper/index_client.vue"),
        children: [
            {
                path: "/",
                component: () => import("../components/HomePage/Home/index.vue"),
            },
            {
                path: "about",
                component: () => import("../components/HomePage/About/index.vue"),
            },
            {
                path: "menu",
                component: () => import("../components/HomePage/Menu/index.vue"),
            },
            {
                path: "news",
                component: () => import("../components/HomePage/New/index.vue"),
            },
            {
                path: "detail-new/:id",
                component: () => import("../components/HomePage/Detail_New/index.vue"),
                props: true,
            },
            {
                path: "ban/:slug_ban/:hash_ban",
                component: () => import("../components/HomePage/Dat_Mon/index.vue"),
                props: true,
            },
        ],
    },

    // Quên mật Khẩu
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
