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

    {
        path: "/",
        component: () => import("../layout/wrapper/index_login.vue"),
        children: [
            {
                path: "login",
                component: () => import("../components/Login/index.vue"),
            },
            {
                path: "dat-lai-mat-khau/:maBiMat",
                component: () => import("../components/DatLaiMatKhau/index.vue"),
            },

            {
                path: "quen-mat-khau",
                component: () => import("../components/QuenMatKhau/index.vue"),
            },
            {
                path: "/auth",
                component: () => import("../components/Auth/index.vue"),
            },
        ],
    },

    //admin

    {
        path: "/admin",
        component: () => import("../layout/wrapper/index.vue"),
        beforeEnter: checkLogin,
        children: [
            {
                path: "",
                component: () => import("../components/Dashboard/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "danh-muc",
                component: () => import("../components/DanhMuc/index.vue"),
                beforeEnter: checkLogin,
            },

            {
                path: "su-dung-dich-vu",
                component: () => import("../components/SuDungDichVu/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "hoa-don-ban-hang",
                component: () => import("../components/HoaDonBanHang/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "bep",
                component: () => import("../components/Bep/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "chuc-vu",
                component: () => import("../components/ChucVu/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "nhan-vien",
                component: () => import("../components/NhanVien/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "nguyen-lieu",
                component: () => import("../components/NguyenLieu/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "nhap-kho",
                component: () => import("../components/NhapKho/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "hoa-don-nhap-kho",
                component: () => import("../components/HoaDonNhapKho/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "mon-an",
                component: () => import("../components/MonAn/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "nha-cung-cap",
                component: () => import("../components/NhaCungCap/index.vue"),
                beforeEnter: checkLogin,
            },
            {
                path: "phan-quyen",
                component: () => import("../components/PhanQuyen/index.vue"),
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
