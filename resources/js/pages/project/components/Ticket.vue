<script>
import Loader from "../../../components/Loader.vue";
import Pagination from "../../../components/Pagination.vue";

export default {
    props: ["id"],
    data() {
        return {
            isLoading: false,
            tickets: [],
            metaPagination: [],
            pagination: {
                perPage: 4,
                page: 1,
            },
        };
    },
    mounted() {
        this.getTickets();
    },
    methods: {
        getTickets() {
            this.isLoading = true;
            const params = [
                `per_page=${this.pagination.perPage}`,
                `page=${this.pagination.page}`,
                `project=${this.id}`,
            ].join("&");
            this.$store
                .dispatch("getData", ["ticket", params])
                .then((response) => {
                    this.isLoading = false;
                    this.tickets = response.data;
                    this.metaPagination = response.meta;
                })
                .catch((error) => {
                    this.isLoading = false;
                    console.log(error);
                });
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getTickets();
        },
        alertTicketPriority(priority) {
            if (priority == "Minor") {
                return `<div class="badge rounded bg-secondary">${priority}</div>`;
            } else if (priority == "Major") {
                return `<div class="badge rounded bg-success">${priority}</div>`;
            } else if (priority == "Urgent") {
                return `<div class="badge rounded bg-warning">${priority}</div>`;
            } else if (priority == "Emergency") {
                return `<div class="badge rounded bg-danger">${priority}</div>`;
            }
        },
    },
    components: { Pagination, Loader },
};
</script>

<template>
    <div class="card">
        <Loader v-if="isLoading" />
        <div
            class="card-header d-flex justify-content-between align-items-center"
        >
            <h5 class="card-title mb-0">Ticket Project</h5>
            <router-link to="" class="btn btn-primary"
                >Kanban Board</router-link
            >
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover border-top">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Priority</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ticket, index) in tickets" :key="index">
                            <td>
                                {{ ticket.ticketCode }}
                            </td>
                            <td v-html="ticket.ticketTitle"></td>
                            <td
                                v-html="
                                    alertTicketPriority(ticket.ticketPriority)
                                "
                            ></td>
                            <td class="text-center" v-if="ticket.ticketStatus">
                                <button
                                    class="btn rounded-pill"
                                    disabled
                                    :class="ticket.ticketStatus.color"
                                    v-html="ticket.ticketStatus.status"
                                ></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination
                :pagination="metaPagination"
                @onPageChange="onPageChange($event)"
            />
        </div>
    </div>
</template>
