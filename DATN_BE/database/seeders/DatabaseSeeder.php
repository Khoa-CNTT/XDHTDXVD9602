<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ChiTietHoaDonBanHang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KhuVucSeeder::class,
            NhanVienSeeder::class,
            BanSeeder::class,
            BaiVietSeeder::class,
            DanhMucSeeder::class,
            MonAnSeeder::class,
            NhaCungCapSeeder::class,
            NguyenLieuSeeder::class,
            ActionSeeder::class,
            ChucVuSeeder::class,
            PhanQuyenSeeder::class,
            HoaDonBanHangSeeder::class,
            ChiTietHoaDonBanHangSeeder::class,
            HoaDonNhapKhoSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
