<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('danh_mucs')->delete();

        DB::table('danh_mucs')->truncate();

        DB::table('danh_mucs')->insert([
            [
                'id'            => 1,
                'icon'          => '<i class="fa-solid fa-bowl-food fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Cơm - Mỳ - Miến',
                'slug_danh_muc' => 'com-my-mien',
                'id_danh_muc_cha' => 0,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 4,
                'icon'          => '<i class="fa-solid fa-bowl-rice fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Cơm',
                'slug_danh_muc' => 'com',
                'id_danh_muc_cha' => 1,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 5,
                'icon'          => '<i class="fa-solid fa-plate-wheat fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Mỳ',
                'slug_danh_muc' => 'my',
                'id_danh_muc_cha' => 1,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 6,
                'icon'          => '<i class="fa-solid fa-plate-wheat fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Miến',
                'slug_danh_muc' => 'mien',
                'id_danh_muc_cha' => 1,
                'tinh_trang' =>  1,
            ],

            [
                'id'            => 2,
                'icon'          => '<i class="fa-solid fa-martini-glass fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Thức Uống',
                'slug_danh_muc' => 'thuc-uong',
                'id_danh_muc_cha' => 0,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 7,
                'icon'          => '<i class="fa fa-coffee fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Nước Ngọt',
                'slug_danh_muc' => 'nuoc-ngot',
                'id_danh_muc_cha' => 2,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 8,
                'icon'          => '<i class="fa-solid fa-beer-mug-empty fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Bia',
                'slug_danh_muc' => 'Bia',
                'id_danh_muc_cha' => 2,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 9,
                'icon'          => '<i class="fa-solid fa-wine-glass fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Rượu',
                'slug_danh_muc' => 'Rượu',
                'id_danh_muc_cha' => 2,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 10,
                'icon'          => '<i class="fa-solid fa-bottle-droplet fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Nước Khoáng',
                'slug_danh_muc' => 'nuoc-khoang',
                'id_danh_muc_cha' => 2,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 3,
                'icon'          => '<i class="fa-solid fa-fish-fins fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Hải Sản',
                'slug_danh_muc' => 'hai-san',
                'id_danh_muc_cha' => 0,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 11,
                'icon'          => '',
                'ten_danh_muc' =>  'Hải Sản Hai Mảnh',
                'slug_danh_muc' => 'hai-san-hai-manh',
                'id_danh_muc_cha' => 3,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 12,
                'icon'          => '<i class="fa-solid fa-fish fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Cá',
                'slug_danh_muc' => 'ca',
                'id_danh_muc_cha' => 3,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 13,
                'icon'          => '<i class="fa-solid fa-shrimp fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Tôm',
                'slug_danh_muc' => 'tom',
                'id_danh_muc_cha' => 3,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 14,
                'icon'          => '<i class="fa-solid fa-utensils fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Cua',
                'slug_danh_muc' => 'cua',
                'id_danh_muc_cha' => 3,
                'tinh_trang' =>  1,
            ],
            [
                'id'            => 15,
                'icon'          => '<i class="fa-solid fa-utensils fa-2x text-primary"></i>',
                'ten_danh_muc' =>  'Ghẹ',
                'slug_danh_muc' => 'ghe',
                'id_danh_muc_cha' => 3,
                'tinh_trang' =>  1,
            ],
        ]);
    }
}
