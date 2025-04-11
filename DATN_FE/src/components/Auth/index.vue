<template>
    <div class="row">
        <div class="col-lg-6" v-if="is_login == false">
            <div class="card">
                <div class="card-header">
                    ĐĂNG NHẬP
                </div>
                <div class="card-body">
                    <label class="mb-2">Email</label>
                    <input v-model="dang_nhap.email" type="email" class="form-control">
                    <label class="mb-2">Mật Khẩu</label>
                    <input v-model="dang_nhap.password" type="text" class="form-control">
                </div>
                <div class="card-footer text-end">
                    <button v-on:click="dangNhap()" class="btn btn-danger">Đăng Nhập</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    CHECK TOKEN
                </div>
                <div class="card-body">
                    <label class="mb-2">Token</label>
                    <input v-model="check_token.token" type="text" class="form-control">
                </div>
                <div class="card-footer text-end">
                    <button v-on:click="checkToken()" class="btn btn-warning">Check Login</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    DANH SÁCH ABC
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">Device</th>
                                    <th class="text-center">Browser</th>
                                    <th class="text-center">Ip</th>
                                    <th class="text-center">Os</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in list_token" :key="k">
                                    <th class="text-center align-middle">{{ v.id }}</th>
                                    <td class="align-middle">{{ v.device }}</td>
                                    <td class="align-middle">{{ v.trinh_duyet }}</td>
                                    <td class="align-middle">{{ v.ip }}</td>
                                    <td class="align-middle">{{ v.os }}</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-danger" @:click="remove_token = v" data-bs-toggle="modal"
                                            data-bs-target="#xoaModal">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Token</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div
                                        class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-dark">Warning</h6>
                                                <div class="text-dark">
                                                    <p>Bạn có muốn xóa token <b></b>
                                                        này không?
                                                    </p>
                                                    <p>
                                                        <b>Lưu ý:</b> Điều này không thể hoàn tác!
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Thoát</button>
                                    <button type="button" class="btn btn-danger" v-on:click="removeToken()"
                                        data-bs-dismiss="modal">Xóa</button>
                                </div>
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
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            dang_nhap: {},
            check_token: {},
            is_login: true,
            list_token: [],
            remove_token: {},
        }
    },
    mounted() {
        // this.is_login = false;
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
                        this.checkToken();
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
                    console.log(res.data);
                    localStorage.setItem('ho_ten', res.data.ho_ten);
                    if (res.status === 200) {
                        this.is_login = true;
                        this.list_token = res.data.list;
                    }

                })
                .catch(() => {
                    this.is_login = false;
                });
        },
        removeToken() {
            axios
                .delete('http://127.0.0.1:8000/api/remove-token/'+ this.remove_token.id)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.list_token = [],
                            this.checkToken();
                    }
                })
        }
    },
}
</script>
<style></style>