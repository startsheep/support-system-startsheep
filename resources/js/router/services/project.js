import ticket from "./project/ticket";

export default [
    ...ticket,
    {
        path: "/project",
        component: () => import("../../pages/project/Index.vue"),
        name: "Project",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/project/create",
        component: () => import("../../pages/project/Create.vue"),
        name: "Add More Project",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/project/:id/detail",
        component: () => import("../../pages/project/Show.vue"),
        name: "Project Detail",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
    {
        path: "/project/:id/edit",
        component: () => import("../../pages/project/Edit.vue"),
        name: "Edit Project",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
