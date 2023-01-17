<script>
import Success from "../../components/notifications/Success.vue";

export default {
    data() {
        return {
            email: "",
            message: "",
            isLoading: false,
            errors: {},
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            const params = {
                email: this.email,
            };
            this.$store
                .dispatch("postData", ["auth/forgot-password", params])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "password reset link sent successfully";
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.errors = error.response.data.messages;
                });
        },
    },
    components: { Success },
};
</script>
<template>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Forgot Your Password?</h1>
                            <span
                                >Enter your email and we will send you a link to
                                get back into your account</span
                            >
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
                                                v-model="email"
                                                :class="{
                                                    'is-invalid': errors.email,
                                                }"
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
