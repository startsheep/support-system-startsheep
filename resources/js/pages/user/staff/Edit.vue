<script>
import { Multiselect } from "vue-multiselect";
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";

export default {
    props: ["id"],
    data() {
        return {
            staff: {
                name: "",
                email: "",
                projectId: [],
            },
            errors: [],
            projects: [],

            isLoading: false,
            message: "",
        };
    },
    mounted() {
        this.getStaff();
        this.getProjects();
    },
    methods: {
        getProjects(search = "") {
            this.isLoading = true;
            const params = [`search=${search}`].join("&");
            this.$store
                .dispatch("getData", ["project", params])
                .then((response) => {
                    this.isLoading = false;
                    this.projects = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        getStaff() {
            this.isLoading = true;

            this.$store
                .dispatch("showData", ["user/staff", this.id])
                .then((response) => {
                    this.isLoading = false;
                    this.staff.name = response.data.name;
                    this.staff.email = response.data.email;
                    response.data.staffHasProject.forEach((project) => {
                        this.staff.projectId.push(project.project);
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;
            this.staff.projectId = this.staff.projectId.map((project) => {
                return project.id;
            });
            this.$store
                .dispatch("updateData", ["user/staff", this.id, this.staff])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "staff has been updated";
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
                                v-model="staff.name"
                                placeholder="enter staff name"
                            />
                            <Error :errors="errors.name" v-if="errors.name" />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                v-model="staff.email"
                                placeholder="enter staff email"
                            />
                            <Error :errors="errors.email" v-if="errors.email" />
                        </div>
                        <div class="mb-3">
                            <label for="projectId">Assign To Project</label>
                            <Multiselect
                                :searchable="true"
                                :internal-search="false"
                                @search-change="getProjects"
                                v-model="staff.projectId"
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
                            :to="{ name: 'Staff' }"
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

    <Success :msg="message" :route="{ name: 'Staff' }" />
</template>
