<?php

namespace Database\Seeders;

use App\Models\HoaDonNhapKho;
use App\Models\NguyenLieu;
use App\Models\NhapKho;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NhapKhoSeeder extends Seeder
{
    public function run()
    {
        DB::table('nhap_khos')->delete();
        DB::table('nhap_khos')->truncate();

        $faker = Faker::create();
        $hoaDonNhapKhos = HoaDonNhapKho::all();

        foreach ($hoaDonNhapKhos as $hoaDon) {
            $this->createNhapKho($hoaDon, $faker);
        }
    }

    private function createNhapKho($hoaDon, $faker)
    {
        $soLuongChiTiet = rand(1, 5);
        $tongTien = 0;

        // Lấy danh sách các nguyên liệu hiện có
        $nguyenLieus = NguyenLieu::all();

        for ($k = 0; $k < $soLuongChiTiet; $k++) {
            $nguyenLieu = $nguyenLieus->random(); // Chọn ngẫu nhiên một nguyên liệu từ danh sách
            $idNguyenLieu = $nguyenLieu->id;
            $soLuong = rand(1, 100);
            $donGia = $nguyenLieu->gia;
            $thanhTien = $soLuong * $donGia;
            $tongTien += $thanhTien;

            $nhapKho = new NhapKho([
                'id_nguyen_lieu' => $idNguyenLieu,
                'id_nhan_vien' => 1,
                'so_luong' => $soLuong,
                'don_gia' => $donGia,
                'thanh_tien' => $thanhTien,
                'created_at' => $hoaDon->created_at,
                'updated_at' => $hoaDon->updated_at,
            ]);
            $nhapKho->save();
        }

        return $tongTien;
    }
}
