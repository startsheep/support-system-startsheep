export default [
    {
        path: "/user/customer",
        component: () => import("../../../pages/user/customer/Index.vue"),
        name: "Customer",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/customer/create",
        component: () => import("../../../pages/user/customer/Create.vue"),
        name: "Create Customer",
        meta: {
            middleware: "auth",
        },
    },
    {
        path: "/user/customer/:id/edit",
        component: () => import("../../../pages/user/customer/Edit.vue"),
        name: "Customer Edit",
        meta: {
            middleware: "auth",
        },
        props: true,
    },
];
