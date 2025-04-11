<?php

namespace Database\Seeders;

use App\Models\HoaDonNhapKho;
use App\Models\NguyenLieu;
use App\Models\NhaCungCap;
use App\Models\NhapKho;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class HoaDonNhapKhoSeeder extends Seeder
{
    public function run()
    {
        DB::table('hoa_don_nhap_khos')->delete();
        DB::table('hoa_don_nhap_khos')->truncate();

        DB::table('nhap_khos')->delete();
        DB::table('nhap_khos')->truncate();
        
        $faker = Faker::create();
        $startDate = strtotime('2024-03-01');
        $endDate = strtotime(now());
        $invoiceCount = 1;

        for ($i = $startDate; $i <= $endDate; $i += 86400) {
            $randomDate = date("Y-m-d H:i:s", $i);

            // Tạo hóa đơn nhập kho cho mỗi ngày
            
            $idNhaCungCap = NhaCungCap::inRandomOrder()->first()->id;
            $maHoaDon = 'NK' . sprintf('%05d', $invoiceCount++); // Tạo mã hóa đơn với số tăng dần

            $hoaDon = new HoaDonNhapKho([
                'ma_hoa_don' => $maHoaDon,
                'tong_tien' => 0, // Sẽ cập nhật sau khi tạo các chi tiết nhập kho
                'id_nhan_vien' => 1,
                'id_nha_cung_cap' => $idNhaCungCap,
                'ghi_chu' => $faker->sentence,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
            $hoaDon->save();

            // Tạo chi tiết nhập kho
            $tongTien = $this->createNhapKho($hoaDon, $faker);
            $hoaDon->update(['tong_tien' => $tongTien]);
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
                'id_hoa_don_nhap_kho' => $hoaDon->id,
                'id_nhan_vien' => 1,
                'created_at' => $hoaDon->created_at,
                'updated_at' => $hoaDon->updated_at,
            ]);
            $nhapKho->save();
        }

        return $tongTien;
    }
}
