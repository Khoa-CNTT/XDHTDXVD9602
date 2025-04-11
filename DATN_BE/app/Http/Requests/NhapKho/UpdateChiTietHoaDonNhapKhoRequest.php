<?php

namespace App\Http\Requests\NhapKho;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChiTietHoaDonNhapKhoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'               =>  'required|exists:nhap_khos,id',
            'so_luong'         =>  'required|numeric|min:1|max:1000',
            'don_gia'          =>  'nullable|numeric|min:0|max:1000000000',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                  =>  'Chi tiết bán hàng không tồn tại!',
            'so_luong.*'            =>  'Số lượng Nhập ít nhất là 1 và nhiều nhất là 1000',
            'don_gia.numeric'       =>  'Đơn giá phải là số!',
            'don_gia.min'           =>  'Đơn giá phải ít nhất là 1!',
            'don_gia.max'           =>  'Đơn giá nhiều nhất là 1.000.000.000!',
        ];
    }

}
