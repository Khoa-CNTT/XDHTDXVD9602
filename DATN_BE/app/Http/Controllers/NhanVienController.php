<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapNhatNhanVienRequest;
use App\Http\Requests\CreateNhanVienRequest;
use App\Jobs\MailJob;
use App\Mail\mailQuenMatKhau;
use App\Models\ChucVu;
use App\Models\NhanVien;
use App\Models\PhanQuyen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Validator;

class NhanVienController extends Controller
{
    public function login(Request $request)
    {
        $check  = Auth::guard('nhan_vien')->attempt(['email' => $request->email, 'password' => $request->password]);
        // check sẽ trả về true hoặc false
        if ($check == true) {  // có
            // Lấy thông tin người đã nhập
            $user  = Auth::guard('nhan_vien')->user();
            $chuc_vu = ChucVu::where('id', $user->id_chuc_vu)->first();
            if($user->tinh_trang == 1) {
                $token = $user->createToken('token')->plainTextToken;
                return response()->json([
                    'message'   =>  'Đăng nhập thành công!',
                    'status'    =>  true,
                    'token'     =>  $token,
                    'user'      =>  $user,
                    'chuc_vu'      =>  $chuc_vu,
                ]);
            } else {
                return response()->json([
                    'message'   =>  'Tài khoản của bạn đã bị khóa !',
                    'status'    =>  false
                ]);
            }
        } else {
            return response()->json([
                'message'   =>  'Đăng nhập thất bại!',
                'status'    =>  false
            ]);
        }
    }

    public function check(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $chuc_vu = ChucVu::where('id', $user->id_chuc_vu)->first();
        if ($user) {
            $agent = new Agent();
            $device     = $agent->device();
            $os         = $agent->platform();
            $browser    = $agent->browser();
            DB::table('personal_access_tokens')
                ->where('id', $user->currentAccessToken()->id)
                ->update([
                    'ip'            =>  request()->ip(),
                    'device'        =>  $device,
                    'os'            =>  $os,
                    'trinh_duyet'   =>  $browser,
                ]);
            return response()->json([
                'email'     =>  $user->email,
                'ho_ten'    =>  $user->ho_va_ten,
                'chuc_vu'   =>  $chuc_vu->ten_chuc_vu,
                'list'      =>  $user->tokens,
            ], 200);
        } else {
            return response()->json([
                'message'   =>  'Bạn cần đăng nhập hệ thống',
                'status'    =>  false,
            ], 401);
        }
    }

