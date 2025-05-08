<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BaiVietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('bai_viets')->truncate();
        DB::table('bai_viets')->delete();
        DB::table('bai_viets')->insert([
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'SPARKLING YOUR SUMMER WITH DIFF 2023 - ƯU ĐÃI TẶNG MÓN MỖI CUỐI TUẦN',
                'hinh_anh' => 'https://brilliantseafood.vn/upload/images/A%CC%89nh%20%C4%91a%CC%86ng%20ca%CC%A3%CC%82p%20nha%CC%A3%CC%82t%20Google%20Maps.png',
                'noi_dung' => 'Hãy ghé thăm ForYou Restaurant và đặt bàn ngay hôm nay để trở thành một trong những khách hàng đầu tiên được hưởng ưu đãi TẶNG MÓN đặc biệt vào mỗi cuối tuần, với món ngon hấp dẫn chỉ dành riêng cho mùa lễ hội này. ForYou Restaurant là địa điểm dừng chân quen thuộc của nhiều du khách gần xa, không chỉ có nhiều món ngon đa dạng, mà còn có không gian sang trọng và thoải mái. Hãy đến để tận hưởng không khí mùa hè cùng lễ hội #DIFF2023 rực rỡ, chắc chắn bạn sẽ có những khoảnh khắc đáng nhớ.
 
                Đừng bỏ lỡ cơ hội này! Liên hệ hotline 1900 599 978 để đặt chỗ hôm ngay hôm nay bạn nhé!',
                'tinh_trang' => 1
            ],
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'NHÀ HÀNG CÓ PHÒNG VIP TẠI ĐÀ NẴNG – SANG TRỌNG, ĂN NGON GIÁ RẺ',
                'hinh_anh' => 'https://brilliantseafood.vn/thumb/550x380/1/upload/news/91722603/nha-hang-co-phong-vip-tai-da-nang-sang-trong-an-ngon-gia-re.jpg',
                'noi_dung' => 'Đà Nẵng là một thành phố rất phát triển về cơ sở hạ tầng cũng như vật chất, nhằm đáp ứng nhu cầu thị hiếu của khách hàng, thành phố du lịch biển đã ngày càng ra đời nhiều nhà hàng khách sạn đẳng cấp 5 Sao, trong đó phải kể đến nhà hàng có phòng vip tại Đà Nẵng ForYou Restaurant. Đây là một trong những nhà hàng có phòng Vip tại Đà Nẵng mà bạn đang cần tìm kiếm, đến với nhà hàng chắc chắn bạn sẽ không khỏi ngạc nhiên bởi không gian sang trọng đẳng cấp, thiết kế của nơi đây vừa mang kiến trúc hiện đại pha một chút cổ điển tất cả đã tạo nên một điểm nhấn trong lòng du khách. Không gian nhà hàng có phòng vip tại Đà Nẵng chủ yếu được trang trí bằng màu gỗ kết hợp với những kiến trúc của dân tộc Việt Nam tạo nên cho du khách một cảm giác vừa sang trọng nhưng lại không kém phần ấm cúng.

                Đây là một điểm hẹn được rất nhiều người lựa chọn khi đặt chân tới Đà Nẵng hay những buổi tiệc nhỏ gặp gỡ cuối tuần, bởi mức giá ở đây cũng rất hợp lý, mà món ăn lại tươi ngon nên thu hút rất đông du khách.Các món ăn chủ yếu của nhà hàng để phục vụ du khách là hải sản tươi sống rất ngon, ngoài ra còn có các món nướng, quay, tiềm, các món rau, thịt,...chắc chắn sẽ đáp ứng hết tất cả nhu cầu của các quý khách hàng khi đến đây.Nhà hàng có phòng Vip tại Đà Nẵng còn có những không gian riêng tư nhỏ dành cho các cặp đôi, hay những buổi gặp gỡ bạn bè cần không gian yên tĩnh, từ các tầng của nhà hàng nếu bạn lựa chọn ngồi gần cửa kính có thể vừa thưởng thức các món ăn ngon cùng người thân vừa ngắm nhìn vẻ đẹp của thành phố biển rất sinh động nhất là vào ban đêm khá lung linh và lãng mạn.

                ',
                'tinh_trang' => 1
            ],
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'BUFFET HẢI SẢN ĐÀ NẴNG NGON – CHẤT LƯỢNG ĐẲNG CẤP REVIEW 5 SAO',
                'hinh_anh' => 'https://brilliantseafood.vn/thumb/550x380/1/upload/news/27543236/buffet-hai-san-da-nang-ngon-chat-luong-dang-cap-review-5-sao.jpg',
                'noi_dung' => 'Là một trong những nhà hàng buffet hải sản Đà Nẵng ngon có tiếng ở Đà Nẵng, tọa lại tại vị trí trung tâm của thành phố biển, cũng khá gần với biển Mỹ Khê, con đường Hồ Nghinh vô cùng sầm uất và thu hút rất nhiều du khách ghé qua. Chính những món ăn nơi đây, về hương vị đặc trưng đã thu hút rất nhiều du khách đến trải nghiệm. Mỗi du khách khi đến với Đà Nẵng đều mong muốn được trải nghiệm nhiều cảnh đẹp cũng như thưởng thức nhiều món ăn ngon của thành phố biển, thì nhà hàng bufffet hải sản Đà Nẵng ngon sẽ là điểm hẹn khó có thể nào chối từ được. Nhiều du khách sau khi trải nghiệm ẩm thực tại nhà hàng buffet hải sản Đà Nẵng ngon đều đánh giá rất tốt về hương vị món ăn, về độ tươi ngon ngọt của hải sản, rất hấp dẫn, phong cách phục vụ của nhà hàng khá chuyên nghiệp không phải chờ đợi quá lâu, không gian nhà hàng thì mang nét ấm cúng, vừa truyền thống lại vừa hiện đại, sạch sẽ tạo cam giác thoải mái cho khách hàng khi đến trải nghiệm. Và hứa hẹn rằng sẽ quay lại và giới thiệu bạn bè đến đây.',
                'tinh_trang' => 1
            ],
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'NHÀ HÀNG HẢI SẢN TỐT NHẤT ĐÀ NẴNG – CHẤT LƯỢNG 5* GIÁ TỐT',
                'hinh_anh' => 'https://brilliantseafood.vn/thumb/550x380/1/upload/news/79593004/nha-hang-hai-san-tot-nhat-da-nang-chat-luong-5-gia-tot.jpg',
                'noi_dung' => 'Đà Nẵng là một thành phố biển thu hút rất nhiều du khách ghé năm mỗi năm, nhất là vào mùa hè, thì Đà Nẵng trở thành điểm đến tuyệt vời, vừa có biển vừa có sông lại vừa có núi, cùng với khí hậu ôn hòa quanh năm nên ai đã đến Đà Nẵng một lần đều có thể nghiện.  

                Nghiện ở đây không chỉ là những cảnh đẹp nên thơ, với cây cầu Vàng điểm đến hot nhất thế giới, hay bãi biển Mỹ Khê khuyến rũ nhất hành tinh mà còn là những món ăn đặc sản, đặc trưng văn hóa ẩm thực nơi đây và những món hải sản tươi ngon hấp dẫn với mức giá vô cùng rẻ.

                Một bữa tiệc hải sản tại nhà hàng hải sản tốt nhất Đà Nẵng chỉ từ 200k – 300k một người là bạn có thể tha hồ thưởng thức hết của ngon vật lạ của Đà Nẵng, bởi Đà Nẵng là một thành phố đáng sống, không có chặt chém như những thành phố lớn nên bạn hoàn toàn yên tâm về điều này nhé!

                ',
                'tinh_trang' => 1
            ],
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'NHÀ HÀNG HẢI SẢN VIEW BIỂN ĐÀ NẴNG – KHÔNG GIAN SANG TRỌNG, ĐẲNG CẤP',
                'hinh_anh' => 'https://brilliantseafood.vn/thumb/550x380/1/upload/news/46017841/nha-hang-hai-san-view-bien-da-nang-khong-gian-sang-trong-dang-cap.jpg',
                'noi_dung' => 'Ngắm cảnh đủ rồi thì bây giờ tìm ngay một địa điểm thưởng thức hải sản thôi nào, giờ chúng tôi sẽ giới thiệu cho bạn một thiên đường ẩm thực vô cùng hấp dẫn ở nhà hàng hải sản view biển Đà Nẵng ForYou Restaurant.

                Nhà hàng nằm ở con đường Hồ Nghinh gần biển chỉ cách ít phút đi bộ là bạn đã có thể chiêm ngưỡng được bãi biển Mỹ Khê. Không gian nhà hàng vô cùng rộng rãi và hiện đại hướng ra biển nên bạn có thể vừa thưởng thức hải sản vừa tận hưởng làn gió biển vô cùng tuyệt vời.
                
                Sau khi tắm biển thõa thích thì đến ngay nhà hàng thưởng thức luôn những món ăn hải sản tươi ngon. Nhà hàng hải sản view biển Đà Nẵng có rất nhiều món ngon phải kể đến như: cua hoàng đế, tôm hùm, tôm alaska, mực ống, các loại cá khác nhau: cá mú, cá đuối,...Ngoài ra còn có các món hấp dẫn khác như tiềm, heo sửa quay, nướng,...Thực đơn rất đa dạng nên bạn có thể tha hồ lựa chọn nhé.',
                'tinh_trang' => 1
            ],
            [
                'id_nhan_vien' => 1,
                'tieu_de' => 'NHÀ HÀNG CÓ TỔ CHỨC SINH NHẬT TẠI ĐÀ NẴNG ĐẸP – LÃNG MẠN NHẤT',
                'hinh_anh' => 'https://brilliantseafood.vn/thumb/550x380/1/upload/news/84978379/nha-hang-co-to-chuc-sinh-nhat-tai-da-nang-dep-lang-man-nhat.jpg',
                'noi_dung' => 'Sinh nhật là một ngày rất quan trọng đúng không nào, là ngày mà mỗi chúng ta sẽ có thêm một tuổi mới, vì vậy một buổi tiệc ấm cúng bên cạnh người thân và gia đình tại nhà hàng tổ chức sinh nhật riêng tại Đà Nẵng là một điều thật ý nghĩa và tuyệt vời đúng không. Nhà hàng có tổ chức sinh nhật tại Đà Nẵng ForYou Restaurant sẽ là một lựa chọn tuyệt vời và vô cùng hợp lý, với không gian thoáng mát, nằm ở vị trí 178 Hồ Nghinh, Sơn Trà, Đà Nẵng khá gần với bãi biển Mỹ Khê, bạn có thể vừa thưởng thức bữa tiệc của mình vừa tận hưởng làn gió biển. Nhà hàng tổ chức sinh nhật riêng tại Đà Nẵng được thiết kế theo phong cách vừa hiện đại vừa đậm chất văn hóa Việt Nam rất đặc trưng nên khi đến một lần là bạn sẽ nhớ mãi. Quán được biết đến với rất nhiều món ăn ngon đặc biệt là các món hải sản ở đây rất tươi mang hương vị rất đặc trưng ăn một lần sẽ nhớ mãi.',
                'tinh_trang' => 1
            ],
        ]);
    }
}
