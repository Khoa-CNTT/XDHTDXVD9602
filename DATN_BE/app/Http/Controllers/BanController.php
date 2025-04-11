<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CreateBanuRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class BanController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 28;
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

        $data   = Ban::join('khu_vucs', 'khu_vucs.id', 'bans.id_khu_vuc')
                     ->select('bans.*', 'khu_vucs.ten_khu')
                     ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'ban'  =>  $data,
        ]);
    }

    public function getDataAll()
    {
        $id_chuc_nang = 29;
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

        $data   = Ban::join('khu_vucs', 'khu_vucs.id', 'bans.id_khu_vuc')
                     ->where('bans.tinh_trang', 1)
                     ->select('bans.*', 'khu_vucs.ten_khu')
                     ->get(); // get là ra 1 danh sách

        return response()->json([
            'ban'  =>  $data,
        ]);
    }

    public function searchBan(Request $request)
    {
        $id_chuc_nang = 30;
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

        $data   = Ban::join('khu_vucs', 'khu_vucs.id', 'bans.id_khu_vuc')
            ->where('bans.ten_ban', 'like', $key)
            ->select('bans.*', 'khu_vucs.ten_khu')
            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'ban'  =>  $data,
        ]);
    }

    public function createBan(CreateBanuRequest $request)
    {
        $id_chuc_nang = 31;
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

        // Check if table already exists in the area
        if (Ban::where('slug_ban', $request->slug_ban)->where('id_khu_vuc', $request->id_khu_vuc)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Bàn này đã tồn tại trong khu vực!'
            ]);
        }

        // Create new table
        $ban = Ban::create([
            'ten_ban' => $request->ten_ban,
            'slug_ban' => $request->slug_ban,
            'id_khu_vuc' => $request->id_khu_vuc,
            'tinh_trang' => $request->tinh_trang,
            'hash_ban' => Str::uuid(),
        ]);

        $qrCode = QrCode::generate("http://localhost:5173/ban/" . $ban->slug_ban . "/" . $ban->hash_ban);

        // Lưu mã QR vào cơ sở dữ liệu (nếu bạn muốn)
        if($qrCode != null){
            $ban->qr_ban = $qrCode;
            $ban->save();
        }else{
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Tạo mã QR không thành công!',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Đã tạo mới bàn thành công!',
        ]);
    }

    public function xoaBan($id)
    {
        $id_chuc_nang = 32;
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
            Ban::where('id', $id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa bàn thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }

    public function capNhatBan(UpdateBanRequest $request)
    {
        $id_chuc_nang = 33;
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
            $ban = Ban::where('slug_ban', $request->slug_ban)
                ->where('id_khu_vuc', $request->id_khu_vuc)
                ->where('id', "<>", $request->id)
                ->first();

            if ($ban) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Bàn này đã tồn tại trong khu vực!'
                ]);
            }

            Ban::where('id', $request->id)
                ->update([
                    'ten_ban'           => $request->ten_ban,
                    'slug_ban'          => $request->slug_ban,
                    'id_khu_vuc'        => $request->id_khu_vuc,
                    'tinh_trang'        => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công ' . $request->ten_ban,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiBan(Request $request)
    {
        $id_chuc_nang = 34;
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
            Ban::where('id', $request->id)
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
}
