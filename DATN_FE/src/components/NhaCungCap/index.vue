<template>
    <div class="row mb-3">
        <div class="col-12 text-end">
            <button class="btn btn-outline-primary px-5 radius-30" data-bs-toggle="modal" data-bs-target="#themMoiModal">
                <b>Thêm Mới</b>
            </button>
        </div>
    </div>
    <div class="modal fade" id="themMoiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Nhà Cung Cấp</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Mã Số Thuế</label>
                                <input type="text" v-model="create_nha_cung_cap.ma_so_thue" class="form-control" placeholder="Nhập Mã Số Thuế" />
                            </div>
                            <div class="col-4">
                                <label class="form-label">Tên Công Ty</label>
                                <input type="text" v-model="create_nha_cung_cap.ten_cong_ty" class="form-control" placeholder="Nhập Tên Công Ty" />
                            </div>
                            <div class="col-4">
                                <label class="form-label">Tên Người Đại Diện</label>
                                <input type="text" v-model="create_nha_cung_cap.ten_nguoi_dai_dien" class="form-control" placeholder="Nhập Tên Người Đại Diện" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label mt-3">Số Điện Thoại</label>
                                <input type="text" v-model="create_nha_cung_cap.so_dien_thoai" class="form-control" placeholder="Nhập Số Điện Thoại" />
                            </div>
                            <div class="col-4">
                                <label class="form-label mt-3">Email</label>
                                <input type="email" v-model="create_nha_cung_cap.email" class="form-control" placeholder="Nhập Email" />
                            </div>
                            <div class="col-4">
                                <label class="form-label mt-3">Địa Chỉ</label>
                                <input type="text" v-model="create_nha_cung_cap.dia_chi" class="form-control" placeholder="Nhập Địa Chỉ" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label mt-3">Tên Gợi Nhớ</label>
                                <input type="text" v-model="create_nha_cung_cap.ten_goi_nho" class="form-control" placeholder="Nhập Tên Gợi Nhớ" />
                            </div>
                            <div class="col-6">
                                <label class="form-label mt-3">Tình Trạng</label>
                                <select class="form-select" v-model="create_nha_cung_cap.tinh_trang">
                                    <option value="0">Tạm Dừng</option>
                                    <option value="1">Hoạt Động</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-primary" v-on:click="createNhaCungCap()" data-bs-dismiss="modal">Thêm Mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-header">
                <h5>Danh Sách Nhà Cung Cấp</h5>
                <div class="input-group mb-3">
                    <input v-on:keyup.enter="searchNhaCungCap()" v-model="key_search.abc" type="text" class="form-control" placeholder="Nhập thông tin cần tìm" />
                    <button class="btn btn-primary" v-on:click="searchNhaCungCap()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle text-nowrap">#</th>
                                <th class="text-center align-middle text-nowrap">Mã Số Thuế</th>
                                <th class="text-center align-middle text-nowrap">Tên Công Ty</th>
                                <th class="text-center align-middle text-nowrap">Người Đại Diện</th>
                                <th class="text-center align-middle text-nowrap">Số Điện Thoại</th>
                                <th class="text-center align-middle text-nowrap">Email</th>
                                <th class="text-center align-middle text-nowrap">Địa Chỉ</th>
                                <th class="text-center align-middle text-nowrap">Tên Giợi Nhớ</th>
                                <th class="text-center align-middle text-nowrap">Tình Trạng</th>
                                <th class="text-center align-middle text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v, k) in nha_cung_caps.data" :key="k">
                                <th class="text-center align-middle text-nowrap">
                                    {{ v.id }}
                                </th>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.ma_so_thue }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.ten_cong_ty }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.ten_nguoi_dai_dien }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.so_dien_thoai }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.email }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#diaChiModal" v-on:click="dia_chi = v">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.ten_goi_nho }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1" class="btn btn-success">Hoạt Động</button>
                                    <button @:click="doiTrangThai(v)" v-else class="btn btn-warning">Tạm Dừng</button>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button
                                        v-on:click="Object.assign(edit_nha_cung_cap, v)"
                                        class="btn btn-info"
                                        style="width: 100px; margin-right: 4px"
                                        data-bs-toggle="modal"
                                        data-bs-target="#capNhatModal"
                                    >
                                        Cập Nhật
                                    </button>
                                    <button class="btn btn-danger" style="width: 100px" data-bs-toggle="modal" data-bs-target="#xoaModal" v-on:click="Object.assign(delete_nha_cung_cap, v)">
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Nhà Cung Cấp</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Mã Số Thuế</label>
                                            <input v-model="edit_nha_cung_cap.ma_so_thue" type="text" class="form-control" placeholder="Nhập Mã Số Thuế" />
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Tên Công Ty</label>
                                            <input v-model="edit_nha_cung_cap.ten_cong_ty" type="text" class="form-control" placeholder="Nhập Tên Công Ty" />
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Tên Người Đại Diện</label>
                                            <input v-model="edit_nha_cung_cap.ten_nguoi_dai_dien" type="text" class="form-control" placeholder="Nhập Tên Người Đại Diện" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label mt-3">Số Điện Thoại</label>
                                            <input v-model="edit_nha_cung_cap.so_dien_thoai" type="number" class="form-control" placeholder="Nhập Số Điện Thoại" />
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label mt-3">Email</label>
                                            <input v-model="edit_nha_cung_cap.email" type="email" class="form-control" placeholder="Nhập Email" />
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label mt-3">Địa Chỉ</label>
                                            <input v-model="edit_nha_cung_cap.dia_chi" type="email" class="form-control" placeholder="Nhập Địa Chỉ" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label mt-3">Tên Gợi Nhớ</label>
                                            <input v-model="edit_nha_cung_cap.ten_goi_nho" type="text" class="form-control" placeholder="Nhập Tên Gợi Nhớ" />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mt-3">Tình Trạng</label>
                                            <select v-model="edit_nha_cung_cap.tinh_trang" class="form-select">
                                                <option value="0">Tạm Dừng</option>
                                                <option value="1">Hoạt Động</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button v-on:click="updateNhaCungCap()" type="button" data-bs-dismiss="modal" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Nhà Cung Cấp</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="font-35 text-dark"><i class="bx bx-info-circle"></i></div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 text-dark">Warning</h6>
                                            <div class="text-dark">
                                                <p>
                                                    Bạn có muốn xóa nhà cung cấp <b>{{ delete_nha_cung_cap.ten_cong_ty }}</b> này không?
                                                </p>
                                                <p><b>Lưu ý:</b> Điều này không thể hoàn tác!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="deleteNhaCungCap()">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="diaChiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Địa Chỉ Nhà Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ dia_chi.dia_chi }}
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
</template>
<script>
import axios from "axios";
import baseRequest from "../../core/baseRequest";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            nha_cung_caps: {
                data: [],
                current_page: 1,
                last_page: 1,
            },
            pageSize: 5,
            key_search: {},
            create_nha_cung_cap: {},
            delete_nha_cung_cap: {},
            dia_chi: {},
            edit_nha_cung_cap: {},
            isSearching: false,
        };
    },
    computed: {
        currentPage() {
            return this.nha_cung_caps.current_page;
        },
        totalPages() {
            return this.nha_cung_caps.last_page;
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
        this.loadDataNhaCungCap(1);
    },
    methods: {
        loadDataNhaCungCap(page) {
            baseRequest.get(`admin/nha-cung-cap/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`).then((res) => {
                this.nha_cung_caps = res.data.nha_cung_cap;
            });
        },

        searchNhaCungCap(page = 1) {
            baseRequest.post(`admin/nha-cung-cap/tim-nha-cung-cap?page=${page}`, this.key_search).then((res) => {
                this.nha_cung_caps = res.data.nha_cung_cap;
                this.nha_cung_caps.current_page = page;
                this.isSearching = true;
            });
        },
        handlePageChange(page) {
            if (this.isSearching) {
                this.searchNhaCungCap(page);
            } else {
                this.loadDataNhaCungCap(page);
            }
        },
        createNhaCungCap() {
            baseRequest
                .post("admin/nha-cung-cap/tao-nha-cung-cap", this.create_nha_cung_cap)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.create_nha_cung_cap = {};
                        this.loadDataNhaCungCap(this.nha_cung_caps.last_page);
                    }
                })
                .catch((errors) => {
                    this.create_nha_cung_cap = {};
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error("Thông báo<br>" + value);
                    });
                });
        },
        deleteNhaCungCap() {
            baseRequest.delete("admin/nha-cung-cap/xoa-nha-cung-cap/" + this.delete_nha_cung_cap.id).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.nha_cung_caps.current_page);
                } else {
                    toaster.error("Thông báo<br>" + res.data.message);
                }
            });
        },
        updateNhaCungCap() {
            baseRequest
                .put("admin/nha-cung-cap/cap-nhat-nha-cung-cap", this.edit_nha_cung_cap)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.handlePageChange(this.nha_cung_caps.current_page);
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
            baseRequest.put("admin/nha-cung-cap/doi-trang-thai", xyz).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.nha_cung_caps.current_page);
                } else {
                    toaster.error(res.data.message);
                }
            });
        },
    },
};
</script>
<style></style>
