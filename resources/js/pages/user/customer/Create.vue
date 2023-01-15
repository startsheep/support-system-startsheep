<script>
import Error from "../../../components/Error.vue";
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";
import Multiselect from "vue-multiselect";

export default {
    data() {
        return {
            form: {
                email: "",
                name: "",
                projectId: [],
            },

            errors: {},
            projects: [],
            projectId: [],

            isLoading: false,
            isLoadingProject: false,
            message: "",
        };
    },
    mounted() {
        this.getProjects();
    },
    methods: {
        getProjects(search = "") {
            this.isLoadingProject = true;
            const params = [`search=${search}`].join("&");

            this.$store
                .dispatch("getData", ["project", params])
                .then((response) => {
                    this.isLoadingProject = false;
                    this.projects = response.data;
                })
                .catch((error) => {
                    this.isLoadingProject = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;
            this.form.projectId = this.projectId.map((project) => project.id);
            this.$store
                .dispatch("postData", ["user/customer", this.form])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "customer has been created";
                    $("#successModal").modal("show");
                })
                .catch((errors) => {
                    this.isLoading = false;
                    this.errors = errors.response.data.messages;
                });
        },
    },
    components: { Error, Loader, Success, Multiselect },
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
                            <label for="name">Customer Name</label>
                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                v-model="form.name"
                                placeholder="enter customer name"
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
                                placeholder="enter customer email"
                            />
                            <Error :errors="errors.email" v-if="errors.email" />
                        </div>
                        <div class="mb-3">
                            <label for="projectId">Assign To Project</label>
                            <Multiselect
                                :searchable="true"
                                :internal-search="false"
                                @search-change="getProjects"
                                v-model="projectId"
                                :options="projects"
                                :custom-label="(project) => project.projectName"
                                placeholder="select Project"
                                track-by="id"
                                :loading="isLoadingProject"
                                multiple
                            >
                            </Multiselect>
                            <Error
                                :errors="errors.projectId"
                                v-if="errors.projectId"
                            />
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <router-link
                            class="btn btn-secondary"
                            :to="{ name: 'Customer' }"
                            >Cancel</router-link
                        >
                        <button type="submit" class="btn btn-success">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success :msg="message" :route="{ name: 'Customer' }" />
</template>
