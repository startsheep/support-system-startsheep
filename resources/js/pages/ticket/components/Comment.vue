<script>
import Loader from "../../../components/Loader.vue";
import moment from "moment";

export default {
    data() {
        return {
            isLoading: false,
            isLoadingComment: false,
            isShow: true,
            createForm: true,
            editForm: false,

            form: {
                message: "",
                ticketId: this.$route.params.id,
                files: [],
            },
            oldFiles: [],
            user: {},
            previewFiles: [],
            comment: [],
            comments: [],
            pagination: {
                page: 1,
                perPage: 10,
            },
        };
    },
    mounted() {
        this.getComments();
        this.getUser();
    },
    computed: {
        createData() {
            const formData = new FormData();
            formData.append("message", this.form.message);
            formData.append("ticket_id", this.form.ticketId);
            this.form.files.forEach((file, index) => {
                formData.append("files[" + index + "]", file);
            });

            return formData;
        },

        updateData() {
            const formData = new FormData();
            formData.append("message", this.comment.message);
            formData.append("ticket_id", this.comment.ticketId);

            this.form.files.forEach((file, index) => {
                formData.append("files[" + index + "]", file);
            });

            this.comment.files.forEach((file, index) => {
                formData.append("old_files[" + index + "]", file.id);
            });

            formData.append("_method", "PUT");
            formData.append("id", this.comment.id);

            return formData;
        },
    },
    methods: {
        getComments() {
            this.isLoadingComment = true;
            const params = [
                `ticket=${this.$route.params.id}`,
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
            ].join("&");
            this.$store
                .dispatch("getData", [`comment`, params])
                .then((response) => {
                    this.isLoadingComment = false;
                    this.comments = response.data;
                })
                .catch((error) => {
                    this.isLoadingComment = false;
                    console.log(error);
                });
        },
        getComment(id) {
            this.isLoading = true;
            this.$store
                .dispatch("showData", [`comment`, id])
                .then((response) => {
                    this.isLoading = false;
                    this.comment = response.data;
                    this.oldFiles = response.data.files;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        getUser() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["/auth/check", {}])
                .then((response) => {
                    this.isLoading = false;
                    this.user = response.user;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        deleteComment(id) {
            this.isLoadingComment = true;
            this.$store
                .dispatch("deleteData", [`comment`, id])
                .then((response) => {
                    this.isLoadingComment = false;
                    this.getComments();
                })
                .catch((error) => {
                    this.isLoadingComment = false;
                    console.log(error);
                });
        },
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postDataUpload", [`comment`, this.createData])
                .then((response) => {
                    this.isLoading = false;
                    this.getComments();
                    this.form.message = "";
                    this.form.files = [];
                    this.previewFiles = [];
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleUpdate(id) {
            this.isLoading = true;
            this.$store
                .dispatch("postDataUpload", [`comment/` + id, this.updateData])
                .then((response) => {
                    this.isLoading = false;
                    this.getComments();
                    this.onCancel();
                    this.form.message = "";
                    this.form.files = [];
                    this.previewFiles = [];
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        handleUpload() {
            $("#fileInput").click();
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
        removeOldFile(index) {
            this.comment.files.splice(index, 1);
        },
        onEdit(id) {
            this.editForm = true;
            this.createForm = false;
            this.isShow = false;
            this.getComment(id);
        },
        onCancel() {
            this.editForm = false;
            this.createForm = true;
            this.isShow = true;
        },
        dateTime(value, format) {
            return moment(value).format(format ?? "YYYY-MM-DD HH:mm");
        },
    },
    components: { Loader },
};
</script>

<template>
    <div
        class="card"
        v-for="(comment, index) in comments"
        :key="index"
        v-if="isShow"
    >
        <Loader v-if="isLoadingComment" />
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex">
                <img
                    :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${comment.user.name}`"
                />
                <div class="card-header-sub ms-3">
                    <span><b v-html="comment.user.name"></b></span><br />
                    <span
                        >Replied at
                        {{
                            dateTime(comment.createdAt, "HH:mm a, DD MMMM YYYY")
                        }}</span
                    >
                </div>
            </div>
            <div class="d-flex" v-if="comment.user.id == user.id">
                <div
                    id="editComment"
                    style="cursor: pointer"
                    class="text-warning me-2"
                    @click="onEdit(comment.id)"
                >
                    <span class="material-symbols-outlined"> edit_note </span>
                </div>
                <div
                    id="deleteComment"
                    style="cursor: pointer"
                    class="text-danger"
                    @click="deleteComment(comment.id)"
                >
                    <span class="material-symbols-outlined"> close </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="mb-4">
                {{ comment.message }}
            </p>
            <div v-if="comment.files && comment.files.length > 0">
                <span><b>Attachments</b> :</span>
                <div class="row mt-2">
                    <div
                        v-for="(file, index) in comment.files"
                        :key="index"
                        class="col-lg-3 col-md-4 col-sm-6 col-12"
                    >
                        <a :href="file.filePath" target="_blank">
                            <img :src="file.filePath" class="img-fluid" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form
        @submit.prevent="handleSubmit"
        method="post"
        id="createComment"
        v-if="createForm"
    >
        <div class="card">
            <Loader v-if="isLoading" />
            <div class="card-header d-flex">
                <img
                    :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${user.name}`"
                />
                <div class="card-header-sub ms-3 mt-1">
                    <span><b v-html="user.name"></b></span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Write your message</label>
                    <textarea
                        class="form-control"
                        rows="5"
                        placeholder="Write your message here..."
                        v-model="form.message"
                    ></textarea>
                </div>
                <div class="mb-3" v-if="previewFiles.length > 0">
                    <span v-for="(file, index) in form.files" class="me-5">
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
                    <label for="documents">Upload photos / videos</label>
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
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
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
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>

    <form
        @submit.prevent="handleUpdate(comment.id)"
        method="post"
        id="editComment"
        v-if="editForm"
    >
        <div class="card">
            <Loader v-if="isLoading" />
            <div class="card-header d-flex">
                <img
                    :src="`https://ui-avatars.com/api/?background=random&size=30&rounded=true&length=2&name=${user.name}`"
                />
                <div class="card-header-sub ms-3 mt-1">
                    <span><b v-html="user.name"></b></span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Edit your message</label>
                    <textarea
                        class="form-control"
                        rows="5"
                        placeholder="Edit your message here..."
                        v-model="comment.message"
                    ></textarea>
                </div>
                <div class="mb-3" v-if="comment.files.length > 0">
                    <span v-for="(file, index) in comment.files" class="me-5">
                        <a
                            class="btn btn-sm btn-success"
                            :key="index"
                            v-html="file.fileName"
                            :href="file.filePath"
                            target="_blank"
                        >
                        </a>
                        <span
                            class="btn btn-danger btn-sm position-absolute cursor"
                            @click="removeOldFile(index)"
                            >&times;</span
                        >
                    </span>
                </div>
                <div class="mb-3" v-if="previewFiles.length > 0">
                    <span v-for="(file, index) in form.files" class="me-5">
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
                    <label for="documents">Upload photos / videos</label>
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
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
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
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-secondary" @click="onCancel">
                    Cancel
                </button>
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
</template>
