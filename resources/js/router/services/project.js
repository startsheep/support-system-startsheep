export default [
    {
        path: "/project",
        component: () => import("../../pages/ticket/Index.vue"),
        name: "Project",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/ticket/:id/edit",
        component: () => import("../../pages/ticket/Show.vue"),
        name: "Project Edit",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
