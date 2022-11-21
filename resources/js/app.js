import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import router from "./router";
import store from "./store";
import VueSweetalert2 from "vue-sweetalert2";

import Auth from "./Auth.vue";
import Guest from "./Guest.vue";
import App from "./App.vue";

createApp(Auth).use(router).use(store).mount("#auth");
createApp(Guest).use(router).use(store).use(VueSweetalert2).mount("#guest");
createApp(App).use(router).use(store).use(VueSweetalert2).mount("#app");
