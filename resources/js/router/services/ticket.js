export default [
    {
        path: "/ticket",
        component: () => import("../../pages/ticket/Index.vue"),
        name: "Ticket",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/ticket/create",
        component: () => import("../../pages/ticket/Create.vue"),
        name: "Create Ticket",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/ticket/:id/detail",
        component: () => import("../../pages/ticket/Show.vue"),
        name: "Ticket Detail",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
