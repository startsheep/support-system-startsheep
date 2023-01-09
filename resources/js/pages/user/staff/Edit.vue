<script>
import Loader from "../../../components/Loader.vue";
import Success from "../../../components/notifications/Success.vue";

export default {
    props: ["id"],
    data() {
        return {
            staff: {},
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
        getProjects() {
            this.isLoading = true;
            this.$store
                .dispatch("getData", ["project", []])
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
                    this.staff = response.data;
                    this.staff.projectId =
                        response.data.staffHasProject.projectId;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;

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
                            <select
                                v-model="staff.projectId"
                                id="projectId"
                                class="form-control"
                            >
                                <option value="" disabled selected>
                                    select project
                                </option>
                                <option
                                    :value="project.id"
                                    v-for="(project, index) in projects"
                                    :key="index"
                                    v-html="project.projectName"
                                ></option>
                            </select>
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
