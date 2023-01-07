<script>
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";

export default {
    props: ["id"],
    data() {
        return {
            admin: {},
            errors: [],

            isLoading: false,
            message: "",
        };
    },
    mounted() {
        this.getAdmin();
    },
    methods: {
        getAdmin() {
            this.isLoading = true;

            this.$store
                .dispatch("showData", ["user/admin", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.admin = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;

            this.$store
                .dispatch("updateData", ["user/admin", this.id, this.admin])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "admin has been updated";
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: { Loader, Success },
};
</script>
<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <form method="post" @submit.prevent="handleSubmit">
                <div class="card">
                    <Loader v-if="isLoading" />
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                v-model="admin.name"
                            />
                            <Error :errors="errors.name" v-if="errors.name" />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                v-model="admin.email"
                            />
                            <Error :errors="errors.email" v-if="errors.email" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-sm btn-primary me-2"
                        >
                            Save
                        </button>
                        <router-link
                            class="btn btn-sm btn-warning"
                            :to="{ name: 'Admin' }"
                            >Cancel</router-link
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success :msg="message" :route="{ name: 'Admin' }" />
</template>
