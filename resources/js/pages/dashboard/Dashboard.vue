<script>
import Loader from "../../components/Loader.vue";
export default {
    data() {
        return {
            ticket: {
                title: "",
                company: "",
                project: "",
                domain: "",
                description: "",
                created_by: "",
            },
            isLoading: false,
            errors: {},
        };
    },
    methods: {
        handleSubmit() {
            this.isLoading = true;
            this.$store
                .dispatch("postData", ["ticket", this.ticket])
                .then((response) => {
                    this.isLoading = false;
                    this.removeValue();
                    this.$swal.fire({
                        title: response.type,
                        text: response.message,
                        icon: response.type,
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.errors = error.response.data.meta.messages;
                });
        },
        removeValue() {
            this.ticket.title = "";
            this.ticket.company = "";
            this.ticket.project = "";
            this.ticket.domain = "";
            this.ticket.description = "";
            this.ticket.created_by = "";
        },
    },
    components: { Loader },
};
</script>
<template>
    <div class="container mt-5 position-relative">
        <Loader v-if="isLoading" />
        <h5 class="text-center mb-3">Create your Ticket</h5>
        <h1 class="text-center mb-5">Hi, What can we help you?</h1>
        <form @submit.prevent="handleSubmit">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="created_by">Created by</label>
                        <input
                            type="text"
                            class="form-control"
                            id="created_by"
                            v-model="ticket.created_by"
                            :class="{
                                'is-invalid': errors.createdBy,
                            }"
                        />
                        <div
                            class="invalid-feedback"
                            v-if="errors.createdBy"
                            v-for="(error, index) in errors.createdBy"
                            :key="index"
                        >
                            {{ error }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="title">Your problem</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                v-model="ticket.title"
                                :class="{
                                    'is-invalid': errors.title,
                                }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.title"
                                v-for="(error, index) in errors.title"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="company">Your company</label>
                            <input
                                type="text"
                                class="form-control"
                                id="company"
                                v-model="ticket.company"
                                :class="{
                                    'is-invalid': errors.company,
                                }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.company"
                                v-for="(error, index) in errors.company"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="title">Your project</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                v-model="ticket.project"
                                :class="{
                                    'is-invalid': errors.project,
                                }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.project"
                                v-for="(error, index) in errors.project"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="company">Your domain</label>
                            <input
                                type="text"
                                class="form-control"
                                id="company"
                                v-model="ticket.domain"
                                :class="{
                                    'is-invalid': errors.domain,
                                }"
                            />
                            <div
                                class="invalid-feedback"
                                v-if="errors.domain"
                                v-for="(error, index) in errors.domain"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            class="form-control"
                            cols="30"
                            rows="10"
                            v-model="ticket.description"
                            :class="{
                                'is-invalid': errors.description,
                            }"
                        ></textarea>
                        <div
                            class="invalid-feedback"
                            v-if="errors.description"
                            v-for="(error, index) in errors.description"
                            :key="index"
                        >
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary">Send</button>
                </div>
            </div>
        </form>
    </div>
</template>
<style></style>
