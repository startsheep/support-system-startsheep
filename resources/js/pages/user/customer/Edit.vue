<script>
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";
import Multiselect from "vue-multiselect";

export default {
    props: ["id"],
    data() {
        return {
            customer: {
                name: "",
                email: "",
                projectId: [],
            },
            errors: [],
            projects: [],

            isLoading: false,
            isLoadingProject: false,
            message: "",
        };
    },
    mounted() {
        this.getCustomer();
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
        getCustomer() {
            this.isLoading = true;

            this.$store
                .dispatch("showData", ["user/customer", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.customer.name = response.data.name;
                    this.customer.email = response.data.email;
                    response.data.customerHasProject.forEach((project) => {
                        this.customer.projectId.push(project.project);
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;
            this.customer.projectId = this.customer.projectId.map(
                (project) => project.id
            );
            this.$store
                .dispatch("updateData", [
                    "user/customer",
                    this.id,
                    this.customer,
                ])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "customer has been updated";
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
    },
    components: { Loader, Success, Multiselect },
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
                                v-model="customer.name"
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
                                v-model="customer.email"
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
                                v-model="customer.projectId"
                                :options="projects"
                                :custom-label="(project) => project.projectName"
                                placeholder="select Project"
                                track-by="id"
                                :loading="isLoadingProject"
                                multiple
                            />
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
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success :msg="message" :route="{ name: 'Customer' }" />
</template>
