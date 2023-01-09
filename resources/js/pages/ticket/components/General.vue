<script>
import Loader from "../../../components/Loader.vue";

export default {
    props: ["ticket", "isLoading"],
    data() {
        return {};
    },
    methods: {
        alertTicketStatus(ticket) {
            if (ticket.status == "Open") {
                return `<button class="btn rounded-pill btn-outline-primary" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "On Hold") {
                return `<button class="btn rounded-pill btn-outline-secondary" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "On Progress") {
                return `<button class="btn rounded-pill btn-outline-warning" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "Closed") {
                return `<button class="btn rounded-pill btn-outline-danger" disabled>${ticket.status}</button>`;
            } else if (ticket.status == "Done") {
                return `<button class="btn rounded-pill btn-outline-success" disabled>${ticket.status}</button>`;
            }
        },
    },
    components: { Loader },
};
</script>

<template>
    <div class="card">
        <Loader v-if="isLoading" />
        <div class="card-body">
            <h5 class="card-title mb-3">General</h5>
            <div class="mb-2">
                <label><b>Status</b></label> <br />
                <div
                    v-if="ticket.ticketStatus"
                    v-html="alertTicketStatus(ticket.ticketStatus)"
                ></div>
            </div>
            <div class="mb-2">
                <label><b>Project</b></label>
                <p
                    v-if="ticket.project"
                    v-html="ticket.project.projectName"
                ></p>
            </div>
            <div class="mb-2">
                <label><b>Priority</b></label>
                <p v-html="ticket.ticketPriority"></p>
            </div>
        </div>
    </div>
</template>
