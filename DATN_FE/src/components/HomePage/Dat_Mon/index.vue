<template>
    <div class="py-5 bg-dark">
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                <h1 class="mb-5">BÀN {{ ban.ten_ban }}</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <template v-for="(v, k) in danh_muc" :key="k">
                        <template v-if="v.id_danh_muc_cha == 0">
                            <li class="nav-item mt-2">
                                <a @click="loadMonAn(v)" class="d-flex align-items-center text-start mx-3 ms-0 pb-3"
                                    data-bs-toggle="pill" href="#tab-1">
                                    <span v-html="v.icon"></span>
                                    <div class="ps-3">
                                        <small class="text-body">ForYou Restaurant</small>
                                        <h6 class="mt-n1 mb-0">{{ v.ten_danh_muc }}</h6>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </template>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="container">
                            <div class="row g-4">
                                <template v-for="(v, k) in mon_an" :key="k">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" :src="v.hinh_anh" alt=""
                                                style="width: 80px;">
                                            <div
                                                class="w-100 d-flex align-items-center justify-content-between text-start ps-4">
                                                <spam class="d-flex flex-column border-bottom me-5">
                                                    <h5>{{ v.ten_mon }}</h5>
                                                    <small class="fst-italic mt-2">{{ formatToVND(v.gia_ban) }}</small>
                                                </spam>
                                                <span class="text-primary me-5"><i @click="themMonAn(v)"
                                                        class="fa-solid fa-circle-plus fa-xl"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a @click="getChiTietHoaDon(ban.hoa_don_hien_tai)" data-bs-toggle="modal" data-bs-target="#exampleModal"
        class="btn btn-lg btn-primary btn-lg-square cart">
        <template v-if="count > 0">
            <span class="alert-count">{{ count }}</span>
        </template>
        <i class="fa-solid fa-basket-shopping"></i>
    </a>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Danh Sách Đặt Món</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Tên món ăn</th>
                                    <th class="text-center align-middle">Số lượng</th>
                                    <th class="text-center align-middle">Đơn giá</th>
                                    <th class="text-center align-middle">Thành tiền</th>
                                    <th class="text-center align-middle">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(v, k) in list_chi_tiet_ban_hang" :key="k">
                                    <tr>
                                        <td class="align-middle text-center">
                                            <template v-if="v.is_in_bep == 1 && v.is_che_bien == 0">
                                                <i class="fa-solid fa-fire text-danger fa-xl"></i>
                                            </template>
                                            <template v-else-if="v.is_in_bep == 1 && v.is_che_bien == 1">
                                                <i class="fa-solid fa-circle-check text-success fa-xl"></i>
                                            </template>
                                            <template v-else>
                                                <i @click="xoaChiTiet(v)"
                                                    class="fa-solid fa-circle-xmark fa-xl text-danger"></i>
                                            </template>
                                        </td>
                                        <td class="align-middle">{{ v.ten_mon }}</td>
                                        <td class="align-middle text-center">
                                            <template v-if="v.is_in_bep">
                                                {{ v.so_luong }}
                                            </template>
                                            <template v-else>
                                                <input type="number" min="1"
                                                    v-model="v.so_luong"
                                                    class="form-control text-center"
                                                    style="width: 100px;"
                                                    @focus="pauseAutoRefreshAndSave(v)"
                                                    @blur="handleQuantityChange(v)">
                                            </template>
                                        </td>
                                        <td class="align-middle">
                                            {{ formatToVND(v.don_gia) }}
                                        </td>
                                        <td class="align-middle">{{ formatToVND(v.thanh_tien) }}</td>
                                        <td class="align-middle">
                                            <template v-if="v.is_in_bep">
                                                {{ v.ghi_chu }}
                                            </template>
                                            <template v-else>
                                                <input type="text" class="form-control" 
                                                    v-model="v.ghi_chu"
                                                    @focus="pauseAutoRefreshAndSave(v)"
                                                    @blur="resumeAutoRefreshAndUpdate(v)">
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-column">
                    <p class="text-center"><h6>Tổng tiền: </h6>{{ formatToVND(this.tong_tien) }}</p>
                    <p class="text-center"><h6>Tổng tiền thanh toán: </h6>{{ formatToVND(this.tong_tien_thu) }}</p>
                    <p>
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button @click="inBep()" type="button" class="btn btn-primary" :disabled="disableOrderButton">Đặt Món</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import baseRequest from '../../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });

