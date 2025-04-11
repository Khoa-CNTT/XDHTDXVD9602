<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatNhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'            =>  'required|exists:nhan_viens,id',
            'ho_va_ten'     =>  'required|min:5|max:30',
            'email'         =>  'required|email|unique:nhan_viens,email,' .$this->id,
            'password'      =>  'required',
            'so_dien_thoai' =>  'required|digits:10',
            'dia_chi'       =>  'required',
            'id_chuc_vu'    =>  'required|exists:chuc_vus,id',
            'tinh_trang'    =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                   =>  'Nhân Viên không tồn tại!',
            'ho_va_ten.required'     =>  'Họ và tên yêu cầu phải nhập',
            'ho_va_ten.min'          =>  'Họ và tên ít nhất 5 chữ cái',
            'ho_va_ten.max'          =>  'Họ và tên nhiều nhất 30 chữ cái',
            'email.required'         =>  'Email yêu cầu phải nhập',
            'email.email'            =>  'Email phải đúng định dạng',
            'email.unique'           =>  'Email đã tồn tại trong hệ thống',
            'password.required'      =>  'Mật khẩu yêu cầu phải nhập',
            'so_dien_thoai.required' =>  'Số điện thoại yêu cầu phải nhập',
            'so_dien_thoai.digits' =>  'Số điện thoại phải 10 số',
            'dia_chi.required'       =>  'Địa chỉ yêu cầu phải nhập',
            'id_chuc_vu.required'    =>  'Chức vụ yêu cầu phải nhập',
            'tinh_trang.required'    =>  'Tình trạng yêu cầu phải nhập',
        ];
    }
}
