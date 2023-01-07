<script>
import Error from "../../components/Error.vue";
import Loader from "../../components/Loader.vue";
import Success from "../../components/notifications/Success.vue";

export default {
    data() {
        return {
            isLoading: false,
            form: {
                projectName: "",
                projectDomain: "",
            },
            errors: [],
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["project", this.form])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "project has been added";
                    $("#successModal").modal("show");
                })
                .catch((errors) => {
                    this.isLoading = false;
                    this.errors = errors.response.data.messages;
                });
        },
    },
    components: { Success, Error, Loader },
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
                            :to="{ name: 'Project' }"
                            >Back</router-link
                        >
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="projectName">Project Name</label>
                            <input
                                type="test"
                                id="projectName"
                                class="form-control"
                                v-model="form.projectName"
                            />
                            <Error
                                :errors="errors.projectName"
                                v-if="errors.projectName"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="projectDomain">Project Domain</label>
                            <input
                                type="url"
                                id="projectDomain"
                                class="form-control"
                                v-model="form.projectDomain"
                                placeholder="http://localhost.test"
                            />
                            <Error
                                :errors="errors.projectDomain"
                                v-if="errors.projectDomain"
                            />
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

    <Success :msg="message" :route="{ name: 'Project' }" />
</template>
