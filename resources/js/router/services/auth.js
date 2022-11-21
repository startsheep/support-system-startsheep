export default [
    {
        path: "/auth/login",
        name: "Login",
        component: () => import("../../pages/auth/Login.vue"),

        meta: {
            middleware: "guest",
        },
    },
];
