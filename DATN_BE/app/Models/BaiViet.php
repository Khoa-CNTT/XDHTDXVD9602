<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $table = 'bai_viets';

    protected $fillable = [
        'id_nhan_vien',
        'tieu_de',
        'hinh_anh',
        'noi_dung',
        'tinh_trang'
    ];
}
