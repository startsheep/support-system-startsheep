<template>
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle d-none d-sm-inline-block"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <img
                            :src="
                                'https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=' +
                                user.name
                            "
                        />
                        <span class="text-dark ms-2">{{ user.name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <button class="dropdown-item" @click="handleLogout">
                            Log out
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import Cookies from "js-cookie";

export default {
    props: ["user"],
    methods: {
        handleLogout() {
            this.$store
                .dispatch("postData", ["auth/logout", {}])
                .then((result) => {
                    Cookies.remove("token");
                    window.location.replace("/auth/login");
                });
        },
    },
};
</script>
