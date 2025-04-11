<template>
    <div class="py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">News</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item">
                        <router-link to="/">
                            <a href="/">Home</a>
                        </router-link>
                    </li>
                    <li class="breadcrumb-item text-white active" aria-current="page">News</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">News</h5>
                <h1 class="mb-5">Featured News</h1>
            </div>
        </div>
        <div class="row">
            <template v-for="(v, k) in list_bai_viet" :key="k">
                <div class="col-lg-4 d-flex">
                    <div class="service-item rounded pt-3 flex-fill mt-4">
                        <router-link :to="'detail-new/' + v.id">
                            <div class="p-4 text-center">
                                <img :src="v.hinh_anh" style="height: 300px; width: 100%;" alt="">
                                <h5 class="text-center text-primary fw-normal mt-3">{{ v.tieu_de }}</h5>
                            </div>
                        </router-link>
                    </div>
                </div>
            </template>
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
            list_bai_viet: [],
        }
    },
    mounted() {
        this.loadDataBaiViet();
    },
    methods: {
        loadDataBaiViet() {
            baseRequest
                .get(`bai-viet-homepage`)
                .then((res) => {
                    this.list_bai_viet = res.data.bai_viet;
                });
        },
    }
}
</script>
<style></style>