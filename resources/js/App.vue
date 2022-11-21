<template>
    <Navbar />
    <router-view />
</template>

<script>
import Cookie from "js-cookie";
import Navbar from "./components/Navbar.vue";

export default {
    components: { Navbar },
    watch: {
        "$route.params.search": {
            handler: function (search) {
                this.$store
                    .dispatch("postData", ["/auth/check", {}])
                    .then((response) => {
                        this.users = JSON.parse(Cookie.get("user"));
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
