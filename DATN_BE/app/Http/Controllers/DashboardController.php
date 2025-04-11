<?php

namespace App\Http\Controllers;

use App\Models\HoaDonBanHang;
use App\Models\HoaDonNhapKho;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getData()
    {
        $nhap_nho = HoaDonNhapKho::get();
        $tong_tien_nk = 0;
        foreach ($nhap_nho as $key => $value) {
            $tong_tien_nk = $tong_tien_nk + $value->tong_tien;
        }

        $hoa_don = HoaDonBanHang::where('is_done', 1)->get();
        $tong_hd = count($hoa_don);
        $tong_tien_hd = 0;
        foreach ($hoa_don as $key => $value) {
            $tong_tien_hd = $tong_tien_hd + $value->tien_thuc_nhan;
        }

        $nhan_vien = NhanVien::where('tinh_trang', 1)->get();
        $tong_nv = count($nhan_vien);

        return response()->json([
            'tong_tien_nk'  =>  $tong_tien_nk,
            'tong_tien_hd'  =>  $tong_tien_hd,
            'tong_hd'       =>  $tong_hd,
            'tong_nv'       =>  $tong_nv,
        ]);
    }

    public function getDataThongkeDoanhThu($begin, $end) // Thống kê số tiền bán ra theo ngày
    {
        $data = HoaDonBanHang::where('is_done', 1)
                             ->whereDate('created_at', ">=", $begin)
                             ->whereDate('created_at', "<=", $end)
                             ->select(
                                DB::raw("SUM(tien_thuc_nhan) as total"),
                                DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as lable"),
                             )
                             ->groupBy('lable')
                             ->orderBy(DB::raw("STR_TO_DATE(lable, '%d/%m/%Y')"), 'asc')
                             ->get();

        $list_lable = [];
        $list_data  = [];

        foreach ($data as $key => $value) {
            array_push($list_data, $value->total);
            array_push($list_lable, $value->lable);
        }

        return response()->json([
            'list_lable' => $list_lable,
            'list_data'  => $list_data,
        ]);
    }

    public function getDataThongkeNhapKho($begin, $end) // Thống kê số tiền bán ra theo ngày
    {
        $data = HoaDonNhapKho::whereDate('created_at', ">=", $begin)
                             ->whereDate('created_at', "<=", $end)
                             ->select(
                                DB::raw("SUM(tong_tien) as total"),
                                DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as lable"),
                             )
                             ->groupBy('lable')
                             ->orderBy(DB::raw("STR_TO_DATE(lable, '%d/%m/%Y')"), 'asc')
                             ->get();

        $list_lable = [];
        $list_data  = [];

        foreach ($data as $key => $value) {
            array_push($list_data, $value->total);
            array_push($list_lable, $value->lable);
        }

        return response()->json([
            'list_lable' => $list_lable,
            'list_data'  => $list_data,
        ]);
    }
}
