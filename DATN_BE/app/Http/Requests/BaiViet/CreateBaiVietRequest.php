<?php

namespace App\Http\Requests\BaiViet;

use Illuminate\Foundation\Http\FormRequest;

class CreateBaiVietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tieu_de'                   => 'required|min:5',
            'hinh_anh'                  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'noi_dung'                  => 'required|min:10',
            'tinh_trang'                => 'required|numeric|between:0,1',
        ];
    }
    public function messages()
    {
        return [
            'tieu_de.*'                          => 'Tiêu đề phải nhiều hơn 5 ký tự',
            'hinh_anh.*'                         => 'Hình ảnh không được bỏ trống',
            'noi_dung.*'                         => 'Nội dung phải nhiều hơn 10 ký tự',
            'tinh_trang.*'                       => 'Tình trạng phải chọn đúng yêu cầu',
        ];
    }

}
