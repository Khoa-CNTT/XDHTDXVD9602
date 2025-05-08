<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">Thêm Mới Bài Viết</div>
                <div class="card-body">
                    <label class="mb-1 mt-1">Tiêu Đề</label>
                    <input v-model="create_bai_viet.tieu_de" class="form-control" type="text" />
                    <label class="mb-1 mt-1">Hình Ảnh</label>
                    <input type="file" v-on:change="handleFile($event, true)" class="form-control mb-3" placeholder="" />
                    <div v-if="banner">
                        <img :src="banner" class="img-fluid" alt="Chưa có hình ảnh" />
                    </div>
                    <label class="mb-1 mt-1">Nội Dung</label>
                    <textarea v-model="create_bai_viet.noi_dung" class="form-control" cols="30" rows="10"></textarea>
                    <label class="mb-1 mt-1">Tình Trạng</label>
                    <select v-model="create_bai_viet.tinh_trang" class="form-select">
                        <option value="1">Hoạt Động</option>
                        <option value="0">Tạm Dừng</option>
                    </select>
                </div>
                <div @:click="createBaiViet()" class="card-footer text-end">
                    <button class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">Danh Sách Bài Viết</div>
                <div class="card-body" style="max-height: 500px; overflow-y: auto">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="100%">
                                        <div class="input-group mb-3">
                                            <input v-on:keyup.enter="searchBaiViet()" v-model="key_search.abc" type="text" class="form-control" placeholder="Nhập thông tin cần tìm" />
                                            <button class="btn btn-primary" v-on:click="searchBaiViet()">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="text-nowrap">
                                    <th class="align-middle text-center">#</th>
                                    <th class="align-middle text-center">Tiêu Đề</th>
                                    <th class="align-middle text-center">Hình Ảnh</th>
                                    <th class="align-middle text-center">Nội Dung</th>
                                    <th class="align-middle text-center">Nhân Viên</th>
                                    <th class="align-middle text-center">Tình Trạng</th>
                                    <th class="align-middle text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(v, k) in bai_viets.data" :key="k">
                                    <th class="align-middle text-center">{{ v.id }}</th>
                                    <td class="align-middle text-wrap">{{ v.tieu_de }}</td>
                                    <td class="align-middle">
                                        <img v-bind:src="v.hinh_anh" class="img-fluid" alt="" />
                                    </td>
                                    <td class="align-middle text-center">
                                        <i @:click="nd = v.noi_dung" data-bs-toggle="modal" data-bs-target="#noiDungModal" class="fa-solid fa-file-lines fa-xl text-warning"></i>
                                    </td>
                                    <td class="align-middle">{{ v.ho_va_ten }}</td>
                                    <td class="align-middle text-center text-nowrap">
                                        <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1" class="btn btn-success">Hoạt động</button>
                                        <button @:click="doiTrangThai(v)" v-else class="btn btn-warning">Tạm Dừng</button>
                                    </td>
                                    <td class="align-middle text-center text-nowrap">
                                        <button v-on:click="Object.assign(edit_bai_viet, v)" style="margin-right: 4px" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#capNhatModal">
                                            Cập Nhật
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#xoaModal" v-on:click="Object.assign(delete_bai_viet, v)">Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Bài Viết</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="mb-1 mt-1">Tên Chức Vụ</label>
                                    <input v-model="edit_bai_viet.tieu_de" class="form-control" type="text" />
                                    <label class="mb-1 mt-1">Hình Ảnh</label>
                                    <input type="file" v-on:change="handleFile($event, false)" class="form-control mb-3" placeholder="" />
                                    <div v-if="edit_bai_viet.hinh_anh && !banner">
                                        <img :src="edit_bai_viet.hinh_anh" class="img-fluid" alt="Chưa có hình ảnh" />
                                    </div>
                                    <div v-if="banner">
                                        <img :src="banner" class="img-fluid" alt="Chưa có hình ảnh" />
                                    </div>
                                    <label class="mb-1 mt-1">Nội Dung</label>
                                    <textarea v-model="edit_bai_viet.noi_dung" class="form-control" cols="30" rows="10"></textarea>
                                    <label class="mb-1 mt-1">Tình Trạng</label>
                                    <select v-model="edit_bai_viet.tinh_trang" class="form-select">
                                        <option value="1">Hoạt Động</option>
                                        <option value="0">Tạm Tắt</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button v-on:click="updateBaiViet()" type="button" data-bs-dismiss="modal" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Bài Viết</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-dark"><i class="bx bx-info-circle"></i></div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-dark">Cảnh báo</h6>
                                                <div class="text-dark">
                                                    <p>
                                                        Bạn có muốn xóa danh mục <b>{{ delete_bai_viet.tieu_de }}</b> này không?
                                                    </p>
                                                    <p><b>Lưu ý:</b> Điều này không thể hoàn tác!</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button type="button" class="btn btn-danger" v-on:click="deleteBaiViet()" data-bs-dismiss="modal">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="noiDungModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nội Dung Bài Viết</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ nd }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end text-nowrap">
                    <button @click="handlePageChange(currentPage - 1)" :disabled="currentPage <= 1" class="btn btn-secondary btn-sm me-2">Previous</button>
                    <button class="btn btn-secondary btn-sm me-2" v-for="page in pageNumbers" :key="page" @click="page !== '...' && handlePageChange(page)" :class="{ active: page === currentPage }">
                        {{ page }}
                    </button>
                    <button @click="handlePageChange(currentPage + 1)" :disabled="currentPage >= totalPages" class="btn btn-secondary btn-sm me-2">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import baseRequest from "../../core/baseRequest";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            banner: "",
            nd: "",
            bai_viets: {
                data: [],
                current_page: 1,
                last_page: 1,
            },
            pageSize: 5,
            key_search: {},
            create_bai_viet: {},
            delete_bai_viet: {},
            edit_bai_viet: {},
            isSearching: false,
        };
    },
    computed: {
        currentPage() {
            return this.bai_viets.current_page;
        },
        totalPages() {
            return this.bai_viets.last_page;
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
                        pages.push("...");
                        pages.push(this.totalPages);
                    }
                } else if (this.currentPage >= this.totalPages - 2) {
                    // Người dùng đang ở ba trang cuối
                    pages.push(1);
                    if (this.totalPages > 4) {
                        pages.push("...");
                    }
                    let minPage = Math.max(this.totalPages - 3, 1); // Đảm bảo không nhỏ hơn trang đầu tiên
                    for (let i = minPage; i <= this.totalPages; i++) {
                        pages.push(i);
                    }
                } else {
                    // Người dùng đang ở các trang giữa
                    pages.push(1);
                    pages.push("...");
                    for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
                        pages.push(i);
                    }
                    pages.push("...");
                    pages.push(this.totalPages);
                }
            }
            return pages;
        },
    },
    mounted() {
        this.loadDataBaiViet(1);
    },
    methods: {
        handleFile(e, isCreate) {
            let files = e.target.files || e.dataTransfer.files;
            this.file = files;
            if (!files.length) return;
            this.createImage(files[0], isCreate);
        },

        createImage(file, isCreate) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.banner = e.target.result;
                if (isCreate == true) {
                    vm.create_bai_viet.hinh_anh = file;
                } else {
                    vm.edit_bai_viet.hinh_anh = file;
                }
            };
            reader.readAsDataURL(file);
        },

        loadDataBaiViet(page) {
            baseRequest.get(`admin/bai-viet/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`).then((res) => {
                this.bai_viets = res.data.bai_viet;
            });
        },

        searchBaiViet(page = 1) {
            baseRequest.post(`admin/bai-viet/tim-bai-viet?page=${page}`, this.key_search).then((res) => {
                this.bai_viets = res.data.bai_viet;
                this.bai_viets.current_page = page;
                this.isSearching = true;
            });
        },
        handlePageChange(page) {
            if (this.isSearching) {
                this.searchBaiViet(page);
            } else {
                this.loadDataBaiViet(page);
            }
        },

        createBaiViet() {
            const formData = new FormData();
            for (let key in this.create_bai_viet) {
                formData.append(key, this.create_bai_viet[key]);
            }
            baseRequest
                .post("admin/bai-viet/tao-bai-viet", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.create_bai_viet = {};
                        this.banner = "";
                        this.loadDataBaiViet(this.bai_viets.last_page);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error("Thông báo<br>" + value);
                    });
                });
        },
        deleteBaiViet() {
            baseRequest.delete("admin/bai-viet/xoa-bai-viet/" + this.delete_bai_viet.id).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.bai_viets.current_page);
                } else {
                    toaster.error("Thông báo<br>" + res.data.message);
                }
            });
        },
        updateBaiViet() {
            const formData = new FormData();
            for (let key in this.edit_bai_viet) {
                formData.append(key, this.edit_bai_viet[key]);
            }
            baseRequest
                .post("admin/bai-viet/cap-nhat-bai-viet", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.handlePageChange(this.bai_viets.current_page);
                    } else {
                        toaster.error("Thông báo<br>" + res.data.message);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error("Thông báo<br>" + value);
                    });
                });
        },
        doiTrangThai(xyz) {
            baseRequest.put("admin/bai-viet/doi-trang-thai", xyz).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.bai_viets.current_page);
                } else {
                    toaster.error(res.data.message);
                }
            });
        },
    },
};
</script>
<style></style>
