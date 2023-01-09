<script>
import Loader from "../../components/Loader.vue";
import Ticket from "./components/Ticket.vue";

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
    components: { Loader, Ticket },
};
</script>
<template>
    <div class="d-flex">
        <router-link class="text-dark mb-3 me-2" :to="{ name: 'Project' }"
            ><span class="material-symbols-outlined">
                chevron_left
            </span></router-link
        >
        <h1 class="h3 mb-3">
            {{ this.$route.name + " " + project.projectName }}
        </h1>
    </div>

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
                            class="btn btn-warning form-control"
                        >
                            Edit
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <Ticket :id="id" />
        </div>
    </div>
</template>
