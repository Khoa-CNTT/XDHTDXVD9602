<?php

namespace Database\Seeders;

use App\Models\HoaDonBanHang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class HoaDonBanHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('hoa_don_ban_hangs')->delete();
        DB::table('hoa_don_ban_hangs')->truncate();

        
        $faker = Faker::create();
        $startDate = strtotime('2024-03-01');
        $endDate = strtotime(now());

        for ($i = $startDate; $i <= $endDate; $i += 86400) {
            $randomDate = date("Y-m-d H:i:s", $i);
            // Tạo hóa đơn cho mỗi bàn trong cùng một ngày
            for ($j = 1; $j <= 37; $j++) { // Tạo hóa đơn cho 37 bàn
                $idBan = $j;
                $idNhanVien = 1; // Thay 10 bằng số lượng nhân viên nếu có
                $maHoaDon = 'HDFY' . $i . $idBan; // Thêm ngày vào mã hóa đơn
                $tongTienTruocGiam = $faker->numberBetween(100000, 1000000);
                $phanTramGiam = $faker->numberBetween(5, 20);
                $tienThucNhan = $tongTienTruocGiam / 100 * $phanTramGiam; // Tính tiền thực nhận
                $hoaDon = new HoaDonBanHang([
                    'ma_hoa_don' => $maHoaDon,
                    'tong_tien_truoc_giam' => $tongTienTruocGiam,
                    'phan_tram_giam' => $phanTramGiam,
                    'tien_thuc_nhan' => $tienThucNhan,
                    'ghi_chu' => $faker->sentence,
                    'id_ban' => $idBan,
                    'id_nhan_vien' => $idNhanVien,
                    'is_done' => 1,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);
                $hoaDon->save();
            }
        }
    }
}
