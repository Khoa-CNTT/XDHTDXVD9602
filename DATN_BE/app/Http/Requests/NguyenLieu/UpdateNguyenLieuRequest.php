<?php

namespace App\Http\Requests\NguyenLieu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNguyenLieuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id'                    =>  'required|exists:nguyen_lieus,id',
            'ten_nguyen_lieu'       =>'required|min:5|max:30',
            'slug_nguyen_lieu'      =>'required|min:5|unique:nguyen_lieus,slug_nguyen_lieu,' .$this->id,
            'so_luong'              =>'required|numeric|min:0|max:1000',
            'gia'                   =>'required|numeric|min:0|max:1000000000',
            'dvt'                   =>'required|min:1',
            'tinh_trang'            =>'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'id.*'                      => 'Tên Nguyên Liệu không tồn tại!',
            'ten_nguyen_lieu.required'  =>  'Yêu cầu phải nhập Tên Nguyên Liệu',
            'ten_nguyen_lieu.min'       =>  'Tên Nguyên Liệu phải từ 5 ký tự',
            'ten_nguyen_lieu.max'       =>  'Tên Nguyên Liệu tối đa được 30 ký tự',
            'slug_nguyen_lieu.*'        =>  'Slug Nguyên Liệu đã tồn tại!',
            'so_luong.*'                =>  'Số Lượng ít nhất là 0 và nhiều nhất là 1000',
            'gia.*'                     =>  'Giá bán ít nhất là 0đ và nhiều nhất là 1.000.000.000đ',
            'dvt.*'                     =>  'Yêu cầu nhập đơn vị tính',
            'dvt.min'                   =>  'Đơn Vị Tính phải từ 1 ký tự',
            'tinh_trang.*'              =>  'Vui lòng chọn tình trạng theo yêu cầu!',
        ];
    }
}
