<script>
import Loader from "../../components/Loader.vue";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,

            project: {},
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
    },
    components: { Loader },
};
</script>
<template>
    <h1 class="h3 mb-3">{{ this.$route.name + " " + project.projectName }}</h1>

    <router-link class="btn btn-sm btn-primary mb-3" :to="{ name: 'Project' }"
        >Back</router-link
    >

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <Loader v-if="isLoading" />
                <div class="card-header">
                    <h5 class="card-title mb-0">Project Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-light" style="font-size: 10px"
                            >Project Name</label
                        >
                        <p v-html="project.projectName"></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-light" style="font-size: 10px"
                            >Project Domain</label
                        >
                        <p v-html="project.projectDomain"></p>
                    </div>
                    <div>
                        <router-link
                            :to="{ name: 'Edit Project', params: { id: id } }"
                            class="btn btn-sm btn-warning form-control"
                        >
                            Edit
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <h5 class="card-title mb-0">Customer PIC</h5>
                    <a class="btn btn-sm btn-primary">Add More PIC</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
