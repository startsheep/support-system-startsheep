<script>
import Cookie from "js-cookie";
import Loader from "../../components/Loader.vue";

export default {
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            isLoading: false,
            errors: {},
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["auth/login", this.user])
                .then((response) => {
                    Cookie.set("token", response.data.token);
                    Cookie.set("user", JSON.stringify(response.data.user));
                    window.location.replace("/");
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.errors = error.response.data.meta.messages;
                });
        },
    },
    components: { Loader },
};
</script>
<template>
    <main class="d-flex w-100">
        <Loader v-if="isLoading" />
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome to SSS</h1>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Email</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="email"
                                                name="email"
                                                placeholder="Enter your email"
                                                :class="{
                                                    'is-invalid': errors.email,
                                                }"
                                                v-model="user.email"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                v-if="errors.email"
                                                v-for="(
                                                    error, index
                                                ) in errors.email"
                                                :key="index"
                                            >
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Password</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="password"
                                                name="password"
                                                placeholder="Enter your password"
                                                v-model="user.password"
                                                :class="{
                                                    'is-invalid':
                                                        errors.password,
                                                }"
                                            />
                                            <div
                                                class="invalid-feedback"
                                                v-if="errors.password"
                                                v-for="(
                                                    error, index
                                                ) in errors.password"
                                                :key="index"
                                            >
                                                {{ error }}
                                            </div>
                                            <small>
                                                <a href="index.html"
                                                    >Forgot password?</a
                                                >
                                            </small>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button
                                                type="submit"
                                                class="btn btn-lg btn-primary"
                                            >
                                                Sign in
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<style></style>
