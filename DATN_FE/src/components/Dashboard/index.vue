<template>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 row-cols-xxl-4">
        <div class="col">
            <div class="card radius-10 bg-gradient-cosmic">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-0 text-white">Tổng số tiền nhập kho</p>
                            <h4 class="my-1 text-white">{{ formatToVND(tong_tien_nk) }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                class="bx bxs-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-ibiza">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-0 text-white">Tổng doanh thu</p>
                            <h4 class="my-1 text-white">{{ formatToVND(tong_tien_hd) }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-ohhappiness">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-0 text-white">Tổng số hóa đơn bán hàng</p>
                            <h4 class="my-1 text-white">{{ tong_hd }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                class="bx bxs-bar-chart-alt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-kyoto">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <p class="mb-0 text-white">Tổng số nhân viên</p>
                            <h4 class="my-1 text-white">{{ tong_nv }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i
                                class="bx bxs-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Thống Kê Tiền Nhập Kho Tháng {{ month }}/{{ year }}</h3>
                        </div>
                    </div>
                    <hr>
                    <Bar v-if="loaded1" :data="chartData1" />
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Thống Kê Doanh Thu Tháng {{ month }}/{{ year }}</h3>
                        </div>
                    </div>
                    <hr>
                    <Line v-if="loaded" :data="chartData" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from '../../core/baseRequest'
import { Bar } from 'vue-chartjs'
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement)
export default {
    components: { Bar, Line },
    data() {
        return {
            loaded: false,
            loaded1: false,
            tong_tien_nk: 0,
            tong_tien_hd: 0,
            tong_hd: 0,
            tong_nv: 0,
            chartData: null,
            begin: '',
            end: '',
            month: '',
            year: '',
            chartData: {
                datasets: [
                    {
                        label: 'Thống Kê Doanh Thu',
                        backgroundColor: [
                            "#C0392B", "#1ABC9C", "#F1C40F", "#E67E22", "#8E44AD", "#2980B9", "#27AE60"
                        ],
                        data: []
                    }
                ]
            },
            chartData1: {
                datasets: [
                    {
                        label: 'Thống Kê Tiền Nhập Kho',
                        backgroundColor: [
                            "#C0392B", "#1ABC9C", "#F1C40F", "#E67E22", "#8E44AD", "#2980B9", "#27AE60"
                        ],
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true
            }
        }
    },
    mounted() {
        this.loaded = false;
        this.loaded1 = false;
        var date = new Date();                  // Ngày và giờ hiện tại
        this.year = date.getFullYear();         // Lấy năm hiện tại
        this.month = (date.getMonth() + 1).toString().padStart(2, '0'); // Lấy tháng hiện tại, định dạng hai chữ số

        // Ngày đầu tiên của tháng hiện tại
        var firstDayOfMonth = new Date(this.year, date.getMonth(), 1);
        this.begin = firstDayOfMonth.toISOString().slice(0, 10);

        // Ngày hiện tại
        this.end = date.toISOString().slice(0, 10);
        this.loadData();
        this.loadDataDoanhThu();
        this.loadDataNhapKho();
    },
    methods: {
        formatToVND(number) {
            number = parseInt(number);
            return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        },

        loadDataDoanhThu() {
            this.loaded = false
            baseRequest
                .get('admin/thong-ke-doanh-thu/' + this.begin + '/' + this.end)
                .then((res) => {
                    this.chartData.labels = res.data.list_lable;
                    this.chartData.datasets[0].data = res.data.list_data;
                    this.loaded = true;
                });
        },

        loadDataNhapKho() {
            this.loaded1 = false
            baseRequest
                .get('admin/thong-ke-tien-nhap-kho/' + this.begin + '/' + this.end)
                .then((res) => {
                    this.chartData1.labels = res.data.list_lable;
                    this.chartData1.datasets[0].data = res.data.list_data;
                    this.loaded1 = true;
                });
        },

        loadData() {
            baseRequest
                .get('admin/dashboard')
                .then((res) => {
                    this.tong_tien_nk = res.data.tong_tien_nk;
                    this.tong_tien_hd = res.data.tong_tien_hd;
                    this.tong_hd = res.data.tong_hd;
                    this.tong_nv = res.data.tong_nv;
                });
        }
    },
}
</script>
<style></style>
