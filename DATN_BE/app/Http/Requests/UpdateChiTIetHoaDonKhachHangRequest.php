<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChiTIetHoaDonKhachHangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'               =>  'required|exists:chi_tiet_hoa_don_ban_hangs,id',
            'so_luong'         =>  'required|numeric|min:1|max:10',
            'don_gia'          =>  'nullable|numeric|min:0',
            'phan_tram_giam'   =>  'numeric',

        ];
    }

    public function messages()
    {
        return [
            'id.*'                  =>  'Chi tiết bán hàng không tồn tại!',
            'so_luong.numeric'            =>  'Số lượng phải là số',
            'so_luong.min'            =>  'Số lượng Nhập ít nhất là 1',
            'so_luong.max'            =>  'Số lượng Nhập nhiều nhất là 10',
            'don_gia.nullable'      =>  'Đơn giá không được để trống!',
            'don_gia.numeric'       =>  'Đơn giá phải là số!',
            'don_gia.min'           =>  'Đơn giá phải lớn hơn hoặc bằng 0!',
            'phan_tram_giam.*'      =>  'Phân trăm giảm phải là số!',

        ];
    }
}
