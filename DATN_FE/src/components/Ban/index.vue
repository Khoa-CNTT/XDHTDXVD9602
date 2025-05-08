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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Bàn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tên Bàn</label>
                                <input v-model="create_ban.ten_ban" v-on:keyup="addSlug()" type="text" class="form-control" placeholder="Nhập tên bàn" />
                            </div>
                            <div class="col-6">
                                <label class="form-label">Slug Bàn</label>
                                <input v-model="create_ban.slug_ban" disabled type="text" class="form-control" placeholder="Nhập slug bàn" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label mt-3">Khu Vực</label>
                                <select v-model="create_ban.id_khu_vuc" class="form-select">
                                    <template v-for="(v, k) in list_khu_vuc" :key="k">
                                        <option v-bind:value="v.id">{{ v.ten_khu }}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label mt-3">Tình Trạng</label>
                                <select v-model="create_ban.tinh_trang" class="form-select">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                    <button @:click="createBan()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Thêm Mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-header">
                <h5>Danh Sách Bàn</h5>
            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="100%">
                                    <div class="input-group mb-3">
                                        <input v-on:keyup.enter="searchBan()" v-model="key_search.abc" type="text" class="form-control" placeholder="Nhập thông tin cần tìm" />
                                        <button class="btn btn-primary" v-on:click="searchBan()">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle text-nowrap">#</th>
                                <th class="text-center align-middle text-nowrap">Tên Bàn</th>
                                <th class="text-center align-middle text-nowrap">Slug Bàn</th>
                                <th class="text-center align-middle text-nowrap">Khu Vực</th>
                                <th class="text-center align-middle text-nowrap">Mã QR</th>
                                <th class="text-center align-middle text-nowrap">Tình Trạng</th>
                                <th class="text-center align-middle text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v, k) in bans.data" :key="k">
                                <th class="text-center align-middle text-nowrap">
                                    {{ v.id }}
                                </th>
                                <td class="align-middle text-nowrap">
                                    {{ v.ten_ban }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{ v.slug_ban }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    {{ v.ten_khu }}
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <div @click="handleQRScan(v.slug_ban, v.hash_ban)" v-html="renderQRCode(v.qr_ban)"></div>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button @:click="doiTrangThai(v)" v-if="v.tinh_trang == 1" class="btn btn-success" style="width: 100px">Mở</button>
                                    <button @:click="doiTrangThai(v)" v-else class="btn btn-warning" style="width: 100px">Đóng</button>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <button v-on:click="Object.assign(edit_ban, v)" class="btn btn-info" style="width: 100px; margin-right: 4px" data-bs-toggle="modal" data-bs-target="#capNhatModal">
                                        Cập Nhật
                                    </button>
                                    <button class="btn btn-danger" style="width: 100px" data-bs-toggle="modal" data-bs-target="#xoaModal" v-on:click="Object.assign(delete_ban, v)">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhật Bàn</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tên Bàn</label>
                                            <input v-model="edit_ban.ten_ban" v-on:keyup="addSlugUpdate()" type="text" class="form-control" placeholder="Nhập tên bàn" />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Slug Bàn</label>
                                            <input v-model="edit_ban.slug_ban" disabled type="text" class="form-control" placeholder="Nhập slug bàn" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label mt-3">Khu Vực</label>
                                            <select v-model="edit_ban.id_khu_vuc" class="form-select">
                                                <template v-for="(v, k) in list_khu_vuc" :key="k">
                                                    <option v-bind:value="v.id">{{ v.ten_khu }}</option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mt-3">Tình Trạng</label>
                                            <select v-model="edit_ban.tinh_trang" class="form-select">
                                                <option value="1">Mở</option>
                                                <option value="0">Đóng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button v-on:click="updateBan()" type="button" data-bs-dismiss="modal" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Bàn</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning border-0 bg-warning">
                                    <div class="d-flex align-items-center">
                                        <div class="font-35 text-dark"><i class="bx bx-info-circle"></i></div>
                                        <div class="ms-3">
                                            <h6><b class="text-danger">Cảnh báo</b></h6>
                                            <div class="text-dark">
                                                <p>
                                                    Bạn có muốn xóa bàn <b>{{ delete_ban.ten_ban }}</b> này không?
                                                </p>
                                                <p><b>Lưu ý:</b> Điều này không thể hoàn tác!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="deleteBan()">Xóa</button>
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
            bans: {
                data: [],
                current_page: 1,
                last_page: 1,
            },
            pageSize: 5,
            list_khu_vuc: [],
            key_search: {},
            create_ban: {},
            delete_ban: {},
            edit_ban: {},
            isSearching: false,
        };
    },
    computed: {
        currentPage() {
            return this.bans.current_page;
        },
        totalPages() {
            return this.bans.last_page;
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
        this.loadDataBan();
        this.loadDataKhuVuc();
    },
    methods: {
        handleQRScan(content, hash) {
            // Chuyển trang đến URL mong muốn với nội dung của mã QR
            // window.location.href = `http://localhost:5173/ban/${content}/${hash}`;
            window.open(`http://localhost:5173/ban/${content}/${hash}`, "_blank");
        },
        renderQRCode(qrCode) {
            // Chuyển đổi mã QR từ XML sang hình ảnh
            const svgData = qrCode.replace('<?xml version="1.0" encoding="UTF-8"?>', ""); // Loại bỏ khai báo XML
            return svgData;
        },
        convertToSlug(str) {
            str = str.toLowerCase();
            str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            str = str.replace(/[đĐ]/g, "d");
            str = str.replace(/([^0-9a-z-\s])/g, "");
            str = str.replace(/(\s+)/g, "-");
            str = str.replace(/-+/g, "-");
            str = str.replace(/^-+|-+$/g, "");
            return str;
        },

        addSlug() {
            this.create_ban.slug_ban = this.convertToSlug(this.create_ban.ten_ban);
        },

        addSlugUpdate() {
            this.edit_ban.slug_ban = this.convertToSlug(this.edit_ban.ten_ban);
        },

        loadDataBan(page) {
            baseRequest.get(`admin/ban/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`).then((res) => {
                this.bans = res.data.ban;
            });
        },

        loadDataKhuVuc() {
            baseRequest.get("admin/khu-vuc/lay-du-lieu-all").then((res) => {
                this.list_khu_vuc = res.data.khu_vuc;
            });
        },

        searchBan(page = 1) {
            baseRequest.post(`admin/ban/tim-ban?page=${page}`, this.key_search).then((res) => {
                this.bans = res.data.ban;
                this.bans.current_page = page;
                this.isSearching = true;
            });
        },
        handlePageChange(page) {
            if (this.isSearching) {
                this.searchBan(page);
            } else {
                this.loadDataBan(page);
            }
        },

        createBan() {
            console.log(this.create_ban);
            baseRequest
                .post("admin/ban/tao-ban", this.create_ban)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.create_ban = {};
                        this.loadDataBan(this.bans.last_page);
                        this.loadDataKhuVuc();
                    } else {
                        toaster.error(res.data.message);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error("Thông báo<br>" + value);
                    });
                });
        },
        deleteBan() {
            baseRequest.delete("admin/ban/xoa-ban/" + this.delete_ban.id).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.bans.current_page);
                } else {
                    toaster.error("Thông báo<br>" + res.data.message);
                }
            });
        },
        updateBan() {
            baseRequest
                .put("admin/ban/cap-nhat-ban", this.edit_ban)
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success("Thông báo<br>" + res.data.message);
                        this.handlePageChange(this.bans.current_page);
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
            baseRequest.put("admin/ban/doi-trang-thai", xyz).then((res) => {
                if (res.data.status == true) {
                    toaster.success("Thông báo<br>" + res.data.message);
                    this.handlePageChange(this.bans.current_page);
                } else {
                    toaster.error(res.data.message);
                }
            });
        },
    },
};
</script>
<style></style>
