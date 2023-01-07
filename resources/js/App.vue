<template>
    <div class="wrapper">
        <Sidebar />
        <div class="main">
            <Navbar :user="user" />
            <main class="content">
                <div class="container-fluid p-0">
                    <router-view></router-view>
                </div>
            </main>
            <Footer />
        </div>
    </div>
</template>

<script>
import Cookie from "js-cookie";
import Footer from "./components/layouts/Footer.vue";
import Navbar from "./components/layouts/Navbar.vue";
import Sidebar from "./components/layouts/Sidebar.vue";

export default {
    components: { Navbar, Sidebar, Footer },
    data() {
        return {
            user: {},
        };
    },
    watch: {
        "$route.params.search": {
            handler: function (search) {
                this.$store
                    .dispatch("postData", ["/auth/check", {}])
                    .then((response) => {
                        this.user = JSON.parse(Cookie.get("user"));
                    })
                    .catch((error) => {
                        this.error = error.response.data;
                        Cookie.remove("token");
                        Cookie.remove("user");
                    });
                if (!Cookie.get("token")) {
                    window.location.replace("/auth/login");
                }
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>

<style></style>
