<template>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
        <div class="col mx-auto">
            <div class="mb-4 text-center">
                <img src="../../assets/assets_rocker/images/logo-icon.png" width="180" alt="" />
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">
                        <div class="text-center">
                            <h3 class="">ĐĂNG NHẬP</h3>
                        </div>
                        <div class="login-separater text-center mb-4">
                            <hr />
                        </div>
                        <div class="form-body">
                            <form class="row g-3">
                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label">Email</label>
                                    <input type="email" v-model="dang_nhap.email" class="form-control"
                                        id="inputEmailAddress" placeholder="Email">
                                </div>
                                <div class="col-12">
                                    <label for="inputChoosePassword" class="form-label">Mật Khẩu</label>
                                    <input type="password" v-model="dang_nhap.password" class="form-control"
                                        id="inputEmailAddress" placeholder="Enter Password">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <router-link to="/quen-mat-khau">
                                        <a href="/quen-mat-khau">Quên mật khẩu?
                                        </a>
                                    </router-link>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" @:click="dangNhap()" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign
                                            in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            dang_nhap: {},
        }
    },
    mounted() {
        this.checkToken();
    },
    methods: {
        dangNhap() {
            axios
                .post('http://127.0.0.1:8000/api/login', this.dang_nhap)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        var arr = res.data.token.split("|");
                        localStorage.setItem('token', arr[1]);
                        console.log(arr[1]);
                        this.checkToken();
                        this.$router.push('/admin');

                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        },
        checkToken() {
            axios
                .post('http://127.0.0.1:8000/api/check', {}, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then((res) => {
                    localStorage.setItem('ho_ten', res.data.ho_ten);
                    if (res.status === 200) {
                        this.list_token = res.data.list;
                        this.$router.push('/admin');
                    }

                })
                .catch(() => {
                });
        },
    },
}
</script>
<style></style>