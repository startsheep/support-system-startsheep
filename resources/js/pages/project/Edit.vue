<script>
import Error from "../../components/Error.vue";
import Loader from "../../components/Loader.vue";
import Success from "../../components/notifications/Success.vue";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,

            project: {},
            errors: [],
        };
    },
    mounted() {
        this.getProject();
    },
    methods: {
        getProject() {
            this.isLoading = true;

            this.$store
                .dispatch("showData", ["project", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.project = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("updateData", ["project", this.id, this.project])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "project has been updated";
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
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="projectName">Project Name</label>
                            <input
                                type="test"
                                id="projectName"
                                class="form-control"
                                v-model="project.projectName"
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
                                v-model="project.projectDomain"
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
                            Save
                        </button>
                        <router-link
                            class="btn btn-sm btn-warning"
                            :to="{ name: 'Project Detail', params: { id: id } }"
                            >Cancel</router-link
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success
        :msg="message"
        :route="{ name: 'Project Detail', params: { id: id } }"
    />
</template>
