<template>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">Thống Kê Doanh Thu</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-1 text-end">
                        <p class="mt-2">Từ Ngày:</p>
                    </div>
                    <div class="col-lg-3">
                        <input v-on:change="loadData()" v-model="thong_ke.begin" type="date" class="form-control" />
                    </div>
                    <div class="col-lg-1 text-end">
                        <p class="mt-2">Đến Ngày:</p>
                    </div>
                    <div class="col-lg-3">
                        <input v-on:change="loadData()" v-model="thong_ke.end" type="date" class="form-control" :max="maxEndDate" />
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary">Thống Kê</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <Bar v-if="loaded" :data="chartData" />
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from "../../core/baseRequest";
import { Bar } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from "chart.js";
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);
export default {
    components: { Bar },
    data() {
        return {
            loaded: false,
            chartData: null,
            thong_ke: { begin: "", end: "" },
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: "Thống Kê",
                        backgroundColor: ["#C0392B", "#1ABC9C", "#F1C40F", "#E67E22", "#8E44AD", "#2980B9", "#27AE60"],
                        data: [],
                    },
                ],
            },
            chartOptions: {
                responsive: true,
            },
        };
    },
    async mounted() {
        this.loaded = false;
        var date = new Date();
        var subday = new Date(date.setDate(date.getDate() - 30));
        this.thong_ke.begin = subday.toISOString().slice(0, 10);
        this.thong_ke.end = new Date().toISOString().slice(0, 10);
        this.loadData();
    },
    methods: {
        loadData() {
            const today = new Date();
            const beginDate = new Date(this.thong_ke.begin);
            const endDate = new Date(this.thong_ke.end);

            // Kiểm tra nếu "Đến ngày" lớn hơn ngày hiện tại
            if (endDate > today) {
                alert("Đến ngày không được lớn hơn ngày hiện tại");
                this.thong_ke.end = today.toISOString().slice(0, 10);
                return;
            }

            // Kiểm tra nếu "Từ ngày" lớn hơn "Đến ngày"
            if (beginDate > endDate) {
                alert("Từ ngày không được lớn hơn Đến ngày");
                this.thong_ke.begin = this.thong_ke.end;
                return;
            }

            this.loaded = false;
            baseRequest.post("admin/thong-ke/data-thong-ke-1", this.thong_ke).then((res) => {
                this.chartData.labels = res.data.list_lable;
                this.chartData.datasets[0].data = res.data.list_data;
                this.loaded = true;
            });
        },
    },

    computed: {
        maxEndDate() {
            const today = new Date();
            const todayStr = today.toISOString().slice(0, 10);

            // Nếu chưa chọn "Từ ngày" thì "Đến ngày" tối đa là ngày hiện tại
            if (!this.thong_ke.begin) {
                return todayStr;
            }

            const beginDate = new Date(this.thong_ke.begin);

            // Nếu "Từ ngày" là ngày tương lai, "Đến ngày" tối đa là "Từ ngày"
            if (beginDate > today) {
                return this.thong_ke.begin;
            }

            // Nếu "Từ ngày" là quá khứ hoặc hiện tại, "Đến ngày" tối đa là ngày hiện tại
            return todayStr;
        },
    },
};
</script>
<style></style>