    public function removeToken($id)
    {
        try {
            DB::table('personal_access_tokens')
                ->where('id', $id)
                ->delete();
            return response()->json([
                'message'   =>  'Đã remove Token thành công !',
                'status'    =>  true,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
        }
    }

    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        if($user) {
            DB::table('personal_access_tokens')
              ->where('id', $user->currentAccessToken()->id)
              ->delete();
            return response()->json([
                'message'   =>  'Đã đăng xuất thành công!',
                'status'    =>  true,
            ]);
        } else {
            return response()->json([
                'message'   =>  'Bạn cần đăng nhập hệ thống',
                'status'    =>  false,
            ]);
        }
    }

    public function logoutAll()
    {
        $user = Auth::guard('sanctum')->user();
        if($user) {
            $tokens = $user->tokens;
            foreach($tokens as $key => $value) {
                $value->delete();
            }

            return response()->json([
                'message'   =>  'Đã đăng xuất tất cả thành công!',
                'status'    =>  true,
            ]);
        } else {
            return response()->json([
                'message'   =>  'Bạn cần đăng nhập hệ thống',
                'status'    =>  false,
            ]);
        }
    }

    public function getData()
    {
        $id_chuc_nang = 16;
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

        $data   = NhanVien::leftjoin('chuc_vus', 'chuc_vus.id', 'nhan_viens.id_chuc_vu')
                            ->select('nhan_viens.*', 'chuc_vus.ten_chuc_vu')
                            ->paginate(5); // get là ra 1 danh sách

        return response()->json([
            'nhan_vien'  =>  $data,
        ]);
    }

    public function searchNhanVien(Request $request)
    {
        $id_chuc_nang = 17;
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

        $data   = NhanVien::join('chuc_vus', 'chuc_vus.id', 'nhan_viens.id_chuc_vu')
            ->where('nhan_viens.ho_va_ten', 'like', $key)
            ->select('nhan_viens.*', 'chuc_vus.ten_chuc_vu')
            ->paginate(5);

        return response()->json([
            'nhan_vien'  =>  $data,
        ]);
    }

    public function createNhanVien(CreateNhanVienRequest $request)
{
    $id_chuc_nang = 18;
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

    if (!$request->filled('password')) {
        return response()->json([
            'status' => false,
            'message' => 'Password không được để trống!',
        ], 400);
    }

    NhanVien::create([
        'ho_va_ten'         => $request->ho_va_ten,
        'email'             => $request->email,
        'password'          => bcrypt($request->password),
        'so_dien_thoai'     => $request->so_dien_thoai,
        'dia_chi'           => $request->dia_chi,
        'id_chuc_vu'        => $request->id_chuc_vu,
        'tinh_trang'        => $request->tinh_trang,
    ]);

    return response()->json([
        'status'            =>   true,
        'message'           =>   'Đã tạo mới nhân viên thành công!',
    ]);
}
    public function xoaNhanVien($id)
    {
        $id_chuc_nang = 19;
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
            $nhan_vien = NhanVien::where('id', $id)->first();
            if($nhan_vien->is_master == 1){
                return response()->json([
                    'status'            =>   false,
                    'message'           =>   'Bạn Không Được Quyền Xóa Tài Khoản Này',
                ]);
            } else {
                $nhan_vien->delete();
                return response()->json([
                    'status'            =>   true,
                    'message'           =>   'Xóa nhân viên thành công!',
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
    public function capNhatNhanVien(CapNhatNhanVienRequest $request)
    {
        $id_chuc_nang = 20;
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
            NhanVien::where('id', $request->id)
                ->update([
                    'ho_va_ten'         => $request->ho_va_ten,
                    'email'             => $request->email,
                    'password'          => bcrypt($request->password),
                    'so_dien_thoai'     => $request->so_dien_thoai,
                    'dia_chi'           => $request->dia_chi,
                    'id_chuc_vu'        => $request->id_chuc_vu,
                    'tinh_trang'        => $request->tinh_trang,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã cập nhật thành công nhân viên ' . $request->ho_va_ten,
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiNhanVien(Request $request)
    {
        $id_chuc_nang = 21;
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
            NhanVien::where('id', $request->id)
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

    public function kiemTraQuenMK(Request $request)
    {
        $check  = NhanVien::where('hash_quen_mat_khau', $request->hash_quen_mat_khau)->first();
        if($check) {
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Bạn hãy tạo mật khẩu mới!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bạn không được phép ở đây!',
            ]);
        }
    }

    public function doiMatKhau(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
            'hash_quen_mat_khau' => 'required',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $nhanVien  = NhanVien::where('hash_quen_mat_khau', $request->hash_quen_mat_khau)->first();
        if($nhanVien) {
            $nhanVien->password             =   bcrypt($request->password);
            $nhanVien->hash_quen_mat_khau   =   null;
            $nhanVien->save();

            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã đổi mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Bạn không được phép ở đây!',
            ]);
        }
    }

    public function quenMatKhau(Request $request)
    {
        // Gửi lên 1 thằng duy nhất $request->email
        $nhanVien   = NhanVien::where('email', $request->email)->first();
        if($nhanVien) {
            // Tạo 1 mã hash_quen_mat_khau (gì cũng được, đừng dễ đoán và không trùng)
            $ma_random                      =   Str::uuid();
            $nhanVien->hash_quen_mat_khau   =   $ma_random;
            $nhanVien->save();
            // Gửi Email
            $info['name']  =    $nhanVien->ho_va_ten;
            $info['email'] =    $request->email;
            $info['link']  =    'http://localhost:5173/dat-lai-mat-khau/' . $ma_random;
            MailJob::dispatch($info);
            // Mail::to($request->email)->send(new mailQuenMatKhau('mail.quen_mat_khau', 'Khôi Phục Tài Khoản Của Bạn', $info));
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Vui lòng kiểm tra email của bạn!',
            ]);
        } else {
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Tài khoản của bạn không tồn tại!',
            ]);
        }
    }
}
