<script>
import Error from "../../../components/Error.vue";
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";
export default {
    data() {
        return {
            form: {
                email: "",
                name: "",
            },

            errors: {},

            isLoading: false,
            message: "",
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["user/admin", this.form])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "admin has been created";
                    $("#successModal").modal("show");
                })
                .catch((errors) => {
                    this.isLoading = false;
                    this.errors = errors.response.data.messages;
                });
        },
    },
    components: { Error, Loader, Success },
};
</script>
<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <form method="post" @submit.prevent="handleSubmit">
                <div class="card">
                    <Loader v-if="isLoading" />
                    <div class="card-header">
                        <router-link
                            class="btn btn-sm btn-primary"
                            :to="{ name: 'Admin' }"
                            >Back</router-link
                        >
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                v-model="form.name"
                            />
                            <Error :errors="errors.name" v-if="errors.name" />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                v-model="form.email"
                            />
                            <Error :errors="errors.email" v-if="errors.email" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-sm btn-primary me-2"
                        >
                            Add
                        </button>
                        <button type="reset" class="btn btn-sm btn-warning">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success :msg="message" :route="{ name: 'Admin' }" />
</template>
