<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('actions')->delete();
        DB::table('actions')->truncate();

        DB::table('actions')->insert([
            ['id' => '1', 'ten_action' => 'Lấy Danh Sách Danh Mục Theo Trang'],
            ['id' => '2', 'ten_action' => 'Lấy Danh Sách Tất Cả Danh Mục'],
            ['id' => '3', 'ten_action' => 'Tìm Kiếm Danh Mục'],
            ['id' => '4', 'ten_action' => 'Thêm Mới Danh Mục'],
            ['id' => '5', 'ten_action' => 'Xóa Danh Mục'],
            ['id' => '6', 'ten_action' => 'Cập Nhật Danh Mục'],
            ['id' => '7', 'ten_action' => 'Đổi Trạng Thái Danh Mục'],
            ['id' => '8', 'ten_action' => 'Kiểm Tra Slug Danh Mục'],
            ['id' => '9', 'ten_action' => 'Lấy Danh Sách Bài Viết Theo Trang'],
            ['id' => '10', 'ten_action' => 'Lấy Danh Sách Tất Cả Bài Viết'],
            ['id' => '11', 'ten_action' => 'Thêm Mới Bài Viết'],
            ['id' => '12', 'ten_action' => 'Cập Nhật Bài Viết'],
            ['id' => '13', 'ten_action' => 'Xóa Bài Viết'],
            ['id' => '14', 'ten_action' => 'Đổi Trạng Thái Bài Viết'],
            ['id' => '15', 'ten_action' => 'Tìm Kiếm Bài Viết'],
            ['id' => '16', 'ten_action' => 'Lấy Danh Sách Nhân Viên Theo Trang'],
            ['id' => '17', 'ten_action' => 'Tìm Kiếm Nhân Viên'],
            ['id' => '18', 'ten_action' => 'Thêm Mới Nhân Viên'],
            ['id' => '19', 'ten_action' => 'Xóa Nhân Viên'],
            ['id' => '20', 'ten_action' => 'Cập Nhật Nhân Viên'],
            ['id' => '21', 'ten_action' => 'Đổi Trạng Thái Nhân Viên'],
            ['id' => '22', 'ten_action' => 'Lấy Danh Sách Chức Vụ Theo Trang'],
            ['id' => '23', 'ten_action' => 'Lấy Danh Sách Tất Cả Chức Vụ'],
            ['id' => '24', 'ten_action' => 'Tìm Kiếm Chức Vụ'],
            ['id' => '25', 'ten_action' => 'Thêm Mới Chức Vụ'],
            ['id' => '26', 'ten_action' => 'Xóa Chức Vụ'],
            ['id' => '27', 'ten_action' => 'Cập Nhật Chức Vụ'],
            ['id' => '28', 'ten_action' => 'Lấy Danh Sách Bàn Theo Trang'],
            ['id' => '29', 'ten_action' => 'Lấy Danh Sách Tất Cả Bàn'],
            ['id' => '30', 'ten_action' => 'Tìm Kiếm Bàn'],
            ['id' => '31', 'ten_action' => 'Thêm Mới Bàn'],
            ['id' => '32', 'ten_action' => 'Xóa Bàn'],
            ['id' => '33', 'ten_action' => 'Cập Nhật Bàn'],
            ['id' => '34', 'ten_action' => 'Đổi Trạng Thái Bàn'],
            ['id' => '35', 'ten_action' => 'Lấy Danh Sách Khu Vực Theo Trang'],
            ['id' => '36', 'ten_action' => 'Lấy Danh Sách Tất Cả Khu Vực'],
            ['id' => '37', 'ten_action' => 'Lấy Danh Sách Khu Vực Đang Hoạt Động'],
            ['id' => '38', 'ten_action' => 'Tìm Kiếm Khu Vực'],
            ['id' => '39', 'ten_action' => 'Thêm Mới Khu Vực'],
            ['id' => '40', 'ten_action' => 'Xóa Khu Vực'],
            ['id' => '41', 'ten_action' => 'Cập Nhật Khu Vực'],
            ['id' => '42', 'ten_action' => 'Đổi Trạng Thái Khu Vực'],
            ['id' => '43', 'ten_action' => 'Kiểm Tra Slug Khu Vực'],
            ['id' => '44', 'ten_action' => 'Kiểm Tra Slug Cập Nhật Khu Vực'],
            ['id' => '45', 'ten_action' => 'Lấy Danh Sách Nguyên Liệu Theo Trang'],
            ['id' => '46', 'ten_action' => 'Lấy Danh Sách Tất Cả Nguyên Liệu'],
            ['id' => '47', 'ten_action' => 'Tìm Kiếm Nguyên Liệu'],
            ['id' => '48', 'ten_action' => 'Thêm Mới Nguyên Liệu'],
            ['id' => '49', 'ten_action' => 'Xóa Nguyên Liệu'],
            ['id' => '50', 'ten_action' => 'Cập Nhật Nguyên Liệu'],
            ['id' => '51', 'ten_action' => 'Đổi Trạng Thái Nguyên Liệu'],
            ['id' => '52', 'ten_action' => 'Kiểm Tra Slug Nguyên Liệu'],
            ['id' => '53', 'ten_action' => 'Kiểm Tra Slug Cập Nhật Nguyên Liệu'],
            ['id' => '54', 'ten_action' => 'Lấy Danh Sách Tất Cả Nhập Kho'],
            ['id' => '55', 'ten_action' => 'Thêm Mới Nguyên Liệu Vào Kho'],
            ['id' => '56', 'ten_action' => 'Xóa Nguyên Liệu Ra Khỏi Kho'],
            ['id' => '57', 'ten_action' => 'Cập Nhật Nguyên Liệu Vào Kho'],
            ['id' => '58', 'ten_action' => 'Thêm Mới Hóa Đơn Nhập Kho'],
            ['id' => '59', 'ten_action' => 'Lấy Danh Sách Hóa Đơn Nhập Kho Theo Trang'],
            ['id' => '60', 'ten_action' => 'Lấy Danh Sách Chi Tiết Hóa Đơn Nhập Kho'],
            ['id' => '61', 'ten_action' => 'Lấy Danh Sách Nhà Cung Cấp Theo Trang'],
            ['id' => '62', 'ten_action' => 'Lấy Danh Sách Tất Cả Nhà Cung Cấp'],
            ['id' => '63', 'ten_action' => 'Tìm Kiếm Nhà Cung Cấp'],
            ['id' => '64', 'ten_action' => 'Thêm Mới Nhà Cung Cấp'],
            ['id' => '65', 'ten_action' => 'Xóa Nhà Cung Cấp'],
            ['id' => '66', 'ten_action' => 'Cập Nhật Nhà Cung Cấp'],
            ['id' => '67', 'ten_action' => 'Đổi Trạng Thái Nhà Cung Cấp'],
            ['id' => '68', 'ten_action' => 'Lấy Danh Sách Món Ăn Theo Trang'],
            ['id' => '69', 'ten_action' => 'Thêm Mới Món Ăn'],
            ['id' => '70', 'ten_action' => 'Tìm Kiếm Món Ăn'],
            ['id' => '71', 'ten_action' => 'Xóa Món Ăn'],
            ['id' => '72', 'ten_action' => 'Cập Nhật Món Ăn'],
            ['id' => '73', 'ten_action' => 'Đổi Trạng Thái Món Ăn'],
            ['id' => '74', 'ten_action' => 'Kiểm Tra Slug Món Ăn'],
            ['id' => '75', 'ten_action' => 'Kiểm Tra Slug Cập Nhật Món Ăn'],
            ['id' => '76', 'ten_action' => 'Lấy Danh Sách Bàn Theo Khu Vực'],
            ['id' => '77', 'ten_action' => 'Lấy Danh Sách Món Ăn Đang Hoạt Động'],
            ['id' => '78', 'ten_action' => 'Mở Bàn'],
            ['id' => '79', 'ten_action' => 'Thêm Món Ăn Vào Bàn'],
            ['id' => '80', 'ten_action' => 'Lấy Danh Sách Chi Tiết Hóa Đơn Bán Hàng Theo Bàn'],
            ['id' => '81', 'ten_action' => 'Cập Nhật Chi Tiết Hóa Đơn Bán Hàng'],
            ['id' => '82', 'ten_action' => 'Xóa Chi Tiết Hóa Đơn Bán Hàng'],
            ['id' => '83', 'ten_action' => 'Thanh Toán Hóa Đơn'],
            ['id' => '84', 'ten_action' => 'Lấy Danh Sách Món Ăn Theo Bàn'],
            ['id' => '85', 'ten_action' => 'Chuyển Món Sang Bàn Khác'],
            ['id' => '86', 'ten_action' => 'In Hóa Đơn'],
            ['id' => '87', 'ten_action' => 'Chuyển Món Vào Bếp'],
            ['id' => '88', 'ten_action' => 'Lấy Danh Sách Món Ăn Ở Bếp'],
            ['id' => '89', 'ten_action' => 'Cập Nhật Món Ăn Ở Bếp'],
            ['id' => '90', 'ten_action' => 'Lấy Danh Sách Hóa Đơn Bán Hàng Theo Trang'],
            ['id' => '91', 'ten_action' => 'Lấy Danh Sách Chi Tiết Hóa Đơn Bán Hàng'],
            ['id' => '92', 'ten_action' => 'Lấy Danh Sách Chi Tiết Hóa Đơn Bán Hàng Theo Hóa Đơn'],
            ['id' => '93', 'ten_action' => 'Lấy Danh Sách Phân Quyền Theo Trang'],
            ['id' => '94', 'ten_action' => 'Thêm Mới Phân Quyền'],
            ['id' => '95', 'ten_action' => 'Lấy Danh Sách Tất Cả Chức Năng'],
            ['id' => '96', 'ten_action' => 'Xóa Phân Quyền'],
            ['id' => '97', 'ten_action' => 'Thống Kê Doanh Thu'],
            ['id' => '98', 'ten_action' => 'Thống Kê Số Lượng Nguyên Liệu Nhập Vào'],
            ['id' => '99', 'ten_action' => 'Thống Kê Số Lượng Món Ăn Đã Bán'],
            ['id' => '100', 'ten_action' => 'Thống Kê Số Tiền Nhập Kho'],
        ]);

    }
}
