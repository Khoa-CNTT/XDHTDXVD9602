<?php

use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\GiaoDichController;
use App\Http\Controllers\HoaDonBanHangController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\NguyenLieuController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\NhapKhoController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/giao-dich', [TransactionController::class, 'getData']);
Route::post('/kiem-tra-quen-mk', [NhanVienController::class, 'kiemTraQuenMK']);
Route::post('/quen-mat-khau', [NhanVienController::class, 'quenMatKhau']);
Route::post('/doi-mat-khau', [NhanVienController::class, 'doiMatKhau']);
Route::post('/login', [NhanVienController::class, 'login']);
Route::post('/check', [NhanVienController::class, 'check']);
Route::delete('/remove-token/{id}', [NhanVienController::class, 'removeToken']);
Route::get('/dang-xuat', [NhanVienController::class, 'logout']);
Route::get('/dang-xuat-tat-ca', [NhanVienController::class, 'logoutAll']);
Route::get('/giao-dich', [GiaoDichController::class, 'index']);
Route::get('/danh-muc-homepage', [DanhMucController::class, 'getDataHomePage']);
Route::post('/mon-an-homepage', [MonAnController::class, 'getDataHomePage']);
Route::get('/mon-an-menu', [MonAnController::class, 'getDataMenu']);
Route::get('/bai-viet-homepage', [BaiVietController::class, 'getDataHomePage']);
Route::get('/chi-tiet-bai-viet-homepage/{id}', [BaiVietController::class, 'getDataChiTietHomePage']);
Route::get('/dat-mon-homepage/{slug_ban}/{hash_ban}', [DichVuController::class, 'datMonHomePage']);
Route::post('/chi-tiet-hoa-don-homepage', [DichVuController::class, 'getCTHDHomePage']);
Route::post('/update-chi-tiet-hoa-don-homepage', [DichVuController::class, 'updateCTHDHomePage']);
Route::post('/delete-chi-tiet-hoa-don-homepage', [DichVuController::class, 'deleteCTHDHomePage']);
Route::post('/create-chi-tiet-hoa-don-homepage', [DichVuController::class, 'createCTHDHomePage']);
Route::post('/dat-mon-bep-homepage', [DichVuController::class, 'datMonCTHDHomePage']);


