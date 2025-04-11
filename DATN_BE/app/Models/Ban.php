<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $table = 'bans';

    protected $fillable = [
        'ten_ban',
        'slug_ban',
        'id_khu_vuc',
        'is_mo_ban',
        'tinh_trang',
        'qr_ban',
        'hash_ban',
        'hoa_don_hien_tai',
    ];
}
