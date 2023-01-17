export default [
    {
        path: "/auth/login",
        name: "Login",
        component: () => import("../../pages/auth/Login.vue"),

        meta: {
            middleware: "guest",
        },
    },
    {
        path: "/auth/new-password",
        name: "New Password",
        component: () => import("../../pages/auth/NewPassword.vue"),
    },
    {
        path: "/auth/reset-password",
        name: "Reset Password",
        component: () => import("../../pages/auth/ResetPassword.vue"),

        meta: {
            middleware: "guest",
        },
    },
];
