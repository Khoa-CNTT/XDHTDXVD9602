<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\ChiTietHoaDonBanHang;
use App\Models\GiaoDich;
use App\Models\HoaDonBanHang;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GiaoDichController extends Controller
{
    public function index()
    {
        $client = new Client();
        $payload = [
            "USERNAME"      => "NGUYENVUHUY211002",
            "PASSWORD"      => "01694682134@aA",
            "DAY_BEGIN"     => Carbon::today()->format('d/m/Y'),
            "DAY_END"       => Carbon::today()->format('d/m/Y'),
            "NUMBER_MB"     => "5380148665533"
        ];
        
        // try {
            $response = $client->post('http://103.137.185.71:2603/mb', [
                'json' => $payload
            ]);

            $data   = json_decode($response->getBody(), true);
            // return response()->json([
            //     'status'            =>   true,
            //     'data'              =>   $data
            // ]);
            $duLieu = $data['data'];
            
            foreach($duLieu as $key => $value) {
                $giaoDich   = GiaoDich::where('pos', $value['pos'])
                                      ->where('creditAmount', $value['creditAmount'])
                                      ->where('description', $value['description'])
                                      ->first();

                if(!$giaoDich) {
                    GiaoDich::create([
                            'creditAmount'      =>  $value['creditAmount'],
                            'description'       =>  $value['description'],
                            'pos'               =>  $value['pos'],
                    ]);
                    
                    // Khi mà chúng ta tạo giao dịch => tìm giao dịch dựa vào description => đổi trạng thái của đơn hàng
                    $description = $value['description'];
                    // Tìm vị trí của chuỗi "HDBH"
                    // $startIndex = strpos($description, "HDBH");
                    // if ($startIndex !== false) {
                    //     $maDonHang = substr($description, $startIndex, strcspn(substr($description, $startIndex), " \t\n\r\0\x0B"));
                    // }
                    // dd($description);
                    if (preg_match('/HDFY(\d+)/', $description, $matches)) {
                        $maDonHang  = $matches[0];
                        $donHang    = HoaDonBanHang::where('ma_hoa_don', $maDonHang)
                                        ->where('tien_thuc_nhan', '<=', $value['creditAmount'])
                                        ->first();
                        if($donHang) {
                            $donHang->is_done = 1;
                            $donHang->save();
                            $chiTiet = ChiTietHoaDonBanHang:: where('id_hoa_don', $donHang->id)->get();
                            foreach ($chiTiet as $key => $value) {
                                $value->is_done = 1;
                                $value->save();
                            }
                            $ban = Ban::where('id', $donHang->id_ban)->first();
                            $ban->is_mo_ban = 0;
                            $ban->hoa_don_hien_tai = null;
                            $ban->save();
                            return response()->json([
                                'status'            =>   true,
                                'message'           =>   'Bàn ' . $ban->ten_ban . ' đã thanh toán hóa đơn '. $donHang->ma_hoa_don . ' thành công!',
                            ]);
                        }

                        

                    }
                }

                

            }
            
        // } catch (Exception $e) {
        //     echo $e;
        // }
    }
}
