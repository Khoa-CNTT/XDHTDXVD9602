<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\CreateMonAnRequest;
use App\Http\Requests\MonAn\UpdateMonAnRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MonAnController extends Controller
{
    public function getDataMenu()
    {
        $data   = MonAn::where('tinh_trang', 1)->get();
        return response()->json([
            'mon_an'  =>  $data,
        ]);
    }

    public function getDataHomePage(Request $request)
    {
        $danh_muc = DanhMuc::where('id', $request->id)->first();
        if ($danh_muc->id_danh_muc_cha == 0) {
            $list_id_danh_muc = DanhMuc::where('id_danh_muc_cha', $request->id)
                ->select('id')
                ->get();
        } else {
            $list_id_danh_muc = DanhMuc::where('id', $request->id)
                ->select('id')
                ->get();
        }
        $data   = MonAn::where('tinh_trang', 1)->whereIn('id_danh_muc', $list_id_danh_muc)->get();

        return response()->json([
            'mon_an'  =>  $data,
        ]);
    }

    public function getData()
    {
        $id_chuc_nang = 68;
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

        $data   = MonAn::join('danh_mucs', 'danh_mucs.id', 'mon_ans.id_danh_muc')
            ->select('mon_ans.*', 'danh_mucs.ten_danh_muc')
            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'mon_an'  =>  $data,
        ]);
    }
    public function createMonAn(CreateMonAnRequest $request)
    {
        $id_chuc_nang = 69;
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
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('MonAn'), $fileName);
            $filePath = asset('MonAn/' . $fileName);
        }
        MonAn::create([
            'ten_mon'       => $request->ten_mon,
            'slug_mon'      => $request->slug_mon,
            'hinh_anh'      => $filePath,
            'gia_ban'       => $request->gia_ban,
            'tinh_trang'    => $request->tinh_trang,
            'id_danh_muc'   => $request->id_danh_muc,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Tạo món ăn thành công!',
        ]);
    }
    public function searchMonAn(Request $request)
    {
        $id_chuc_nang = 70;
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

        $data   = MonAn::join('danh_mucs', 'danh_mucs.id', 'mon_ans.id_danh_muc')
            ->where('mon_ans.ten_mon', 'like', $key)
            ->select('mon_ans.*', 'danh_mucs.ten_danh_muc')
            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'mon_an'  =>  $data,
        ]);
    }
    public function xoaMonAn($id)
    {
        $id_chuc_nang = 71;
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
            MonAn::where('id', $id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa món ăn nhập kho thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function capNhatMonAn(UpdateMonAnRequest $request)
    {
        $id_chuc_nang = 72;
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
            $monAn = MonAn::find($request->id);

            if (!$monAn) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy món ăn',
                ]);
            }

            // Handle file upload
            $filePath = $monAn->hinh_anh; // Giữ nguyên đường dẫn ảnh cũ nếu không có file mới được gửi
            if ($request->hasFile('hinh_anh')) {
                $file = $request->file('hinh_anh');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('MonAn'), $fileName);
                $filePath = asset('MonAn/' . $fileName);

                // Xóa ảnh cũ nếu có
                if ($monAn->hinh_anh && file_exists(public_path('MonAn/' . basename($monAn->hinh_anh)))) {
                    unlink(public_path('MonAn/' . basename($monAn->hinh_anh)));
                }
            }
            MonAn::where('id', $request->id)
                ->update([
                    'ten_mon'       => $request->ten_mon,
                    'slug_mon'      => $request->slug_mon,
                    'hinh_anh'      => $filePath,
                    'gia_ban'       => $request->gia_ban,
                    'id_danh_muc'   => $request->id_danh_muc,
                    'tinh_trang'    => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công món ' . $request->ten_mon,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function doiTrangThaiMonAn(Request $request)
    {
        $id_chuc_nang = 73;
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
            MonAn::where('id', $request->id)
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

    public function kiemTraSlugMonAn(Request $request)
    {
        $id_chuc_nang = 74;
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

        $mon_an = MonAn::where('slug_mon', $request->slug)->first();

        if (!$mon_an) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Món Ăn phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Món Ăn Đã Tồn Tại!',
            ]);
        }
    }

    public function kiemTraSlugMonAnUpdate(Request $request)
    {
        $id_chuc_nang = 75;
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

        $mon_an = MonAn::where('slug_mon', $request->slug)
            ->where('id', '<>', $request->id)
            ->first();

        if (!$mon_an) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tên Món Ăn phù hợp!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tên Món Ăn Đã Tồn Tại!',
            ]);
        }
    }
}
