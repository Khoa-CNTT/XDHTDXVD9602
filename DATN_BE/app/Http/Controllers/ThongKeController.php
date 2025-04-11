<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDonBanHang;
use App\Models\HoaDonBanHang;
use App\Models\HoaDonNhapKho;
use App\Models\NhapKho;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function getDataThongke1(Request $request) // Thống kê số tiền bán ra theo ngày
    {
        $id_chuc_nang = 97;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                                ->where('id_chuc_nang', $id_chuc_nang)
                                ->first();
            if(!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = HoaDonBanHang::where('is_done', 1)
                             ->whereDate('created_at', ">=", $request->begin)
                             ->whereDate('created_at', "<=", $request->end)
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

    public function getDataThongke2(Request $request) // Thống kê 7 Nguyên Liệu được nhập kho nhiều nhất từ ngày đến ngày
    {
        $id_chuc_nang = 98;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                                ->where('id_chuc_nang', $id_chuc_nang)
                                ->first();
            if(!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = NhapKho::join('hoa_don_nhap_khos', 'hoa_don_nhap_khos.id', 'nhap_khos.id_hoa_don_nhap_kho')
                        ->join('nguyen_lieus', 'nguyen_lieus.id', 'nhap_khos.id_nguyen_lieu')
                        ->whereDate('hoa_don_nhap_khos.created_at', ">=", $request->begin)
                        ->whereDate('hoa_don_nhap_khos.created_at', "<=", $request->end)
                        ->select(
                            DB::raw("SUM(nhap_khos.so_luong) as total"),
                            'nguyen_lieus.ten_nguyen_lieu'
                        )
                        ->groupBy('nguyen_lieus.ten_nguyen_lieu')
                        ->get();

        $list_lable = [];
        $list_data  = [];

        foreach ($data as $key => $value) {
            array_push($list_data, $value->total);
            array_push($list_lable, $value->ten_nguyen_lieu);
        }

        return response()->json([
            'list_lable' => $list_lable,
            'list_data'  => $list_data,
        ]);
    }

    public function getDataThongke3(Request $request) // Thống kê 7 món ăn được order nhiều nhất từ ngày đến ngày
    {
        $id_chuc_nang = 99;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                                ->where('id_chuc_nang', $id_chuc_nang)
                                ->first();
            if(!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = ChiTietHoaDonBanHang::join('hoa_don_ban_hangs', 'hoa_don_ban_hangs.id', 'chi_tiet_hoa_don_ban_hangs.id_hoa_don')
                                    ->join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
                                    ->whereDate('hoa_don_ban_hangs.created_at', ">=", $request->begin)
                                    ->whereDate('hoa_don_ban_hangs.created_at', "<=", $request->end)
                                    ->select(
                                        DB::raw("SUM(chi_tiet_hoa_don_ban_hangs.so_luong) as total"),
                                        'mon_ans.ten_mon'
                                    )
                                    ->groupBy('mon_ans.ten_mon')
                                    ->get();
            $list_lable = [];
            $list_data  = [];

            foreach ($data as $key => $value) {
                array_push($list_data, $value->total);
                array_push($list_lable, $value->ten_mon);
            }
        return response()->json([
            'list_lable' => $list_lable,
            'list_data'  => $list_data,
        ]);
    }

    public function getDataThongke4(Request $request) // Thống kê số tiền bán ra theo ngày
    {
        $id_chuc_nang = 100;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                                ->where('id_chuc_nang', $id_chuc_nang)
                                ->first();
            if(!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = HoaDonNhapKho::whereDate('created_at', ">=", $request->begin)
                             ->whereDate('created_at', "<=", $request->end)
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
