<template>
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="topbar-logo-header">
                    <router-link to="/admin">
                        <img src="../../assets/assets_rocker/images/logo-icon.png" class="logo-icon" alt="logo icon">
                    </router-link>
                    <router-link to="/admin">
                        <h4 class="logo-text atma-medium text-dark">FORYOU</h4>
                    </router-link>
                </div>
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                <div class="search-bar flex-grow-1">
                    <div class="position-relative search-bar-box">
                        <input type="text" class="form-control search-control" placeholder="Type to search..."> <span
                            class="position-absolute top-50 search-show translate-middle-y"><i
                                class='bx bx-search'></i></span>
                        <span class="position-absolute top-50 search-close translate-middle-y"><i
                                class='bx bx-x'></i></span>
                    </div>
                </div>
                <div class="top-menu ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item mobile-search-icon">
                            <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                            </a>
                        </li>
                        <div class="header-notifications-list">
                        </div>
                        <div class="header-message-list">
                        </div>
                        <li class="nav-item dropdown dropdown-large">
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                        </li>
                    </ul>
                </div>
                <div class="user-box dropdown">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../assets/assets_rocker/images/avatars/avatar-2.png" class="user-img"
                            alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0">{{ ten_hien_thi }}</p>
                            <p class="designattion mb-0">{{ chuc_vu }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a v-on:click="dangXuat()" class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-log-out-circle'></i><span>Đăng Xuất</span></a>
                        </li>
                        <li>
                            <a v-on:click="dangXuatAll()" class="dropdown-item" href="javascript:;"><i
                                    class="fa-solid fa-right-from-bracket"></i>
                                <span>Đăng Xuất Tất Cả Thiết Bị</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</template>
<script>
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            ten_hien_thi: 'Chưa đăng nhập',
            chuc_vu: 'Chưa đăng nhập',
        }
    },
    mounted() {
        this.ten_hien_thi = localStorage.getItem('ho_ten');
        this.chuc_vu = localStorage.getItem('chuc_vu');
    },
    methods: {
        dangXuat() {
            baseRequest
                .get('dang-xuat')
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.$router.push('/login');
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        },
        dangXuatAll() {
            baseRequest
                .get('dang-xuat-tat-ca')
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.$router.push('/login');
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        }
    },
}
</script>
<style>
.atma-medium {
    font-family: "Atma", system-ui;
    font-weight: 700;
    font-style: normal;
}
</style>