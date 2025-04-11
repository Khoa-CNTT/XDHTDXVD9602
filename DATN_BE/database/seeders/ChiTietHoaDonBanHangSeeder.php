<?php

namespace Database\Seeders;

use App\Models\ChiTietHoaDonBanHang;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ChiTietHoaDonBanHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_tiet_hoa_don_ban_hangs')->delete();
        DB::table('chi_tiet_hoa_don_ban_hangs')->truncate();
        
        $faker = Faker::create();
        $startDate = strtotime('2024-03-01');
        $endDate = strtotime(now());

        for ($i = $startDate; $i <= $endDate; $i += 86400) {
            $randomDate = date("Y-m-d H:i:s", $i);
            // Tạo hóa đơn cho mỗi bàn trong cùng một ngày
            for ($j = 1; $j <= 37; $j++) { // Tạo hóa đơn cho 37 bàn
                $idBan = $j;
                $idNhanVien = rand(1, 10); // Thay 10 bằng số lượng nhân viên nếu có
                $maHoaDon = 'HDFY' . $i . '_' . $idBan; // Thêm ngày vào mã hóa đơn
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
                    'is_done' => 1,
                    'id_nhan_vien' => $idNhanVien,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);
                $hoaDon->save();

                // Tạo chi tiết hóa đơn
                $this->createChiTietHoaDon($hoaDon, $faker);
            }
        }
    }

    private function createChiTietHoaDon($hoaDon, $faker)
    {
        $soLuongChiTiet = rand(1, 5);
        $thanhTienTong = 0;
        $monAns = MonAn::all();
        for ($k = 0; $k < $soLuongChiTiet; $k++) {
            $monAn = $monAns->random(); // Chọn ngẫu nhiên một món ăn từ danh sách
            $idMonAn = $monAn->id;
            $donGia = $monAn->gia_ban;
            $soLuong = rand(1, 5);
            $thanhTien = $soLuong * $donGia;
            $thanhTienTong += $thanhTien;

            $chiTietHoaDon = new ChiTietHoaDonBanHang([
                'id_hoa_don' => $hoaDon->id,
                'id_mon_an' => $idMonAn,
                'so_luong' => $soLuong,
                'don_gia' => $donGia,
                'thanh_tien' => $thanhTien,
                'phan_tram_giam' => $faker->numberBetween(0, 10),
                'ghi_chu' => $faker->sentence,
                'is_done' => 1,
                'is_che_bien' => 1,
                'is_in_bep' => 1,
                'created_at' => $hoaDon->created_at,
                'updated_at' => $hoaDon->updated_at,
            ]);
            $chiTietHoaDon->save();
        }

        // Cập nhật lại tổng thanh toán của hóa đơn dựa trên tổng thanh toán của các chi tiết hóa đơn
        $hoaDon->update(['tien_thuc_nhan' => $thanhTienTong]);
    }

}
