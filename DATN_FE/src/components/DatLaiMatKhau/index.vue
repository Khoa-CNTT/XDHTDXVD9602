<template>
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="row g-0">
                <div class="col-lg-5 border-end">
                    <div class="card-body">
                        <div class="p-5">
                            <div class="text-start">
                                <img src="../../../assets/assets_rocker/images/logo-img.png" width="180" alt="" />
                            </div>
                            <h4 class="mt-5 font-weight-bold">Đặt Lại Mật Khẩu</h4>
                            <p class="text-muted">Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Vui lòng nhập mật khẩu mới của bạn!</p>
                            <div class="mb-3 mt-5">
                                <label class="form-label">Nhập Mật Khẩu Mới</label>
                                <input type="password" v-model="doi_mat_khau.password" class="form-control" placeholder="Nhập vào mật khẩu mới" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nhập Lại Mật Khẩu Mới</label>
                                <input type="password" v-model="doi_mat_khau.re_password" class="form-control" placeholder="Nhập lại mật khẩu mới" />
                            </div>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" v-on:click="doiMatKhau()">Xác Nhận</button>
                                <router-link to="/login">
                                    <a href="/login" class="btn btn-light" style="width: 100%">
                                        <i class="bx bx-arrow-back mr-1"></i>
                                        Back to Login
                                    </a>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <img src="../../assets/assets_rocker/images/login-images/forgot-password-frent-img.jpg" class="card-img login-img h-100" alt="..." />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from "../../core/baseRequest";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            doi_mat_khau: {},
        };
    },
    mounted() {
        this.checkOke();
    },
    methods: {
        checkOke() {
            this.doi_mat_khau.hash_quen_mat_khau = this.$route.params.maBiMat;
            baseRequest.post("kiem-tra-quen-mk", this.doi_mat_khau).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                } else {
                    toaster.error("Thông báo<br>" + res.data.message);
                    this.$router.push("/login");
                }
            });
        },
        doiMatKhau() {
            if (this.doi_mat_khau.password !== this.doi_mat_khau.re_password) {
                toaster.error("Thông báo<br>Mật khẩu và nhập lại mật khẩu không khớp!");
                return;
            }

            baseRequest
                .post("doi-mat-khau", {
                    hash_quen_mat_khau: this.doi_mat_khau.hash_quen_mat_khau,
                    password: this.doi_mat_khau.password,
                    password_confirmation: this.doi_mat_khau.re_password,
                })
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.$router.push("/login");
                    } else {
                        toaster.error("Thông báo<br>" + res.data.message);
                        this.$router.push("/login");
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        let msg = "";
                        Object.keys(errors).forEach((key) => {
                            msg += errors[key][0] + "<br>";
                        });
                        toaster.error("Thông báo<br>" + msg);
                    }
                });
        },
    },
};
</script>
<style></style>
