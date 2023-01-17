<script>
import Loader from "../../components/Loader.vue";
import Success from "../../components/notifications/Success.vue";

export default {
    data() {
        return {
            isLoading: false,
            errors: {},
            message: "",
            password: "",
            passwordConfirmation: "",
        };
    },
    computed: {
        email() {
            return this.$route.href.split("?")[1].split("&")[1].split("=")[1];
        },
        token() {
            return this.$route.href.split("?")[1].split("&")[0].split("=")[1];
        },
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;

            const params = {
                email: this.email,
                token: this.token,
                password: this.password,
                passwordConfirmation: this.passwordConfirmation,
            };

            this.$store
                .dispatch("postData", ["auth/new-password", params])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "Password changed successfully";
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.errors = error.response.data.messages;
                });
        },
    },
    components: { Loader, Success },
};
</script>
<template>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Create New Password</h1>
                        </div>

                        <div class="card">
                            <Loader v-if="isLoading" />
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Password</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="password"
                                                name="password"
                                                placeholder="Enter your password"
                                                v-model="password"
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
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Confirm Password</label
                                            >
                                            <input
                                                class="form-control form-control-lg"
                                                type="password"
                                                name="password"
                                                placeholder="Enter your password"
                                                v-model="passwordConfirmation"
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
                                        <div class="text-center mt-3">
                                            <button
                                                type="submit"
                                                class="btn btn-lg btn-primary"
                                            >
                                                Submit
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
    <Success :msg="message" :route="{ name: 'Login' }" />
</template>
