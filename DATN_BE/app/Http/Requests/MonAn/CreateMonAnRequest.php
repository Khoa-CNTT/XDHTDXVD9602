<?php

namespace App\Http\Requests\MonAn;

use Illuminate\Foundation\Http\FormRequest;

class CreateMonAnRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ten_mon'           =>  'required|min:5|max:30',
            'slug_mon'          =>  'required|min:5|unique:mon_ans,slug_mon',
            'hinh_anh'          =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gia_ban'           =>  'required|numeric|min:0|max:2000000000',
            'tinh_trang'        =>  'required|in:0,1',
            'id_danh_muc'       =>  'required|exists:danh_mucs,id',
        ];
    }
    public function messages()
    {
        return [
            'ten_mon.required'  =>  'Yêu cầu phải nhập tên món',
            'ten_mon.min'       =>  'Tên món phải từ 5 ký tự',
            'ten_mon.max'       =>  'Tên món tối đa được 30 ký tự',
            'slug_mon.*'        =>  'Slug món đã tồn tại!',
            'gia_ban.*'         =>  'Giá bán ít nhất là 0đ và nhiều nhất là 2,000,000,000đ',
            'tinh_trang.*'      =>  'Vui lòng chọn tình trạng theo yêu cầu!',
            'id_danh_muc.*'     =>  'Danh mục không tồn tại trong hệ thống!',
            'hinh_anh.*'        =>  'Hình ảnh phải nhập và tối đa 2048 ký tự',
        ];
    }

}
