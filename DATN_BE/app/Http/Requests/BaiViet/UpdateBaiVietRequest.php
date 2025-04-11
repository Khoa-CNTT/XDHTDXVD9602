<?php

namespace App\Http\Requests\BaiViet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBaiVietRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                        => 'required|exists:bai_viets,id',
            'tieu_de'                   => 'required|min:5',
            'hinh_anh'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'noi_dung'                  => 'required|min:10',
            'tinh_trang'                => 'required|numeric|between:0,1',
        ];
    }
    public function messages()
    {
        return [
            'id.*'                               => 'Bài Viết không tồn tại!',
            'tieu_de.*'                          => 'Tiêu đề phải nhiều hơn 5 ký tự',
            'hinh_anh.*'                         => 'Hình ảnh không được bỏ trống',
            'noi_dung.*'                         => 'Mô tả ngắn phải nhiều hơn 10 ký tự',
            'tinh_trang.*'                       => 'Tình trạng phải chọn đúng yêu cầu',
            'id_chuyen_muc_tin_tuc.required'     => 'Vui lòng chọn chuyên mục!',
            'id_chuyen_muc_tin_tuc.exists'       => 'Chuyên mục không tồn tại!',

        ];
    }
}
