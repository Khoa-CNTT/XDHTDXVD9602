<template>
    <div class="row">
        <div class="col-lg-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    Thêm Mới Chức Năng
                </div>
                <div class="card-body">
                    <label class="mb-1 mt-1">Tên Chức Vụ</label>
                    <input v-model="create_chuc_vu.ten_chuc_vu" class="form-control" type="text">
                    <label class="mb-1 mt-1">Tình Trạng</label>
                    <select v-model="create_chuc_vu.tinh_trang" class="form-control">
                        <option value="1">
                            Hoạt Động
                        </option>
                        <option value="0">
                            Tạm Dừng
                        </option>
                    </select>
                </div>
                <div @:click="createChucVu()" class="card-footer text-end">
                    <button class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    Danh Sách Chức Vụ
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="100%">
                                        <div class="input-group mb-3">
                                            <input v-on:keyup.enter="searchChucVu()" v-model="key_search.abc"
                                                type="text" class="form-control" placeholder="Nhập thông tin cần tìm">
                                            <button class="btn btn-primary" v-on:click="searchChucVu()">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">#</th>
                                    <th class="align-middle text-center">Tên Chức Vụ</th>
                                    <th class="align-middle text-center">Tình Trạng</th>
                                    <th class="align-middle text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in chuc_vus.data" :key="k" class="text-nowrap">
                                    <th class="align-middle text-center">{{ v.id }}</th>
                                    <td class="align-middle">{{ v.ten_chuc_vu }}</td>
                                    <td class="align-middle text-center">
                                        <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1"
                                            class="btn btn-success">Hoạt động</button>
                                        <button @:click="doiTrangThai(v)" v-else class="btn btn-warning">Tạm
                                            Dừng</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="Object.assign(edit_chuc_vu, v)" style="margin-right: 4px;"
                                            class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#capNhatModal">Cập Nhật</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#xoaModal"
                                            v-on:click="Object.assign(delete_chuc_vu, v)">Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Chức Vụ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="mb-1 mt-1">Tên Chức Vụ</label>
                                    <input v-model="edit_chuc_vu.ten_chuc_vu" class="form-control" type="text">
                                    <label class="mb-1 mt-1">Tình Trạng</label>
                                    <select v-model="edit_chuc_vu.tinh_trang" class="form-control">
                                        <option value="1">
                                            Hoạt Động
                                        </option>
                                        <option value="0">
                                            Tạm Dừng
                                        </option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Thoát</button>
                                    <button v-on:click="updateChucVu()" type="button" data-bs-dismiss="modal"
                                        class="btn btn-danger">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Chức Vụ</h1>
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
                                                <h6 class="mb-0 text-dark">Cảnh báo</h6>
                                                <div class="text-dark">
                                                    <p>Bạn có muốn xóa danh mục <b>{{ delete_chuc_vu.ten_chuc_vu }}</b>
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
                                    <button type="button" class="btn btn-danger" v-on:click="deleteChucVu()"
                                        data-bs-dismiss="modal">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end text-nowrap">
                    <button @click="handlePageChange(currentPage - 1)" :disabled="currentPage <= 1"
                        class="btn btn-secondary btn-sm me-2">Previous</button>
                    <button class="btn btn-secondary btn-sm me-2" v-for="page in pageNumbers" :key="page"
                        @click="page !== '...' && handlePageChange(page)" :class="{ active: page === currentPage }">
                        {{ page }}
                    </button>
                    <button @click="handlePageChange(currentPage + 1)" :disabled="currentPage >= totalPages"
                        class="btn btn-secondary btn-sm me-2">Next</button>
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
            chuc_vus: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            key_search: {},
            create_chuc_vu: {},
            delete_chuc_vu: {},
            edit_chuc_vu: {},
            isSearching: false
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
        this.loadDataChucVu(1);
    },
    methods: {
        loadDataChucVu(page) {
            baseRequest
                .get(`admin/chuc-vu/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`)
                .then((res) => {
                    this.chuc_vus = res.data.chuc_vu;
                });
        },

        searchChucVu(page = 1) {
            baseRequest
                .post(`admin/chuc-vu/tim-chuc-vu?page=${page}`, this.key_search)
                .then((res) => {
                    this.chuc_vus = res.data.chuc_vu;
                    this.chuc_vus.current_page = page;
                    this.isSearching = true;
                });
        },
        handlePageChange(page) {
            if (this.isSearching) {
                this.searchChucVu(page);
            } else {
                this.loadDataChucVu(page);
            }
        },
        createChucVu() {
            console.log(this.create_chuc_vu);
            baseRequest
                .post('admin/chuc-vu/tao-chuc-vu', this.create_chuc_vu)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.create_chuc_vu = {};
                        this.loadDataChucVu(this.chuc_vus.last_page);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        deleteChucVu() {
            baseRequest
                .delete('admin/chuc-vu/xoa-chuc-vu/' + this.delete_chuc_vu.id)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.chuc_vus.current_page);
                    }
                    else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        },
        updateChucVu() {
            baseRequest
                .put('admin/chuc-vu/cap-nhat-chuc-vu', this.edit_chuc_vu)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.chuc_vus.current_page);
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        doiTrangThai(xyz) {
            baseRequest
                .put('admin/chuc-vu/doi-trang-thai', xyz)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.chuc_vus.current_page);
                    } else {
                        toaster.error(res.data.message);
                    }
                });
        }
    }
}
</script>
<style></style>