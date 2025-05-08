<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMuc\CreateDanhMucRequest;
use App\Http\Requests\DanhMuc\UpdateDanhMucRequest;
use App\Models\ChucVu;
use App\Models\DanhMuc;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DanhMucController extends Controller
{
    public function getDataHomePage()
    {
        $data   = DanhMuc::where('tinh_trang', 1)->get();
        return response()->json([
            'danh_muc'  =>  $data,
        ]);
    }

    public function getData()
    {
        $id_chuc_nang = 1;
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

        $check = Auth::guard('sanctum')->check();
        if($check == false) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn chưa login!',
            ], 401);
        }

        $data   = DanhMuc::select('id', 'icon', 'ten_danh_muc', 'slug_danh_muc', 'tinh_trang', 'id_danh_muc_cha')
                         ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'danh_muc'  =>  $data,
        ]);
    }

    public function getDataAll()
    {
        $id_chuc_nang = 2;
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

        // $check = Auth::guard('sanctum')->check();
        // if($check == false) {
        //     return response()->json([
        //         'status'    =>  0,
        //         'message'   =>  'Bạn chưa login!',
        //     ], 401);
        // }

        $data   = DanhMuc::where('tinh_trang', 1)
                         ->select('id', 'ten_danh_muc', 'slug_danh_muc', 'tinh_trang', 'id_danh_muc_cha')
                         ->get(); // get là ra 1 danh sách

        return response()->json([
            'danh_muc'  =>  $data,
        ]);
    }

    public function searchDanhMuc(Request $request)
    {
        $id_chuc_nang = 3;
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

        $key = "%" . $request->abc . "%";

        $data   = DanhMuc::select('id', 'ten_danh_muc', 'slug_danh_muc', 'tinh_trang', 'id_danh_muc_cha')
            ->where('ten_danh_muc', 'like', $key)
            ->paginate(5);

        return response()->json([
            'danh_muc'  =>  $data,
        ]);
    }

    public function createDanhMuc(CreateDanhMucRequest $request)
    {
        $id_chuc_nang = 4;
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

        DanhMuc::create([
            'icon'              => $request->icon,
            'ten_danh_muc'      => $request->ten_danh_muc,
            'slug_danh_muc'     => $request->slug_danh_muc,
            'id_danh_muc_cha'   => $request->id_danh_muc_cha,
            'tinh_trang'        => $request->tinh_trang,
        ]);

        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới danh mục thành công!',
        ]);
    }
    public function xoaDanhMuc($id)
    {
        $id_chuc_nang = 5;
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
            DanhMuc::where('id', $id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa danh mục thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function capNhatDanhMuc(UpdateDanhMucRequest $request)
    {
        $id_chuc_nang = 6;
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
            DanhMuc::where('id', $request->id)
                ->update([
                    'icon'               => $request->icon,
                    'ten_danh_muc'       => $request->ten_danh_muc,
                    'slug_danh_muc'      => $request->slug_danh_muc,
                    'id_danh_muc_cha'    => $request->id_danh_muc_cha,
                    'tinh_trang'         => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công danh mục ' . $request->ten_danh_muc,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiDanhMuc(Request $request)
    {
        $id_chuc_nang = 7;
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
            DanhMuc::where('id', $request->id)
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

    public function kiemTraSlugDanhMuc(Request $request)
    {
        $id_chuc_nang = 8;
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

        $danh_muc = DanhMuc::where('slug_danh_muc', $request->slug)->first();

        if(!$danh_muc) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Danh Mục phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Danh Mục Đã Tồn Tại!',
            ]);
        }
    }

    public function kiemTraSlugDanhMucUpdate(Request $request)
    {
        $id_chuc_nang = 9;
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

        $danh_muc= DanhMuc::where('slug_danh_muc', $request->slug)
            ->where('id', '<>', $request->id)
            ->first();

        if (!$danh_muc) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Danh Mục phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Danh Mục Đã Tồn Tại!',
            ]);
        }
    }
}
