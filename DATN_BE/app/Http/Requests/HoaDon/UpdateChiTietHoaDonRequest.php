<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChiTietHoaDonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'               =>  'required|exists:chi_tiet_hoa_don_ban_hangs,id',
            'so_luong'         =>  'required|numeric|min:1|max:1000',
            'don_gia'          =>  'nullable|numeric|min:0|max:1000000000',
            'phan_tram_giam'   =>  'numeric|min:0|max:100',

        ];
    }

    public function messages()
    {
        return [
            'id.*'                  =>  'Chi tiết bán hàng không tồn tại!',
            'so_luong.*'            =>  'Số lượng Nhập ít nhất là 1 và nhiều nhất là 1000',
            'don_gia.nullable'      =>  'Đơn giá không được để trống!',
            'don_gia.numeric'       =>  'Đơn giá phải là số!',
            'don_gia.min'           =>  'Đơn giá phải lớn hơn hoặc bằng 0!',
            'don_gia.max'           =>  'Đơn giá phải nhỏ hơn hoặc bằng 1000000000!',
            'phan_tram_giam.numeric'  =>  'Phân trăm giảm phải là số!',
            'phan_tram_giam.min'      =>  'Phân trăm giảm phải lớn hơn hoặc bằng 0!',
            'phan_tram_giam.max'      =>  'Phân trăm giảm không được quá 100',

        ];
    }
}
