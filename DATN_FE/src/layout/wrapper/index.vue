<template>
    <div class="wrapper">
        <div class="header-wrapper">
            <TopRocker></TopRocker>
            <MenuRocker></MenuRocker>
        </div>
        <div class="page-wrapper">
            <div class="page-content">
                <router-view></router-view>
            </div>
        </div>
        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top">
            <i class='bx bxs-up-arrow-alt'></i>
        </a>
        <BotRocker></BotRocker>
    </div>
</template>
<script>
import TopRocker from "../components/TopRocker.vue";
import MenuRocker from "../components/MenuRocker.vue";
import BotRocker from "../components/BotRocker.vue";
import "../../assets/assets_rocker/js/bootstrap.bundle.min.js";
import "../../assets/assets_rocker/js/jquery.min.js";
import "../../assets/assets_rocker/plugins/simplebar/js/simplebar.min.js";
import "../../assets/assets_rocker/plugins/metismenu/js/metisMenu.min.js";
import "../../assets/assets_rocker/plugins/perfect-scrollbar/js/perfect-scrollbar.js";
import "../../assets/assets_rocker/js/index.js";
import "../../assets/assets_rocker/js/app.js";
export default {
    name        : 'app',
    components  : {
        TopRocker, MenuRocker, BotRocker
    }
}
</script>
<style>
@import "../../assets/assets_rocker/plugins/vectormap/jquery-jvectormap-2.0.2.css";
@import "../../assets/assets_rocker/plugins/simplebar/css/simplebar.css";
@import "../../assets/assets_rocker/plugins/perfect-scrollbar/css/perfect-scrollbar.css";
@import "../../assets/assets_rocker/plugins/metismenu/css/metisMenu.min.css";
@import "../../assets/assets_rocker/css/bootstrap.min.css";
@import "../../assets/assets_rocker/css/bootstrap-extended.css";
@import "../../assets/assets_rocker/css/app.css";
@import "../../assets/assets_rocker/css/icons.css";
@import "../../assets/assets_rocker/css/dark-theme.css";
@import "../../assets/assets_rocker/css/semi-dark.css";
@import "../../assets/assets_rocker/css/header-colors.css";
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css");
</style>