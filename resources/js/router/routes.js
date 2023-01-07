import auth from "./services/auth";
import ticket from "./services/ticket";
import project from "./services/project";
import user from "./services/user";

const routes = [
    ...auth,
    ...ticket,
    ...project,
    ...user,
    {
        path: "/",
        component: () => import("../pages/dashboard/Dashboard.vue"),
        name: "Home",
    },
];

export default routes;
