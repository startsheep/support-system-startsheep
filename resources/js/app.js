import "./bootstrap";
import "../css/app.css";
import "vue-toast-notification/dist/theme-sugar.css";

import { createApp } from "vue";
import { abilitiesPlugin } from "@casl/vue";
import ability from "./store/services/ability";
import ToastPlugin from "vue-toast-notification";
import VueDraggable from "vue-draggable";

import router from "./router";
import store from "./store";
import VueSweetalert2 from "vue-sweetalert2";

import Auth from "./Auth.vue";
import Guest from "./Guest.vue";
import App from "./App.vue";

createApp(Auth).use(router).use(store).mount("#auth");
createApp(Guest)
    .use(router)
    .use(store)
    .use(VueSweetalert2)
    .use(abilitiesPlugin, ability, {
        useGlobalProperties: true,
    })
    .use(ToastPlugin, {
        position: "top",
        duration: 1000,
    })
    .mount("#guest");
createApp(App).use(router).use(store).use(VueSweetalert2).mount("#app");
