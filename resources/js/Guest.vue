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
import { AbilityBuilder, Ability, defineAbility } from "@casl/ability";
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
                        this.user = response.user;
                        var permission = response.permission;
                        const { can, rules } = new AbilityBuilder(Ability);
                        for (var prop in permission) {
                            if (permission.hasOwnProperty(prop)) {
                                can(
                                    permission[prop],
                                    prop.charAt(0).toUpperCase() + prop.slice(1)
                                );
                            }
                        }
                        this.$ability.update(rules);
                    })
                    .catch((error) => {
                        console.log(error);
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
