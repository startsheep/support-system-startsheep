<template>
    <router-view />
</template>

<script>
import Cookie from "js-cookie";

export default {
    watch: {
        "$route.params.search": {
            handler: function (search) {
                if (Cookie.get("token")) {
                    window.location.replace("/");
                }
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>

<style></style>
