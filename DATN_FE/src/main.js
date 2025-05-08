import { createApp } from "vue";
import axios from "axios";
import App from "./App.vue";
import router from "./router";
import Toaster from "@meforma/vue-toaster";

const app = createApp(App);

app.use(router, axios, Toaster);
app.mount("#app");
