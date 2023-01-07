<script>
import Loader from "../../components/Loader.vue";
import Pagination from "../../components/Pagination.vue";
import Delete from "../../components/notifications/Detele.vue";

export default {
    data() {
        return {
            projects: [],
            metaPagination: [],
            pagination: {
                perPage: 10,
                page: 1,
            },

            search: "",
            deleteId: null,
            isLoading: false,
        };
    },
    mounted() {
        this.getProjects();
    },
    methods: {
        getProjects() {
            this.isLoading = true;

            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `search=${this.search}`,
            ].join("&");

            this.$store
                .dispatch("getData", ["project", params])
                .then((response) => {
                    this.isLoading = false;
                    this.projects = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        deleteProject() {
            $("#deleteModal").modal("hide");

            this.isLoading = true;

            this.$store
                .dispatch("deleteData", ["project", this.deleteId])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "data has been deleted";
                    this.getProjects();
                    $("#successModal").modal("show");
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        iteration(index) {
            return (
                (this.metaPagination.currentPage - 1) *
                    this.metaPagination.perPage +
                index +
                1
            );
        },
        onDelete(e) {
            this.deleteId = e;
            $("#deleteModal").modal("show");
        },
    },
    components: { Pagination, Loader, Delete },
};
</script>

<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <router-link
                                :to="{ name: 'Add More Project' }"
                                class="btn btn-sm btn-primary mb-3"
                            >
                                Add More Project
                            </router-link>
                        </div>
                        <div
                            class="d-flex justify-content-end flex-md-row flex-xs-column align-items-center"
                        >
                            <div class="me-2">
                                <input
                                    type="search"
                                    class="form-control"
                                    style="margin-top: -13px"
                                    @keyup="onSearch"
                                    v-model="search"
                                    placeholder="Search..."
                                />
                            </div>

                            <Pagination
                                :pagination="metaPagination"
                                @onPageChange="onPageChange($event)"
                            />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Project Domain</th>
                                    <th>Ticket</th>
                                    <th>Customer PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(project, index) in projects"
                                    :key="index"
                                >
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'Project Detail',
                                                params: { id: project.id },
                                            }"
                                            class="text-dark"
                                            >{{
                                                project.projectName
                                            }}</router-link
                                        >
                                    </td>
                                    <td>
                                        <a
                                            :href="project.projectDomain"
                                            target="_blank"
                                            class="text-dark"
                                        >
                                            {{ project.projectDomain }}</a
                                        >
                                    </td>
                                    <td v-html="0"></td>
                                    <td v-html="0"></td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            @click="onDelete(project.id)"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Delete @onDelete="deleteProject" />
</template>
