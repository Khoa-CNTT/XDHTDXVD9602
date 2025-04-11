<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CreateKhuVucRequest;
use App\Http\Requests\KhuVuc\UpdateKhuVucRequest;
use App\Models\Ban;
use App\Models\KhuVuc;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KhuVucController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 35;
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

        $data   = KhuVuc::paginate(5); // get là ra 1 danh sách

        return response()->json([
            'khu_vuc'  =>  $data,
        ]);
    }

    public function getDataAll()
    {
        $id_chuc_nang = 36;
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

        $data   = KhuVuc::where('tinh_trang', 1)->get(); // get là ra 1 danh sách

        return response()->json([
            'khu_vuc'  =>  $data,
        ]);
    }

    public function getDataHoatDong()
    {
        $id_chuc_nang = 37;
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

        $data   = KhuVuc::where('tinh_trang', 1)->get(); // get là ra 1 danh sách

        return response()->json([
            'khu_vuc'  =>  $data,
        ]);
    }

    public function searchKhuVuc(Request $request)
    {
        $id_chuc_nang = 38;
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

        $key = "%" . $request->abc . "%";

        $data   = KhuVuc::where('ten_khu', 'like', $key)
            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'khu_vuc'  =>  $data,
        ]);
    }

    public function createKhuVuc(CreateKhuVucRequest $request)
    {
        $id_chuc_nang = 39;
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

        KhuVuc::create([
            'ten_khu'           => $request->ten_khu,
            'slug_khu'          => $request->slug_khu,
            'tinh_trang'        => $request->tinh_trang,
        ]);

        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới khu vực thành công!',
        ]);
    }

    public function xoaKhuVuc($id)
    {
        $id_chuc_nang = 40;
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
            $ban = Ban::where('id_khu_vuc', $id)->get();
            if (count($ban) > 0) {
                return response()->json([
                    'status'            =>   false,
                    'message'           =>   'Khu Vực Này Có Bàn!',
                ]);
            } else {
                KhuVuc::where('id', $id)->delete();
                return response()->json([
                    'status'            =>   true,
                    'message'           =>   'Xóa khu vực thành công!',
                ]);
            }
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function capNhatKhuVuc(UpdateKhuVucRequest $request)
    {
        $id_chuc_nang = 41;
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
            KhuVuc::where('id', $request->id)
                ->update([
                    'ten_khu'       => $request->ten_khu,
                    'slug_khu'      => $request->slug_khu,
                    'tinh_trang'    => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật tên khu thành ' . $request->ten_khu,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function doiTrangThaiKhuVuc(Request $request)
    {
        $id_chuc_nang = 42;
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
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            KhuVuc::where('id', $request->id)
                ->update([
                    'tinh_trang'  => $tinh_trang_moi,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã đổi trạng thái thành công',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function kiemTraSlugKhuVuc(Request $request)
    {
        $id_chuc_nang = 43;
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

        $khu_vuc = KhuVuc::where('slug_khu', $request->slug)->first();

        if (!$khu_vuc) {
            return response()->json([
                'status'    => true,
                'message'   => 'Tên Khu Vực có thể dùng được!'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tên Khu Vực đã tồn tại!'
            ]);
        }
    }

    public function kiemTraSlugKhuVucUpdate(Request $request)
    {
        $id_chuc_nang = 44;
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

        $chuyen_muc = KhuVuc::where('slug_khu', $request->slug)
            ->where('id', '<>', $request->id)
            ->first();

        if (!$chuyen_muc) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Khu Vực phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Khu Vực Đã Tồn Tại!',
            ]);
        }
    }
}
