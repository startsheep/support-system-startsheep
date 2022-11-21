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
    <div class="bg-primary bg-gradient" style="height: 100vh">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-md-6 my-5">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <Loader v-if="isLoading" />
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">
                                                Welcome Back!
                                            </h1>
                                        </div>
                                        <form @submit.prevent="handleSubmit">
                                            <div class="mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.email,
                                                    }"
                                                    placeholder="Enter Email Address..."
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
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    placeholder="Password"
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
                                            </div>
                                            <button
                                                class="btn btn-primary form-control"
                                            >
                                                Login
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style></style>
