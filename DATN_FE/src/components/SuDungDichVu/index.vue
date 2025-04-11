<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation" v-on:click="loadDataBan(); khu_vuc = khu_vuc_tat_ca">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon me-1 text-danger fa-2x">
                                    </div>
                                    <div class="tab-title">Tất cả</div>
                                </div>
                            </a>
                        </li>
                        <template v-for="(v, k) in list_khu_vuc" :key="k">
                            <li class="nav-item" role="presentation" v-on:click="getBanTheoKhuVuc(v); khu_vuc = v">
                                <a class="nav-link" data-bs-toggle="tab" v-bind:href="'#primaryhome' + k" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon me-1 text-danger fa-2x">
                                            <span v-html="v.icon"></span>
                                        </div>
                                        <div class="tab-title">{{ v.ten_khu }}</div>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </ul>
                    <div class="tab-content py-3">
                        <div class="row">
                            <template v-for="(v, k) in list_ban" :key="k">
                                <template v-if="v.tinh_trang == 1">
                                    <template v-if="v.is_mo_ban == 0">
                                        <div class="col-md-2">
                                            <div class="tab-pane fade show" id="primaryhome" role="tabpanel">
                                                <div class="card radius-10">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <div
                                                                class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3">
                                                                <img src="../../assets/assets_rocker/anh_ban.png"
                                                                    class="img-fluid" alt="">
                                                            </div>
                                                            <h4 class="my-1">{{ v.ten_ban }}</h4>
                                                            <button v-if="v.is_mo_ban == 0" v-on:click="moBan(v)"
                                                                class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#mobanModal">Mở Bàn</button>
                                                            <button v-else class="btn btn-success" v-on:click="moBan(v)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#mobanModal">Thanh
                                                                Toán</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="col-md-2">
                                            <div class="tab-pane fade show" id="primaryhome" role="tabpanel">
                                                <div class="card radius-10"
                                                    style="background-color: rgb(143, 255, 255);">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <div
                                                                class="widgets-icons rounded-circle mx-auto text-primary mb-3">
                                                                <img src="../../assets/assets_rocker/anh_ban.png"
                                                                    class="img-fluid" alt="">
                                                            </div>
                                                            <h4 class="my-1">{{ v.ten_ban }}</h4>
                                                            <button v-if="v.is_mo_ban == 0" v-on:click="moBan(v)"
                                                                class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#mobanModal">Mở Bàn</button>
                                                            <button v-else class="btn btn-success" v-on:click="moBan(v)"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#mobanModal">Thanh
                                                                Toán</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                    <!-- modal -->

                    <div class="modal fade" id="mobanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl" style="max-width: 100%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-2" id="exampleModalLabel">Bàn {{ ten_ban }}</h1>
                                    <button @click="closeLoadBan(khu_vuc)" type="button" class="btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row" v-if="trang_thai == 0">
                                        <div class="col-md-4 d-flex">
                                            <div class="card flex-fill">
                                                <div class="card-header">
                                                    <h6>Danh sách món ăn</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="table-responsive" style="max-height: 500px">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle text-center">#</th>
                                                                        <th class="align-middle text-center">Tên Hàng
                                                                        </th>
                                                                        <th class="align-middle text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template v-for="(value, key) in list_mon_an"
                                                                        :key="key">
                                                                        <tr>
                                                                            <td class="align-middle text-center">{{ key
                                                                                + 1
                                                                                }}</td>
                                                                            <td class="align-middle text-center">{{
                                                                                value.ten_mon }}</td>
                                                                            <td class="align-middle text-center">
                                                                                <button v-on:click="themMonAn(value)"
                                                                                    class="btn btn-primary">Thêm</button>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 d-flex">
                                            <div class="card ">
                                                <div class="card-header">
                                                    Món ăn sử dụng
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center align-middle">#</th>
                                                                    <th class="text-center align-middle">Tên món ăn</th>
                                                                    <th class="text-center align-middle">Số lượng</th>
                                                                    <th class="text-center align-middle">Đơn giá</th>
                                                                    <th class="text-center align-middle">% giảm giá</th>
                                                                    <th class="text-center align-middle">Thành tiền</th>
                                                                    <th class="text-center align-middle">Ghi chú</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <template v-for="(v, k) in list_chi_tiet_ban_hang"
                                                                    :key="k">
                                                                    <tr>
                                                                        <th class="align-middle text-center">

                                                                            <template
                                                                                v-if="v.is_in_bep == 1 && v.is_che_bien == 0">
                                                                                <i class="fa-solid fa-trash-can text-danger me-2"
                                                                                    v-on:click="xoaChiTiet(v)"></i>
                                                                                <i
                                                                                    class="fa-solid fa-fire text-danger"></i>
                                                                            </template>
                                                                            <template
                                                                                v-else-if="v.is_in_bep == 1 && v.is_che_bien == 1">
                                                                                <i
                                                                                    class="fa-solid fa-circle-check text-success"></i>
                                                                            </template>
                                                                            <template v-else>
                                                                                <i class="fa-solid fa-trash-can text-danger"
                                                                                    v-on:click="xoaChiTiet(v)"></i>
                                                                            </template>
                                                                        </th>
                                                                        <td class="align-middle">
                                                                            {{ v.ten_mon }}
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                            <template v-if="v.is_in_bep">
                                                                                {{ v.so_luong }}
                                                                            </template>
                                                                            <template v-else>
                                                                                <input v-on:change="updateChiTiet(v)"
                                                                                    type="number" class="form-control"
                                                                                    v-model="v.so_luong">
                                                                            </template>
                                                                        </td>
                                                                        <td class="align-middle text-end">
                                                                            <template v-if="v.is_in_bep">
                                                                                {{ formatToVND(v.don_gia) }}
                                                                            </template>
                                                                            <template v-else>
                                                                                <input v-on:change="updateChiTiet(v)"
                                                                                    type="number" class="form-control"
                                                                                    v-model="v.don_gia">
                                                                            </template>
                                                                        </td>
                                                                        <td class="align-middle text-center">
                                                                                <input v-on:change="updateChiTiet(v)"
                                                                                    type="number" class="form-control"
                                                                                    v-model="v.phan_tram_giam">
                                                                        </td>
                                                                        <td class="align-middle text-end">{{
                                                                            formatToVND(v.thanh_tien) }}
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <template v-if="v.is_in_bep">
                                                                                {{ v.ghi_chu }}
                                                                            </template>
                                                                            <template v-else>
                                                                                <input v-on:change="updateChiTiet(v)"
                                                                                    type="text" class="form-control"
                                                                                    v-model="v.ghi_chu">
                                                                            </template>
                                                                        </td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white text-end">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <textarea v-model="ghi_chu_hoa_don" class="form-control"
                                                                cols="30" rows="4"></textarea>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img style="width: 100%;" v-bind:src="link_qr" alt="">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-lg-6 text-nowrap">
                                                                    <p><b>Tổng tiền:</b></p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <p><b>{{ formatToVND(tong_tien) }}</b></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6 text-nowrap">
                                                                    <p><b>Tổng thanh toán:</b></p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <p><b>{{ formatToVND(tong_tien_thu) }}</b></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6 text-nowrap">
                                                                    <p><b>Phần trăm giảm: </b></p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="number" class="form-control"
                                                                        v-on:keyup="updateHoaDon()"
                                                                        v-model="phan_tram_giam_hoa_don" min="0">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6 text-nowrap">
                                                                    <p><b>Tiền thực thu: </b></p>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <p><b>{{ formatToVND(tien_thuc_thu)
                                                                            }}</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="trang_thai == 1">
                                        <div class="col-md-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">Chọn bàn</th>
                                                            <th>
                                                                <select
                                                                    v-on:change="loadDanhSachMonTheoHoaDonChuyenBan(id_ban_nhan)"
                                                                    v-model="id_ban_nhan" class="form-control">
                                                                    <option value="0">Chọn bàn cần chuyển món</option>
                                                                    <template v-for="(value, key) in list_ban"
                                                                        :key="key">
                                                                        <template
                                                                            v-if="value.tinh_trang == 1 && value.is_mo_ban != 0">
                                                                            <template v-if="value.id != id_ban">
                                                                                <option v-bind:value="value.id">{{
                                                                                    value.ten_ban }}</option>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </select>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">Tên Món</th>
                                                            <th class="text-center">Số Lượng</th>
                                                            <th class="text-center">Ghi Chú</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(value, key) in list_mon_2" :key="key">
                                                            <th class="text-center">{{ key + 1 }}</th>
                                                            <td>{{ value.ten_mon }}</td>
                                                            <td class="text-center">{{ value.so_luong }}</td>
                                                            <td>{{ value.ghi_chu }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">Tên Món</th>
                                                            <th class="text-center">Số Lượng</th>
                                                            <th class="text-center">Số Lượng Chuyển</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(value, key) in list_chi_tiet_ban_hang" :key="key">
                                                            <th class="text-center align-middle">
                                                                {{ key + 1 }}
                                                            </th>
                                                            <td class="align-middle">{{ value.ten_mon }} - {{ value.id
                                                                }}</td>
                                                            <td class="align-middle text-center">
                                                                {{ value.so_luong }}
                                                            </td>
                                                            <td class="align-middle" style="width: 15%;">
                                                                <input v-model="value.so_luong_chuyen" type="number"
                                                                    class="form-control" min="0">
                                                            </td>
                                                            <td class="text-center">
                                                                <button v-on:click="chuyenMon(value)"
                                                                    class="btn btn-primary">Chuyển</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeLoadBan(khu_vuc)" type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button v-if="trang_thai == 0" v-on:click="trang_thai = 1" type="button"
                                        class="btn btn-danger">Chuyển
                                        Bàn</button>
                                    <button v-if="trang_thai == 1" v-on:click="trang_thai = 0" type="button"
                                        class="btn btn-danger">Xong
                                        Chuyển Bàn</button>
                                    <button @click="inBep(id_hoa_don_ban_hang)" type="button" class="btn btn-primary">In
                                        Bếp</button>
                                    <button @click="printBill()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">In Hóa
                                        Đơn</button>

                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                        v-on:click="thanhToan()">Thanh
                                        Toán</button>
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
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            ma_hoa_don: '',
            intervalId: null,
            ghi_chu_hoa_don: '',
            id_hd_nhan: 0,
            list_mon_2: [],
            id_ban: 0,
            ten_ban: '',
            id_ban_nhan: 0,
            trang_thai: 0,
            list_khu_vuc: [],
            list_ban: [],
            list_mon_an: [],
            list_chi_tiet_ban_hang: [],
            id_hoa_don_ban_hang: 0,
            tong_tien: 0,
            tong_tien_thu: 0,
            phan_tram_giam_hoa_don: 0,
            tien_thuc_thu: 0,
            link_qr: "",
            khu_vuc: {
                'id': 0
            },
            khu_vuc_tat_ca: {
                'id': 0
            },
        }
    },
    mounted() {
        this.loadDataKhuVuc();
        this.loadDataBan();
        this.loadMonAn();
    },
    watch: {
        $route(to, from) {
            console.log(this.tien_thuc_thu);
        }
    },
    methods: {
        hienMaThanhToan(amount, bill_id) {
            if (amount > 0) {
                this.link_qr = "https://img.vietqr.io/image/MB-5380148665533-compact2.jpg?amount=" + amount + "&addInfo=" + bill_id + "&accountName=NGUYEN_VU_HUY"
            } else {
                this.link_qr = "https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg"
            }
        },
        closeLoadBan(v) {
            if (v.id < 1) {
                this.loadDataBan();
            } else {
                this.getBanTheoKhuVuc(v)
            }
        },

        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },

        chuyenMon(v) {
            v['id_hoa_don_nhan'] = this.id_hd_nhan;
            v['id_ban_nhan'] = this.id_ban_nhan;
            console.log(v);

            baseRequest
                .post('admin/dich-vu/chuyen-mon', v)
                .then((res) => {
                    if (res.data.status) {
                        this.loadMonAn();
                        this.getChiTietHoaDon(v.id_hoa_don)
                        // this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                        this.loadDanhSachMonTheoHoaDonChuyenBan(this.id_ban_nhan);
                        toaster.success(res.data.message);
                    } else {
                        toaster.error(res.data.message);
                    }
                });
        },

        loadDanhSachMonTheoHoaDonChuyenBan(id_ban_nhan) {
            var payload = {
                'id_ban': id_ban_nhan,
            };

            baseRequest
                .post('admin/dich-vu/danh-sach-mon-theo-id-ban', payload)
                .then((res) => {
                    if (res.data.status) {
                        this.list_mon_2 = res.data.data;
                        this.id_hd_nhan = res.data.id_hd;
                    } else {
                        toaster.error(res.data.message);
                    }
                })
                .catch((res) => {
                    $.each(res.response.data.errors, function (k, v) {
                        toaster.error(v[0]);
                    });
                });
        },

        loadDataKhuVuc() {
            baseRequest
                .get('admin/khu-vuc/lay-du-lieu-hoat-dong')
                .then((res) => {
                    this.list_khu_vuc = res.data.khu_vuc;
                });
        },

        loadDataBan() {
            baseRequest
                .get('admin/ban/lay-du-lieu-all')
                .then((res) => {
                    this.list_ban = res.data.ban;
                });
        },

        getBanTheoKhuVuc(v) {
            baseRequest
                .post('admin/dich-vu/lay-du-lieu-ban-theo-khu-vuc', v)
                .then((res) => {
                    this.list_ban = res.data.data;

                });

        },

        loadMonAn() {
            baseRequest
                .get('admin/dich-vu/lay-du-lieu-mon-an')
                .then((res) => {
                    this.list_mon_an = res.data.data;
                });
        },

        moBan(v) {
            this.ghi_chu_hoa_don = '';
            this.phan_tram_giam_hoa_don = 0;
            baseRequest
                .post('admin/dich-vu/mo-ban', v)
                .then((res) => {
                    if (res.data.status == 1) {
                        toaster.success(res.data.message);
                        this.tong_tien = 0,
                            this.tong_tien_thu = 0,
                            this.phan_tram_giam_hoa_don = 0,
                            this.tien_thuc_thu = 0,
                            this.id_hoa_don_ban_hang = res.data.id_hoa_don_ban_hang;
                        this.id_ban = res.data.id_ban;
                        this.ten_ban = res.data.ten_ban;
                        this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                        this.closeLoadBan(this.khu_vuc)
                    } else if (res.data.status == 2) {
                        this.id_hoa_don_ban_hang = res.data.id_hoa_don_ban_hang;
                        this.tong_tien = res.data.tong_tien;
                        this.tong_tien_thu = res.data.tong_tien_thu;
                        this.tien_thuc_thu = res.data.tong_tien_thu;
                        this.id_ban = res.data.id_ban;
                        this.ten_ban = res.data.ten_ban;
                        this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                    }
                });
        },

        themMonAn(v) {
            var payload = {
                'id_hoa_don': this.id_hoa_don_ban_hang,
                'id_mon_an': v.id,
                'don_gia': v.gia_ban,
            }
            baseRequest
                .post('admin/dich-vu/them-mon-an', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                        this.closeLoadBan(this.khu_vuc)
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },

        getChiTietHoaDon(id) {
            var payload = {
                'id_hoa_don': id,
            }
            baseRequest
                .post('admin/dich-vu/get-chi-tiet', payload)
                .then((res) => {
                    this.list_chi_tiet_ban_hang = res.data.data;
                    this.tong_tien = res.data.tong_tien;
                    this.tong_tien_thu = res.data.tong_tien_thu;
                    this.tien_thuc_thu = res.data.tong_tien_thu;
                    this.ma_hoa_don = res.data.hoa_don.ma_hoa_don
                    this.hienMaThanhToan(this.tien_thuc_thu, this.ma_hoa_don);
                });
        },

        updateChiTiet(v) {
            baseRequest
                .post('admin/dich-vu/update-chi-tiet', v)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                        this.closeLoadBan(this.khu_vuc)
                    }
                })
                .catch((errors) => {
                    this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },

        updateHoaDon() {
            if(this.phan_tram_giam_hoa_don < 0) {
                toaster.error("Phần trăm giảm không được bé hơn 0");
                this.phan_tram_giam_hoa_don = 0;
                var tien_giam = this.tong_tien_thu / 100 * this.phan_tram_giam_hoa_don;
                this.tien_thuc_thu = this.tong_tien_thu - tien_giam;
                this.hienMaThanhToan(this.tien_thuc_thu, this.ma_hoa_don);
            } else if(this.phan_tram_giam_hoa_don > 100) {
                toaster.error("Phần trăm giảm không được lớn hơn 100");
                this.phan_tram_giam_hoa_don = 0;
                var tien_giam = this.tong_tien_thu / 100 * this.phan_tram_giam_hoa_don;
                this.tien_thuc_thu = this.tong_tien_thu - tien_giam;
                this.hienMaThanhToan(this.tien_thuc_thu, this.ma_hoa_don);
            } else {
                var tien_giam = this.tong_tien_thu / 100 * this.phan_tram_giam_hoa_don;
                this.tien_thuc_thu = this.tong_tien_thu - tien_giam;
                this.hienMaThanhToan(this.tien_thuc_thu, this.ma_hoa_don);
            }
        },

        thanhToan() {
            var payload = {
                'id': this.id_hoa_don_ban_hang,
                'tong_tien_truoc_giam': this.tong_tien_thu,
                'phan_tram_giam': this.phan_tram_giam_hoa_don,
                'tien_thuc_nhan': this.tien_thuc_thu,
                'ghi_chu': this.ghi_chu_hoa_don,
            }
            baseRequest
                .post('admin/dich-vu/thanh-toan', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.tong_tien = 0,
                            this.phan_tram_giam_hoa_don = 0,
                            this.tien_thuc_thu = 0,
                            this.closeLoadBan(this.khu_vuc);
                    } else {
                        toaster.error(res.data.message);
                        this.closeLoadBan(this.khu_vuc);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },

        xoaChiTiet(v) {
            baseRequest
                .post('admin/dich-vu/delete-chi-tiet', v)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.phan_tram_giam_hoa_don = 0;
                        this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                        this.closeLoadBan(this.khu_vuc)
                    }

                });
        },
        inBep(id_hoa_don) {
            var payload = {
                'id_hoa_don_ban_hang': id_hoa_don
            };
            baseRequest
                .post('admin/dich-vu/in-bep', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                    } else {
                        toaster.error(res.data.message);
                    }
                    this.getChiTietHoaDon(this.id_hoa_don_ban_hang);
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        printBill() {
            var payload = {
                'id': this.id_hoa_don_ban_hang,
                'tong_tien_truoc_giam': this.tong_tien_thu,
                'phan_tram_giam': this.phan_tram_giam_hoa_don,
                'tien_thuc_nhan': this.tien_thuc_thu,
                'ghi_chu': this.ghi_chu_hoa_don,
            }
            baseRequest
                .post('admin/dich-vu/bill/print', payload)
                .then(response => {
                    if (response.data.status) {
                        console.log(response.data);
                        this.createPrintWindow(response.data);
                        this.checkThanhToan();
                        setTimeout(() => {
                            this.checkThanhToan(response.data);
                            // Run checkThanhToan every 10 seconds
                            this.intervalId = setInterval(() => {
                                this.checkThanhToan(response.data);
                            }, 10000);
                        }, 10000);
                    } else {
                        toaster.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.error("Có lỗi xảy ra khi lấy dữ liệu bill", error);
                });
        },
        createPrintWindow(data) {
            const bill = data.bill;
            const chiTietHoaDon = data.chiTietHoaDon;
            let htmlContent = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hóa Đơn Nhà Hàng For You</title>
            <style>
            .bill-container {
                font-family: 'Arial', sans-serif;
                max-width: 100%; /* Thay đổi max-width để phù hợp với kích thước trang in */
                margin: auto;
                padding: 10px;
                background: #fff;
                page-break-inside: avoid; /* Ngăn chặn trang bị ngắt */
            }
            h2 {
            text-align: center;
            margin: 5px 0;
            }
            table {
            width: 100%;
            border-collapse: collapse;
            }
            table, th, td {
            border: 1px solid black;
            }
            th, td {
            padding: 2px 5px;
            text-align: left;
            }
            tfoot tr th {
            text-align: right;
            }
            .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 0.8em;
            }
            .text-center {
                text-align: center
            }
            .text-end {
                text-align: right !important;
            }
            .img-fluid {
                height: 100px;
                width: auto;
            }
            .img-bill {
                height: 120px;
                width: auto;
            }
            .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-0.5 * var(--bs-gutter-x));
            margin-left: calc(-0.5 * var(--bs-gutter-x));
            }
            .row > * {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * 0.5);
            padding-left: calc(var(--bs-gutter-x) * 0.5);
            margin-top: var(--bs-gutter-y);
            }

            .col {
            flex: 1 0 0%;
            }
            @media print {
                body {
                    overflow: visible !important;
                }
                @page {
                    size: auto;
                    margin: 0mm;
                }
            }
            </style>
            </head>
            <body>
            <div class="bill-container">
            <h2><img src="https://img.upanh.tv/2024/04/11/logo-icon.png" class="img-fluid" alt="logo-icon.png" border="0"></h2>
            <h2>Thông Tin Hóa Đơn</h2>
            <div class="row">
                <div class="col">
                    <p><b>Mã Hóa Đơn:</b> ${bill.ma_hoa_don}</p>
                    <p><b>Bàn:</b> ${bill.ten_ban}</p>
                    <p><b>Thu Ngân:</b> ${bill.ho_va_ten}</p>
                </div>
                <div class="col text-end">
                    <img class="img-bill" src="https://img.vietqr.io/image/MB-5380148665533-qr_only.jpg?amount=${this.tien_thuc_thu}&addInfo=${bill.ma_hoa_don}&accountName=NGUYEN_VU_HUY" alt="">
                </div>
            </div>
            
            <hr>
            <h2>Chi Tiết Hóa Đơn</h2>
            <table>
                <thead>
                <tr>
                    <th>Tên món</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
                </thead>
                <tbody>`;

            chiTietHoaDon.forEach(item => {
                htmlContent += `<tr>
                <td>${item.ten_mon}</td>
                <td class="text-center">${item.so_luong}</td>
                <td class="text-end">${this.formatToVND(item.don_gia)}</td>
                <td class="text-end">${this.formatToVND(item.thanh_tien)}</td>
            </tr>`;
            });

            htmlContent += `</tbody>
            </table>
            <hr>
            <p><b>Tổng Tiền:</b> ${this.formatToVND(this.tong_tien_thu)}</p>
            <p><b>Phần trăm giảm:</b> ${this.phan_tram_giam_hoa_don}%</p>
            <p><b>Tổng Tiền Sau GIảm:</b> ${this.formatToVND(this.tien_thuc_thu)}</p>
            <hr>
            </div>
            <p class="footer">Cảm ơn Quý khách. Hẹn gặp lại!</p>
            </body>
            </html>`;


            const blob = new Blob([htmlContent], { type: 'text/html' });
            const url = URL.createObjectURL(blob);

            const printWindow = window.open(url, '_blank');
            printWindow.onload = function () {
                printWindow.print();
                setTimeout(() => {
                    URL.revokeObjectURL(url);
                    printWindow.close();
                }, 100);
            }
        },
        checkThanhToan() {
            baseRequest
                .get('giao-dich')
                .then((res) => {
                    if (res.data.status == true) {
                        toaster.success(res.data.message);
                        this.closeLoadBan(this.khu_vuc)
                        clearInterval(this.intervalId);
                    }
                    // console.log(res.data);
                })
        }
    }
}
</script>
<style></style>
