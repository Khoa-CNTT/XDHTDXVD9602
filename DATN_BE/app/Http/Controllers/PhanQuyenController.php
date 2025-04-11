<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhanQuyenRequest;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhanQuyenController extends Controller
{
    public function createPhanQuyen(CreatePhanQuyenRequest $request)
    {
        $id_chuc_nang = 94;
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

        $check = PhanQuyen::where('id_chuc_nang', $request->id_chuc_nang)
            ->where('id_chuc_vu', $request->id_chuc_vu)->first();
        if ($check) {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Chức vụ đã có chức năng này!'
            ]);
        } else {
            PhanQuyen::create([
                'id_chuc_nang'  =>  $request->id_chuc_nang,
                'id_chuc_vu'    =>  $request->id_chuc_vu
            ]);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã phân quyền thành công'
            ]);
        }
    }

    public function getChucNang(Request $request)
    {
        $id_chuc_nang = 95;
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

        $data   = DB::table('actions')->join('phan_quyens', 'actions.id', 'phan_quyens.id_chuc_nang')
            ->where('id_chuc_vu', $request->id)
            ->select('phan_quyens.*', 'actions.ten_action')
            ->get();
        // $data   = PhanQuyen::where('id_chuc_vu', $request->id)->get();
        $existingActions = DB::table('phan_quyens')
            ->where('id_chuc_vu', $request->id)
            ->pluck('id_chuc_nang');

        // Lấy tất cả các actions chưa có trong chức vụ
        $chuc_nang = DB::table('actions')
            ->whereNotIn('id', $existingActions)
            ->get();
        return response()->json([
            'data'   =>  $data,
            'chuc_nang' => $chuc_nang
        ]);
    }

    public function xoaPhanQuyen($id)
    {
        $id_chuc_nang = 96;
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

        $phan_quyen = PhanQuyen::where('id', $id)->first();

        if ($phan_quyen) {
            $phan_quyen->delete();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xóa phân quyền thành công'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Đã có lỗi xảy ra!'
            ]);
        }
    }
}
