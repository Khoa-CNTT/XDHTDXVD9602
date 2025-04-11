<template>
    <div class="py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Food Menu</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item">
                        <router-link to="/">
                            <a href="/">Home</a>
                        </router-link>
                    </li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                </ol>
            </nav>
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
                        <template v-if="v.id_danh_muc_cha != 0">
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
                    this.loadMonAnMenu();
                });
        },

        loadMonAnMenu() {
            baseRequest
                .get(`mon-an-menu`)
                .then((res) => {
                    this.list_mon_an = res.data.mon_an;
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