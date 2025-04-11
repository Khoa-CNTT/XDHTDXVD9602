<template lang="">
<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                Danh Sách Nguyên Liệu
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
                                <th class="text-center align-middle text-nowrap">#</th>
                                <th class="text-center align-middle text-nowrap">Tên Nguyên Liệu</th>
                                <th class="text-center align-middle text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list_nguyen_lieu">
                                <tr>
                                    <th class="text-center align-middle text-nowrap">{{key + 1}}</th>
                                    <td class="align-middle text-nowrap">{{value.ten_nguyen_lieu}}</td>
                                    <th class="text-center align-middle text-nowrap">
                                        <button class="btn btn-primary" v-on:click="addnguyenLieu(value)">Thêm</button>
                                    </th>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                Danh Sách Nhập Kho
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle text-nowrap">#</th>
                                <th class="text-center align-middle text-nowrap">Tên Nguyên Liệu</th>
                                <th class="text-center align-middle text-nowrap">Số Lương</th>
                                <th class="text-center align-middle text-nowrap">Đơn Giá</th>
                                <th class="text-center align-middle text-nowrap">Thành Tiền</th>
                                <th class="text-center align-middle text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list_nhap_kho">
                                <tr>
                                    <th class="text-center align-middle text-nowrap">{{key + 1}}</th>
                                    <td class="align-middle text-nowrap">{{value.ten_nguyen_lieu}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <input type="text" v-model="value.so_luong" v-on:change="updateNhapKho(value)" class="form-control">
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <input type="text" v-model="value.don_gia" v-on:change="updateNhapKho(value)" class="form-control">
                                    </td>
                                    <td class="text-center align-middle text-nowrap">{{formatToVND(value.thanh_tien)}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <i class="fa-solid fa-trash fa-2x text-danger" v-on:click="deletenguyenLieu(value)"></i>
                                    </td>
                                </tr>
                            </template>
                                <tr>
                                    <td colspan="5">
                                        <label for="" class="mb-2">Chọn Nhà Cung Cấp</label>
                                        <select name="" class="form-control" id="" v-model="nhap_kho.id_nha_cung_cap">
                                            <template v-for="(value, index) in list_nha_cung_cap">
                                                <option v-bind:value="value.id">{{ value.ten_cong_ty }}</option>
                                            </template>
                                        </select>
                                    </td>
                                    
                                    <td colspan="1">
                                        <label for="" class="mb-2"><b>Tổng Tiền</b></label>
                                        <p class="text-danger">{{ formatToVND(tong_tien) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="" class="mb-2">Nhập Ghi Chú Nhập Kho</label>
                                        <textarea v-model="nhap_kho.ghi_chu" cols="30" rows="4" class="form-control"></textarea>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-end">
                        <button class="btn btn-primary" v-on:click="createHoaDonNhapkho()">Nhập Kho</button>
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
            list_nguyen_lieu    : [],
            list_nhap_kho       : [],
            key_search          : {abc : ""},
            list_nha_cung_cap   : [],
            tong_tien           : 0,
            nhap_kho            : {
                'id_nha_cung_cap' : 0,
                'ghi_chu'         : null
            },
        }
    },
    mounted()  {
        this.loadDataNguyenLieu();
        this.loadDataNhapKho();
        this.loadDataNhaCungCap();
    },
    methods :   {
        formatToVND(number) {
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },
        updateInputValue(input) {
            var number = input.value.replace(/[^0-9]/g, ''); // Xóa bất kỳ ký tự không phải số
            var formattedNumber = formatToVND(Number(number));
            input.value = formattedNumber;
        },

        loadDataNhaCungCap() {
            baseRequest
                .get('admin/nha-cung-cap/lay-du-lieu-all')
                .then((res) => {
                    this.list_nha_cung_cap = res.data.nha_cung_cap;
                });
        },

        loadDataNguyenLieu()   {
            baseRequest
                .get('admin/nguyen-lieu/lay-du-lieu-all')
                .then((res) =>  {
                    this.list_nguyen_lieu = res.data.nguyen_lieu;
                });
        },
        loadDataNhapKho()   {
            baseRequest
                .get('admin/nhap-kho/lay-du-lieu')
                .then((res) =>  {
                    this.list_nhap_kho = res.data.nhap_kho;
                    this.tong_tien     = res.data.tong_tien;
                });
        },
        searchNguyenLieu() {
            baseRequest
                .post('admin/nguyen-lieu/tim-nguyen-lieu', this.key_search)
                .then((res) =>  {
                    this.list_nguyen_lieu = res.data.nguyen_lieu;
                });
        },
        addnguyenLieu(value){
            baseRequest
                .post('admin/nhap-kho/them-nguyen-lieu',value)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.loadDataNhapKho();
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        deletenguyenLieu(value){
            baseRequest
                .delete('admin/nhap-kho/xoa-nguyen-lieu/' + value.id)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.loadDataNhapKho();
                    }
                });
        },

        updateNhapKho(value) {  
            baseRequest
                .put('admin/nhap-kho/cap-nhat-nhap-kho', value)
                .then((res) => {
                    if(res.data.status) {
                        toaster.success(res.data.message);
                        this.loadDataNhapKho();
                    } else {
                        toaster.error(res.data.message);
                        this.loadDataNhapKho();
                    }
                })
                .catch((errors) => {
                    this.loadDataNhapKho();
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        }, 

        createHoaDonNhapkho() {
            baseRequest
                .post('admin/nhap-kho/tao-hoa-don-nhap-kho', this.nhap_kho)
                .then((res) => {
                    if(res.data.status) {
                        toaster.success(res.data.message);
                        this.loadDataNhapKho();
                        this.nhap_kho = {
                            'id_nha_cung_cap' : 0,
                            'ghi_chu'         : null
                        };
                    } else {
                        toaster.error(res.data.message);
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        }
    },
}
</script>

<style>

</style>