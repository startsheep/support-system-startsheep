<template>
    <Navbar />
    <router-view />
</template>

<script>
import Cookie from "js-cookie";
import Navbar from "./components/Navbar.vue";

export default {
    components: { Navbar },
};
</script>

<style></style>
