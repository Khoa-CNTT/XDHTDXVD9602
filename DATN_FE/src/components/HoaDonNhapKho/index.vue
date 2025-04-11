<template>
    <div class="row">
        <div class="card">
            <div class="card-header">
                Danh Sách Hóa Đơn Nhập Kho
            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                <div class="table-responesive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="align-middle">Từ Ngày</td>
                                <td class="align-middle">
                                    <input v-on:change="getDataHoaDonNhapKho()" type="date" class="form-control" v-model="tk.begin">
                                </td>
                                <td class="align-middle">Đến Ngày</td>
                                <td class="align-middle">
                                    <input v-on:change="getDataHoaDonNhapKho()" type="date" class="form-control" v-model="tk.end">
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-primary" v-on:click="getDataHoaDonNhapKho()">Thống Kê</button>
                                </td>
                                <td class="align-middle" colspan="3">
                                    Tổng Tiền: {{ formatToVND(tong_tien) }}
                                </td>
                            </tr>
                            <tr class="text-center align-middle">
                                <th>Mã Hóa Đơn</th>
                                <th>Tổng Tiền</th>
                                <th>Nhà Cung Cấp</th>
                                <th>Ghi Chú</th>
                                <th>Chi Tiết Hóa Đơn</th>
                                <th>Nhân Viên</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in hoa_don_nhap_khos.data" :key="index">
                                <tr>
                                    <td class="text-center align-middle">{{ value.ma_hoa_don }}</td>
                                    <td class="text-end align-middle">{{ formatToVND(value.tong_tien) }}</td>
                                    <td class="align-middle">{{ value.ten_cong_ty}}</td>
                                    <td class="text-center align-middle">
                                        <i class="fa-solid fa-notes-medical fa-2x text-info" v-on:click="Object.assign(detail_hoa_don, value)" data-bs-toggle="modal"
                                        data-bs-target="#ghiChuModal"></i>
                                    </td>
                                    <td class="text-center align-middle">
                                        <i class="fa-solid fa-circle-info fa-2x text-success" v-on:click="getDataChiTietHoaDonNhapKho(value)" data-bs-toggle="modal"
                                        data-bs-target="#chiTietModal"></i>
                                    </td>
                                    <td class="align-middle">{{ value.ho_va_ten}}</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="ghiChuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ghi Chú</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea v-model="detail_hoa_don.ghi_chu" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ghi Chú</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responesive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th>#</th>
                                                <th>Tên Nguyên Liệu</th>
                                                <th>Số Lượng</th>
                                                <th>Đơn Giá</th>
                                                <th>Thành Tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(value, index) in list_chi_tiet_hoa_don" :key="index">
                                                <tr>
                                                    <th class="text-center align-middle">{{ index + 1 }}</th>
                                                    <td class="align-middle">{{ value.ten_nguyen_lieu }}</td>
                                                    <td class="text-center align-middle">{{ value.so_luong }}</td>
                                                    <td class="text-end align-middle">{{ formatToVND(value.don_gia) }}</td>
                                                    <td class="text-end align-middle">{{ formatToVND(value.thanh_tien) }}</td>
                                                </tr>
                                            </template>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end text-nowrap">
                <button @click="getDataHoaDonNhapKho(currentPage - 1)" :disabled="currentPage <= 1"
                    class="btn btn-secondary btn-sm me-2">Previous</button>
                <button class="btn btn-secondary btn-sm me-2" v-for="page in pageNumbers" :key="page"
                    @click="page !== '...' && getDataHoaDonNhapKho(page)" :class="{ active: page === currentPage }">
                    {{ page }}
                </button>
                <button @click="getDataHoaDonNhapKho(currentPage + 1)" :disabled="currentPage >= totalPages"
                    class="btn btn-secondary btn-sm me-2">Next</button>
            </div>
        </div>
    </div>
</template>
<script>
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
import baseRequest from '../../core/baseRequest';
export default {
    data() {
        return {
            hoa_don_nhap_khos: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            pageSize: 5,
            list_chi_tiet_hoa_don       : [],
            detail_hoa_don              : {},
            tk                          :   {begin: '', end : ''},
            tong_tien                   : 0,
            isSearching: false
        }
    },
    computed: {
        currentPage() {
            return this.hoa_don_nhap_khos.current_page;
        },
        totalPages() {
            return this.hoa_don_nhap_khos.last_page;
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
        var date        = new Date();
        var subday      = new Date(date.setDate(date.getDate() - 0));
        this.tk.begin   = subday.toISOString().slice(0, 10);
        this.tk.end     = new Date().toISOString().slice(0, 10);
        this.getDataHoaDonNhapKho(1);
    },
    methods: {
        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },
        
        getDataHoaDonNhapKho(page) {
            baseRequest
                .post(`admin/nhap-kho/data-hoa-don-nhap-kho?page=${page}&pageSize=${this.pageSize}`, this.tk)
                .then((res) => {
                    this.hoa_don_nhap_khos  = res.data.data;
                    this.tong_tien          = res.data.tong_tien;
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value, index) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },

        getDataChiTietHoaDonNhapKho(v) {
            baseRequest
                .post('admin/nhap-kho/data-chi-tiet-hoa-don-nhap-kho', v)
                .then((res) => {
                    this.list_chi_tiet_hoa_don = res.data.data;
                })
        }
    },
}
</script>
<style>
    
</style>
