<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nhan_viens')->delete();

        DB::table('nhan_viens')->truncate();

        DB::table('nhan_viens')->insert([
            ['id' => '1', 'ho_va_ten' => 'Admin', 'email' => 'admin@master.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '1', 'tinh_trang' => '1', 'is_master' => '1'],
            ['id' => '2', 'ho_va_ten' => 'Trần Công Trực', 'email' => 'trancongtruc7523@gmail.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '3', 'tinh_trang' => '1', 'is_master' => '0'],
            ['id' => '3', 'ho_va_ten' => 'Võ Gia Khánh', 'email' => 'vogiakhanh0711@gmail.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '2', 'tinh_trang' => '1', 'is_master' => '0'],
            ['id' => '4', 'ho_va_ten' => 'Trịnh Thanh Ngọc', 'email' => 'trinhthanhngoc0408@gmail.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '5', 'tinh_trang' => '1', 'is_master' => '0'],
            ['id' => '5', 'ho_va_ten' => 'Nguyễn Minh Tú', 'email' => 'minhtu3403@gmail.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '4', 'tinh_trang' => '1', 'is_master' => '0'],
            ['id' => '6', 'ho_va_ten' => 'Đỗ Xuân Anh', 'email' => 'anhdo2112003@gmail.com', 'password' => bcrypt('123456'), 'so_dien_thoai' => '123456789', 'dia_chi' => 'Đà Nẵng', 'id_chuc_vu' => '3', 'tinh_trang' => '1', 'is_master' => '0'],
        ]);
    }
}
