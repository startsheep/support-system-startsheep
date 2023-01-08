export default [
    {
        path: "/user/staff",
        component: () => import("../../../pages/user/staff/Index.vue"),
        name: "Staff",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/staff/create",
        component: () => import("../../../pages/user/staff/Create.vue"),
        name: "Create Staff",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/staff/:id/edit",
        component: () => import("../../../pages/user/staff/Edit.vue"),
        name: "Staff Edit",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
