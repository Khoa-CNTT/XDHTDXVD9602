<template>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->
        <!-- Navbar & Hero Start -->
        <div class="position-relative p-0">
            <MenuClient></MenuClient>
        </div>

        <router-view></router-view>
        <BotClient></BotClient>
        <!-- Footer End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
</template>
<script>
var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
(function () {
    var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = "https://embed.tawk.to/6805fea36d34aa190b0562db/1ipbmlcja";
    s1.charset = "UTF-8";
    s1.setAttribute("crossorigin", "*");
    s0.parentNode.insertBefore(s1, s0);
})();
import MenuClient from "../components/MenuClient.vue";
import BotClient from "../components/BotClient.vue";
import "../../assets/assets_client/lib/jquery-init.js";
// import "../../assets/assets_client/lib/wow/wow.js";
import "../../assets/assets_client/lib/easing/easing.js";
import "../../assets/assets_client/lib/waypoints/waypoints.min.js";
import "../../assets/assets_client/lib/counterup/counterup.min.js";
import "../../assets/assets_client/lib/owlcarousel/owl.carousel.min.js";
// import "../../assets/assets_client/lib/tempusdominus/js/moment.min.js";
// import "../../assets/assets_client/lib/tempusdominus/js/moment-timezone.min.js";
// import "../../assets/assets_client/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js";
import "../../assets/assets_client/js/main.js";
export default {
    name: "app",
    components: {
        MenuClient,
        BotClient,
    },
};
</script>
<style>
@import "../../assets/assets_client/lib/animate/animate.min.css";
@import "../../assets/assets_client/lib/owlcarousel/assets/owl.carousel.min.css";
@import "../../assets/assets_client/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css";
@import "../../assets/assets_client/css/bootstrap.min.css";
@import "../../assets/assets_client/css/style.css";
@import url("https://fonts.googleapis.com");
@import url("https://fonts.gstatic.com");
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css");
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css");
</style>
