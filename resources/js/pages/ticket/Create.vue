<script>
import Error from "../../components/Error.vue";
import Loader from "../../components/Loader.vue";
import Success from "../../components/notifications/Success.vue";

export default {
    data() {
        return {
            form: {
                ticketTitle: "",
                ticketPriority: "",
                projectId: "",
                description: "",
                files: [],
            },
            previewFiles: [],
            errors: {},
            projects: [],
            priorities: [],

            isLoading: false,
            message: "",
        };
    },
    mounted() {
        this.getProjects();
        this.getPriorities();
    },
    computed: {
        formData() {
            const formData = new FormData();
            formData.append("ticket_title", this.form.ticketTitle);
            formData.append("ticket_priority", this.form.ticketPriority);
            formData.append("project_id", this.form.projectId);
            formData.append("description", this.form.description);
            for (let index = 0; index < this.form.files.length; index++) {
                formData.append("files[" + index + "]", this.form.files[index]);
            }
            return formData;
        },
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
        getPriorities() {
            this.priorities = [
                {
                    priorityName: "Minor",
                },
                {
                    priorityName: "Major",
                },
                {
                    priorityName: "Urgent",
                },
                {
                    priorityName: "Emergency",
                },
            ];
        },
        uploadFiles(e) {
            const files = this.$refs.fileInput.files;
            this.form.files = [];
            console.log(files);
            for (let index = 0; index < files.length; index++) {
                this.form.files.push(files[index]);
                this.previewFiles.push(URL.createObjectURL(files[index]));
            }
        },
        removeFile(index) {
            this.$refs.fileInput.value = "";
            this.form.files.splice(index, 1);
            this.previewFiles.splice(index, 1);
        },
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postDataUpload", ["ticket", this.formData])
                .then((response) => {
                    this.isLoading = false;
                    this.message = "ticket has been added";
                    $("#successModal").modal("show");
                })
                .catch((errors) => {
                    this.isLoading = false;
                    this.errors = errors.response.data.messages;
                });
        },
        handleUpload() {
            $("#fileInput").click();
        },
    },
    components: { Error, Loader, Success },
};
</script>

<template>
    <h1 class="h3 mb-3">{{ this.$route.name }}</h1>

    <div class="row">
        <div class="col-12">
            <form @submit.prevent="handleSubmit" method="post">
                <div class="card">
                    <Loader v-if="isLoading" />
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ticketTitle">Your problem</label>
                            <input
                                type="test"
                                id="ticketTitle"
                                class="form-control"
                                v-model="form.ticketTitle"
                                placeholder="eg. The dashboard won’t updating the table"
                            />
                            <Error
                                :errors="errors.ticketTitle"
                                v-if="errors.ticketTitle"
                            />
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="projectId">Project</label>
                                <select
                                    id="projectId"
                                    class="form-control"
                                    v-model="form.projectId"
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
                            <div class="col-lg-6 mb-3">
                                <label for="ticketPriority">Priority</label>
                                <select
                                    id="ticketPriority"
                                    class="form-control"
                                    v-model="form.ticketPriority"
                                >
                                    <option value="" disabled selected>
                                        select priority
                                    </option>
                                    <option
                                        v-for="(priority, index) in priorities"
                                        :value="priority.priorityName"
                                        :key="index"
                                        v-html="priority.priorityName"
                                    ></option>
                                </select>
                                <Error
                                    :errors="errors.ticketPriority"
                                    v-if="errors.ticketPriority"
                                />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description">Problem description</label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="form-control"
                                rows="10"
                                placeholder="explain your problem"
                            ></textarea>
                            <Error
                                :errors="errors.description"
                                v-if="errors.description"
                            />
                        </div>
                        <div class="mb-3" v-if="previewFiles.length > 0">
                            <span
                                v-for="(file, index) in form.files"
                                class="me-5"
                            >
                                <a
                                    class="btn btn-sm btn-success"
                                    :key="index"
                                    v-html="file.name"
                                    :href="previewFiles[index]"
                                    target="_blank"
                                >
                                </a>
                                <span
                                    class="btn btn-danger btn-sm position-absolute cursor"
                                    @click="removeFile(index)"
                                    >&times;</span
                                >
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="documents"
                                >Upload photos / videos</label
                            >
                            <div
                                class="text-center"
                                id="customFileInput"
                                style="cursor: pointer"
                                @click="handleUpload"
                            >
                                <p>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-upload align-middle me-2"
                                    >
                                        <path
                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                        ></path>
                                        <polyline
                                            points="17 8 12 3 7 8"
                                        ></polyline>
                                        <line
                                            x1="12"
                                            y1="3"
                                            x2="12"
                                            y2="15"
                                        ></line>
                                    </svg>
                                </p>
                                <p>upload documents in here...</p>
                                <input
                                    type="file"
                                    multiple=""
                                    id="fileInput"
                                    @change="uploadFiles"
                                    hidden
                                    ref="fileInput"
                                />
                            </div>
                            <Error
                                :errors="errors.projectTitle"
                                v-if="errors.projectTitle"
                            />
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <router-link
                            :to="{ name: 'Ticket' }"
                            class="btn btn-secondary me-3"
                            >Cancel
                        </router-link>
                        <button type="submit" class="btn btn-success">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Success :msg="message" :route="{ name: 'Ticket' }" />
</template>
