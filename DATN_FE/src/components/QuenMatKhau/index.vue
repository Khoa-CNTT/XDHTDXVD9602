<template>
    <div class="authentication-forgot d-flex align-items-center justify-content-center">
        <div v-if="is_done == false" class="card forgot-box">
            <div class="card-body">
                <div class="p-4 rounded  border">
                    <div class="text-center">
                        <img src="../../assets/assets_rocker/images/icons/forgot-2.png" width="120" alt="">
                    </div>
                    <h4 class="mt-5 font-weight-bold">Bạn Đã Quên Mật Khẩu?</h4>
                    <p class="text-muted">Vui lòng nhập email tài khoản của bạn để có thể đổi lại mật khẩu mới</p>
                    <hr>
                    <div class="my-4">
                        <label class="form-label">Email</label>
                        <input v-model="email" type="text" class="form-control form-control-lg" placeholder="Nhập Email của bạn tại đây">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary btn-lg" v-on:click="quenMatKhau()">Send</button> 
                        <router-link to="/login">
                            <a href="/login" class="btn btn-light btn-lg" style="width: 100%;">
                                <i class="bx bx-arrow-back me-1"></i>
                                Back to Login
                            </a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="card forgot-box">
            <div class="card-body">
                <div class="p-4 rounded border">
                    <div class="text-center">
                        <img src="../../assets/assets_rocker/images/icons/user.png" width="120" alt="">
                    </div>
                    <h4 class="mt-5 font-weight-bold">Gửi Mail Thành Công</h4>
                    <p class="text-muted">Vui lòng kiểm tra hộp email của bạn để có thể đổi mới mật khẩu</p>
                    <div class="d-grid gap-2">
                        <router-link to="/login">
                            <a href="/login" class="btn btn-primary btn-lg" style="width: 100%;">
                                <i class="bx bx-arrow-back me-1"></i>
                                Back to Login
                            </a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            email   :   '',
            is_done :   false,
        }
    },
    methods: {
        quenMatKhau() {
            const payload = {
                'email' : this.email
            };
            baseRequest
                .post('quen-mat-khau', payload)
                .then((res) =>  {
                    if(res.data.status == true) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.$router.push('/login');
                        this.is_done = true;
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        }
    },
}
</script>
<style></style>