export default {
    props: ['slug_ban', 'hash_ban'],
    data() {
        return {
            ban: {},
            mon_an: [],
            danh_muc: [],
            list_chi_tiet_ban_hang: [],
            tong_tien: 0,
            tong_tien_thu: 0,
            count: 0,
            refreshInterval: null,
            disableOrderButton: false,
            hasOrderedInThisSession: false,
            currentEditingItem: null,
            isEditingNote: false
        }
    },
    mounted() {
        this.loadDataDatMon();
        this.setupAutoRefresh();
        
        const modal = document.getElementById('exampleModal');
        modal.addEventListener('show.bs.modal', () => {
            this.hasOrderedInThisSession = false;
            this.updateButtonState();
        });
    },
    beforeUnmount() {
        this.clearAutoRefresh();
    },
    methods: {
        pauseAutoRefreshAndSave(item) {
            this.pauseAutoRefresh();
            this.currentEditingItem = {...item};
            this.isEditingNote = true;
        },
        
        handleQuantityChange(item) {
            if (item.so_luong < 1) {
                item.so_luong = 1;
                toaster.warning('Số lượng tối thiểu là 1');
            }
            
            if (this.currentEditingItem && 
                (this.currentEditingItem.so_luong !== item.so_luong || 
                 this.currentEditingItem.ghi_chu !== item.ghi_chu)) {
                this.updateChiTiet(item);
            }
            
            this.resumeAutoRefresh();
            this.currentEditingItem = null;
            this.isEditingNote = false;
        },
        
        resumeAutoRefreshAndUpdate(item) {
            if (this.currentEditingItem && this.currentEditingItem.ghi_chu !== item.ghi_chu) {
                this.updateChiTiet(item);
            }
            this.resumeAutoRefresh();
            this.currentEditingItem = null;
            this.isEditingNote = false;
        },
        
        setupAutoRefresh() {
            this.clearAutoRefresh();
            if (!this.isEditingNote) {
                this.refreshInterval = setInterval(() => {
                    this.autoRefreshData();
                }, 3000);
            }
        },
        
        clearAutoRefresh() {
            if (this.refreshInterval) {
                clearInterval(this.refreshInterval);
                this.refreshInterval = null;
            }
        },
        
        pauseAutoRefresh() {
            this.isEditingNote = true;
            this.clearAutoRefresh();
        },
        
        resumeAutoRefresh() {
            this.isEditingNote = false;
            this.setupAutoRefresh();
            this.autoRefreshData();
        },
        
        autoRefreshData() {
            if (this.ban.hoa_don_hien_tai && document.getElementById('exampleModal').classList.contains('show')) {
                this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
            }
            this.loadDataDatMon();
        },
        
        updateButtonState() {
            this.disableOrderButton = this.hasOrderedInThisSession || 
                                    this.list_chi_tiet_ban_hang.length === 0 ||
                                    this.list_chi_tiet_ban_hang.every(item => item.is_in_bep);
        },
        
        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },
        
        loadDataDatMon() {
            baseRequest
                .get(`dat-mon-homepage/` + this.slug_ban + '/' + this.hash_ban)
                .then((res) => {
                    if (res.data.status == true) {
                        this.ban = res.data.ban;
                        this.mon_an = res.data.mon_an;
                        this.danh_muc = res.data.danh_muc;
                        this.count = res.data.count;
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                        this.$router.push('/');
                    }
                });
        },
        
        loadMonAn(v) {
            baseRequest
                .post(`mon-an-homepage`, v)
                .then((res) => {
                    this.mon_an = res.data.mon_an;
                });
        },
        
        getChiTietHoaDon(v) {
            var payload = {
                'ma_hoa_don': v,
            }
            baseRequest
                .post('chi-tiet-hoa-don-homepage', payload)
                .then((res) => {
                    if (res.data.status) {
                        this.list_chi_tiet_ban_hang = res.data.data;
                        this.tong_tien = res.data.tong_tien;
                        this.tong_tien_thu = res.data.tong_tien_thu;
                        this.count = res.data.count;
                        this.updateButtonState();
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                        this.$router.push('/');
                    }
                });
        },
        
        themMonAn(v) {
            var payload = {
                'ma_hoa_don': this.ban.hoa_don_hien_tai,
                'id_mon_an': v.id,
                'don_gia': v.gia_ban,
            }
            baseRequest
                .post('create-chi-tiet-hoa-don-homepage', payload)
                .then((res) => {
                    if (res.data.status) {
                        this.tong_tien = res.data.tong_tien;
                        this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                        this.$router.push('/');
                    }
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        
        updateChiTiet(v) {
            baseRequest
                .post('update-chi-tiet-hoa-don-homepage', v)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.tong_tien = res.data.tong_tien;
                        this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                        this.$router.push('/');
                    }
                })
                .catch((errors) => {
                    this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    })
                });
        },
        
        xoaChiTiet(v) {
            baseRequest
                .post('delete-chi-tiet-hoa-don-homepage', v)
                .then((res) => {
                    if (res.data.status) {
                        this.tong_tien = res.data.tong_tien;
                        this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                        this.$router.push('/');
                    }
                });
        },
        
        inBep() {
            if (this.currentEditingItem) {
                const item = this.list_chi_tiet_ban_hang.find(i => i.id === this.currentEditingItem.id);
                if (item && (this.currentEditingItem.so_luong !== item.so_luong || 
                             this.currentEditingItem.ghi_chu !== item.ghi_chu)) {
                    this.updateChiTiet(item);
                }
            }
            
            if (this.disableOrderButton) return;
            
            var payload = {
                'ma_hoa_don': this.ban.hoa_don_hien_tai
            };
            baseRequest
                .post('dat-mon-bep-homepage', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                        this.hasOrderedInThisSession = true;
                        this.updateButtonState();
                    } else {
                        toaster.error(res.data.message);
                        this.$router.push('/');
                    }
                    this.getChiTietHoaDon(this.ban.hoa_don_hien_tai);
                })
                .catch((errors) => {
                    const listErrors = errors.response.data.errors;
                    Object.values(listErrors).forEach((value) => {
                        toaster.error('Thông báo<br>' + value);
                    });
                });
        }
    }
}
</script>

<style>
.cart {
    position: fixed;
    display: none;
    right: 20px;
    top: 95px;
    z-index: 99;
}

.alert-count {
    position: absolute;
    top: 5px;
    left: 30px;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 12px;
    font-weight: 500;
    color: #fff;
    background: #f62718;
}
</style>