Route::group(['prefix'  =>  '/admin', "middleware" => "nhanVien"], function () {

    Route::get('/dashboard', [DashboardController::class, 'getData']);
    Route::get('/thong-ke-doanh-thu/{begin}/{end}', [DashboardController::class, 'getDataThongkeDoanhThu']);
    Route::get('/thong-ke-tien-nhap-kho/{begin}/{end}', [DashboardController::class, 'getDataThongkeNhapKho']);

    Route::group(['prefix'  =>  '/danh-muc'], function () {
        Route::get('/lay-du-lieu', [DanhMucController::class, 'getData']);
        Route::get('/lay-du-lieu-all', [DanhMucController::class, 'getDataAll']);
        Route::post('/tim-danh-muc', [DanhMucController::class, 'searchDanhMuc']);
        Route::post('/tao-danh-muc', [DanhMucController::class, 'createDanhMuc']);
        Route::delete('/xoa-danh-muc/{id}', [DanhMucController::class, 'xoaDanhMuc']);
        Route::put('/cap-nhat-danh-muc', [DanhMucController::class, 'capNhatDanhMuc']);
        Route::put('/doi-trang-thai', [DanhMucController::class, 'doiTrangThaiDanhMuc']);
        Route::post('/kiem-tra-slug', [DanhMucController::class, 'kiemTraSlugDanhMuc']);
    });










    Route::group(['prefix'  =>  '/nguyen-lieu'], function () {
        Route::get('/lay-du-lieu', [NguyenLieuController::class, 'getData']);
        Route::get('/lay-du-lieu-all', [NguyenLieuController::class, 'getDataAll']);
        Route::post('/tim-nguyen-lieu', [NguyenLieuController::class, 'searchNguyenLieu']);
        Route::post('/tao-nguyen-lieu', [NguyenLieuController::class, 'createNguyenLieu']);
        Route::delete('/xoa-nguyen-lieu/{id}', [NguyenLieuController::class, 'xoaNguyenLieu']);
        Route::put('/cap-nhat-nguyen-lieu', [NguyenLieuController::class, 'capNhatNguyenLieu']);
        Route::put('/doi-trang-thai', [NguyenLieuController::class, 'doiTrangThaiNguyenLieu']);
        Route::post('/kiem-tra-slug', [NguyenLieuController::class, 'kiemTraSlugNguyenLieu']);
        Route::post('/kiem-tra-slug-update', [NguyenLieuController::class, 'kiemTraSlugNguyenLieuUpdate']);
    });

    Route::group(['prefix'  =>  '/nhap-kho'], function () {
        Route::get('/lay-du-lieu', [NhapKhoController::class, 'getData']);
        Route::post('/them-nguyen-lieu', [NhapKhoController::class, 'addNguyenLieu']);
        Route::delete('/xoa-nguyen-lieu/{id}', [NhapKhoController::class, 'xoaNguyenLieu']);
        Route::put('/cap-nhat-nhap-kho', [NhapKhoController::class, 'updateNhapKho']);
        Route::post('/tao-hoa-don-nhap-kho', [NhapKhoController::class, 'createHoaDonNhapKho']);
        Route::post('/data-hoa-don-nhap-kho', [NhapKhoController::class, 'getDataHoaDonNhapKho']);
        Route::post('/data-chi-tiet-hoa-don-nhap-kho', [NhapKhoController::class, 'getDataChiTietHoaDonNhapKho']);
    });

    Route::group(['prefix'  =>  '/nha-cung-cap'], function () {
        Route::get('/lay-du-lieu', [NhaCungCapController::class, 'getData']);
        Route::get('/lay-du-lieu-all', [NhaCungCapController::class, 'getDataAll']);
        Route::post('/tim-nha-cung-cap', [NhaCungCapController::class, 'searchNhaCungCap']);
        Route::post('/tao-nha-cung-cap', [NhaCungCapController::class, 'createNhaCungCap']);
        Route::delete('/xoa-nha-cung-cap/{id}', [NhaCungCapController::class, 'xoaNhaCungCap']);
        Route::put('/cap-nhat-nha-cung-cap', [NhaCungCapController::class, 'capNhatNhaCungCap']);
        Route::put('/doi-trang-thai', [NhaCungCapController::class, 'doiTrangThaiNhaCungCap']);
    });

    Route::group(['prefix'  =>  '/mon-an'], function () {
        Route::get('/lay-du-lieu', [MonAnController::class, 'getData']);
        Route::post('/tim-mon-an', [MonAnController::class, 'searchMonAn']);
        Route::post('/tao-mon-an', [MonAnController::class, 'createMonAn']);
        Route::delete('/xoa-mon-an/{id}', [MonAnController::class, 'xoaMonAn']);
        Route::post('/cap-nhat-mon-an', [MonAnController::class, 'capNhatMonAn']);
        Route::put('/doi-trang-thai', [MonAnController::class, 'doiTrangThaiMonAn']);
        Route::post('/kiem-tra-slug', [MonAnController::class, 'kiemTraSlugMonAn']);
        Route::post('/kiem-tra-slug-update', [MonAnController::class, 'kiemTraSlugMonAnUpdate']);
    });

    Route::group(['prefix'  =>  '/dich-vu'], function () {
        Route::post('/lay-du-lieu-ban-theo-khu-vuc', [DichVuController::class, 'getDataTheoKhuVuc']);
        Route::get('/lay-du-lieu-mon-an', [DichVuController::class, 'getDataMonAn']);
        Route::post('/mo-ban', [DichVuController::class, 'moBan']);
        Route::post('/them-mon-an', [DichVuController::class, 'themMonAn']);
        Route::post('/get-chi-tiet', [DichVuController::class, 'getChiTietBanHang']);
        Route::post('/update-chi-tiet', [DichVuController::class, 'updateChiTietBanHang']);
        Route::post('/delete-chi-tiet', [DichVuController::class, 'deleteChiTietBanHang']);
        Route::post('/thanh-toan', [DichVuController::class, 'thanhToan']);
        Route::post('/danh-sach-mon-theo-id-ban', [DichVuController::class, 'getDanhSachMonTheoIdBan']);
        Route::post('/chuyen-mon', [DichVuController::class, 'chuyenMonQuaBanKhac']);
        Route::post('/bill/print', [DichVuController::class, 'printBill']);
        Route::post('/in-bep', [DichVuController::class, 'InBep']);
        Route::get('/bep/lay-du-lieu', [DichVuController::class, 'getDataBep']);
        Route::post('/bep/update', [DichVuController::class, 'updateBep']);
    });

    Route::group(['prefix'  =>  '/hoa-don'], function () {
        Route::post('/lay-du-lieu', [HoaDonBanHangController::class, 'getData']);
        Route::post('/chi-tiet-hoa-don', [HoaDonBanHangController::class, 'chiTietHoaDon']);
        Route::post('/data-bill', [HoaDonBanHangController::class, 'dataBill']);
    });



});
