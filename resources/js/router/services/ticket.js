export default [
    {
        path: "/ticket",
        component: () => import("../../pages/ticket/Index.vue"),
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/ticket/:id/detail",
        component: () => import("../../pages/ticket/Show.vue"),
        meta: {
            middleware: "auth",
        },
        props: true
    },
];
