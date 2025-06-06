<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanhMucRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'icon'                  => 'required|min:1',
            'ten_danh_muc'          => 'required|between:5,50',
            'slug_danh_muc'         => 'required|between:4,50|unique:danh_mucs,slug_danh_muc',
            'id_danh_muc_cha'       => 'required|min:0',
            'tinh_trang'            => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'icon.required'                 =>  'Icon Danh Mục yêu cầu phải nhập',
            'ten_danh_muc.required'         =>  'Tên Danh Mục yêu cầu phải nhập',
            'ten_danh_muc.between'          =>  'Tên Danh Mục phải từ 5 đến 50 ký tự',
            'slug_danh_muc.required'        =>  'Slug Danh Mục yêu cầu phải nhập',
            'slug_danh_muc.between'         =>  'Slug Danh Mục phải từ 4 đến 50 ký tự',
            'slug_danh_muc.unique'          =>  'Slug Danh Mục đã tồn tại',
            'id_danh_muc_cha.*'             =>  'Danh Mục phải là số',
            'tinh_trang.*'                  =>  'Vui lòng chọn tình trạng theo yêu cầu!',
        ];
    }
}
