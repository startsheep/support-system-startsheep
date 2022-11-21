import auth from "./services/auth";
import ticket from "./services/ticket";

const routes = [
    ...auth,
    ...ticket,
    {
        path: "/",
        component: () => import("../pages/dashboard/Dashboard.vue"),
    },
];

export default routes;
