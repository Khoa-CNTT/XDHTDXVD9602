<template>
    <div class="row mb-3">
        <div class="col-12 text-end">
            <button class="btn btn-outline-primary px-5 radius-30" data-bs-toggle="modal" data-bs-target="#themMoiModal">
                <b>Thêm Mới</b>
            </button>
        </div>
    </div>
    <div class="modal fade" id="themMoiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Nguyên Liệu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tên Nguyên Liệu</label>
                                <input v-model="create_nguyen_lieu.ten_nguyen_lieu" v-on:keyup="addSlug()" v-on:change="kiemTraSlug()" type="text" class="form-control" placeholder="Nhập tên nguyên liệu">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Slug Nguyên Liệu</label>
                                <input v-model="create_nguyen_lieu.slug_nguyen_lieu" disabled v-on:change="kiemTraSlug()" type="text" class="form-control" placeholder="Nhập slug nguyên liệu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label mt-3">Giá</label>
                                <input v-model="create_nguyen_lieu.gia" type="number" class="form-control" placeholder="0">
                            </div>
                            <div class="col-6">
                                <label class="form-label mt-3">Số Lượng</label>
                                <input v-model="create_nguyen_lieu.so_luong" type="number" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label mt-3">Đơn Vị Tính</label>
                                <input v-model="create_nguyen_lieu.dvt" type="text" class="form-control" placeholder="Đơn vị tính">
                            </div>
                            <div class="col-6">
                                <label class="form-label mt-3">Tình Trạng</label>
                                <select v-model="create_nguyen_lieu.tinh_trang" class="form-control">
                                    <option value="1">Hoạt Động</option>
                                    <option value="0">Tạm Dừng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button @:click="createNguyenLieu()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Thêm Mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-header">
                <h5>Danh Sách Nguyên Liệu</h5>
            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="100%">
                                    <div class="input-group mb-3">
                                        <input v-on:keyup.enter="searchNguyenLieu()" v-model="key_search.abc" type="text" class="form-control" placeholder="Nhập thông tin cần tìm">
                                        <button class="btn btn-primary" v-on:click="searchNguyenLieu()">
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
                                    Tên Nguyên Liệu
                                </th>
                                <th class="text-center align-middle text-nowrap">
                                    Slug Nguyên Liệu
                                </th>
                                <th class="text-center align-middle text-nowrap">
                                    Giá
                                </th>
                                <th class="text-center align-middle text-nowrap">
                                    Số Lượng
                                </th>
                                <th class="text-center align-middle text-nowrap">
                                    Đơn Vị Tính
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
                            <tr v-for="(v, k) in nguyen_lieus.data" :key="k">
                                <th class="text-center align-middle text-nowrap">
                                    {{  v.id }}
                                </th>
                                <td class="align-middle text-nowrap">
                                    {{ v.ten_nguyen_lieu }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{ v.slug_nguyen_lieu }}
                                </td>
                                <td class="text-end align-middle text-nowrap">
                                    {{ v.gia }} đ
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.so_luong }}
                                </td>

                                <td class="text-center align-middle text-nowrap">
                                    {{ v.dvt }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1" class="btn btn-success" style="width: 100px;">Hiển
                                        Thị</button>
                                    <button @:click="doiTrangThai(v)" v-else class="btn btn-warning" style="width: 100px;">Tạm Dừng</button>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button  v-on:click="Object.assign(edit_nguyen_lieu, v)" class="btn btn-info" style="width: 100px; margin-right: 4px;" data-bs-toggle="modal"
                                        data-bs-target="#capNhatModal">Cập
                                        Nhật</button>
                                    <button class="btn btn-danger" style="width: 100px;" data-bs-toggle="modal"
                                        data-bs-target="#xoaModal" v-on:click="Object.assign(delete_nguyen_lieu,v)">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Nguyên Liệu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tên Nguyên Liệu</label>
                                            <input v-model="edit_nguyen_lieu.ten_nguyen_lieu" v-on:keyup="addSlugUpdate()" v-on:change="kiemTraSlugUpdate()" type="text" class="form-control" placeholder="Nhập tên nguyên liệu">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Slug Nguyên Liệu</label>
                                            <input v-model="edit_nguyen_lieu.slug_nguyen_lieu" type="text" disabled class="form-control" placeholder="Nhập slug nguyên liệu">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label mt-3">Giá</label>
                                            <input v-model="edit_nguyen_lieu.gia" type="number" class="form-control" placeholder="0">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mt-3">Số Lượng</label>
                                            <input v-model="edit_nguyen_lieu.so_luong" type="number" class="form-control" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label mt-3">Đơn Vị Tính</label>
                                            <input v-model="edit_nguyen_lieu.dvt" type="text" class="form-control" placeholder="Đơn vị tính">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mt-3">Tình Trạng</label>
                                            <select v-model="edit_nguyen_lieu.tinh_trang" class="form-control">
                                                <option value="1">Hoạt Động</option>
                                                <option value="0">Tạm Dừng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button v-on:click="updateNguyenLieu()" type="button" data-bs-dismiss="modal" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Nguyên Liệu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 text-dark">Cảnh báo</h6>
                                            <div class="text-dark">
                                                <p>Bạn có muốn xóa sản phẩm <b> {{ delete_nguyen_lieu.ten_nguyen_lieu }}</b> này không?</p>
                                                <p>
                                                    <b>Lưu ý:</b> Điều này không thể hoàn tác!
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="deleteNguyenLieu()">Xóa</button>
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
</template>
<script>
import axios from 'axios';
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            nguyen_lieus: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            key_search          : {},
            create_nguyen_lieu  : {},
            delete_nguyen_lieu  : {},
            edit_nguyen_lieu    : {},
            is_create           : 0,
            is_update           : 0,
            isSearching: false
        }
    },
    computed: {
        currentPage() {
            return this.nguyen_lieus.current_page;
        },
        totalPages() {
            return this.nguyen_lieus.last_page;
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
        this.loadDataNguyenLieu(1);
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
            this.create_nguyen_lieu.slug_nguyen_lieu = this.convertToSlug(this.create_nguyen_lieu.ten_nguyen_lieu);
        },

        addSlugUpdate() {
            this.edit_nguyen_lieu.slug_nguyen_lieu = this.convertToSlug(this.edit_nguyen_lieu.ten_nguyen_lieu);
        },

        kiemTraSlug() {
            var payload = {
                'slug' : this.create_nguyen_lieu.slug_nguyen_lieu
            }
            baseRequest
                .post('admin/nguyen-lieu/kiem-tra-slug', payload)
                .then((res) => {
                    if(res.data.status) {
                        toaster.success(res.data.message);
                        this.is_create = 1;
                    } else {
                        toaster.error(res.data.message);
                        this.is_create = 0;
                    }
                });
        }, 

        kiemTraSlugUpdate() {
            var payload = {
                'slug' : this.edit_nguyen_lieu.slug_nguyen_lieu,
                'id'   : this.edit_nguyen_lieu.id
            }
            baseRequest
                .post('admin/nguyen-lieu/kiem-tra-slug-update', payload)
                .then((res) => {
                    if(res.data.status) {
                        toaster.success(res.data.message);
                        this.is_update = 1;
                    } else {
                        this.is_update = 0;
                        toaster.error(res.data.message);
                    }
                });
        }, 

        loadDataNguyenLieu(page) {
            baseRequest
                .get(`admin/nguyen-lieu/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`)
                .then((res) => {
                    this.nguyen_lieus = res.data.nguyen_lieu;
                });
        },

        searchNguyenLieu(page = 1){
            baseRequest
                .post(`admin/nguyen-lieu/tim-nguyen-lieu?page=${page}`, this.key_search)
                .then((res) =>  {
                    this.nguyen_lieus = res.data.nguyen_lieu;
                    this.nguyen_lieus.current_page = page;
                    this.isSearching = true;
                });
        },

        handlePageChange(page) {
            if (this.isSearching) {
                this.searchNguyenLieu(page);
            } else {
                this.loadDataNguyenLieu(page);
            }
        },

        createNguyenLieu() {
            baseRequest
                .post('admin/nguyen-lieu/tao-nguyen-lieu', this.create_nguyen_lieu)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.create_nguyen_lieu = {};
                        this.loadDataNguyenLieu(this.nguyen_lieus.last_page);
                    }
                })
                .catch((errors) => {
                    this.create_nguyen_lieu = {};
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        deleteNguyenLieu() {
           
            baseRequest
                .delete('admin/nguyen-lieu/xoa-nguyen-lieu/' + this.delete_nguyen_lieu.id)
                .then((res) =>  {
                    if(res.data.status == true) {
                         toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.nguyen_lieus.current_page);
                    }
                    else{
                         toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
                
        },
        updateNguyenLieu() {
            baseRequest
                .put('admin/nguyen-lieu/cap-nhat-nguyen-lieu/', this.edit_nguyen_lieu)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.nguyen_lieus.current_page);
                    } else {
                        alert(res.data.message);
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
                .put('admin/nguyen-lieu/doi-trang-thai', xyz)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.handlePageChange(this.nguyen_lieus.current_page);
                    } else {
                        toaster.error(res.data.message);
                    }
                });
        }
    }
}
</script>
<style></style>