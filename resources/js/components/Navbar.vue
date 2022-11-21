<script>
import Cookie from "js-cookie";

export default {
    data() {
        return {
            isLoggedIn: false,
        };
    },
    mounted() {
        this.checkLogging();
    },
    methods: {
        checkLogging() {
            let token = Cookie.get("token");
            if (token) {
                this.isLoggedIn = true;
            } else {
                this.isLoggedIn = false;
            }
        },
    },
};
</script>
<template>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <router-link to="/" class="navbar-brand">SSS</router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <router-link class="nav-link" to="/ticket"
                            >Ticket</router-link
                        >
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>
</template>
