<template>
    <div class="py-5 bg-dark mb-5" :style="{ backgroundImage: 'url(' + bai_viet.hinh_anh + ')',
                                             backgroundPosition: 'center center',
                                             backgroundRepeat: 'no-repeat',
                                             backgroundSize: 'cover',
                                             height: '500px' }">
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="container">
                    <div class="col-lg-12">
                        <h1 class="mb-4">{{ bai_viet.tieu_de }}</h1>
                        <p class="mb-4">{{ bai_viet.noi_dung }}</p>
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
    props : ['id'],
    data() {
        return {
            bai_viet: {},
        }
    },
    mounted() {
        this.loadDataBaiViet();
    },
    beforeRouteUpdate(to, from, next) {
        this.loadDataBaiViet();
    },
    methods: {
        loadDataBaiViet() {
            baseRequest
                .get(`chi-tiet-bai-viet-homepage/` + this.id)
                .then((res) => {
                    this.bai_viet = res.data.bai_viet;
                });
        },
    }
}
</script>
<style></style>