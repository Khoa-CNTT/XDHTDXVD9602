<template>
    <div class="py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Welcom to<br>ForYou Restaurant</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">Let ForYou take care of "Healthy Body - Peaceful Mind" within you!</p>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="../../../assets/assets_client/img/hero.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4 text-center">
                            <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                            <h5>Master Chefs</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4 text-center">
                            <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                            <h5>Quality Food</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4 text-center">
                            <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                            <h5 class="text-nowrap">Online Make A Reservation</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4 text-center">
                            <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                            <h5>24/7 Service</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s"
                                src="../../../assets/assets_client/img/about-1.jpg">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s"
                                src="../../../assets/assets_client/img/about-2.jpg" style="margin-top: 25%;">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s"
                                src="../../../assets/assets_client/img/about-3.jpg">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s"
                                src="../../../assets/assets_client/img/about-4.jpg">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">About Us</h5>
                    <h1 class="mb-4">Welcome to <img src="../../../assets/assets_rocker/images/logo-icon-cl.png"
                            style="height: 50px; width: auto;" alt="">ForYou</h1>
                    <p class="mb-4">Located on Quang Trung street - one of the busiest streets in Da Nang today, ForYou
                        Restaurant is a completely new and unique restaurant that you cannot find anywhere else in Da
                        Nang city.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15</h1>
                                <div class="ps-4">
                                    <p class="mb-0">Years of</p>
                                    <h6 class="text-uppercase mb-0">Experience</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50</h1>
                                <div class="ps-4">
                                    <p class="mb-0">Popular</p>
                                    <h6 class="text-uppercase mb-0">Master Chefs</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <router-link to="/about">
                        <a class="btn btn-primary py-3 px-5 mt-2" href="/about">Read More</a>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                <h1 class="mb-5">Most Popular Items</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <template v-for="(v, k) in list_danh_muc" :key="k">
                        <template v-if="v.id_danh_muc_cha == 0">
                            <li class="nav-item">
                                <a @click="loadMonAn(v)" class="d-flex align-items-center text-start mx-3 ms-0 pb-3"
                                    data-bs-toggle="pill" href="#tab-1">
                                    <span v-html="v.icon"></span>
                                    <div class="ps-3">
                                        <small class="text-body">ForYou Restaurant</small>
                                        <h6 class="mt-n1 mb-0">{{ v.ten_danh_muc }}</h6>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </template>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="container" style="width: 1000px;">
                            <div class="row g-4">
                                <template v-for="(v, k) in list_mon_an" :key="k">
                                    <div class="col-lg-4">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" :src="v.hinh_anh" alt=""
                                                style="width: 80px;">
                                            <div
                                                class="w-100 d-flex align-items-center justify-content-between text-start ps-4">
                                                <spam class="d-flex flex-column border-bottom me-5">
                                                    <h5 class="text-nowrap">{{ v.ten_mon }}</h5>
                                                    <small class="fst-italic mt-2">{{ formatToVND(v.gia_ban) }}</small>
                                                </spam>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import baseRequest from '../../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            list_danh_muc: [],
            list_mon_an: [],
        }
    },
    mounted() {
        this.loadDataDanhMuc();
    },
    methods: {
        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },
        loadDataDanhMuc() {
            baseRequest
                .get(`danh-muc-homepage`)
                .then((res) => {
                    this.list_danh_muc = res.data.danh_muc;
                    this.loadMonAn(this.list_danh_muc[0]);
                });
        },

        loadMonAn(v) {
            baseRequest
                .post(`mon-an-homepage`, v)
                .then((res) => {
                    this.list_mon_an = res.data.mon_an;
                });
        }
    }
}
</script>
<style></style>