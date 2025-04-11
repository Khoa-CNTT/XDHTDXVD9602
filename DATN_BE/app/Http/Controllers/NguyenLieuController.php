<?php

namespace App\Http\Controllers;

use App\Http\Requests\NguyenLieu\CreateNguyenLieuRequest;
use App\Http\Requests\NguyenLieu\UpdateNguyenLieuRequest;
use App\Models\NguyenLieu;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NguyenLieuController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 45;
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

        $data   = NguyenLieu::select('id',  'ten_nguyen_lieu', 'slug_nguyen_lieu', 'so_luong', 'gia', 'dvt', 'tinh_trang')
                            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'nguyen_lieu'  =>  $data,
        ]);
    }

    public function getDataAll()
    {
        $id_chuc_nang = 46;
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

        $data   = NguyenLieu::where('tinh_trang', 1)
                            ->select('id',  'ten_nguyen_lieu', 'slug_nguyen_lieu', 'so_luong', 'gia', 'dvt', 'tinh_trang')
                            ->get(); // get là ra 1 danh sách

        return response()->json([
            'nguyen_lieu'  =>  $data,
        ]);
    }

    public function searchNguyenLieu(Request $request)
    {
        $id_chuc_nang = 47;
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

        $key = '%' . $request->abc . '%';

        $data   = NguyenLieu::where('ten_nguyen_lieu', 'like', $key)
                            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'nguyen_lieu'  =>  $data,
        ]);
    }

    public function createNguyenLieu(CreateNguyenLieuRequest $request)
    {
        $id_chuc_nang = 48;
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

        NguyenLieu::create([
            'ten_nguyen_lieu'       => $request->ten_nguyen_lieu,
            'slug_nguyen_lieu'      => $request->slug_nguyen_lieu,
            'so_luong'              => $request->so_luong,
            'gia'                   => $request->gia,
            'dvt'                   => $request->dvt,
            'tinh_trang'            => $request->tinh_trang,
        ]);

        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới nguyên liệu thành công!',
        ]);
    }
    public function xoaNguyenLieu($id)
    {
        $id_chuc_nang = 49;
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

        try {
            NguyenLieu::where('id', $id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa nguyên liệu thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function capNhatNguyenLieu(UpdateNguyenLieuRequest $request)
    {
        $id_chuc_nang = 50;
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

        try {
            NguyenLieu::where('id', $request->id)
                ->update([
                    'ten_nguyen_lieu'       => $request->ten_nguyen_lieu,
                    'slug_nguyen_lieu'      => $request->slug_nguyen_lieu,
                    'so_luong'              => $request->so_luong,
                    'gia'                   => $request->gia,
                    'dvt'                   => $request->dvt,
                    'tinh_trang'            => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công nguyên liệu ' . $request->ten_nguyen_lieu,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiNguyenLieu(Request $request)
    {
        $id_chuc_nang = 51;
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

        try {
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            NguyenLieu::where('id', $request->id)
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

    public function kiemTraSlugNguyenLieu(Request $request)
    {
        $id_chuc_nang = 52;
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

        $nguyen_lieu = NguyenLieu::where('slug_nguyen_lieu', $request->slug)->first();

        if(!$nguyen_lieu) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Nguyên Liệu phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Nguyên Liệu Đã Tồn Tại!',
            ]);
        }
    }

    public function kiemTraSlugNguyenLieuUpdate(Request $request)
    {
        $id_chuc_nang = 53;
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

        $chuyen_muc = NguyenLieu::where('slug_nguyen_lieu', $request->slug)
                                     ->where('id', '<>' , $request->id)
                                     ->first();

        if(!$chuyen_muc) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Nguyên Liệu phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Nguyên Liệu Đã Tồn Tại!',
            ]);
        }
    }
}
