<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-header">
                    <h5>Thêm Mới Danh Mục</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">Icon</label>
                    <input v-model="create_danh_muc.icon" type="text" class="form-control"
                        placeholder="Nhập icon danh mục">
                    <label class="form-label  mt-3">Tên Danh Mục</label>
                    <input v-model="create_danh_muc.ten_danh_muc" v-on:keyup="addSlug()" v-on:change=" kiemTraSlug()"
                        type="text" class="form-control" placeholder="Nhập tên danh mục">
                    <label class="form-label mt-3">Slug Danh Mục</label>
                    <input disabled v-model="create_danh_muc.slug_danh_muc" v-on:change="kiemTraSlug()" type="text"
                        class="form-control" placeholder="Nhập slug danh mục">
                    <label class="form-label mt-3">Danh Mục Cha</label>
                    <select v-model="create_danh_muc.id_danh_muc_cha" class="form-control">
                        <option value="0">Root</option>
                        <template v-for="(value, key) in list_danh_muc" :key="key">
                            <option v-bind:value="value.id">{{ value.ten_danh_muc }}</option>
                        </template>
                    </select>
                    <label class="form-label mt-3">Tình Trạng</label>
                    <select v-model="create_danh_muc.tinh_trang" class="form-control">
                        <option value="0">Tạm Dừng</option>
                        <option value="1">Hiển Thị</option>
                    </select>
                </div>
                <div class="card-footer text-end">
                    <button @:click="createDanhMuc()" v-if="is_create" class="btn btn-primary">Thêm mới</button>
                    <button v-else class="btn btn-primary" disabled>Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-header">
                    <h5>Danh Sách Danh Mục</h5>
                </div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="100%">
                                        <div class="input-group mb-3">
                                            <input v-on:keyup.enter="searchDanhMuc()" v-model="key_search.abc"
                                                type="text" class="form-control" placeholder="Nhập thông tin cần tìm">
                                            <button class="btn btn-primary" v-on:click="searchDanhMuc()">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle text-nowrap">
                                        #
                                    </th>
                                    <th class="text-center align-middle text-nowrap">
                                        Icon
                                    </th>
                                    <th class="text-center align-middle text-nowrap">
                                        Tên Danh Mục
                                    </th>
                                    <th class="text-center align-middle text-nowrap">
                                        Slug Danh Mục
                                    </th>
                                    <th class="text-center align-middle text-nowrap">
                                        Tình Trạng
                                    </th>
                                    <th class="text-center align-middle text-nowrap">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in danh_mucs.data" :key="k">
                                    <th class="text-center align-middle text-nowrap">
                                        {{ v.id }}
                                    </th>
                                    <td class="align-middle text-nowrap text-center">
                                        <span v-html="v.icon"></span>
                                    </td>
                                    <td class="align-middle text-nowrap">
                                        {{ v.ten_danh_muc }}
                                    </td>
                                    <td class="align-middle text-nowrap">
                                        {{ v.slug_danh_muc }}
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1"
                                            class="btn btn-success" style="width: 100px;">Hiển
                                            Thị</button>
                                        <button @:click="doiTrangThai(v)" v-else class="btn btn-warning"
                                            style="width: 100px;">Tạm Dừng</button>
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button v-on:click="Object.assign(edit_danh_muc, v)" class="btn btn-info me-1"
                                            style="width: 100px;" data-bs-toggle="modal"
                                            data-bs-target="#capNhatModal">Cập
                                            Nhật</button>
                                        <button class="btn btn-danger" style="width: 100px;" data-bs-toggle="modal"
                                            data-bs-target="#xoaModal"
                                            v-on:click="Object.assign(delete_danh_muc, v)">Xóa</button>
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
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Danh Mục
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Icon</label>
                                            <input v-model="edit_danh_muc.icon" type="text" class="form-control"
                                                placeholder="Nhập icon danh mục">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Tên Danh Mục</label>
                                            <input v-model="edit_danh_muc.ten_danh_muc" type="text" class="form-control"
                                                placeholder="Nhập tên danh mục">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mt-3">Slug Danh Mục</label>
                                            <input v-model="edit_danh_muc.slug_danh_muc" type="text"
                                                class="form-control" placeholder="Nhập slug danh mục">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label mt-3">Tình Trạng</label>
                                            <select v-model="edit_danh_muc.tinh_trang" class="form-control">
                                                <option value="0">Tạm Dừng</option>
                                                <option value="1">Hiển Thị</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="updateDanhMuc()" type="button" data-bs-dismiss="modal"
                                        class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Danh Mục</h1>
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
                                                    <p>Bạn có muốn xóa danh mục <b>{{ delete_danh_muc.ten_danh_muc
                                                            }}</b>
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
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                        v-on:click="deleteDanhMuc()">Xóa</button>
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
import baseRequest from '../../core/baseRequest';
import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            list_danh_muc: [],
            key_search: {},
            create_danh_muc: {},
            danh_mucs: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            delete_danh_muc: {},
            edit_danh_muc: {},
            is_create: 0,
            isSearching: false
        }
    },
    computed: {
        currentPage() {
            return this.danh_mucs.current_page;
        },
        totalPages() {
            return this.danh_mucs.last_page;
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
        this.loadDataDanhMuc(1);
        this.loadDataDanhMucAll();
    },
    methods: {
        convertToSlug(str) {
            str = str.toLowerCase();
            str = str
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
            str = str.replace(/[đĐ]/g, 'd');
            str = str.replace(/([^0-9a-z-\s])/g, '');
            str = str.replace(/(\s+)/g, '-');
            str = str.replace(/-+/g, '-');
            str = str.replace(/^-+|-+$/g, '');
            return str;
        },

        addSlug() {
            this.create_danh_muc.slug_danh_muc = this.convertToSlug(this.create_danh_muc.ten_danh_muc);
        },
        addSlugEdit() {
            this.edit_danh_muc.slug_danh_muc = this.convertToSlug(this.edit_danh_muc.ten_danh_muc);
        },

        loadDataDanhMuc(page) {
            baseRequest
                .get(`admin/danh-muc/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`)
                .then((res) => {
                    this.danh_mucs = res.data.danh_muc;
                })
        },

        loadDataDanhMucAll() {
            baseRequest
                .get(`admin/danh-muc/lay-du-lieu-all`)
                .then((res) => {
                    this.list_danh_muc = res.data.danh_muc;
                })
        },

        kiemTraSlug() {
            var payload = {
                'slug': this.create_danh_muc.slug_danh_muc
            }
            baseRequest
                .post('admin/danh-muc/kiem-tra-slug', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.is_create = 1;
                    } else {
                        this.is_create = 0;
                        toaster.error(res.data.message);
                    }
                });
        },

        searchDanhMuc(page = 1) {
            baseRequest
                .post(`admin/danh-muc/tim-danh-muc?page=${page}`, this.key_search)
                .then((res) => {
                    this.danh_mucs = res.data.danh_muc;
                    this.danh_mucs.current_page = page;
                    this.isSearching = true;
                });
        },
        handlePageChange(page) {
            if (this.isSearching) {
                this.searchDanhMuc(page);
            } else {
                this.loadDataDanhMuc(page);
            }
        },
        createDanhMuc() {
            console.log(this.create_danh_muc);
            baseRequest
                .post('admin/danh-muc/tao-danh-muc', this.create_danh_muc)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.create_danh_muc = {};
                        this.loadDataDanhMuc(this.danh_mucs.last_page);
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
        deleteDanhMuc() {
            baseRequest
                .delete('admin/danh-muc/xoa-danh-muc/' + this.delete_danh_muc.id)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.danh_mucs.current_page);
                    }
                    else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                })
        },
        updateDanhMuc() {
            baseRequest
                .put('admin/danh-muc/cap-nhat-danh-muc', this.edit_danh_muc)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.danh_mucs.current_page);
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
                .put('admin/danh-muc/doi-trang-thai', xyz)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.danh_mucs.current_page);
                    } else {
                        toaster.error(res.data.message);
                    }
                })

        }
    }
}
</script>
<style></style>