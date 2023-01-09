<script>
import Loader from "../../../components/Loader.vue";

export default {
    props: ["ticket"],
    data() {
        return {
            ticketStatus: [],
            staff: [],
            isLoading: false,
        };
    },
    mounted() {
        this.getTicketStatus();
        this.getStaff();
        this.getPriorities();
    },
    methods: {
        getStaff() {
            this.isLoading = true;
            this.$store
                .dispatch("getData", ["user/staff", []])
                .then((response) => {
                    this.isLoading = false;
                    this.staff = response.data;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        getTicketStatus() {
            this.isLoading = true;
            this.$store
                .dispatch("getData", ["ticket-status", []])
                .then((response) => {
                    this.isLoading = false;
                    this.ticketStatus = response.data;
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
        handleSubmit() {
            this.isLoading = true;
            const attributes = {
                ticketStatus: this.ticket.ticketStatus.id,
                staffId: this.ticket.staffId,
                ticketPriority: this.ticket.ticketPriority,
                description: this.ticket.description,
                ticketTitle: this.ticket.ticketTitle,
                projectId: this.ticket.projectId,
            };
            this.$store
                .dispatch("updateData", ["ticket", this.ticket.id, attributes])
                .then((response) => {
                    this.isLoading = false;
                    this.$emit("updateTicket", 1);
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
    <div class="card">
        <Loader v-if="isLoading" />
        <form @submit.prevent="handleSubmit" method="post">
            <div class="card-body">
                <h5 class="card-title mb-3">Properties</h5>
                <div class="mb-3">
                    <label class="fw-bolder">Priority</label>
                    <select
                        class="form-control"
                        v-model="ticket.ticketPriority"
                    >
                        <option value="" disabled selected>
                            select priority
                        </option>
                        <option
                            :value="priority.priorityName"
                            v-html="priority.priorityName"
                            v-for="(priority, index) in priorities"
                            :key="index"
                        ></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bolder">Status</label>
                    <select
                        class="form-control"
                        v-if="ticket.ticketStatus"
                        v-model="ticket.ticketStatus.id"
                    >
                        <option value="" disabled selected>
                            select status
                        </option>
                        <option
                            :value="status.id"
                            v-html="status.status"
                            v-for="(status, index) in ticketStatus"
                            :key="index"
                        ></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bolder">Assign to staff</label>
                    <select class="form-control" v-model="ticket.staffId">
                        <option value="" disabled selected>select staff</option>
                        <option
                            v-for="(staff, index) in staff"
                            :key="index"
                            :value="staff.id"
                            v-html="staff.name"
                        ></option>
                    </select>
                </div>
                <div class="mt-4 mb-3">
                    <button class="btn btn-success form-control">Update</button>
                </div>
            </div>
        </form>
    </div>
</template>
