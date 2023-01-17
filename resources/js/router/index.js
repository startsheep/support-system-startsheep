import routes from "./routes";
import Cookies from "js-cookie";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

// router.beforeEach(async (to, from, next) => {
//     const token = Cookies.get("token");
//     if (to.meta.middleware === "auth") {
//         if (!token) {
//             next({
//                 name: "Login",
//             });
//         } else {
//             next();
//         }
//     }
//     if (to.meta.middleware === "guest") {
//         if (token) {
//             next({
//                 name: "Dashboard",
//             });
//         } else {
//             next();
//         }
//     }
//     next();
// });

export default router;
