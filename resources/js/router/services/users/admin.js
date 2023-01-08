export default [
    {
        path: "/user",
        component: () => import("../../../pages/user/admin/Index.vue"),
        name: "Admin User",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/admin",
        component: () => import("../../../pages/user/admin/Index.vue"),
        name: "Admin",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/admin/create",
        component: () => import("../../../pages/user/admin/Create.vue"),
        name: "Create Admin",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/admin/:id/edit",
        component: () => import("../../../pages/user/admin/Edit.vue"),
        name: "Admin Edit",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
