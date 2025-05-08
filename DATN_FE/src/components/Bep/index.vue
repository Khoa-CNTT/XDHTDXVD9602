<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header text-center">
                    <h3>MENU BẾP</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Hình Ảnh</th>
                                    <th class="text-center align-middle">Tên Món Ăn</th>
                                    <th class="text-center align-middle">Số Lượng</th>
                                    <th class="text-center align-middle">Tên Bàn</th>
                                    <th class="text-center align-middle">Ghi Chú</th>
                                    <th class="text-center align-middle">Thời Gian Đặt Món</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in beps" :key="k">
                                    <th class="align-middle text-center">
                                        <img v-bind:src="v.hinh_anh" style="width: 100px; height: auto;" alt="">
                                    </th>
                                    <td class="align-middle">
                                        {{ v.ten_mon }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ v.so_luong }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ v.ten_ban }}
                                    </td>
                                    <td class="align-middle text-wrap">
                                        {{ v.ghi_chu }}
                                    </td>
                                    <td class="align-middle text-wrap text-center">
                                        {{ date_format(v.updated_at) }}
                                    </td>
                                    <td class="align-middle text-center text-nowrap">
                                        <button @click="updateBep(v)" style="margin-right: 4px;" class="btn btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#capNhatModal">Xong</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            beps: [],
        }
    },
    mounted() {
        this.loadDataBep();
    },
    methods: {
        loadDataBep() {
            baseRequest
                .get(`admin/dich-vu/bep/lay-du-lieu`)
                .then((res) => {
                    this.beps = res.data.data;
                });
        },
        updateBep(v) {
            baseRequest
                .post('admin/dich-vu/bep/update', v)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.loadDataBep();
                    } else {
                        toaster.error(res.data.message);
                    }
                })
        },
        date_format(now) {
            const date = new Date(now);
            return new Intl.DateTimeFormat('vi-Vi', {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            }).format(date);
        },
    }
}
</script>
<style></style>