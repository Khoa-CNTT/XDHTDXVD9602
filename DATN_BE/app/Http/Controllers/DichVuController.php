<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\TaoHoaDonRequest;
use App\Http\Requests\HoaDon\UpdateChiTietHoaDonRequest;
use App\Http\Requests\UpdateChiTIetHoaDonKhachHangRequest;
use App\Models\Ban;
use App\Models\ChiTietHoaDonBanHang;
use App\Models\DanhMuc;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DichVuController extends Controller
{
    public function datMonCTHDHomePage(Request $request)
    {
        $hoaDonBanHang   = HoaDonBanHang::where('ma_hoa_don', $request->ma_hoa_don)->first();
        if ($hoaDonBanHang && $hoaDonBanHang->is_done == 0) {
            $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDonBanHang->id)->where('is_in_bep', 0)->get();
            if (count($chiTiet) > 0) {
                ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDonBanHang->id)
                    ->update([
                        'is_in_bep'     => 1,
                    ]);
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã đặt món thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Không có món ăn được thêm mới để đặt món!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function createCTHDHomePage(Request $request)
    {
        $hoaDon = HoaDonBanHang::where('ma_hoa_don', $request->ma_hoa_don)->first();
        if (!$hoaDon || $hoaDon->is_done == 1) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        } else {
            // Kiểm tra xem đã có món ăn với is_in_bep == 0 và cùng id_mon_an và id_hoa_don hay chưa
            $timMonAnNgoaiBep = ChiTietHoaDonBanHang::where('is_done', 0)
                ->where('id_mon_an', $request->id_mon_an)
                ->where('id_hoa_don', $hoaDon->id)
                ->where('is_in_bep', 0)
                ->first();

            if ($timMonAnNgoaiBep) {
                // Nếu có món ăn ngoài bếp, cập nhật thông tin của nó thay vì tạo mới
                $timMonAnNgoaiBep->so_luong += 1;
                $tienGiam = $timMonAnNgoaiBep->so_luong * $timMonAnNgoaiBep->don_gia / 100 * $timMonAnNgoaiBep->phan_tram_giam;

                $timMonAnNgoaiBep->thanh_tien = ($timMonAnNgoaiBep->don_gia * $timMonAnNgoaiBep->so_luong) - $tienGiam;
                $timMonAnNgoaiBep->save();
            } else {
                // Nếu không có món ăn ngoài bếp, tạo mới
                $chiTiet = ChiTietHoaDonBanHang::create([
                    'id_hoa_don'   => $hoaDon->id,
                    'id_mon_an'    => $request->id_mon_an,
                    'so_luong'     => 1,
                    'don_gia'      => $request->don_gia,
                    'thanh_tien'   => $request->don_gia,
                ]);
            }

            // Tính lại tổng tiền của hóa đơn
            $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)->get();
            $tong_tien = 0;
            foreach ($chiTiet as $key => $value) {
                $tong_tien += $value->thanh_tien;
            }

            return response()->json([
                'status'    => 1,
                'message'   => isset($timMonAnNgoaiBep) ? 'Cập nhật món thành công!' : 'Thêm món thành công!',
                'tong_tien' => $tong_tien,
            ]);
        }
    }

    public function deleteCTHDHomePage(Request $request)
    {
        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->where('is_done', 0)->first();
        $hoaDon = HoaDonBanHang::where('id', $chiTiet->id_hoa_don)->where('is_done', 0)->first();
        if ($hoaDon) {
            if ($chiTiet) {
                $chiTiet->delete();
                $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->get();
                $tong_tien = 0;
                foreach ($data as $key => $value) {
                    $tong_tien = $tong_tien + $value->thanh_tien;
                }
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Xóa thành công!',
                    'tong_tien' => $tong_tien,
                ]);
            }
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bàn đã được thanh toán!',
            ]);
        }
    }

    public function updateCTHDHomePage(UpdateChiTIetHoaDonKhachHangRequest $request)
    {
        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->where('is_done', 0)->first();
        $hoaDon = HoaDonBanHang::where('id', $chiTiet->id_hoa_don)->where('is_done', 0)->first();
        if ($hoaDon) {
            if ($chiTiet) {
                $chiTiet->so_luong =  $request->so_luong;
                $chiTiet->don_gia =  $request->don_gia;
                $chiTiet->thanh_tien =  ($request->so_luong * $request->don_gia);
                $chiTiet->ghi_chu =  $request->ghi_chu;
                $chiTiet->update();
                $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->get();
                $tong_tien = 0;
                foreach ($data as $key => $value) {
                    $tong_tien = $tong_tien + $value->thanh_tien;
                }
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Cập nhật thành công!',
                    'tong_tien' => $tong_tien,
                ]);
            }
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bàn đã được thanh toán!',
            ]);
        }
    }

    public function getCTHDHomePage(Request $request)
    {
        // return response()->json($request->all());
        $hoaDon = HoaDonBanHang::where('ma_hoa_don', $request->ma_hoa_don)->where('is_done', 0)->first();
        if ($hoaDon) {
            $chiTiet = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
                ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $hoaDon->id)
                ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
                ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.ten_mon')
                ->get();

            $chiTietChinh = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
                ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $hoaDon->id)
                ->where('chi_tiet_hoa_don_ban_hangs.is_in_bep', 1)
                ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
                ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.ten_mon')
                ->get();
            $count = 0;
            $tong_tien = 0;
            $tong_tien_thu = 0;
            foreach ($chiTiet as $key => $value) {
                $tong_tien  = $tong_tien + $value->thanh_tien;
                $count      = $count + $value->so_luong;
            }

            foreach ($chiTietChinh as $key => $value) {
                $tong_tien_thu  = $tong_tien_thu + $value->thanh_tien;
            }
            return response()->json([
                'status'   =>   true,
                'data'    => $chiTiet,
                'tong_tien' => $tong_tien,
                'tong_tien_thu' => $tong_tien_thu,
                'count'     => $count,
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bàn đã được thanh toán!',
            ]);
        }
    }

    public function datMonHomePage($slug_ban, $hash_ban)
    {
        $ban = Ban::where('slug_ban', $slug_ban)->where('hash_ban', $hash_ban)->where('tinh_trang', 1)->first();
        if ($ban) {
            if ($ban->is_mo_ban == 0) {
                return response()->json([
                    'status'            =>   false,
                    'message'           =>   'Bàn đã được thanh toán!',
                ]);
            } else {
                $hoaDon = HoaDonBanHang::where('ma_hoa_don', $ban->hoa_don_hien_tai)->first();
                $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)->get();
                $count = 0;
                foreach ($chiTiet as $key => $value) {
                    $count      = $count + $value->so_luong;
                }
                $monAn = MonAn::where('tinh_trang', 1)->get();
                $danhMuc   = DanhMuc::where('tinh_trang', 1)->get();
                return response()->json([
                    'status'            =>   true,
                    'ban'               =>   $ban,
                    'mon_an'            =>   $monAn,
                    'danh_muc'          =>   $danhMuc,
                    'count'             =>   $count,
                ]);
            }
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bàn chưa được mở',
            ]);
        }
    }

    public function printBill(Request $request)
    {
        $id_chuc_nang = 86;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = $request->all();
        $bill = HoaDonBanHang::join('bans', 'bans.id', 'hoa_don_ban_hangs.id_ban')
            ->join('nhan_viens', 'nhan_viens.id', 'hoa_don_ban_hangs.id_nhan_vien')
            ->where('hoa_don_ban_hangs.id', $data['id'])
            ->select('bans.ten_ban', 'nhan_viens.ho_va_ten', 'hoa_don_ban_hangs.*')
            ->first();
        if ($bill) {
            $chiTietHoaDon = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
                ->where('id_hoa_don', $bill->id)
                ->where('chi_tiet_hoa_don_ban_hangs.is_in_bep', 1)
                ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
                ->select('mon_ans.ten_mon', 'chi_tiet_hoa_don_ban_hangs.*')
                ->get();

            if (count($chiTietHoaDon) > 0) {
                $bill->tong_tien_truoc_giam = $data['tong_tien_truoc_giam'];
                $bill->phan_tram_giam = $data['phan_tram_giam'];
                $bill->tien_thuc_nhan = $data['tien_thuc_nhan'];
                $bill->ghi_chu = $data['ghi_chu'];
                $bill->save();
                return response()->json([
                    'status' =>   true,
                    'bill' => $bill,
                    'chiTietHoaDon' => $chiTietHoaDon,
                ]);
            } else {
                return response()->json([
                    'status'            =>   false,
                    'message'           =>   'Không có món ăn hoàn thành để in hóa đơn',
                ]);
            }
        }
    }

    public function chuyenMonQuaBanKhac(Request $request)
    {
        $id_chuc_nang = 85;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $so_luong_chuyen    =   $request->so_luong_chuyen;
        $id_hoa_don_nhan    =   $request->id_hoa_don_nhan;

        $hoaDon = HoaDonBanHang::find($request->id_hoa_don);
        if ($request->id_ban_nhan > 0) {
            if ($hoaDon && $hoaDon->is_done == 0) {
                // Trường hợp a
                if ($so_luong_chuyen > 0 && $so_luong_chuyen == $request->so_luong) {
                    $chiTietBanHang                         = ChiTietHoaDonBanHang::find($request->id);
                    $chiTietBanHang->id_hoa_don             = $id_hoa_don_nhan;
                    $dau_cach                               =  $chiTietBanHang->ghi_chu ? ": " : '';
                    $chiTietBanHang->ghi_chu                =  'Chuyển món từ bàn ' . $request->id_ban . ' ' . ' có hóa đơn ' . $hoaDon->ma_hoa_don . ' sang' . $dau_cach .  $chiTietBanHang->ghi_chu;
                    $chiTietBanHang->save();

                    return response()->json([
                        'status'    => 1,
                        'message'   => 'Đã chuyển món thành công!',
                    ]);
                } else if ($so_luong_chuyen > 0 && $so_luong_chuyen < $request->so_luong) {
                    $chiTietBanHang                         = ChiTietHoaDonBanHang::find($request->id);
                    $don_gia                                = $chiTietBanHang->don_gia;
                    $chiTietBanHang->so_luong               -= $so_luong_chuyen;
                    $phan_tram_giam                         = $chiTietBanHang->phan_tram_giam;
                    $tienGiam = $chiTietBanHang->so_luong * $don_gia / 100 * $phan_tram_giam;
                    $chiTietBanHang->thanh_tien =  ($chiTietBanHang->so_luong * $don_gia) - $tienGiam;
                    $chiTietBanHang->save();

                    $dau_cach       =  $chiTietBanHang->ghi_chu ? ": " : '';

                    ChiTietHoaDonBanHang::create([
                        'id_hoa_don'                =>  $id_hoa_don_nhan,
                        'id_mon_an'                 =>  $chiTietBanHang->id_mon_an,
                        'so_luong'                  =>  $so_luong_chuyen,
                        'don_gia'                   =>  $don_gia,
                        'phan_tram_giam'            =>  $chiTietBanHang->phan_tram_giam,
                        'thanh_tien'                =>  $chiTietBanHang->thanh_tien,
                        'ghi_chu'                   =>  'Chuyển món từ bàn' . $request->id_ban . ' ' . ' có hóa đơn ' . $chiTietBanHang->id_hoa_don . ' sang' . $dau_cach .  $chiTietBanHang->ghi_chu,
                    ]);

                    return response()->json([
                        'status'    => 1,
                        'message'   => 'Đã chuyển món thành công!',
                    ]);
                } else {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Dữ liệu không chính xác!',
                    ]);
                }
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Hóa đơn này đã tính tiền!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Chưa chọn bàn để chuyển',
            ]);
        }
    }

    public function getDanhSachMonTheoIdBan(Request $request)
    {
        $id_chuc_nang = 84;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }
        // B1: Tìm hóa đơn mà có bàn id = 7 đang hoạt động
        $hoaDon     = HoaDonBanHang::where('id_ban', $request->id_ban)->where('is_done', 0)->first();
        if ($hoaDon) {
            $data   = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
                ->where('id_hoa_don', $hoaDon->id)
                ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.ten_mon')
                ->get();

            return response()->json([
                'status'    => 1,
                'data'      => $data,
                'id_hd'     => $hoaDon->id,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function getDataTheoKhuVuc(Request $request)
    {
        $id_chuc_nang = 76;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = Ban::where('tinh_trang', 1)
            ->where('id_khu_vuc', $request->id)
            ->get();

        if ($data) {
            return response()->json([
                'data'    => $data,
            ]);
        }
    }

    public function getDataMonAn()
    {
        $id_chuc_nang = 77;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = MonAn::where('tinh_trang', 1)->get();

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function moBan(Request $request)
    {
        $id_chuc_nang = 78;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $ban = Ban::where('id', $request->id)->first();

        if ($ban) {
            $hoaDon = HoaDonBanHang::where('is_done', 0)
                ->where('id_ban', $ban->id)
                ->first();
            if ($hoaDon) {
                $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)->get();
                $chiTietChinh = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)
                    ->where('is_in_bep', 1)
                    ->get();
                $tong_tien = 0;
                $tong_tien_thu = 0;
                foreach ($chiTiet as $key => $value) {
                    $tong_tien = $tong_tien + $value->thanh_tien;
                }
                foreach ($chiTietChinh as $key => $value) {
                    $tong_tien_thu = $tong_tien_thu + $value->thanh_tien;
                }
                return response()->json([
                    'status'               => 2,
                    'hoa_don'              => $hoaDon,
                    'id_hoa_don_ban_hang'  => $hoaDon->id,
                    'tong_tien'            => $tong_tien,
                    'tong_tien_thu'        => $tong_tien_thu,
                    'id_ban'               => $ban->id,
                    'ten_ban'              => $ban->ten_ban,
                ]);
            } else {
                $user = Auth::guard('sanctum')->user();
                $hoaDon = HoaDonBanHang::create([
                    'id_ban' => $request->id,
                    'id_nhan_vien' => $user->currentAccessToken()->tokenable_id,
                ]);

                $hoaDon['ma_hoa_don'] = "HDFY2110" . $hoaDon['id'];

                $hoaDon->save();

                if ($hoaDon) {
                    $ban->is_mo_ban = 1;
                    $ban->hoa_don_hien_tai = $hoaDon['ma_hoa_don'];
                    $ban->save();
                    return response()->json([
                        'status'                => 1,
                        'message'               => 'Đã mở bàn thành công!',
                        'hoa_don'               => $hoaDon,
                        'id_hoa_don_ban_hang'   => $hoaDon->id,
                        'id_ban'                => $ban->id,
                        'ten_ban'               => $ban->ten_ban,

                    ]);
                }
            }
        }
    }

    public function themMonAn(Request $request)
    {
        $id_chuc_nang = 79;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $hoaDon = HoaDonBanHang::where('id', $request->id_hoa_don)->first();
        if ($hoaDon->is_done == 1) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        } else {
            // Kiểm tra xem đã có món ăn với is_in_bep == 0 và cùng id_mon_an và id_hoa_don hay chưa
            $timMonAnNgoaiBep = ChiTietHoaDonBanHang::where('is_done', 0)
                ->where('id_mon_an', $request->id_mon_an)
                ->where('id_hoa_don', $request->id_hoa_don)
                ->where('is_in_bep', 0)
                ->first();

            if ($timMonAnNgoaiBep) {
                // Nếu có món ăn ngoài bếp, cập nhật thông tin của nó thay vì tạo mới
                $timMonAnNgoaiBep->so_luong += 1;
                $tienGiam = $timMonAnNgoaiBep->so_luong * $timMonAnNgoaiBep->don_gia / 100 * $timMonAnNgoaiBep->phan_tram_giam;

                $timMonAnNgoaiBep->thanh_tien = ($timMonAnNgoaiBep->don_gia * $timMonAnNgoaiBep->so_luong) - $tienGiam;
                $timMonAnNgoaiBep->save();
            } else {
                // Nếu không có món ăn ngoài bếp, tạo mới
                $chiTiet = ChiTietHoaDonBanHang::create([
                    'id_hoa_don'   => $request->id_hoa_don,
                    'id_mon_an'    => $request->id_mon_an,
                    'so_luong'     => 1,
                    'don_gia'      => $request->don_gia,
                    'thanh_tien'   => $request->don_gia,
                ]);
            }

            // Tính lại tổng tiền của hóa đơn
            $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don)->get();
            $tong_tien = 0;
            foreach ($chiTiet as $key => $value) {
                $tong_tien += $value->thanh_tien;
            }

            return response()->json([
                'status'    => 1,
                'message'   => isset($timMonAnNgoaiBep) ? 'Cập nhật món thành công!' : 'Thêm món thành công!',
                'tong_tien' => $tong_tien,
                'hoa_don'   => $hoaDon
            ]);
        }
    }


    public function getChiTietBanHang(Request $request)
    {
        $id_chuc_nang = 80;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }
        $hoaDon = HoaDonBanHang::where('id', $request->id_hoa_don)->first();
        $chiTiet = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
            ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $hoaDon->id)
            ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.ten_mon')
            ->get();

        $chiTietChinh = ChiTietHoaDonBanHang::join('mon_ans', 'mon_ans.id', 'chi_tiet_hoa_don_ban_hangs.id_mon_an')
            ->where('chi_tiet_hoa_don_ban_hangs.id_hoa_don', $hoaDon->id)
            ->where('chi_tiet_hoa_don_ban_hangs.is_in_bep', 1)
            ->where('chi_tiet_hoa_don_ban_hangs.is_done', 0)
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'mon_ans.ten_mon')
            ->get();
        $tong_tien = 0;
        $tong_tien_thu = 0;
        foreach ($chiTiet as $key => $value) {
            $tong_tien = $tong_tien + $value->thanh_tien;
        }
        foreach ($chiTietChinh as $key => $value) {
            $tong_tien_thu = $tong_tien_thu + $value->thanh_tien;
        }

        return response()->json([
            'data'                  => $chiTiet,
            'hoa_don'               => $hoaDon,
            'tong_tien'             => $tong_tien,
            'tong_tien_thu'         => $tong_tien_thu,
        ]);
    }

    public function updateChiTietBanHang(UpdateChiTietHoaDonRequest $request)
    {
        $id_chuc_nang = 81;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->first();
        $hoaDon = HoaDonBanHang::where('id', $chiTiet->id_hoa_don)->first();
        if ($chiTiet) {
            $tienGiam = $request->so_luong * $request->don_gia / 100 * $request->phan_tram_giam;
            $chiTiet->so_luong =  $request->so_luong;
            $chiTiet->don_gia =  $request->don_gia;
            $chiTiet->phan_tram_giam =  $request->phan_tram_giam;
            $chiTiet->thanh_tien =  ($request->so_luong * $request->don_gia) - $tienGiam;
            $chiTiet->ghi_chu =  $request->ghi_chu;
            $chiTiet->update();
            $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Cập nhật thành công!',
                'tong_tien' => $tong_tien,
                'hoa_don'   => $hoaDon
            ]);
        }
    }

    public function deleteChiTietBanHang(Request $request)
    {
        $id_chuc_nang = 82;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $chiTiet = ChiTietHoaDonBanHang::where('id', $request->id)->first();
        $hoaDon = HoaDonBanHang::where('id', $chiTiet->id_hoa_don)->first();
        if ($chiTiet) {
            $chiTiet->delete();
            $data = ChiTietHoaDonBanHang::where('id_hoa_don', $chiTiet->id_hoa_don)->where('is_in_bep', 1)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien = $tong_tien + $value->thanh_tien;
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Xóa thành công!',
                'tong_tien' => $tong_tien,
                'hoa_don'   => $hoaDon
            ]);
        }
    }


    public function thanhToan(TaoHoaDonRequest $request)
    {
        $id_chuc_nang = 83;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        try {
            $data = $request->all();

            $hoaDon = HoaDonBanHang::where('id', $data['id'])->first();

            if ($hoaDon) {
                $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)
                    ->where('is_in_bep', 1)
                    ->first();
                if ($chiTiet) {
                    $hoaDon->tong_tien_truoc_giam = $data['tong_tien_truoc_giam'];
                    $hoaDon->phan_tram_giam = $data['phan_tram_giam'];
                    $hoaDon->tien_thuc_nhan = $data['tien_thuc_nhan'];
                    $hoaDon->ghi_chu = $data['ghi_chu'];
                    $hoaDon->is_done = 1;
                    $hoaDon->save();
                    $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $hoaDon->id)
                        ->where('is_in_bep', 1)
                        ->get();
                    foreach ($chiTiet as $key => $value) {
                        $value->is_done = 1;
                        $value->save();
                    }
                    $ban = Ban::where('id', $hoaDon->id_ban)->first();
                    $ban->is_mo_ban = 0;
                    $ban->hoa_don_hien_tai = null;
                    $ban->save();

                    return response()->json([
                        'status'            =>   true,
                        'message'           =>   'Đã thanh toán thành công!',
                    ]);
                } else {
                    $ban = Ban::where('id', $hoaDon->id_ban)->first();
                    $ban->is_mo_ban = 0;
                    $ban->hoa_don_hien_tai = null;
                    $ban->save();
                    $hoaDon->delete();
                    return response()->json([
                        'status'            =>   false,
                        'message'           =>   'Đã đóng bàn, không có món ăn hoàn thành!',
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function InBep(Request $request)
    {
        $id_chuc_nang = 87;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $hoaDonBanHang   = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if ($hoaDonBanHang && $hoaDonBanHang->is_done == 0) {
            $chiTiet = ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don_ban_hang)->where('is_in_bep', 0)->get();
            if (count($chiTiet) > 0) {
                ChiTietHoaDonBanHang::where('id_hoa_don', $request->id_hoa_don_ban_hang)
                    ->update([
                        'is_in_bep'     => 1,
                    ]);
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã in bếp thành công!',
                    'hoa_don'   => $hoaDonBanHang,
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Không có món ăn để in bếp!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function getDataBep()
    {
        $id_chuc_nang = 88;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $data = ChiTietHoaDonBanHang::where('is_in_bep', 1)
            ->where('is_che_bien', 0)
            ->join('hoa_don_ban_hangs', 'chi_tiet_hoa_don_ban_hangs.id_hoa_don', 'hoa_don_ban_hangs.id')
            ->join('mon_ans', 'chi_tiet_hoa_don_ban_hangs.id_mon_an', 'mon_ans.id')
            ->join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
            ->select('chi_tiet_hoa_don_ban_hangs.*', 'bans.ten_ban', 'mon_ans.ten_mon', 'mon_ans.hinh_anh')
            ->orderBy('chi_tiet_hoa_don_ban_hangs.updated_at', 'asc')
            ->get();
        return response()->json([
            'status'    => 1,
            'data'   => $data,
        ]);
    }

    public function updateBep(Request $request)
    {
        $id_chuc_nang = 89;
        $user = Auth::guard('sanctum')->user();

        if ($user instanceof \App\Models\NhanVien) {
            $user_chuc_vu   = $user->id_chuc_vu;
            $check  = PhanQuyen::where('id_chuc_vu', $user_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if (!$check) {
                return response()->json([
                    'status'  =>  false,
                    'message' =>  'Bạn không có quyền chức năng này'
                ]);
            }
        }

        $check = ChiTietHoaDonBanHang::find($request->id);

        if ($check && $check->is_che_bien == 0) {
            $check->is_che_bien         = 1;
            $check->save();

            return response()->json([
                'status'    => true,
                'message'   => 'Đã hoàn thành món ăn',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hệ thống đã có sự cố',
            ]);
        }
    }
}
