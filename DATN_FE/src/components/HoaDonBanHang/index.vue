<template>
    <div class="card">
        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
            <h3>Hóa Đơn Bán Hàng</h3>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td class="align-middle">Từ Ngày</td>
                        <td class="align-middle">
                            <input v-on:change="loadData()" type="date" class="form-control" v-model="tk.begin">
                        </td>
                        <td class="align-middle">Đến Ngày</td>
                        <td class="align-middle">
                            <input v-on:change="loadData()" type="date" class="form-control" v-model="tk.end">
                        </td>
                        <td class="align-middle text-center">
                            <button class="btn btn-primary" v-on:click="loadData()">Thống Kê</button>
                        </td>
                        <td class="align-middle" colspan="3">
                            Tổng Tiền: {{ formatToVND(tong_tien) }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">
                            Tên Bàn
                        </th>
                        <th class="align-middle text-center">
                            Mã Hóa Đơn
                        </th>
                        <th class="align-middle text-center">
                            Nhân Viên Thanh Toán
                        </th>
                        <th class="align-middle text-center">
                            Tiền Trước Giảm
                        </th>
                        <th class="align-middle text-center">
                            Phần Trăm Giảm
                        </th>
                        <th class="align-middle text-center">
                            Tổng Tiền Đã Giảm
                        </th>
                        <th class="align-middle text-center">
                            Ghi Chú
                        </th>
                        <th class="align-middle text-center">
                            Chi Tiết Hóa Đơn
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v, k) in hoa_don_ban_hangs.data" :key="k">
                        <td class="align-middle text-center">{{ v.ten_ban }}</td>
                        <td class="align-middle text-center">{{ v.ma_hoa_don }}</td>
                        <td class="align-middle text-start">{{ v.ten_nhan_vien }}</td>
                        <td class="align-middle text-end">{{ formatToVND(v.tong_tien_truoc_giam) }}</td>
                        <td class="align-middle text-center">{{ v.phan_tram_giam }}</td>
                        <td class="align-middle text-end">{{ formatToVND(v.tien_thuc_nhan) }}</td>
                        <td class="align-middle text-center">
                            <button v-on:click="ghi_chu = v.ghi_chu" type="button" class="btn btn-light"
                                data-bs-toggle="modal" data-bs-target="#ghiChuModal">
                                <i class="fa-solid fa-comment"></i>
                            </button>
                        </td>
                        <td class="align-middle text-center">
                            <button v-on:click="chiTietHoaDon(v)" type="button" class="btn btn-primary me-1"
                                data-bs-toggle="modal" data-bs-target="#chiTietModal">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chi Tiết Hóa Đơn</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">
                                            #
                                        </th>
                                        <th class="text-center align-middle">
                                            Tên Món
                                        </th>
                                        <th class="text-center align-middle">
                                            Số Lượng
                                        </th>
                                        <th class="text-center align-middle">
                                            Đơn Giá
                                        </th>
                                        <th class="text-center align-middle">
                                            Thành Tiền
                                        </th>
                                        <th class="text-center align-middle">
                                            Phần Trăm Giảm
                                        </th>
                                        <th class="text-center align-middle">
                                            Ghi Chú
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(v, k) in chi_tiet" :key="k">
                                        <th class="text-center align-middle">{{ k + 1 }}</th>
                                        <td class="align-middle">{{ v.ten_mon }}</td>
                                        <td class="text-center align-middle">{{ v.so_luong }}</td>
                                        <td class="text-center align-middle">{{ formatToVND(v.don_gia) }}</td>
                                        <td class="text-center align-middle">{{ formatToVND(v.thanh_tien) }}</td>
                                        <td class="text-center align-middle">{{ v.phan_tram_giam }}</td>
                                        <td class="align-middle">{{ v.ghi_chu }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="ghiChuModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ghi Chú</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ ghi_chu }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end text-nowrap">
            <button @click="loadData(currentPage - 1)" :disabled="currentPage <= 1"
                class="btn btn-secondary btn-sm me-2">Previous</button>
            <button class="btn btn-secondary btn-sm me-2" v-for="page in pageNumbers" :key="page"
                @click="page !== '...' && loadData(page)" :class="{ active: page === currentPage }">
                {{ page }}
            </button>
            <button @click="loadData(currentPage + 1)" :disabled="currentPage >= totalPages"
                class="btn btn-secondary btn-sm me-2">Next</button>
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
            hoa_don_ban_hangs: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            ghi_chu: 'Thầy Long quá đẹp trai',
            chi_tiet: [],
            tk: { begin: '', end: '' },
            tong_tien: 0,
            isSearching: false
        }
    },
    computed: {
        currentPage() {
            return this.hoa_don_ban_hangs.current_page;
        },
        totalPages() {
            return this.hoa_don_ban_hangs.last_page;
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
        var date = new Date();
        var subday = new Date(date.setDate(date.getDate() - 0));
        this.tk.begin = subday.toISOString().slice(0, 10);
        this.tk.end = new Date().toISOString().slice(0, 10);
        this.loadData(1);
    },
    methods: {
        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },
        loadData(page) {
            baseRequest
                .post(`admin/hoa-don/lay-du-lieu?page=${page}&pageSize=${this.pageSize}`, this.tk)
                .then((res) => {
                    this.hoa_don_ban_hangs = res.data.data;
                    this.tong_tien = res.data.tong_tien;
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        chiTietHoaDon(payload) {
            baseRequest
                .post('admin/hoa-don/chi-tiet-hoa-don', payload)
                .then((res) => {
                    this.chi_tiet = res.data.data;
                });
        },
    },
}
</script>
<style></style>