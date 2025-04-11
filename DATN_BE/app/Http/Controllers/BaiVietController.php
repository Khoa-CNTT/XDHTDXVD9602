<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaiViet\CreateBaiVietRequest;
use App\Http\Requests\BaiViet\UpdateBaiVietRequest;
use App\Models\BaiViet;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BaiVietController extends Controller
{

    public function getDataChiTietHomePage($id)
    {
        $baiViet = BaiViet::where('id', $id)->first();

        return response()->json([
            'bai_viet'   => $baiViet,
        ]);
    }

    public function getDataHomePage()
    {
        $baiViet = BaiViet::where('tinh_trang', 1)->get();
        return response()->json([
            'bai_viet'   => $baiViet,
        ]);
    }

    public function getData()
    {

        $id_chuc_nang = 9;
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
        if ($check == false) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn chưa login!',
            ], 401);
        }
        $baiViet = BaiViet::join('nhan_viens', 'nhan_viens.id', 'bai_viets.id_nhan_vien')
                          ->select('bai_viets.*', 'nhan_viens.ho_va_ten')
                          ->paginate(5);
        return response()->json([
            'bai_viet'   => $baiViet,
        ]);
    }
    public function getDataAll()
    {

        $id_chuc_nang = 10;
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

        $baiViet = BaiViet::get();
        return response()->json([
            'bai_viet'   => $baiViet,
        ]);
    }
    public function createBaiViet(CreateBaiVietRequest $request)
    {
        $id_chuc_nang = 11;
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
        if ($check == false) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn chưa login!',
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('BaiViet'), $fileName);
            $filePath = asset('BaiViet/' . $fileName);
        }
        BaiViet::create([
            'id_nhan_vien'  => $user->id,
            'tieu_de'       => $request->tieu_de,
            'hinh_anh'      => $filePath,
            'noi_dung'      => $request->noi_dung,
            'tinh_trang'    => $request->tinh_trang,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Tạo Bài Viết Thành Công !',
        ]);
    }
    public function capNhatBaiViet(UpdateBaiVietRequest $request)
    {
        $id_chuc_nang = 12;
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
            $check = Auth::guard('sanctum')->check();
            if ($check == false) {
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Bạn chưa login!',
                ], 401);
            }

            $baiViet = BaiViet::find($request->id);

            if (!$baiViet) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy bài viết',
                ]);
            }

            // Handle file upload
            $filePath = $baiViet->hinh_anh; // Giữ nguyên đường dẫn ảnh cũ nếu không có file mới được gửi
            if ($request->hasFile('hinh_anh')) {
                $file = $request->file('hinh_anh');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('BaiViet'), $fileName);
                $filePath = asset('BaiViet/' . $fileName);

                // Xóa ảnh cũ nếu có
                if ($baiViet->hinh_anh && file_exists(public_path('BaiViet/' . basename($baiViet->hinh_anh)))) {
                    unlink(public_path('BaiViet/' . basename($baiViet->hinh_anh)));
                }
            }
            $data = BaiViet::where('id', $request->id)->where('id_nhan_vien', $user->id)->first();
            $data->update([
                'id_nhan_vien' => $user->id,
                'tieu_de'      => $request->tieu_de,
                'hinh_anh'     => $filePath,
                'noi_dung'     => $request->noi_dung,
                'tinh_trang'   => $request->tinh_trang,
            ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công Bài Viết ' . $request->tieu_de,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function xoaBaiViet($id){
        $id_chuc_nang = 13;
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
            BaiViet::where('id',$id)->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa Bài Viết thành công !',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiBaiViet(Request $request){
        $id_chuc_nang = 14;
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
                $tinh_trang_new = 0;
            } else {
                $tinh_trang_new = 1;
            }
            BaiViet::where('id', $request->id)
                ->update([
                    'tinh_trang'  => $tinh_trang_new,
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

    public function searchBaiViet(Request $request)
    {

        $id_chuc_nang = 15;
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

        $data   = BaiViet::join('nhan_viens', 'bai_viets.id_nhan_vien', 'nhan_viens.id')->select('bai_viets.*', 'nhan_viens.ho_va_ten')
            ->where('bai_viets.tieu_de', 'like', $key)
            ->paginate(5);

        return response()->json([
            'bai_viet'  =>  $data,
        ]);
    }
}
