<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            Danh Sách Quyền
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th>#</th>
                                    <th>Tên Quyền</th>
                                    <th>Cấp Quyền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in chuc_vus.data" :key="k" class="align-middle">
                                    <th class="text-center">{{ v.id }}</th>
                                    <td>{{ v.ten_chuc_vu }}</td>
                                    <td class="text-center">
                                        <button v-on:click="chucVu = v; check_cv = true; getChucNang()"
                                            class="btn btn-info text-white">Phân Quyền</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end text-nowrap">
                    <button @click="getData(currentPage - 1)" :disabled="currentPage <= 1"
                        class="btn btn-secondary btn-sm me-2">Previous</button>
                    <button class="btn btn-secondary btn-sm me-2" v-for="page in pageNumbers" :key="page"
                        @click="page !== '...' && getData(page)" :class="{ active: page === currentPage }">
                        {{ page }}
                    </button>
                    <button @click="getData(currentPage + 1)" :disabled="currentPage >= totalPages"
                        class="btn btn-secondary btn-sm me-2">Next</button>
                </div>
            </div>
        </div>

        <div class="col-lg-4" v-if="check_cv == true">
            <div class="card">
                <div class="card-header">
                    Danh Sách Chức Năng
                </div>
                <div class="card-body" style="max-height: 460px; overflow-y: auto;">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center text-nowrap align-middle">
                                        <th>#</th>
                                        <th>Tên Chức Năng</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(v, k) in listChucNang" :key="k" class="align-middle">
                                        <th class="text-center">{{ k + 1 }}</th>
                                        <td class="text-wrap">{{ v.ten_action }}</td>
                                        <td class="text-center">
                                            <button v-on:click="createPhanQuyen(v.id)" class="btn btn-primary">Cấp
                                                Quyền</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" v-if="check_cv == true">
            <div class="card">
                <div class="card-header">
                    Đang Phân Quyền Cho <b class="text-danger"> {{ chucVu.ten_chuc_vu }}</b>
                </div>
                <div class="card-body" style="max-height: 460px; overflow-y: auto;">
                    <div class="row">
                        <template v-for="(v, k) in phan_quyen" :key="k">
                            <div class="col-lg-12 text-nowrap">

                                <div class="chip chip-lg text-white w-100 d-flex align-items-center justify-content-between" style="height: 60px;" :class="v.dynamicClass">
                                <b><span>{{ k + 1 }}. </span> <span class="text-wrap">{{
                                    v.ten_action }}</span>
                                </b>
                                <span class="closebtn" v-on:click="xoaPhanQuyen(v)">×</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            listChucNang: [],
            chuc_vus: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            chucVu: {},
            phan_quyen: [],
            check_cv: false
        }
    },
    computed: {
        currentPage() {
            return this.chuc_vus.current_page;
        },
        totalPages() {
            return this.chuc_vus.last_page;
        },
        pageNumbers() {
            let pages = [];
            for (let i = 1; i <= this.totalPages; i++) {
                pages.push(i);
            }
            return pages;
        },
        // Tính toán các số trang để hiển thị
        pageNumbers() {
            let pages = [];
            if (this.totalPages <= 4) {
                // Nếu tổng số trang <= 3, hiển thị tất cả các trang
                for (let i = 1; i <= this.totalPages; i++) {
                    pages.push(i);
                }
            } else {
                if (this.currentPage < 4) {
                    // Người dùng đang ở ba trang đầu
                    let maxPage = Math.min(4, this.totalPages); // Đảm bảo không vượt quá tổng số trang
                    for (let i = 1; i <= maxPage; i++) {
                        pages.push(i);
                    }
                    if (this.totalPages > 4) {
                        pages.push('...');
                        pages.push(this.totalPages);
                    }
                } else if (this.currentPage >= this.totalPages - 2) {
                    // Người dùng đang ở ba trang cuối
                    pages.push(1);
                    if (this.totalPages > 4) {
                        pages.push('...');
                    }
                    let minPage = Math.max(this.totalPages - 3, 1); // Đảm bảo không nhỏ hơn trang đầu tiên
                    for (let i = minPage; i <= this.totalPages; i++) {
                        pages.push(i);
                    }
                } else {
                    // Người dùng đang ở các trang giữa
                    pages.push(1);
                    pages.push('...');
                    for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
                        pages.push(i);
                    }
                    pages.push('...');
                    pages.push(this.totalPages);
                }
            }
            return pages;
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData(page) {
            baseRequest
                .get(`admin/phan-quyen/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`)
                .then((res) => {
                    this.chuc_vus = res.data.listChucVu;
                });
        },
        createPhanQuyen(id) {
            const payload = {
                'id_chuc_nang': id,
                'id_chuc_vu': this.chucVu.id,
            };
            baseRequest
                .post('admin/phan-quyen/create', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.getChucNang();
                    } else {
                        toaster.error('Có Lỗi<br>' + res.data.message);
                    }
                })
                .catch((res) => {
                    var errors = Object.values(res.response.data.errors);
                    errors.forEach(function (v, k) {
                        toaster.error('Có Lỗi<br>' + v[0]);
                    });
                });
        },

        layTenMauNgauNhien() {
            const danhSachMau = ['deepblue', 'orange', 'ohhappiness', 'ibiza', 'scooter', 'bloody', 'quepal', 'blooker', 'cosmic', 'burning', 'lush', 'kyoto', 'blues', 'moonlit'];
            return danhSachMau[Math.floor(Math.random() * danhSachMau.length)];
        },

        getChucNang() {
            baseRequest
                .post('admin/phan-quyen/get-chuc-nang', this.chucVu)
                .then((res) => {
                    this.phan_quyen = res.data.data.map(item => {
                        // Tính toán và gán lớp CSS động cho mỗi phần tử
                        item.dynamicClass = 'bg-gradient-' + this.layTenMauNgauNhien();
                        return item;
                    });
                    this.listChucNang = res.data.chuc_nang;

                })
                .catch((res) => {
                    var errors = Object.values(res.response.data.errors);
                    errors.forEach(function (v, k) {
                        toaster.error('Có Lỗi<br>' + v[0]);
                    });
                });
        },

        xoaPhanQuyen(value) {
            baseRequest
                .delete('admin/phan-quyen/xoa-phan-quyen/' + value.id)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.getChucNang();
                    } else {
                        toaster.error('Có Lỗi<br>' + res.data.message);
                    }
                })
                .catch((res) => {
                    var errors = Object.values(res.response.data.errors);
                    errors.forEach(function (v, k) {
                        toaster.error('Có Lỗi<br>' + v[0]);
                    });
                });
        }
    },
}
</script>
<style></style>